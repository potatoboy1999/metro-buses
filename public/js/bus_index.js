$(window).ready(function() {
    $('.button-bus').on('click', function() {
        let busId = $(this).attr('bus');
        busEditLoading(true);
        $("#editBusId").val(busId);
        $("#editBusModal").modal("show");
        let data = {
            bus_id: busId,
            _token: $("input[name=_token]").val()
        };
        let types = ["regular", "express"];
        $.ajax({
            url: '/buses/edit',
            method: 'POST',
            data: data,
            success: function(response) {
                let bus = response.bus;
                $("#editBusCodeName").val(bus.code_name);
                $("#editBusFullName").val(bus.full_name);
                $("#editBusType").val(types[bus.express]);
                busEditLoading(false);
            },
            error: function(xhr, status, error) {
                console.error("Error fetching bus details:", error);
                $("#editBusModal").modal("hide");
                busEditLoading(false);
            }
        });
    });
});

function busEditLoading(isLoading){
    if(isLoading){
        $('#editBusModal .loading').show();
        $('#editBusForm').hide();
        return;
    }
    $('#editBusModal .loading').hide();
    $('#editBusForm').show();
}
