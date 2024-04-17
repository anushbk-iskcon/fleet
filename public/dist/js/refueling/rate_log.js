$.validator.addMethod('toDateGreaterThan', function (value, element, param) {
    let startDateValue = $(param).val();
    return (this.optional(element) || moment(value).isAfter(startDateValue) || moment(value).isSame(startDateValue));
}, 'End date should be after or the same as start date');

$(document).ready(function () {

    let fuelRateLogTable = $("#fuelRateLogTable").DataTable({
        columnDefs: [{ width: '120px', orderable: false, targets: [4] }],
        autoWidth: false
    });

    loadTable(fuelRateLogTable);

    // Enable date-pickers for Filter Dates
    $("#filterDateFrom, #filterDateTo").daterangepicker({
        singleDatePicker: true,
        autoUpdateInput: false
    });
    $("#filterDateFrom, #filterDateTo").on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format('DD-MMM-YYYY'));
    });
    $("#filterDateFrom, #filterDateTo").on('cancel.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format(''));
    });

    // Enable date pickers in the Add form
    $("#fuelRateDateFrom, #fuelRateDateTill").daterangepicker({
        singleDatePicker: true,
        autoUpdateInput: false
    });
    $("#fuelRateDateFrom, #fuelRateDateTill").on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format('DD-MMM-YYYY'));
    });
    $("#fuelRateDateFrom, #fuelRateDateTill").on('cancel.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format(''));
    });

    // Validate and submit the Add Rate log form
    $("#addFuelRateForm").validate({
        rules: {
            date_from: 'required',
            date_to: {
                toDateGreaterThan: $("#fuelRateDateFrom")
            },
            fuel_type: 'required',
            fuel_rate: {
                required: true,
                number: true,
                min: 0
            }
        },
        errorElement: 'div',
        errorPlacement: function (error, element) {
            $(element).closest('div[class*=col-]').append(error);
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
                        $("#add0").modal('hide');
                        loadTable(fuelRateLogTable);
                    } else {
                        toastr.error(res.message, '', { closeButton: true });
                    }
                },
                error: function (jqXHR, textStatus, err) {
                    toastr.error('Error adding details. Please try again', '', { closeButton: true });
                }
            })
        }
    });

    // On closing Add Modal, remove validation errors
    $("#add0").on('hidden.bs.modal', function () {
        $("#addFuelRateForm").trigger('reset');
        $("#addFuelRateForm").validate().resetForm();
        $("#addFuelRateForm .form-control.error").removeClass('error');
    });

    // On clearing the add form, remove validation errors
    $("#clearAddFormBtn").click(function (ev) {
        setTimeout(() => {
            $("#addFuelRateForm").validate().resetForm();
            $("#addFuelRateForm .form-control.error").removeClass('error');
        }, 10);
    });

    // On loading the Edit Form
    $("#edit").on('shown.bs.modal', function () {
        // Enable date-pickers in the Edit Form - locale object is required since we have set the edit value using moment().format()
        $("#updateFuelRateDateFrom, #updateFuelRateDateTill").daterangepicker({
            singleDatePicker: true,
            autoUpdateInput: false,
            locale: {
                format: 'DD-MMM-YYYY'
            }
        });
        $("#updateFuelRateDateFrom, #updateFuelRateDateTill").on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('DD-MMM-YYYY'));
        });
        $("#updateFuelRateDateFrom, #updateFuelRateDateTill").on('cancel.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format(''));
        });
    });

    // To validate and submit the Edit Form for updating data
    $("#updateFuelRateForm").validate({
        rules: {
            date_from: 'required',
            date_to: {
                toDateGreaterThan: $("#updateFuelRateDateFrom")
            },
            fuel_type: 'required',
            fuel_rate: {
                required: true,
                number: true,
                min: 0
            }
        },
        errorElement: 'div',
        errorPlacement: function (error, element) {
            $(element).closest('div[class*=col-]').append(error);
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
                        loadTable(fuelRateLogTable);
                    } else {
                        toastr.error(res.message, '', { closeButton: true });
                    }
                },
                error: function (jqXHR, textStatus, err) {
                    toastr.error('Error adding details. Please try again', '', { closeButton: true });
                }
            })
        }
    });

    // On clsoing the Edit Modal, remove validation errors
    $("#edit").on('hidden.bs.modal', function () {
        $("#updateFuelRateForm").data('validator').resetForm();
        $("#updateFuelRateForm .form-control.error").removeClass('error');
    });

});

// To load details to Edit Form
function editInfo(id) {
    $.ajax({
        url: getDetailsURL,
        type: 'post',
        data: {
            _token: csrfToken,
            log_id: id
        },
        dataType: 'json',
        success: function (res) {
            console.log(res);
            $("#updateFuelRateId").val(id);
            $("#updateFuelRateDateFrom").val(moment(res.FROM_DATE).format('DD-MMM-YYYY'));
            if (res.TO_DATE)
                $("#updateFuelRateDateTill").val(moment(res.TO_DATE).format('DD-MMM-YYYY'));
            else
                $("#updateFuelRateDateTill").val('');
            $("#updateFuelTypeForRate").val(res.FUEL_TYPE).change();
            $("#updateFuelRate").val(res.FUEL_RATE);
            $("#edit").modal('show');
        },
        error: function () {
            console.log("Error getting details");
        }
    });

}

// to activate/de-activate an entry
function updateActivation(id) {
    if (confirm("Are you sure?")) {
        $.ajax({
            url: activationChangeURL,
            type: 'post',
            data: {
                _token: csrfToken,
                log_id: id
            },
            dataType: 'json',
            success: function (res) {
                if (res.successCode == 1) {
                    toastr.success(res.message, '', { closeButton: true });
                    loadTable($("#fuelRateLogTable").DataTable());
                } else {
                    toastr.error(res.message, '', { closeButton: true });
                }
            },
            error: function () {
                toastr.error("Error performing this action. Please try again", '', { closeButton: true });
            }
        });
    }
}

// To populate the DataTable on page load, filtering or update
function loadTable(table) {
    $.ajax({
        url: listURL,
        type: 'post',
        data: {
            _token: csrfToken,
            filter_fuel_type: $("#filterFuelType").val(),
            filter_date_from: $("#filterDateFrom").val(),
            filter_date_to: $("#filterDateTo").val()
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
                    let actionBtns = `<button class="btn btn-info mr-2" onclick="editInfo(${data.FUEL_RATE_LOG_ID})" title="Edit">
                    <i class="ti-pencil"></i>
                    </button>`;
                    if (data.IS_ACTIVE == 'Y')
                        actionBtns += `<button class="btn btn-danger" onclick="updateActivation(${data.FUEL_RATE_LOG_ID})" title="Deactivate">
                    <i class="ti-close"></i>
                    </button>`;
                    else
                        actionBtns += `<button class="btn btn-danger" onclick="updateActivation(${data.FUEL_RATE_LOG_ID})" title="Activate">
                    <i class="ti-reload"></i>
                    </button>`;
                    table.row.add([
                        i + 1,
                        data.FUEL_TYPE_NAME,
                        moment(data.FROM_DATE).format('DD-MMM-YYYY'),
                        data.FUEL_RATE,
                        actionBtns
                    ]);
                });
            }

            table.draw();
        },
        error: function () {
            toastr.error("Error fetching data. Please try again", '', { closeButton: true });
        },
        complete: function () {
            $("#table-loader").hide();
        }
    });
}