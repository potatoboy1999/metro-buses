$(window).ready(function() {
    console.log("Route index JS loaded");
    $('.btn-all-stops').on('click', function() {
        let routeId = $(this).attr('route');
        console.log("Fetching stops for route ID: " + routeId);
        let data = {
            route_id: routeId,
            _token: $("input[name=_token]").val()
        }
        $.ajax({
            url: '/routes/get-stops',
            method: 'POST',
            data: data,
            beforeSend: function() {
                console.log("Fetching stops...");
                stopsModalLoading(true);
                $('#allStopsModal .stops-list').html("");
                $('#allStopsModal').modal('show');
            },
            success: function(response) {
                console.log("Stops received:", response);
                let stopsList = response.stops;
                let htmlTxT = ``;
                stopsList.forEach((stop, index) => {
                    htmlTxT += stationItemHTML(stop.pivot.order, stop.name);
                });
                $('#allStopsModal .stops-list').html(htmlTxT);
                stopsModalLoading(false);
            },
            error: function(xhr, status, error) {
                console.error("Error fetching stops:", error);
                $('#allStopsModal .stops-list').html(`<p class="fs-7">Failed to load stops. Please try again later.</p>`);
                stopsModalLoading(false);
            }
        });
    });

    $(".btn-delete-route").on("click", function(ev){
        let routeId = $(this).attr("route");
        $("#confirmDeleteBtn").attr("route", routeId);
        $("#deleteRouteModal").modal("show");
    });

    $("#confirmDeleteBtn").on("click", function(ev){
        ev.preventDefault();
        let routeId = $(this).attr("route");
        let data = {
            route_id: routeId,
            _token: $("input[name=_token]").val()
        };
        $.ajax({
            url: '/routes/delete',
            method: 'POST',
            data: data,
            beforeSend: function() {
                $("#confirmDeleteBtn").prop("disabled", true);
                $("#confirmDeleteBtn").html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Deleting...`);
            },
            success: function(response) {
                if(response.success){
                    $(`.route-row.route-${routeId}`).remove();
                }
                $("#deleteRouteModal").modal("hide");
                $("#confirmDeleteBtn").prop("disabled", false);
                $("#confirmDeleteBtn").html(`Yes, Delete`);
            },
            error: function(xhr, status, error) {
                console.error("Error deleting route:", error);
                $("#confirmDeleteBtn").prop("disabled", false);
                $("#confirmDeleteBtn").html(`Yes, Delete`);
            }
        });
    });
});
function stopsModalLoading(isLoading){
    if(isLoading){
        $('#allStopsModal .loading').show();
        $('#allStopsModal .stops-list').hide();
        return;
    }
    $('#allStopsModal .loading').hide();
    $('#allStopsModal .stops-list').show();
}
function stationItemHTML(position, name){
    return `
        <div class="station-item d-flex gap-2 align-items-center border rounded p-2 mb-2">
            <span class="badge bg-secondary">${position}</span>
            <p class="m-0">${name}</p>
        </div>`;
}
