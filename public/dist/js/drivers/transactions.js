$(document).ready(function () {
    let transactionsTable = $("#driverTransactionsTable").DataTable({
        "columnDefs": [{
            "orderable": false,
            "width": "55px",
            "className": "text-center",
            "targets": 7
        }],
        "autoWidth": false
    });

    loadTable(transactionsTable);

    // On clicking the filter button, show filters
    // $("#filterBtn").click(function () {
    //     $("#filterFormContainer").toggleClass('d-none');
    //     $("#filterBtn").toggleClass('btn-success');
    // });

    // Enable Datepicker for the filter
    $("#filter_date").daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        //minYear: 1901,
        autoUpdateInput: false,
        locale: {
            cancelLabel: 'Clear',
            format: "DD-MMM-YYYY"
        }
    });
    $("#filter_date").on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format('DD-MMM-YYYY'));
    });
    $("#filter_date").on('cancel.daterangepicker', function (ev, picker) {
        $(this).val('');
    });

    // Enable Datepicker on the Add Form on opening modal:
    $("#add0").on('shown.bs.modal', function () {
        $("#addTransactionDetailsForm .new-datepicker").daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear',
                "format": "DD-MMM-YYYY"
            }
        });

        $("#addTransactionDetailsForm .new-datepicker").on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('DD-MMM-YYYY'));
        });
        $("#addTransactionDetailsForm .new-datepicker").on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
        });
    });

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

    // On selecting driver in Add Form, Load OT rate for the driver
    $("#transactionForDriver").on('change', function () {
        if ($("#transactionForDriver").val()) {
            $.ajax({
                url: getDriverOTRateURL,
                type: 'post',
                data: {
                    _token: csrfToken,
                    driver_id: $("#transactionForDriver").val()
                },
                beforeSend: function () {
                    $('.customloader').show();
                },
                success: function (res) {
                    if (res != null && res != undefined)
                        $("#driverOTRate").val(res);
                    else
                        $("#driverOTRate").val(0);
                    $("#addDriverOTRate").css('display', 'flex');

                    let totalOTVal = $("#driverOTRate").val() * $("#durationForOvertime").val();
                    $("#transactionAmt").val(totalOTVal);
                },
                error: function () {
                    toastr.error("Error getting details. Please try again", '', { closeButton: true });
                    $("#addDriverOTRate").css('display', 'none');
                },
                complete: function () {
                    $('.customloader').hide();
                }
            });
        } else {
            $("#addDriverOTRate").css('display', 'none');
        }
    });

    // On selecting driver in Edit Form, Load OT rate for the driver
    $("#editTransactionForDriver").on('change', function () {
        if ($("#editTransactionForDriver").val()) {
            $.ajax({
                url: getDriverOTRateURL,
                type: 'post',
                data: {
                    _token: csrfToken,
                    driver_id: $("#editTransactionForDriver").val()
                },
                beforeSend: function () {
                    $('.customloader').show();
                },
                success: function (res) {
                    if (res != null && res != undefined)
                        $("#editDriverOTRate").val(res);
                    else
                        $("#editDriverOTRate").val(0);
                    $("#editDriverOTRateRow").css('display', 'flex');

                    let totalOTVal = $("#editDriverOTRate").val() * $("#editDurationForOvertime").val();
                    $("#editTransactionAmt").val(totalOTVal);
                },
                error: function () {
                    toastr.error("Error getting details. Please try again", '', { closeButton: true });
                    $("#editDriverOTRateRow").css('display', 'none');
                },
                complete: function () {
                    $('.customloader').hide();
                }
            });
        } else {
            $("#editDriverOTRateRow").css('display', 'none');
        }
    });

    // On entering number of hours worked in add transaction form, update total overtime
    $("#durationForOvertime").on('input', function () {
        if ($("#transactionForDriver").val()) {
            let totalOTVal = $("#driverOTRate").val() * $("#durationForOvertime").val();
            $("#transactionAmt").val(totalOTVal);
        }
    });

    // On entering number of hours worked in EDIT transaction form, update total overtime
    $("#editDurationForOvertime").on('input', function () {
        if ($("#editTransactionForDriver").val()) {
            let totalOTVal = $("#editDriverOTRate").val() * $("#editDurationForOvertime").val();
            $("#editTransactionAmt").val(totalOTVal);
        }
    });

    // On selecting department in dropdown in Add From, set department name also to be sent to server
    $("#addTransactionDeptCode").change(function () {
        let deptName = $(this).find(':selected').text();
        if ($(this).val())
            $("#addTransactionDeptName").val(deptName);
        else
            $("#addTransactionDeptName").val('');
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


    // On selecting department in dropdown in EDIT From, set department name also to be sent to server
    $("#editTransactionDeptCode").change(function () {
        let deptName = $(this).find(':selected').text();
        if ($(this).val())
            $("#editTransactionDeptName").val(deptName);
        else
            $("#editTransactionDeptName").val('');
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
            $("#editTransactionDate").data('daterangepicker').setStartDate($("#editTransactionDate").attr('data-og-date'));
            $("#editTransactionDate").data('daterangepicker').setEndDate($("#editTransactionDate").attr('data-og-date'));
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

                    let transactionDate = moment(data.TRANSACTION_DATE).format('DD-MMM-YYYY');
                    let transactionPurpose = data.PURPOSE == 1 ? 'Over Time' : '';
                    let dateAdded = data.CREATED_ON.substring(0, 10);
                    let dateRecorded = moment(dateAdded).format('DD-MMM-YYYY');
                    table.row.add([
                        i + 1,
                        transactionDate,
                        data.DRIVER_NAME,
                        transactionPurpose,
                        data.DURATION,
                        data.AMOUNT,
                        dateRecorded,
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
            let transactionDate = moment(res.TRANSACTION_DATE).format('DD-MMM-YYYY');

            $("#editTransactionDate").val(transactionDate);

            $("#editTransactionDate").attr('data-og-date', transactionDate);
            $("#editTransactionDate").attr('value', transactionDate);

            // To enable date picker on date input
            $("#updateTransactionDetailsForm .new-datepicker").daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                minYear: 1901,
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear',
                    "format": "DD-MMM-YYYY"
                }
            });

            $("#updateTransactionDetailsForm .new-datepicker").on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('DD-MMM-YYYY'));
            });
            $("#updateTransactionDetailsForm .new-datepicker").on('cancel.daterangepicker', function (ev, picker) {
                $(this).val('');
            });

            // For Date Range Picker to reflect set date:
            $("#editTransactionDate").data('daterangepicker').setStartDate(transactionDate);
            $("#editTransactionDate").data('daterangepicker').setEndDate(transactionDate);

            $("#editTransactionForDriver").val(res.DRIVER_ID).change();
            $("#editTransactionForDriver").data('og-selection', res.DRIVER_ID);
            $("#editTransactionPurpose").val(res.PURPOSE);
            $("#editTransactionPurpose").data('og-selection', res.PURPOSE);
            $("#editDurationForOvertime").val(res.DURATION);
            $("#editDurationForOvertime").attr('value', res.DURATION);
            $("#editTransactionAmt").val(res.AMOUNT);
            $("#editTransactionAmt").attr('value', res.AMOUNT);
            $("#editDevoteeName").val(res.DEVOTEE_NAME);
            $("#editTransactionDeptCode").val(res.DEVOTEE_DEPARTMENT_CODE).change();
            $("#edit").modal('show');

            // $("#resetUpdateFormBtn").click(function () {
            //     setTimeout(() => {
            //         $("#editTransactionForDriver").val($("#editTransactionForDriver").data('og-selection')).change();
            //         $("#editTransactionPurpose").val($("#editTransactionPurpose").data('og-selection'));
            //         $("#updateTransactionDetailsForm").data('validator').resetForm();

            //         // For Date Range Picker to reflect initially set set date:
            //         $("#editTransactionDate").data('daterangepicker').setStartDate($("#editTransactionDate").attr('data-og-date'));
            //         $("#editTransactionDate").data('daterangepicker').setEndDate($("#editTransactionDate").attr('data-og-date'));
            //     }, 10);
            // });

            $(".customloader").hide();
        },
        error: function () {
            toastr.error("Error getting details. Please try again", "", { closeButton: true });
            $(".customloader").hide();
        }
    });
}