$(document).ready(function () {
    let refuelSettingTable = $("#refuelSettingTable").DataTable();

    $("#addRefuelSettingForm").validate({
        rules: {
            vehicle: 'required',
            fuel_type: 'required',
            fuel_station: 'required',
            budget_given: {
                required: true,
                number: true
            },
            place: 'required',
            kilometer_per_unit: 'required',
            driver: 'required',
            driver_mobile: 'required',
            max_unit: 'required'
        },
        errorElement: 'div',
        errorPlacement: function (error, element) {
            $(element).closest('div[class*=col-sm-]').append(error);
        },
        submitHandler: function (form, ev) {
            ev.preventDefault();
        }
    });

    $("#add0").on('hidden.bs.modal', function () {
        $("#addRefuelSettingForm").trigger('reset');
        $("#addRefuelSettingForm").data('validator').resetForm();
        $("#addRefuelSettingForm .form-control").removeClass('error').removeAttr('aria-invalid');
        $('.basic-single').trigger('change');
    });
});

// To load data into Data Table
function populateTable(table) {
    $.ajax({
        url: refuelSettingListURL,
        type: 'post',
        data: {
            _token: csrfToken
        },
        dataType: 'json',
        success: function (res) {
            // table.clear();
            if (res.length >= 1) { }
            // table.draw();
        },
        error: function (jqXHR, textStatus, err) {
            toastr.error("Error trying to get data. Please try again", "", { closeButton: true });
        }
    })
}