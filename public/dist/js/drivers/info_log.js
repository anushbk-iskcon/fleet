/* Begin jQuery document.ready block */
$(document).ready(function () {
    let logInfoTable = $("#logInfoTable").DataTable();

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
            console.log(res);
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

/* Shwon form to Edit a specific information log */
function editInfo() {

}