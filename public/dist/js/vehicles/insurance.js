$(document).ready(function () {
    let insuranceTable = $("#insuranceInfoTable").DataTable();

    populateTable(insuranceTable);

    $("#addInsuranceDetailsForm").validate({
        rules: {
            company_name: {
                required: true,
                maxlength: 100
            },
            vehicle: 'required',
            policy_number: {
                required: true,
                maxlength: 10
            },
            charge_payable: {
                required: true,
                min: 0
            },
            start_date: 'required',
            end_date: 'required',
            recurring_period: 'required',
            deductible: 'required',
            policy_document: {
                required: true
            },
            remarks: {
                maxlength: 200
            }
        },
        errorElement: 'div',
        errorPlacement: function (error, element) {
            $(element).closest('div[class*=col-sm-]').append(error);
        },
        submitHandler: function (form, ev) {
            ev.preventDefault();
            let addInsuranceFormData = new FormData($(form)[0]);

            $.ajax({
                url: form.action,
                type: form.method,
                data: addInsuranceFormData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function (res) {
                    if (res.successCode === 1) {
                        toastr.success(res.message, '', { closeButton: true });
                        populateTable(insuranceTable);
                        $("#add0").modal('hide');
                    } else {
                        toastr.error(res.message, '', { closeButton: true });
                    }
                },
                error: function (jqXHR, textStatus, err) {
                    toastr.error('Error adding insurance details. Please try again', '', { closeButton: true });
                }
            });
        }
    });

    $("#add0").on('hidden.bs.modal', function () {
        $("#addInsuranceDetailsForm").trigger('reset');
        $("#addInsuranceDetailsForm").data('validator').resetForm();
        $("#addInsuranceDetailsForm .form-control").removeClass('error').removeAttr('aria-invalid');
        $("#addInsuranceDetailsForm input[name='policy_document']").removeClass('error');
    });

    $("#addInsuranceDetailsForm").on('reset', function (e) {
        setTimeout(() => {
            $("#addInsuranceDetailsForm").data('validator').resetForm();
            $("#addInsuranceDetailsForm .form-control").removeClass('error').removeAttr('aria-invalid');
            $("#addInsuranceDetailsForm input[name='policy_document']").removeClass('error');
        }, 10);
    });

    $("#editInsuranceDetailsForm").validate({
        rules: {
            company_name: {
                required: true,
                maxlength: 100
            },
            vehicle: 'required',
            policy_number: {
                required: true,
                maxlength: 10
            },
            charge_payable: {
                required: true,
                min: 0
            },
            start_date: 'required',
            end_date: 'required',
            recurring_period: 'required',
            deductible: 'required',
            remarks: {
                maxlength: 200
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

}); // End of document.ready

function populateTable(table) {
    $.ajax({
        url: insuranceInfoListURL,
        type: 'post',
        data: {
            _token: csrfToken,
            vehiclesr: $("#vehiclesr").val(),
            insurance_company: $("#insurance_company").val(),
            policy_numbersr: $("#policy_numbersr").val(),
            date_fr: $("#date_fr").val(),
            date_to: $("#date_to").val()
        },
        dataType: 'json',
        success: function (res) {
            if (res.length >= 1) {
                table.clear();
                $.each(res, function (i, data) {
                    let actionBtns = `<button class="btn btn-sm btn-info mr-1" onclick="editInfo(${data.INSURANCE_ID})" title="Edit"><i class="ti-pencil"></i></button>`;

                    table.row.add([
                        i + 1,
                        data.COMPANY_NAME,
                        data.VEHICLE_NAME,
                        data.POLICY_NUMBER,
                        data.START_DATE,
                        data.END_DATE,
                        data.RECURRING_PERIOD_NAME,
                        data.RECURRING_DATE,
                        actionBtns
                    ]);
                })
                table.draw();
            }
        },
        error: function (jqXHR, status, err) {
            toastr.error("Error fetching data. Please try again", '', { closeButton: true });
        }
    });
}

function editInfo(id) {
    let updateURL = updateDetailsURL;
    $.ajax({
        url: getDetailsURL,
        type: 'post',
        data: {
            _token: csrfToken,
            insurance_id: id
        },
        dataType: 'json',
        success: function (res) {
            // console.log(res);

            $("#edit .modal-body").html('');
            let editFormContent = `<form action="${updateURL}" method="post" enctype="multipart/form-data" class="row" id="editInsuranceDetailsForm" accept-charset="utf-8">
            <input type="hidden" name="_token" value="${csrfToken}">
            <input type="hidden" name="insurance_id" value="${res.INSURANCE_ID}">
            <div class="col-md-12 col-lg-6">
                <div class="form-group row">
                    <label for="edit_company_name" class="col-sm-5 col-form-label">Company Name <i class="text-danger">*</i></label>
                    <div class="col-sm-7">
                        <input type="text" name="company_name" class="form-control" id="edit_company_name" placeholder="Company Name" value="${res.COMPANY_NAME}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="edit_policy_number" class="col-sm-5 col-form-label">Policy Number <i class="text-danger">*</i></label>
                    <div class="col-sm-7">
                        <input name="policy_number" required="" class="form-control" type="number" placeholder="Policy Number" id="edit_policy_number" value="${res.POLICY_NUMBER}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="edit_start_date" class="col-sm-5 col-form-label">Start Date <i class="text-danger">*</i></label>
                    <div class="col-sm-7">
                        <input name="start_date" class="form-control newdatetimepicker" type="text" placeholder="Start Date" id="edit_start_date" value="${res.START_DATE}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="edit_recurring_period" class="col-sm-5 col-form-label">Recurring Period <i class="text-danger">*</i></label>
                    <div class="col-sm-7">
                        <select class="form-control basic-single" required="" name="recurring_period" id="edit_recurring_period">
                            <option value="">Please Select One</option>`;

            $.each(recurringPeriods, function (i, data) {
                if (data.RECURRING_PERIOD_ID == res.RECURRING_PERIOD)
                    editFormContent += '<option value="' + data.RECURRING_PERIOD_ID + '" selected>' + data.RECURRING_PERIOD_NAME + '</option>';
                else
                    editFormContent += '<option value="' + data.RECURRING_PERIOD_ID + '">' + data.RECURRING_PERIOD_NAME + '</option>';
            });

            editFormContent += `</select></div></div>
                <div class="form-group row">
                    <label for="checkbox_reminder${res.INSURANCE_ID}" class="col-sm-5 col-form-label">&nbsp;</label>
                    <div class="col-sm-7 checkbox checkbox-primary">
                            <input id="checkbox_reminder${res.INSURANCE_ID}" type="checkbox" name="add_reminder" value="1" ${res.RECURRING_PERIOD_REMINDER == 'Y' ? "checked" : ""}>
                            <label for="checkbox_reminder${res.INSURANCE_ID}">Add Reminder</label>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="checkbox_status${res.INSURANCE_ID}" class="col-sm-5 col-form-label">&nbsp;</label>
                    <div class="col-sm-7 checkbox checkbox-primary">
                        <input id="checkbox_status${res.INSURANCE_ID}" type="checkbox" name="status" value="1" ${res.STATUS == 'Y' ? "checked" : ""}>
                            <label for="checkbox_status${res.INSURANCE_ID}">Status</label>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="edit_remarks" class="col-sm-5 col-form-label">Remarks </label>
                    <div class="col-sm-7">
                        <textarea name="remarks" id="edit_remarks" class="form-control" placeholder="Remarks" cols="30" rows="3" value="${res.REMARKS}"></textarea>
                    </div>
                </div>
            </div>
            `;

            editFormContent += `<div class="col-md-12 col-lg-6">
                <div class="form-group row">
                    <label for="edit_vehicle" class="col-sm-5 col-form-label">Vehicle <i class="text-danger">*</i></label>
                        <div class="col-sm-7">
                            <select class="form-control basic-single" required="" name="vehicle" id="edit_vehicle">
                                <option value="">Please Select One</option>`;

            $.each(vehicles, function (i, data) {
                if (data.VEHICLE_ID == res.VEHICLE)
                    editFormContent += '<option value="' + data.VEHICLE_ID + '" selected>' + data.VEHICLE_NAME + '</option>';
                else
                    editFormContent += '<option value="' + data.VEHICLE_ID + '">' + data.VEHICLE_NAME + '</option>';
            });
            editFormContent += `</select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="edit_charge_payable" class="col-sm-5 col-form-label">Charge Payable <i class="text-danger">*</i></label>
                    <div class="col-sm-7">
                        <input name="charge_payable" required="" class="form-control" type="number" placeholder="Charge Payable" id="edit_charge_payable" value="${res.CHARGE_PAYABLE}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="edit_end_date" class="col-sm-5 col-form-label">End Date <i class="text-danger">*</i></label>
                    <div class="col-sm-7">
                            <input name="end_date" class="form-control newdatetimepicker" type="text" placeholder="End Date" id="edit_end_date" value="${res.END_DATE}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="edit_recurring_date" class="col-sm-5 col-form-label">Recurring Date </label>
                    <div class="col-sm-7">
                        <input name="recurring_date" class="form-control newdatetimepicker" type="text" placeholder="Recurring Date" id="edit_recurring_date" value="${res.RECURRING_DATE}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="deductible" class="col-sm-5 col-form-label">Deductible <i class="text-danger">*</i></label>
                    <div class="col-sm-7">
                        <input name="deductible" required="" class="form-control" type="number" placeholder="Deductible" id="deductible" value="${res.DEDUCTIBLE}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-5 col-form-label">Uploaded Document</label>
                    <div class="col-sm-7">
                        <a href="${documentsPath + '/' + res.POLICY_DOCUMENT}" target="_blank" class="btn btn-info">
                        <i class="fas fa-eye"></i> View Current Document
                        </a>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="policy_document" class="col-sm-5 col-form-label">Upload New Policy Document</label>
                    <div class="col-sm-7 file-upload-container">
                        <input name="policy_document" type="file" accept="image/*,application/pdf,.doc,.docx" />
                    </div>
                </div>

                <div class="form-group text-right">
                    <button type="reset" class="btn btn-primary w-md m-b-5" id="resetEditInsFormBtn">Reset</button>
                    <button type="submit" class="btn btn-success w-md m-b-5">Save</button>
                </div>
            </div>
            </form>`;

            $("#edit .modal-body").html(editFormContent);
            $("#editInsuranceDetailsForm .basic-single").select2();
            $("#editInsuranceDetailsForm .newdatetimepicker").daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                locale: {
                    format: 'YYYY-MM-DD'
                },
                maxYear: parseInt(moment().format('YYYY'), 10)
            });

            $("#resetEditInsFormBtn").click(function () {
                setTimeout(() => {
                    $("#editInsuranceDetailsForm .basic-single").trigger('change');
                    $("#editInsuranceDetailsForm").validate().resetForm();
                }, 10);
            });

            $("#edit").modal('show');
            reinitValidationForEditForm();
        },
        error: function () {
            console.log("Error getting details");
        }
    });
}

// Re-initilaize validation for dynamically-generated Edit Insurance details Form
function reinitValidationForEditForm() {
    let validator = $("#editInsuranceDetailsForm").validate();
    validator.destroy();
    $("#editInsuranceDetailsForm").validate({
        rules: {
            company_name: {
                required: true,
                maxlength: 100
            },
            vehicle: 'required',
            policy_number: {
                required: true,
                maxlength: 10
            },
            charge_payable: {
                required: true,
                min: 0
            },
            start_date: 'required',
            end_date: 'required',
            recurring_period: 'required',
            deductible: 'required',
            remarks: {
                maxlength: 200
            }
        },
        errorElement: 'div',
        errorPlacement: function (error, element) {
            $(element).closest('div[class*=col-sm-]').append(error);
        },
        submitHandler: function (form, ev) {
            ev.preventDefault();
            let updatedInsuranceDetails = new FormData($(form)[0]);

            $.ajax({
                url: form.action,
                type: form.method,
                data: updatedInsuranceDetails,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function (res) {
                    if (res.successCode === 1) {
                        toastr.success(res.message, '', { closeButton: true });
                        populateTable($("#insuranceInfoTable").DataTable());
                        $("#edit").modal('hide');
                    } else {
                        toastr.error(res.message, '', { closeButton: true });
                    }
                },
                error: function () {
                    toastr.error('Error updating. Please try again', '', { closeButton: true });
                }
            });
        }
    });
}