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
            duration: {
                required: true,
                number: true,
                min: 0
            },
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

    $("#updateTransactionDetailsForm").validate({
        rules: {
            transaction_date: 'required',
            driver: 'required',
            purpose: 'required',
            duration: {
                required: true,
                number: true,
                min: 0
            },
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
                    if (res.successCode === 1) {
                        toastr.success(res.message, '', { closeButton: true });
                        $("#edit").modal('hide');
                        loadTable(transactionsTable);
                    } else {
                        toastr.error(res.message, '', { closeButton: true });
                    }
                },
                error: function () {
                    toastr.error("Error updating details. Please try again", '', { closeButton: true });
                }
            });
        }
    });

    // On resetting Update Transaction Details Form
    $("#resetUpdateFormBtn").click(function () {
        setTimeout(() => {
            $("#editTransactionForDriver").val($("#editTransactionForDriver").data('og-selection')).change();
            $("#editTransactionPurpose").val($("#editTransactionPurpose").data('og-selection'));
            $("#updateTransactionDetailsForm").data('validator').resetForm();
            // For Date Range Picker to reflect initially set set date:
            $("#editTransactionDate").data('daterangepicker').setStartDate($("#editTransactionDate").data('og-date'));
            $("#editTransactionDate").data('daterangepicker').setEndDate($("#editTransactionDate").data('og-date'));
        }, 10);
    });

    // On closing the Update Transaction Form Modal
    $("#edit").on('hidden.bs.modal', function () {
        $("#updateTransactionDetailsForm").data('validator').resetForm();
        $("#updateTransactionDetailsForm .form-control").removeAttr('aria-invalid').removeClass('error');
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
// /\ End of jQuery document.ready block 

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
                    <i class="ti-pencil"></i>
                    </button>`;

                    let transactionPurpose = data.PURPOSE == 1 ? 'Over Time' : '';
                    let dateAdded = data.CREATED_ON.substring(0, 10);
                    table.row.add([
                        i + 1,
                        data.TRANSACTION_DATE,
                        data.DRIVER_NAME,
                        transactionPurpose,
                        data.DURATION,
                        data.AMOUNT,
                        dateAdded,
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
    $("#editTransactionId").val(transaction_id);
    $.ajax({
        url: transactionDetailsURL,
        type: 'post',
        data: {
            _token: csrfToken,
            transaction_id: transaction_id
        },
        beforeSend: function () {
            $('.customloader').show();
        },
        dataType: 'json',
        success: function (res) {
            // console.log(res);
            $("#editTransactionDate").val(res.TRANSACTION_DATE);
            $("#editTransactionDate").data('og-date', res.TRANSACTION_DATE);
            $("#editTransactionDate").attr('value', res.TRANSACTION_DATE);

            // For Date Range Picker to reflect set date:
            $("#editTransactionDate").data('daterangepicker').setStartDate(res.TRANSACTION_DATE);
            $("#editTransactionDate").data('daterangepicker').setEndDate(res.TRANSACTION_DATE);

            $("#editTransactionForDriver").val(res.DRIVER_ID).change();
            $("#editTransactionForDriver").data('og-selection', res.DRIVER_ID);
            $("#editTransactionPurpose").val(res.PURPOSE);
            $("#editTransactionPurpose").data('og-selection', res.PURPOSE);
            $("#editDurationForOvertime").val(res.DURATION);
            $("#editDurationForOvertime").attr('value', res.DURATION);
            $("#editTransactionAmt").val(res.AMOUNT);
            $("#editTransactionAmt").attr('value', res.AMOUNT);
            $("#edit").modal('show');
            $(".customloader").hide();
        },
        error: function () {
            toastr.error("Error getting detals. Please try again", "", { closeButton: true })
            $(".customloader").hide();
        }
    });
}