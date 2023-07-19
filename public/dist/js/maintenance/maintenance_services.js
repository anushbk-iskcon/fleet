$(document).ready(function () {
    let maintenServiceInfoTable = $("#maintenServiceInfoTable").DataTable();

    // Draw table on Page Load

    // Validate and submit Add New Maintenance Service Form
    $("#addMaintenanceServiceForm").validate({
        rules: {
            service_name: {
                required: true,
                maxlength: 50
            },
            service_type: 'required'
        },
        submitHandler: function (form, ev) {
            ev.preventDefault();
        }
    });

    // On closing Add New Maintenance Service modal, reset form and remove validation errors
    $("#add0").on('hidden.bs.modal', function () {
        $("#addMaintenanceServiceForm").trigger('reset');
        $("#addMaintenanceServiceForm").data('validator').resetForm();
    });

    // Validate and Submit Edit Maintenance Service Form
    $("#editMaintenanceServiceForm").validate({
        rules: {
            service_name: {
                required: true,
                maxlength: 50
            },
            service_type: 'required'
        },
        submitHandler: function (form, ev) {
            ev.preventDefault();
        }
    });

    // On closing Edit Mainteneance Service modal, reset form and remove validation errors
    $("#edit").on('hidden.bs.modal', function () {
        $("#editMaintenanceServiceForm").trigger('reset');
        $("#editMaintenanceServiceForm").data('validator').resetForm();
    });
});

// To draw table on page load or refresh after update
function populateTable(table) {
    // table.clear();
}

// Set ID for Editing Maintenance Service Details