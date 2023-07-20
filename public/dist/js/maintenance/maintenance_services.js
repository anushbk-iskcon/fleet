$(document).ready(function () {
    let maintenServiceInfoTable = $("#maintenServiceInfoTable").DataTable();

    // Draw table on Page Load
    populateTable(maintenServiceInfoTable);

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

            $.ajax({
                url: form.action,
                type: form.method,
                data: $(form).serialize(),
                dataType: 'json',
                success: function (res) {
                    if (res.successCode == 1) {
                        toastr.success(res.message, '', { closeButton: true });
                        populateTable(maintenServiceInfoTable);
                        $("#add0").modal('hide');
                    } else {
                        toastr.error(res.message, '', { closeButton: true });
                    }
                },
                error: function (jqXHR, textStatus, err) {
                    toastr.error("Error adding data. Please try again", '', { closeButton: true });
                }
            });
        }
    });

    // On closing Add New Maintenance Service modal, reset form and remove validation errors
    $("#add0").on('hidden.bs.modal', function () {
        $("#addMaintenanceServiceForm").trigger('reset');
        $("#addMaintenanceServiceForm").data('validator').resetForm();
        $("#addMaintenanceServiceForm .form-control.error").removeClass('error');
        $("#addMaintenanceServiceForm .form-control").removeAttr('aria-invalid');
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

            $.ajax({
                url: form.action,
                type: form.method,
                data: $(form).serialize(),
                dataType: 'json',
                success: function (res) {
                    if (res.successCode == 1) {
                        toastr.success(res.message, '', { closeButton: true });
                        populateTable(maintenServiceInfoTable);
                        $("#add0").modal('hide');
                    } else {
                        toastr.error(res.message, '', { closeButton: true });
                    }
                },
                error: function (jqXHR, textStatus, err) {
                    toastr.error("Error adding data. Please try again", '', { closeButton: true });
                }
            });
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

    $.ajax({
        url: getTableDataURL,
        type: 'post',
        data: {
            _token: csrfToken,
            serv_typesr: $("#serv_typesr").val(),
            ser_namesr: $("#ser_namesr").val()
        },
        dataType: 'json',
        success: function (res) {
            table.clear();

            if (res.length >= 1) {
                $.each(res, function (i, data) {
                    let status = data.IS_ACTIVE == 'Y' ? 'Active' : 'Inactive';
                    let actionBtns = `
                    <button type="button" class="btn btn-info mr-1" data-id="${data.MAINTENANCE_SERVICE_ID}" onclick="editInfo(this);">
                    <i class="ti-pencil"></i>
                    </button>
                    <button type="button" class="btn ${data.IS_ACTIVE == 'Y' ? 'btn-danger mr-1' : 'btn-success mr-1'}" data-id="${data.MAINTENANCE_SERVICE_ID}"
                    onclick="changeActivationStatus(this)" title="${data.IS_ACTIVE == 'Y' ? 'Deactivate' : 'Activate'}">
                    ${data.IS_ACTIVE == 'Y' ? '<i class="ti-close"></i>' : '<i class="ti-reload"></i>'}
                    </button>
                    `;
                    table.row.add([
                        i + 1,
                        data.MAINTENANCE_NAME,
                        data.MAINTENANCE_SERVICE_NAME,
                        status,
                        actionBtns
                    ]);
                });
            }

            table.draw();
        }
    });
}

// Set ID for Editing Maintenance Service Details
function editInfo(el) {

}