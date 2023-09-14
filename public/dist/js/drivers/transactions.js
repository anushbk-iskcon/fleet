$(document).ready(function () {
    let transactionsTable = $("#driverTransactionsTable").DataTable();

    loadTable(transactionsTable);

    // On clicking the filter button, show filters
    // $("#filterBtn").click(function () {
    //     $("#filterFormContainer").toggleClass('d-none');
    //     $("#filterBtn").toggleClass('btn-success');
    // });

    // Validate and submit Add Transaction / Over time details form
    $("#addTransactionDetailsForm").validate({
        rules: {
            transaction_date: 'required',
            driver: 'required',
            purpose: 'required',
            duration: 'required',
            amount: {
                required: true,
                number: true,
                min: 0
            }
        },
        errorElement: 'div',
        errorPlacement: function (error, element) {
            $(element).closest('div[class*=col-sm-]').append(error);
        },
        submitHandler: function (form, ev) {
            ev.preventDefault();
        }
    });

    // On closing Add details From modal, reset validations
    $("#add0").on('hidden.bs.modal', function () {
        $("#addTransactionDetailsForm").trigger('reset');
        $("#addTransactionDetailsForm").data('validator').resetForm();
        $("#addTransactionDetailsForm .form-control").removeClass('error').removeAttr('aria-invalid');
        $("#addTransactionDetailsForm .basic-single").val("").trigger('change');
    });

    // On resetting Add details form, remove validation errors
    $("#resetAddFormBtn").click(function () {
        setTimeout(() => {
            $("#addTransactionDetailsForm").data('validator').resetForm();
            $("#addTransactionDetailsForm .form-control").removeClass('error').removeAttr('aria-invalid');
            $("#addTransactionDetailsForm .basic-single").val("").trigger('change');
        }, 10);
    });
});

function loadTable(table) { }