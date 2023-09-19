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

            $.ajax({
                url: form.action,
                type: form.method,
                data: $(form).serialize(),
                dataType: 'json',
                success: function (res) {
                    if (res.successCode == 1) {
                        toastr.success(res.message, '', { closeButton: true });
                        loadTable(transactionsTable);
                        $("#add0").modal('hide');
                    } else {
                        toastr.error(res.message, '', { closeButton: true });
                    }
                },
                error: function (jqXHR, textStatus, err) {
                    toastr.error('Error adding details. Please try again', '', { closeButton: true });
                }
            });
        }
    });
    // /\ End of jQuery document.ready block 

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
    });


});

function loadTable(table) {
    $.ajax({
        url: transactionsListURL,
        type: 'post',
        data: {
            _token: csrfToken,
            driver_sr: $("#filter_driver").val(),
            date_sr: $("#filter_date").val(),
            purpose_sr: $("#filterPurpose").val()
        },
        dataType: 'json',
        beforeSend: function () {
            $("#table-loader").show();
        },
        success: function (res) {
            table.clear();
            if (res.length >= 1) {
                // console.log(res);
                $.each(res, function (i, data) {
                    let actionBtns = `<button class="btn btn-sm btn-info" title="Edit" onclick="editInfo(${data.TRANSACTION_ID})">
                    <i class="fas fa-edit"></i>
                    </button>`;

                    let transactionPurpose = data.PURPOSE == 1 ? 'Over Time' : '';

                    table.row.add([
                        i + 1,
                        data.TRANSACTION_DATE,
                        data.DRIVER_NAME,
                        transactionPurpose,
                        data.DURATION,
                        data.AMOUNT,
                        data.CREATED_ON,
                        actionBtns
                    ]);
                });
            }
            table.draw();
        },
        error: function () {
            toastr.error("Error loading data. Please try again", "", { closeButton: true });
        },
        complete: function () {
            $("#table-loader").hide();
        }
    });
}

function editInfo(transaction_id) {
    // console.log(transaction_id);
    $.ajax({
        url: transactionDetailsURL,
        type: 'post',
        data: {
            _token: csrfToken,
            transaction_id: transaction_id
        },
        dataType: 'json',
        success: function (res) {
            console.log(res);
        },
        error: function () {
            console.log("Error getting details");
        }
    });
}