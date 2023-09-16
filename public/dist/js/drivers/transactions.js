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

    // On selecting driver in Add Form, validate to remove any existing error message
    $("#transactionForDriver").on('change', function () {
        $("#transactionForDriver").valid();
    });

    // On closing Add details Form modal, reset validations
    $("#add0").on('hidden.bs.modal', function () {
        $("#addTransactionDetailsForm").trigger('reset');
        $("#addTransactionDetailsForm .basic-single").val("").trigger('change');
        $("#addTransactionDetailsForm").data('validator').resetForm();
        $("#addTransactionDetailsForm .form-control").removeClass('error').removeAttr('aria-invalid');
    });

    // On resetting Add details form, remove validation errors
    $("#resetAddFormBtn").click(function () {
        setTimeout(() => {
            $("#addTransactionDetailsForm .basic-single").val("").trigger('change');
            $("#addTransactionDetailsForm").data('validator').resetForm();
            $("#addTransactionDetailsForm .form-control").removeClass('error').removeAttr('aria-invalid');
        }, 10);
    });

    $("#btn-filter").click(function () {
        loadTable(transactionsTable);
    });

    $("#btn-reset").click(function () {
        $("#filter_driver").val('').trigger('change');
        $("#filter_date").val('');
        $("#filterPurpose").val('');
        loadTable(transactionsTable);
    })


});

function loadTable(table) {
    // $.ajax({
    //     url: '',
    //     type: 'post',
    //     data: {
    //         _token: csrfToken
    //     },
    //     dataType: 'json',
    //     beforeSend: function () {
    //     $("#table-loader").show();
    // },
    //     success: function (res) { },
    //     error: function () { },
    //     complete: function () {
    //     $("#table-loader").hide();
    // }
    // });
}