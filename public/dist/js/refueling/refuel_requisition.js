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
            }
        },
        errorElement: 'div',
        errorPlacement: function (error, element) {
            $(element).closest('div[class*=col-sm-]').append(error);
        },
        submitHandler: function (form, ev) {
            ev.preventDefault();
            console.log($(form).serialize());
        }
    });

    // On closing modal, reset ADD Refuel Requisition Form
    $("#add0").on('hidden.bs.modal', function () {
        $("#addRefuelRequisitionForm").trigger('reset');
        $("#addRefuelRequisitionForm").validate().resetForm();
        $("#addRefuelRequisitionForm .form-control.error").removeClass('error').removeAttr('aria-invalid');
    });

    // Validate and submit Update Refuel Requisition Form

    // On closing modal, reset Update Refuel Requisition Form
});

function populateTable(table) { }