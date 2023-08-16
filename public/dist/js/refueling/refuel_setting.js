$(document).ready(function () {
    let refuelSettingTable = $("#refuelSettingTable").DataTable();

    $("#addRefuelSettingForm").validate({
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

}