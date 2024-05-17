$.validator.addMethod('dateLessThan', function (value, element, params) {
    return this.optional(element) || ($(params).val() ? moment(value, 'DD-MMM-YYYY').isBefore(moment($(params).val(), 'DD-MMM-YYYY')) : true);
}, 'Start Date should be less than Expiry Date');

$.validator.addMethod('dateGreaterThan', function (value, element, params) {
    return this.optional(element) || ($(params).val() ? moment(value, 'DD-MMM-YYYY').isAfter(moment($(params).val(), 'DD-MMM-YYYY')) : true);
}, 'Expiry Date should be greater than Start Date');

$(document).ready(function () {
    let chargesTable = $("#chargesTable").DataTable({
        autoWidth: false,
        columnDefs: [
            { width: '50px', targets: [0] },
            { orderable: false, targets: [7] }
        ]
    });

    // Enable date-pickers for Filter Dates
    $("#filterDateFrom, #filterDateTill").daterangepicker({
        singleDatePicker: true,
        autoUpdateInput: false
    });
    $("#filterDateFrom, #filterDateTill").on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format('DD-MMM-YYYY'));
    });
    $("#filterDateFrom, #filterDateTill").on('cancel.daterangepicker', function (ev, picker) {
        $(this).val('');
    });

    loadTable(chargesTable);

    // On selecting the Charge Type in Add From, show inpus ad other controls
    $("#addChargeType").change(function () {
        let additionalFields = '';
        let chargeType = $(this).val();
        $(this).attr('data-selection', chargeType);

        if (chargeType) {
            // Type = 1 for FC, 2 for Road Tax, 3 for Permit Charges
            additionalFields += `<div class="row">
            <div class="col-md-12 col-lg-6">
            <div class="form-group row">
                <label for="addVehicleType" class="col-form-label col-sm-5">Vehicle Type <i class="text-danger">*</i></label>
                <div class="col-sm-7">
                    <select name="vehicle_type" id="addVehicleType" class="form-control basic-single">
                    <option value="">Please Select</option>`;
            vehicleTypes.forEach((vehicleType) => {
                additionalFields += `<option value="${vehicleType['VEHICLE_TYPE_ID']}">${vehicleType['VEHICLE_TYPE_NAME']}</option>`;
            });

            additionalFields += `</select>
                </div>
            </div>
            <div class="form-group row">
                <label for="addChargeForVehicle" class="col-sm-5 col-form-label">Vehicle <i class="text-danger">*</i></label>
                <div class="col-sm-7">
                    <select name="vehicle" class="form-control basic-single" id="addChargeForVehicle">
                        <option value="">Please Select</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="addChallanNo" class="col-sm-5 col-form-label">Challan Number <i class="text-danger">*</i></label>
                <div class="col-sm-7">
                    <input type="text" name="challan_number" class="form-control" id="addChallanNo" placeholder="Challan No." maxlength="25">
                </div>
            </div>
            </div>`;  // End left half of form

            additionalFields += `<div class="col-md-12 col-lg-6">
            <div class="form-group row">
                <label for="addChargeAmount" class="col-form-label col-sm-5" id="addChargeAmountLabel"></label>
                <div class="col-sm-7">
                    <input type="number" name="amount" class="form-control" id="addChargeAmount" placeholder="Enter amount" maxlength="10">
                </div>
            </div>
            <div class="form-group row">
                <label for="addChargeFromDate" class="col-form-label col-sm-5" id="addFromDateLabel"></label>
                <div class="col-sm-7">
                    <input type="text" name="start_date" class="form-control" id="addChargeFromDate" placeholder="Start Date" autocomplete="off">
                </div>
            </div>
            <div class="form-group row">
                <label for="addChargeExpiryDate" class="col-form-label col-sm-5" id="addToDateLabel"></label>
                <div class="col-sm-7">
                    <input type="text" name="expiry_date" class="form-control" id="addChargeExpiryDate" placeholder="Expiry Date" autocomplete="off">
                </div>
            </div>
            </div>`; //End Right Half of Form

            $("#addFormAdditionalFields").empty().html(additionalFields);
            if (chargeType == 1) {
                $("#addChargeAmountLabel").empty().html('FC Amount <i class="text-danger">*</i>');
                $("#addFromDateLabel").empty().html('FC Starts From <i class="text-danger">*</i>');
                $("#addToDateLabel").empty().html('FC Expires On <i class="text-danger">*</i>');
            } else if (chargeType == 2) {
                $("#addChargeAmountLabel").empty().html('Road Tax Amount <i class="text-danger">*</i>');
                $("#addFromDateLabel").empty().html('Road Tax Starts From<i class="text-danger">*</i>');
                $("#addToDateLabel").empty().html('Road Tax Expires On <i class="text-danger">*</i>');
            } else {
                $("#addChargeAmountLabel").empty().html('Permit Amount <i class="text-danger">*</i>');
                $("#addFromDateLabel").empty().html('Permit Starts From <i class="text-danger">*</i>');
                $("#addToDateLabel").empty().html('Permit Expires On <i class="text-danger">*</i>');
            }

            // Enable date pickers
            $("#addChargeFromDate, #addChargeExpiryDate").daterangepicker({
                singleDatePicker: true,
                autoUpdateInput: false
            });
            $("#addChargeFromDate, #addChargeExpiryDate").on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('DD-MMM-YYYY'));
            });
            $("#addChargeFromDate, #addChargeExpiryDate").on('cancel.daterangepicker', function (ev, picker) {
                $(this).val('');
            });

            // Enable select2
            $("#addChargeForm .basic-single").select2();

            $("#addVehicleType").change(function () {
                loadFilteredVehicles(this);
            });

            // Allow only digits to be input
            $("#addChargeAmount").keypress(function (ev) {
                var charCode = (ev.which) ? ev.which : ev.keyCode;

                if (String.fromCharCode(charCode).match(/[^0-9\.]/g))

                    return false;
            });
        } else {
            // If Charge type is empty ("")
            $("#addFormAdditionalFields").empty();
        }
    });

    // Validate and Submit the ADD Form
    $("#addChargeForm").validate({
        rules: {
            charge_type: 'required',
            vehicle_type: 'required',
            vehicle: 'required',
            challan_number: {
                required: true,
                maxlength: 25
            },
            amount: {
                required: true,
                min: 0
            },
            start_date: {
                required: true,
                dateLessThan: "#addChargeExpiryDate"
            },
            expiry_date: {
                required: true,
                dateGreaterThan: "#addChargeFromDate"
            }
        },
        errorElement: 'div',
        errorPlacement: function (error, element) {
            $(element).closest('div[class*=col-]').append(error);
        },
        submitHandler: function (form, ev) {
            ev.preventDefault();

            // Form submission
            $.ajax({
                url: form.action,
                type: 'post',
                data: $(form).serialize(),
                dataType: 'json',
                success: function (res) {
                    if (res.successCode === 1) {
                        toastr.success(res.message, '', { closeButton: true });
                        $("#add").modal('hide');
                        loadTable(chargesTable);
                    } else {
                        toastr.error(res.message, '', { closeButton: true });
                    }
                },
                error: function () {
                    toastr.error("Error adding data. Please try again", '', { closeButton: true });
                }
            });
        }
    });

    $("#add").on('hidden.bs.modal', function () {
        $("#addChargeForm").trigger('reset');
        $("#addChargeForm").data('validator').resetForm();
        $("#addFormAdditionalFields").empty();
    });

    $("#clearAddFormBtn").click(function () {
        setTimeout(() => {
            $("#addChargeForm").data('validator').resetForm();
            $("#addChargeForm .basic-single").val('').change();
            $("#addChargeForm .form-control.error").removeClass('error');
            $("#addChargeType").val($("#addChargeType").attr('data-selection'));
        }, 10);
    });

    // On submitting filter form, send AJAX request and filter
    $("#btn-filter").click(function (e) {
        e.preventDefault();
        loadTable(chargesTable);
    });

    $("#btn-reset").click(function (ev) {
        setTimeout(() => {
            loadTable(chargesTable);
            $('#filterForm .basic-single').val('').change();
        }, 10);
    });
});
// End of jQuery document.ready

function loadFilteredVehicles(el) {
    $.ajax({
        url: filteredVehiclesListURL,
        type: 'post',
        data: {
            _token: csrfToken,
            vehicle_type: $(el).val()
        },
        dataType: 'json',
        beforeSend: function () {
            $('.custom-loader').show();
        },
        success: function (res) {
            let vehicleSelectBox = $(el).closest('form').find('select[name=vehicle]');
            if (res.length >= 1) {
                vehicleSelectBox.empty().append('<option value="">Please Select</option>');

                $.each(res, function (i, data) {
                    // console.log(i, data);
                    vehicleSelectBox.append(`<option value="${data.VEHICLE_ID}">
                    ${data.VEHICLE_NAME + ' (' + data.LICENSE_PLATE + ')'}
                    </option>`);
                });
            } else {
                vehicleSelectBox.empty().append('<option value="">Please Select</option>');
                toastr.error("No vehicles found", '', { closeButton: true });
            }
        },
        error: function () {
            toastr.error("Error getting data. Please try again", "", { closeButton: true });
        },
        complete: function () {
            $('.custom-loader').hide();
        }
    });
}

function editInfo(id) {
    $.ajax({
        url: getChargeDetailsURL,
        type: 'post',
        data: {
            _token: csrfToken,
            charge_id: id
        },
        dataType: 'json',
        beforeSend: function () {
            $('.custom-loader').show();
        },
        success: function (res) {
            console.log('Details', res);
            if (Object.keys(res).length) {
                loadEditForm(res);
            } else {
                toastr.error("Could not get details. Please try again", '', { closeButton: true });
            }
        },
        error: function () {
            toastr.error("Error fetching details. Please try again", '', { closeButton: true });
        },
        complete: function () {
            $('.custom-loader').hide();
        }
    });
}

function loadTable(table) {
    $.ajax({
        url: listURL,
        type: 'post',
        data: $("#filterForm").serialize(),
        dataType: 'json',
        beforeSend: function () {
            $("#table-loader").show();
        },
        success: function (res) {
            console.log(res);
            table.clear();
            if (res.length >= 1) {
                $.each(res, function (i, data) {
                    let actionBtns = `<button class="btn btn-info" onclick="editInfo(${data.CHARGE_ID})"><i class="ti-pencil"></i></button>`;
                    let chargeTypes = ['FC', 'Road Tax', 'Permit'];
                    let chargeType = chargeTypes[data.CHARGE_TYPE - 1];
                    table.row.add([
                        i + 1,
                        chargeType,
                        data.VEHICLE_NAME + ' (' + data.LICENSE_PLATE + ')',
                        data.CHALLAN_NUMBER,
                        moment(data.START_DATE).format('DD-MMM-YYYY'),
                        moment(data.EXPIRE_DATE).format('DD-MMM-YYYY'),
                        data.AMOUNT,
                        actionBtns
                    ]);
                });
            }
            table.draw();
        },
        error: function () {
            console.log("Error loading list");
        },
        complete: function () {
            $("#table-loader").hide();
        }
    });
}

// To enable validation for the Edit Form
function initValidationForEditForm() {
    $("#editChargeForm").validate({
        rules: {
            charge_type: 'required',
            vehicle_type: 'required',
            vehicle: 'required',
            challan_number: {
                required: true,
                maxlength: 25
            },
            amount: {
                required: true,
                min: 0
            },
            start_date: { required: true, dateLessThan: '#editChargeTillDate' },
            expiry_date: { required: true, dateGreaterThan: '#editChargeFromDate' }
        },
        errorElement: 'div',
        errorPlacement: function (error, element) {
            $(element).closest('div[class*=col-]').append(error);
        },
        submitHandler: function (form, ev) {
            ev.preventDefault();

            // Form submission
            $.ajax({
                url: form.action,
                type: 'post',
                data: $(form).serialize(),
                dataType: 'json',
                success: function (res) {
                    if (res.successCode === 1) {
                        toastr.success(res.message, '', { closeButton: true });
                        $("#edit").modal('hide');
                        loadTable($("#chargesTable").DataTable());
                    } else {
                        toastr.error(res.message, '', { closeButton: true });
                    }
                },
                error: function () {
                    toastr.error("Error adding data. Please try again", '', { closeButton: true });
                }
            });
        }
    });
}

// Get current details to Edit Form
function loadEditForm(details) {
    console.log(details);

    let amountLabels = ['FC Amount', 'Road Tax Amount', 'Permit Amount'];
    let startDateLabels = ['FC Starts From', 'Road Tax Start From', 'Permit Starts From'];
    let expiryDateLabels = ['FC Expires On', 'Road Tax Expires On', 'Permit Expires On'];

    let formContent = `<input type="hidden" name="_token" value="${csrfToken}">
    <input type="hidden" name="charge_id" value="${details.CHARGE_TYPE}">`;
    formContent += `<div class="row">
    <div class="col-sm-12 col-lg-6">
        <div class="form-group row">
            <label for="editChargeType" class="col-sm-5 col-form-label">Charge For <i class="text-danger">*</i></label>
            <div class="col-sm-7">
                <select name="charge_type" id="editChargeType" class="form-control" disabled>
                    <option value="">Please Select</option>
                    <option value="1" ${details.CHARGE_TYPE == 1 ? 'selected' : ''}>FC</option>
                    <option value="2" ${details.CHARGE_TYPE == 2 ? 'selected' : ''}>Road Tax</option>
                    <option value="3" ${details.CHARGE_TYPE == 3 ? 'selected' : ''}>Permit</option>
                </select>
            </div>
        </div>
        <input type="hidden" name="charge_type" value="${details.CHARGE_TYPE}">
    </div></div>`; // End the first row containing the type selection

    formContent += `<div class="editFormAdditionalFields">
    <div class="row">
        <div class="col-md-12 col-lg-6">
            <div class="form-group row">
                <label for="editVehicleType" class="col-sm-5 col-form-label">Vehicle Type <i class="text-danger">*</i></label>
                <div class="col-sm-7">
                    <select name="vehicle_type" id="editVehicleType" class="form-control basic-single">
                        <option value="">Please Select</option>`;

    vehicleTypes.forEach((vehicleType) => {
        formContent += `<option value="${vehicleType.VEHICLE_TYPE_ID}">${vehicleType.VEHICLE_TYPE_NAME}</option>`;
    });

    formContent += `</select>
                </div>
            </div>
            <div class="form-group row">
                <label for="editVehicle" class="col-sm-5 col-form-label">Vehicle <i class="text-danger">*</i></label>
                <div class="col-sm-7">
                    <select name="vehicle" id="editVehicle" class="form-control basic-single">
                            <option value="">Please Select</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="editChallanNo" class="col-sm-5 col-form-label">Challan Number <i class="text-danger">*</i></label>
                <div class="col-sm-7">
                    <input type="text" name="challan_number" id="editChallanNo" class="form-control" value="${details.CHALLAN_NUMBER}" placeholder="Challan No.">
                </div>
            </div>
        </div>`;  // End left half of form

    formContent += `<div class="col-md-12 col-lg-6">
        <div class="form-group row">
            <label for="editChargeAmount" class="col-sm-5 col-form-label" id="editChargeAmountLabel">
            ${amountLabels[details.CHARGE_TYPE - 1]} <i class="text-danger">*</i>
            </label>
            <div class="col-sm-7">
                <input type="number" name="amount" class="form-control" id="editChargeAmount" value="${details.AMOUNT}" placholder="Enter amount" maxlength="10">
            </div>
        </div>
        <div class="form-group row">
            <label for="editChargeFromDate" class="col-sm-5 col-form-label" id="editChargeFromDateLabel">
            ${startDateLabels[details.CHARGE_TYPE - 1]} <i class="text-danger">*</i>
            </label>
            <div class="col-sm-7">
                <input type="text" name="start_date" class="form-control" id="editChargeFromDate" value="${moment(details.START_DATE).format('DD-MMM-YYYY')}" placeholder="Start Date" autocomplete="off">
            </div>
        </div>
        <div class="form-group row">
            <label for="editChargeTillDate" class="col-sm-5 col-form-label" id="editChargeTillDateLabel">
            ${expiryDateLabels[details.CHARGE_TYPE - 1]} <i class="text-danger">*</i>
            </label>
            <div class="col-sm-7">
                <input type="text" name="expiry_date" class="form-control" id="editChargeTillDate" value="${moment(details.EXPIRE_DATE).format('DD-MMM-YYYY')}" placeholder="Expiry Date" autocomplete="off">
            </div>
        </div>
    </div></div>`; // End right half of form

    formContent += `<div id="editFormBtnsWrapper">
    <div class="row">
        <div class="col-12 d-flex justify-content-end">
            <div class="form-group text-right">
                <button type="submit" class="btn btn-success">Save</button>
            </div>
        </div>
    </div>
    </div>`;

    $("#editChargeForm").empty().html(formContent);
    $("#edit").modal('show');

    $("#editChargeForm .basic-single").select2();

    $("#editVehicleType").change(function () {
        loadFilteredVehicles(this);
    });

    $("#editVehicleType").val(details.VEHICLE_TYPE_ID).change();
    setTimeout(() => {
        $("#editVehicle").val(details.VEHICLE_ID).change();
    }, 500);

    // The 'locale' object is used as date was set in that format by using moment().format()
    $("#editChargeFromDate, #editChargeTillDate").daterangepicker({
        singleDatePicker: true,
        locale: {
            format: 'DD-MMM-YYYY'
        },
        autoUpdateInput: false
    });
    $("#editChargeFromDate, #editChargeTillDate").on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format('DD-MMM-YYYY'));
    });

    // Allow only numbers to be input
    $("#editChargeAmount").keypress(function (ev) {
        var charCode = (ev.which) ? ev.which : ev.keyCode;

        if (String.fromCharCode(charCode).match(/[^0-9\.]/g))

            return false;
    });

    initValidationForEditForm();
}

/* To allow only digits to be entered into certain inputs */
function allowOnlyDigits(ev) {
    if (!/[0-9]/.test(ev.target.value))
        return false;
}