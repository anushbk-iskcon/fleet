$(document).ready(function () {
    let maintenServiceInfoTable = $("#maintenServiceInfoTable").DataTable();

    // Draw table on Page Load
    //On Clicking Filter button
    $("#btn-filter").on('click', function () {
        populateTable(maintenServiceInfoTable);
    });

    $("#btn-reset").on('click', function () {
        $("#serv_typesr").val('').trigger('change');
        $("#ser_namesr").val('');
        populateTable(maintenServiceInfoTable);
    });
    // 

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

    // On closing Edit Maintenance Service modal, reset form and remove validation errors
    $("#edit").on('hidden.bs.modal', function () {
        $("#editMaintenanceServiceForm").trigger('reset');
        $("#editMaintenanceServiceForm").data('validator').resetForm();
        $("#editMaintenanceServiceForm .form-control.error").removeClass('error');
        $("#editMaintenanceServiceForm .form-control").removeAttr('aria-invalid');
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
    $.ajax({
        url: editMaintenServiceURL,
        type: 'post',
        data: {
            _token: csrfToken,
            mainten_service_id: $(el).data('id')
        },
        success: function (res) {
            // Success
            $("#editMaintenanceServiceForm").html('');
            $("#editMaintenanceServiceForm").html('<input type="hidden" name="_token" value=' + csrfToken + '">');
            $("#editMaintenanceServiceForm").append(res);
            $("#edit").modal('show');
        },
        error: function (jqXHR, status, err) {
            toastr.error("Could not get details. Please try again", '', { closeButton: true });
        }
    });
}

function changeActivationStatus(el) {
    let maintenServiceId = $(el).data('id');

    toastr.warning("<br /><button type='button' class='btn btn-success mr-2' value='yes'>Yes</button><button class='btn btn-danger' type='button' value='no' >No</button>", 'Are you sure?', {
        allowHtml: true,
        onclick: function (toast) {
            value = toast.target.value
            if (value == 'yes') {
                var url = activationStatusChangeURL;

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        "_token": csrfToken,
                        mainten_service_id: maintenServiceId
                    },
                    success: function (response) {
                        toastr.remove();

                        if (response['IS_ACTIVE'] == 'Y') {
                            $(el).removeClass('btn-success').addClass('btn-danger');
                            $(el).html('<i class="ti-close"></i>');
                            $(el).attr('title', 'Deactivate');
                            $(el).closest('td').prev().html('Active');

                        } else {
                            $(el).removeClass('btn-danger').addClass('btn-success');
                            $(el).html('<i class="ti-reload"></i>');
                            $(el).attr('title', 'Activate');
                            $(el).closest('td').prev().html('Inactive');
                        }

                        toastr.success('Status Updated', '', {
                            closeButton: true
                        });
                    },
                    error: function (jqXHR, textStatus, err) {
                        toastr.remove();
                        toastr.error("Error updating status. Please try again", '', { closeButton: true });
                    }
                });

            } else {
                toastr.remove();
            }
        }
    });
}