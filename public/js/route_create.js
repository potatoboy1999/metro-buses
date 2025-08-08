$(window).ready(function () {
    console.log("ready");

    var total_stops = 0;

    $("#add-stop").on("click", function (e) {
        e.preventDefault();
        var stationId = $("#route_stops").val();
        var stationName = $("#route_stops option:selected").text();

        if(stationId === "" || stationId === null) {
            console.log("No station selected");
            return;
        }
        console.log("Adding station:", stationId, stationName);

        // hide the select dropdown option
        $("#stop-" + stationId).hide();

        var stopsListContainer = $("#stops-list-container");
        var newStopItem = $(`
        <div class="stop-item round m-2 px-2 py-2 rounded border border-light" position="${total_stops}">
            <div class="d-flex flex-row">
                <div class="flex d-flex flex-row">
                    <div class="btn-stop-position btn btn-outline-primary btn-sm me-1" data-swap="up">
                        <i class="fa-solid fa-arrow-up"></i>
                    </div>
                    <div class="btn-stop-position btn btn-outline-primary btn-sm me-1" data-swap="down">
                        <i class="fa-solid fa-arrow-down"></i>
                    </div>
                    <div class="btn-stop-remove btn btn-outline-danger btn-sm me-1" data-remove="${total_stops}" data-id="${stationId}">
                        <i class="fa-solid fa-trash"></i>
                    </div>
                </div>
                <div class="flex-auto align-content-center">
                    <p class="ms-2 my-0 d-inline">${stationName}</p>
                </div>
                <input type="hidden" name="route_stops[]" value="${stationId}">
            </div>
        </div>`);
        total_stops++;
        stopsListContainer.append(newStopItem);

        // select the first option in the dropdown
        $("#route_stops").val("");
        $("#route_stops option:first").prop("selected", true);
        $("#no-stops").hide();
    });

    //remove stop item
    $(document).on("click", ".btn-stop-remove", function (e) {
        e.preventDefault();
        var stopItem = $(this).closest(".stop-item");
        var stopId = $(this).data("id");
        console.log("Removing stop:", stopId);

        // Show the select dropdown option again
        $("#stop-" + stopId).show();

        stopItem.remove();
        total_stops--;
        if ($("#stops-list-container").children().length === 0) {
            $("#no-stops").show();
        }
    });

    //swap stop positions
    $(document).on("click", ".btn-stop-position", function (e) {
        e.preventDefault();
        var stopItem = $(this).closest(".stop-item");
        var swapDirection = $(this).data("swap");
        var currentPosition = parseInt(stopItem.attr("position"));

        if (swapDirection === "up" && currentPosition > 0) {
            var previousStopItem = stopItem.prev(".stop-item");
            if (previousStopItem.length) {
                stopItem.insertBefore(previousStopItem);
                stopItem.attr("position", currentPosition - 1);
                previousStopItem.attr("position", currentPosition);
            }
        } else if (swapDirection === "down") {
            var nextStopItem = stopItem.next(".stop-item");
            if (nextStopItem.length) {
                stopItem.insertAfter(nextStopItem);
                stopItem.attr("position", currentPosition + 1);
                nextStopItem.attr("position", currentPosition);
            }
        }
    });
});
