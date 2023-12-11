/* Begin jQuery document.ready block */
$(document).ready(function () {
    let logInfoTable = $("#logInfoTable").DataTable({
        "columnDefs": [
            { "width": "50px", "targets": 0 },
            { "max-width": "30%", "targets": 1 },
            { "width": "60px", "orderable": false, "className": "text-center", "targets": 5 }
        ],
        "autoWidth": false
    });

    // To enable datepicker on the filter date
    $("#filterDate").daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        autoUpdateInput: false,
        autoApply: false,
        locale: {
            format: 'DD-MMM-YYYY'
        }
    });
    $("#filterDate").on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format('DD-MMM-YYYY'));
    });
    $("#filterDate").on('cancel.daterangepicker', function (ev, picker) {
        $(this).val('');
    });

    loadTable(logInfoTable);

    // To prevent page reload on submit
    $("#filterLogsForm").submit(function (ev) {
        ev.preventDefault();
        loadTable(logInfoTable);
    });

    $("#btn-reset").click(function () {
        setTimeout(() => {
            loadTable(logInfoTable);
        }, 10);
    });

    $("#add0").on('shown.bs.modal', function (ev) {
        // Enable Datepicker on showing Add new log Form modal
        $("#loggedDate").daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            autoUpdateInput: false,
            autoApply: false,
            locale: {
                format: 'DD-MMM-YYYY'
            }
        });
        $("#loggedDate").on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('DD-MMM-YYYY'));
        });
        $("#loggedDate").on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
        });
    });

    // To validate and submit Add New Log Form
    $("#addLogForm").validate({
        rules: {
            driver: 'required',
            log_date: 'required',
            log_category: 'required',
            remarks: {
                required: true,
                minlength: 3,
                maxlength: 200
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
                    toastr.success(res.message, '', { closeButton: true });
                    $("#add0").modal('hide');
                    loadTable(logInfoTable);
                },
                error: function (jqXHR, textStatus, err) {
                    toastr.error(res.message, '', { closeButton: true });
                }
            });
        }
    });

    // On resetting Add New Log Form
    $("#resetAddFormBtn").click(function () {
        setTimeout(() => {
            $("#addLogForm").trigger('reset');
            $("#addLogForm .basic-single").change();
            $("#addLogForm").data('validator').resetForm();
            $("#addLogForm .form-control").removeClass('error').removeAttr('aria-invalid');
        }, 10);
    });

    // On closing Add New Log form, reset validations
    $("#add0").on('hidden.bs.modal', function (ev) {
        $("#addLogForm").trigger('reset');
        $("#addLogForm .basic-single").change();
        $("#addLogForm").data('validator').resetForm();
        $("#addLogForm .form-control").removeClass('error').removeAttr('aria-invalid');
    });

    // Validate and Submit the Edit Log Form
    $("#editLogForm").validate({
        rules: {
            driver: 'required',
            log_date: 'required',
            log_category: 'required',
            remarks: {
                required: true,
                minlength: 3,
                maxlength: 200
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
                    toastr.success(res.message, '', { closeButton: true });
                    $("#edit").modal('hide');
                    loadTable(logInfoTable);
                },
                error: function (jqXHR, textStatus, err) {
                    toastr.error(res.message, '', { closeButton: true });
                }
            });
        }
    });


    // On resetting the Edit Form, reset values using saved data-* attributes
    $("#resetEditFormBtn").click(function () {
        setTimeout(() => {
            $("#editLogForm").data('validator').resetForm();
            $("#editLogForm .form-control").removeClass('error').removeAttr('aria-invalid');
            $("#editLoggedDriver").val($("#editLoggedDriver").attr('data-og-value')).change();
            $("#editLogCategory").val($("#editLogCategory").attr('data-og-value'));
            $("#editLogRemarks").val($("#editLogRemarks").attr('data-og-value'));

            // For Date Range Picker to reflect original date:
            $("#editLoggedDate").data('daterangepicker').setStartDate($("#editLoggedDate").attr('data-og-value'));
            $("#editLoggedDate").data('daterangepicker').setEndDate($("#editLoggedDate").attr('data-og-value'));
        }, 10);
    });
});
/* End jQuery document.ready block */

/* To populate the log entries table on filtering or updating data */
function loadTable(table) {
    $.ajax({
        url: loadTableDataURL,
        type: 'post',
        data: {
            _token: csrfToken,
            driver_sr: $("#filterDriver").val(),
            date_sr: $("#filterDate").val(),
            log_categ_sr: $("#filterLogCategory").val()
        },
        dataType: 'json',
        beforeSend: function () {
            $("#table-loader").show();
        },
        success: function (res) {
            // console.log(res);
            table.clear();
            if (res.length >= 1) {
                $.each(res, function (i, data) {
                    let logDate = moment(data.DATE).format('DD-MMM-YYYY');

                    let actionBtns = `<button type="button" class="btn btn-info btn-sm" onclick="editInfo(${data.INFO_LOG_ID})">
                    <i class="ti-pencil"></i></button>`;
                    table.row.add([
                        i + 1,
                        data.DRIVER_NAME,
                        logDate,
                        data.CATEGORY,
                        data.REMARKS,
                        actionBtns
                    ]);
                });
            }
            table.draw();
        },
        error: function () {
            toastr.error('Error loading data. Please try again', '', { closeButton: true });
        },
        complete: function () {
            $("#table-loader").hide();
        }
    });
}

/* Show form to Edit a specific information log */
function editInfo(id) {
    $.ajax({
        url: getLogDetailsURL,
        type: 'post',
        data: {
            _token: csrfToken,
            log_id: id
        },
        beforeSend: function () {
            $('.customloader').show();
        },
        dataType: 'json',
        success: function (res) {
            // console.log(res);
            // On success, load details from res to Edit Form, show the modal with the form

            $("#editLogId").val(id);

            let logDate = moment(res.DATE).format('DD-MMM-YYYY');
            $("#editLoggedDriver").attr('value', res.DRIVER);
            $("#editLoggedDriver").attr('data-og-value', res.DRIVER);
            $("#editLoggedDriver").val(res.DRIVER).change();

            $("#editLoggedDate").attr('value', logDate);
            $("#editLoggedDate").val(logDate);
            $("#editLoggedDate").attr('data-og-value', logDate);
            $("#editLogCategory").attr('data-og-value', res.CATEGORY);
            $("#editLogCategory").val(res.CATEGORY);
            $("#editLogRemarks").attr('data-og-value', res.REMARKS);
            $("#editLogRemarks").val(res.REMARKS);

            $("#editLoggedDate").daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                autoUpdateInput: false,
                autoApply: false,
                locale: {
                    format: 'DD-MMM-YYYY'
                }
            });
            $("#editLoggedDate").on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('DD-MMM-YYYY'));
            });
            $("#editLoggedDate").on('cancel.daterangepicker', function (ev, picker) {
                $(this).val('');
            });

            // For Date Range Picker to reflect set date:
            $("#editLoggedDate").data('daterangepicker').setStartDate(logDate);
            $("#editLoggedDate").data('daterangepicker').setEndDate(logDate);

            $("#edit").modal('show');
            $('.customloader').hide();
        },
        error: function () {
            toastr.error('Error getting details. Please try again', '', { closeButton: true });
            $('.customloader').hide();
        }
    });
}