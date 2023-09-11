$(document).ready(function () {
    let refuelRequestsTable = $("#refuel_requests").DataTable();

    populateTable(refuelRequestsTable);

    // Validate and Submit Add Refuel Requisition Form
    $("#addRefuelRequisitionForm").validate({
        rules: {
            vehicle_name: {
                required: true
            },
            qty: {
                required: true
            },
            fuel_station: 'required',
            fuel_type: 'required',
            current_odometer: {
                required: true
            },
            amount: {
                required: true
            }
        },
        errorElement: 'div',
        errorPlacement: function (error, element) {
            $(element).closest('div[class*=col-sm-]').append(error);
        },
        submitHandler: function (form, ev) {
            ev.preventDefault();
            console.log($(form).serialize());

            $.ajax({
                url: form.action,
                type: form.method,
                data: $(form).serialize(),
                success: function (res) {
                    if (res.successCode == 1) {
                        toastr.success(res.message, '', { closebutton: true });
                        $("#add0").modal('hide');

                        populateTable(refuelRequestsTable);
                    } else {
                        toastr.error(res.message, '', { closeButton: true });
                    }
                },
                error: function (jqXHR, textStatus, err) {
                    toastr.error("Error adding requisition details. Please try again", "", { closeButton: true });
                }
            });
        }
    });

    // On closing modal, reset ADD Refuel Requisition Form
    $("#add0").on('hidden.bs.modal', function () {
        $("#addRefuelRequisitionForm").trigger('reset');
        $("#addRefuelRequisitionForm").validate().resetForm();
        $("#addRefuelRequisitionForm .form-control.error").removeClass('error').removeAttr('aria-invalid');

        // To prevent select2 boxes still displaying previously selected value on resetting form
        $('#add0 .basic-single').val('').trigger('change');
    });

    // To reset form validation and remove errors on resetting add requisition form
    $("#resetAddRefuelReqFormBtn").click(function () {
        $("#addRefuelRequisitionForm").trigger('reset');
        $("#addRefuelRequisitionForm").validate().resetForm();
        $("#addRefuelRequisitionForm .form-control.error").removeClass('error').removeAttr('aria-invalid');

        // To prevent select2 boxes still displaying previously selected value on resetting form
        $('#add0 .basic-single').val('').trigger('change');
    });

    // Validate and submit Update Refuel Requisition Form
    $("#editRefuelRequisitionForm").validate({
        rules: {
            vehicle_name: {
                required: true
            },
            qty: {
                required: true
            },
            fuel_station: 'required',
            fuel_type: 'required',
            current_odometer: {
                required: true
            },
            amount: {
                required: true
            }
        },
        errorElement: 'div',
        errorPlacement: function (error, element) {
            $(element).closest('div[class*=col-sm-]').append(error);
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
                        $("#edit").modal('hide');
                        populateTable(refuelRequestsTable);
                    } else {
                        toastr.error(res.message, '', { closeButton: true });
                    }
                },
                error: function (jqXHR, textStatus, err) {
                    toastr.error("Something went wrong updating. Please try again", "", { closeButton: true });
                }
            });
        }
    });

    // On closing modal, reset Update Refuel Requisition Form
    $("#edit").on('hidden.bs.modal', function () {
        $("#editRefuelRequisitionForm").trigger('reset');
        $("#editRefuelRequisitionForm").validate().resetForm();
        $("#editRefuelRequisitionForm .form-control.error").removeClass('error').removeAttr('aria-invalid');

        // To prevent select2 boxes still displaying previously selected value on resetting form
        $('#edit .basic-single').val('').trigger('change');
    });
});

function populateTable(table) {
    $.ajax({
        url: refuelRequisitionsListURL,
        method: 'post',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        dataType: 'json',
        success: function (res) {
            table.clear();
            $.each(res, function (i, data) {
                let reqStatus = data.STATUS == 'P' ? "Pending" : "Released";

                let actionBtns = '<button type="button" class="btn btn-info mr-1" title="Edit" data-id="' + data.REFUEL_REQUISITION_ID + '" onclick="editInfo(this)"><i class="ti-pencil"></i></button>';
                if (data.IS_ACTIVE == 'Y')
                    actionBtns += '<button type="button" class="btn btn-danger mr-1" title="Deactivate" data-id="' + data.REFUEL_REQUISITION_ID + '" onclick="changeActivationStatus(this)"><i class="ti-close"></i></button>';
                else
                    actionBtns += '<button type="button" class="btn btn-success mr-1" title="Activate" data-id="' + data.REFUEL_REQUISITION_ID + '" onclick="changeActivationStatus(this)"><i class="ti-reload"></i></button>';

                let statusChangeBtnsContainer = `<div class="text-right" style="display:inline-block;">
                                        <div class="actions" style="display:inline-block;">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changeStatus2(0, ${data.REFUEL_REQUISITION_ID})" class="dropdown-item">Pending</a>
                                                    <a onclick="changeStatus2(1, ${data.REFUEL_REQUISITION_ID})" class="dropdown-item">Release</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>`;

                actionBtns += statusChangeBtnsContainer;
                table.row.add([
                    i + 1,
                    data.VEHICLE_NAME,
                    data.FUEL_TYPE,
                    data.CURRENT_ODOMETER,
                    data.QUANTITY,
                    data.FUEL_STATION,
                    data.AMOUNT,
                    reqStatus,
                    actionBtns
                ]);
            });

            table.draw(false);
        },
        error: function (jqXHR, textStatus, err) {
            console.log("Could not fetch data");
            toastr.error("Error fetching data. Please refresh and try again", "", { closeButton: true });
        }
    });
}

function editInfo(el) {
    $.ajax({
        url: getReqDetailsURL,
        type: 'post',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            refuel_req_id: $(el).data('id')
        },
        dataType: 'json',
        success: function (res) {
            if (res.successCode == 1) {
                console.log(res.data);
                $("#editRefuelReqId").val($(el).data('id'));
                $("#edit").modal('show');
                $("#new_vehicle_name").val(res.data.VEHICLE_ID).trigger('change');
                $("#new_vehicle_name").data('original-selection', res.data.VEHICLE_ID);
                $("#new_qty").attr('value', res.data.QUANTITY);
                $("#new_fuel_station").val(res.data.FUEL_STATION).trigger('change');
                $("#new_fuel_station").data('original-selection', res.data.FUEL_STATION);
                $("#new_fuel_type").val(res.data.FUEL_TYPE).trigger('change');
                $("#new_fuel_type").data('original-selection', res.data.FUEL_TYPE);
                $("#new_current_odometer").attr('value', res.data.CURRENT_ODOMETER);
                if (res.data.STATUS == 'R')
                    $("#new_amount").attr('value', res.data.AMOUNT).prop('disabled', true);
                else
                    $("#new_amount").attr('value', res.data.AMOUNT);
            } else {
                console.log(res.message);
                toastr.error(res.message, '', { closeButton: true });
            }
        },
        error: function (jqXHR, textStatus, err) {
            toastr.error("Something went wrong fetching details. Please try again", '', { closeButton: true })
        }
    });
}

// On clicking the reset button of the edit form
$("#resetUpdateRefuelReqFormBtn").click(function () {
    setTimeout(() => {
        $("#new_vehicle_name").val($("#new_vehicle_name").data('original-selection')).trigger('change');
        $("#new_fuel_station").val($("#new_fuel_station").data('original-selection')).trigger('change');
        $("#new_fuel_type").val($("#new_fuel_type").data('original-selection')).trigger('change');
    }, 10)
});

function changeStatus2(status, reqId) {
    // Status 0 = Pending, 1 = Approved (in controller)
    let refuelReqTable = $("#refuel_requests").DataTable();

    if (window.confirm("Are you sure?")) {
        $.ajax({
            url: reqStatusUpdateURL,
            type: 'post',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                refuel_req_id: reqId,
                requisition_status: status
            },
            success: function (res) {
                populateTable(refuelReqTable);
                toastr.success("Status Updated successfully", "", { closeButton: true });
            },
            error: function (jqXHR, status, err) {
                toastr.error("Something went wrong updating requisition status. Please try again");
            }
        })
    }
}

function changeActivationStatus(el) {
    let refuelReqId = $(el).data('id');
    let refuelReqTable = $("#refuel_requests").DataTable();

    if (confirm("Are you sure?")) {
        $.ajax({
            url: reqActivationUpdateURL,
            type: 'post',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                refuel_req_id: refuelReqId
            },
            success: function (res) {
                populateTable(refuelReqTable);
                toastr.success("Updated successfully", "", { closeButton: true });
            },
            error: function (jqxhr, status, err) {
                toastr.error("Something went wrong updating activation status. Please try again");
            }
        });
    }
}