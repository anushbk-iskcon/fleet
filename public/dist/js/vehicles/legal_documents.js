// For validating file types before upload
$.validator.addMethod('validFileType', function (val, element, params) {
    let fileName = ''; let fileExtn = '';
    if (element.files[0]) { // If document is selected for uploading
        fileName = element.files[0].name;
        fileExtn = fileName.substring(fileName.lastIndexOf('.') + 1).toLowerCase();
    }
    return (this.optional(element) || fileExtn === 'jpg' || fileExtn === 'jpeg' || fileExtn === 'png' || fileExtn === 'webp' || fileExtn === 'pdf');
}, "Please select only PDF or image for upload");

// For validating file size before upload
$.validator.addMethod('validFileSize', function (val, element, params) {
    let maxFileSize = 5 * 1024 * 1024; // 5 MB
    let fileSize = 0;
    if (element.files[0]) {
        fileSize = element.files[0].size;
    }
    return (this.optional(element) || fileSize <= maxFileSize);
}, "Maximum allowed file size is 5 MB");

$(document).ready(function () {
    let legalDocumentsTable = $("#legalDocumentsTable").DataTable({
        autoWidth: false,
        columnDefs: [{ orderable: false, targets: [5] }]
    });

    $("#legalDocumentsTable").css('width', '100%');

    populateTable(legalDocumentsTable);

    // Enable datepickers on filter date select
    $("#exp_date_fr, #exp_date_to").daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        autoUpdateInput: false,
        autoApply: false,
        minYear: 2000,
        drops: "down",
        locale: {
            format: 'DD-MMM-YYYY'
        }
    });
    $('#exp_date_fr, #exp_date_to').on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format('DD-MMM-YYYY'));
    });
    $('#exp_date_fr, #exp_date_to').on('cancel.daterangepicker', function (ev, picker) {
        $(this).val('');
    });

    // For sending email and SMS number in Add Form based on checked state of toggleboxes
    $("#emailCheckbox").change(function () {
        if (this.checked) {
            $("#email").prop('disabled', false);
        } else {
            $("#email").prop('disabled', true);
        }
    });

    $("#smsCheckbox").change(function () {
        if (this.checked) {
            $("#sms").prop('disabled', false);
        } else {
            $("#sms").prop('disabled', true);
        }
    });

    $("#btn-filter").click(function () {
        populateTable(legalDocumentsTable);
    });

    $("#btn-reset").click(function () {
        $("#vehiclesr").val("").change();
        $("#document_typesr").val("").change();
        $("#exp_date_fr").val("");
        $("#exp_date_to").val("");
        populateTable(legalDocumentsTable);
    });

    // Enable date-pickers on Add Details Form
    $("#add0").on('shown.bs.modal', function (ev) {
        $("#addLegalDocumentForm .new-datepicker").daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            autoUpdateInput: false,
            autoApply: false,
            minYear: 2000,
            drops: "down",
            locale: {
                format: 'DD-MMM-YYYY'
            }
        });
        $('#addLegalDocumentForm .new-datepicker').on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('DD-MMM-YYYY'));
        });
        $('#addLegalDocumentForm .new-datepicker').on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
        });
    });

    $("#addLegalDocumentForm").validate({
        rules: {
            document_type: 'required',
            vehicle: 'required',
            last_issue_date: 'required',
            expire_date: 'required',
            charge_paid: {
                required: true,
                min: 0
            },
            vendor: 'required',
            commission: {
                required: true,
                min: 0
            },
            notification_before: 'required',
            email: {
                required: "#emailCheckbox:checked",
                email: true,
                maxlength: 99
            },
            sms: {
                required: "#smsCheckbox:checked",
                digits: true,
                maxlength: 15
            },
            document_attachment: {
                validFileType: true,
                validFileSize: true
            }
        },
        errorElement: 'div',
        errorPlacement: function (error, element) {
            $(element).closest('div[class*=col-sm-]').append(error);
        },
        submitHandler: function (form, ev) {
            ev.preventDefault();
            let legalDocumentFormData = new FormData($(form)[0]);

            $.ajax({
                url: form.action,
                type: form.method,
                data: legalDocumentFormData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function (res) {
                    if (res.successCode == 1) {
                        toastr.success(res.message, '', { closeButton: true });
                        $("#add0").modal('hide');
                        populateTable(legalDocumentsTable);
                    }
                    else
                        toastr.error(res.message, '', { closeButton: true });
                },
                error: function (jqXHR, status, err) {
                    toastr.error('Error adding document. Please try again', '', { closeButton: true });
                }
            });
        }
    });

    $("#add0").on('hidden.bs.modal', function () {
        $("#addLegalDocumentForm").trigger('reset');
        $("#addLegalDocumentForm").data('validator').resetForm();
        $("#addLegalDocumentForm .form-control").removeClass('error').removeAttr('aria-invalid');
        $("#addLegalDocumentForm .basic-single").trigger('change');
        $("#addLegalDocumentForm .form-check-input").bootstrapToggle('off');
    });

    $("#resetAddFormBtn").click(function () {
        setTimeout(() => {
            $("#addLegalDocumentForm").data('validator').resetForm();
            $("#addLegalDocumentForm .form-control").removeClass('error').removeAttr('aria-invalid');
            $("#addLegalDocumentForm .basic-single").trigger('change');
            $("#addLegalDocumentForm .form-check-input").bootstrapToggle('off');
        }, 10);
    });

    // Validation rules submitHandler etc. specified in reinitValidation function
    $("#updateLegalDocumentForm").validate();
}); // End of document.ready function


function populateTable(table) {
    $.ajax({
        url: documentsListURL,
        type: 'post',
        data: {
            _token: csrfToken,
            vehiclesr: $("#vehiclesr").val(),
            document_typesr: $("#document_typesr").val(),
            exp_date_fr: $("#exp_date_fr").val(),
            exp_date_to: $("#exp_date_to").val()
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
                    let actionBtns = `<button class="btn btn-sm btn-info mr-1" onclick="editInfo(${data.LEGAL_DOCUMENT_ID})" title="Edit"><i class="ti-pencil"></i></button>`;

                    let lastIssueDate = moment(data.LAST_ISSUE_DATE).format('DD-MMM-YYYY');
                    let expireDate = moment(data.EXPIRE_DATE).format('DD-MMM-YYYY');
                    let viewDocumentBtn = '';
                    if (data.DOCUMENT_ATTACHMENT != null)
                        viewDocumentBtn = `<a href="${documentsPath + "/" + data.DOCUMENT_ATTACHMENT}" target="_blank" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>`;
                    if (data.IS_ACTIVE == 'Y')
                        actionBtns += `<button class="btn btn-sm btn-danger mr-1" onclick="changeActivation(${data.LEGAL_DOCUMENT_ID}, 0)" title="Deactivate"><i class="ti-close"></i></button>`;
                    else
                        actionBtns += `<button class="btn btn-sm btn-danger mr-1" onclick="changeActivation(${data.LEGAL_DOCUMENT_ID}, 1)" title="Activate"><i class="ti-reload"></i></button>`;
                    table.row.add([
                        i + 1,
                        data.DOCUMENT_TYPE_NAME,
                        data.VEHICLE_NAME,
                        lastIssueDate,
                        expireDate,
                        viewDocumentBtn,
                        data.VENDOR_NAME,
                        data.COMMISSION,
                        data.NOTIFICATION_TYPE_NAME,
                        actionBtns
                    ]);
                });

            }
            table.draw();
        },
        error: function (jqxhr, status, err) {
            toastr.error("Error loading data. Please try again", "", { closeButton: true });
        },
        complete: function () {
            $("#table-loader").hide();
        }
    });
}

function editInfo(id) {
    // Get details and generate pre-filled form
    $.ajax({
        url: getDetailsURL,
        type: 'post',
        data: {
            _token: csrfToken,
            legal_document_id: id
        },
        dataType: 'json',
        success: function (res) {
            $("#edit .modal-body").html("");

            let lastIssueDate = moment(res.LAST_ISSUE_DATE).format('DD-MMM-YYYY');
            let expireDate = moment(res.EXPIRE_DATE).format('DD-MMM-YYYY');

            let editFormContent = `<form action="${updateDetailsURL}" method="post" id="updateLegalDocumentForm" class="row" enctype="multipart/form-data" accept-charset="utf-8">`;
            editFormContent += `<input type="hidden" name="_token" value="${csrfToken}">`;
            editFormContent += `<input type="hidden" name="legal_document_id" value="${res.LEGAL_DOCUMENT_ID}">`;
            editFormContent += `<div class="col-md-12 col-lg-6">
            <div class="form-group row">
                <label for="edit_document_type" class="col-sm-5 col-form-label">Document Type <i class="text-danger">*</i></label>
                <div class="col-sm-7">
                    <select class="form-control basic-single" name="document_type" id="edit_document_type">
                        <option value="">Please Select One</option>`;

            $.each(documentTypes, function (i, data) {
                if (res.DOCUMENT_TYPE == data.DOCUMENT_TYPE_ID)
                    editFormContent += `<option value="${data.DOCUMENT_TYPE_ID}" selected>${data.DOCUMENT_TYPE_NAME}</option>`;
                else
                    editFormContent += `<option value="${data.DOCUMENT_TYPE_ID}">${data.DOCUMENT_TYPE_NAME}</option>`;
            });

            editFormContent += '</select></div></div>';

            editFormContent += `<div class="form-group row">
            <label for="edit_vehicle" class="col-sm-5 col-form-label">Vehicle <i class="text-danger">*</i></label>
            <div class="col-sm-7">
                <select class="form-control basic-single" name="vehicle" id="edit_vehicle">
                    <option value="">Please Select One</option>`;

            $.each(vehicles, function (i, vehicle) {
                if (res.VEHICLE == vehicle.VEHICLE_ID)
                    editFormContent += `<option value="${vehicle.VEHICLE_ID}" selected="selected">${vehicle.VEHICLE_NAME}</option>`;
                else
                    editFormContent += `<option value="${vehicle.VEHICLE_ID}">${vehicle.VEHICLE_NAME}</option>`;
            });

            editFormContent += '</select></div></div>';

            editFormContent += `<div class="form-group row">
            <label for="edit_last_issue_date" class="col-sm-5 col-form-label">Last Issue Date <i class="text-danger">*</i></label>
            <div class="col-sm-7">
                <input name="last_issue_date" autocomplete="off" class="form-control new-datepicker" type="text" placeholder="Last Issue Date" id="edit_last_issue_date"
                value="${lastIssueDate}">
            </div>
            </div>
            <div class="form-group row">
                <label for="edit_expire_date" class="col-sm-5 col-form-label">Expire Date <i class="text-danger">*</i></label>
            <div class="col-sm-7">
                <input name="expire_date" autocomplete="off" class="form-control new-datepicker" type="text" placeholder="Expire Date" id="edit_expire_date"
                value="${expireDate}">
            </div>
            </div>
            <div class="form-group row">
                <label for="edit_charge_paid" class="col-sm-5 col-form-label">Charge Paid <i class="text-danger">*</i></label>
                <div class="col-sm-7">
                    <input name="charge_paid" class="form-control" type="number" placeholder="Charge Paid" id="edit_charge_paid" value="${res.CHARGE_PAID}">
                </div>
            </div>`;

            editFormContent += `<div class="form-group row">
                <label for="edit_vendor" class="col-sm-5 col-form-label">Vendor <i class="text-danger">*</i></label>
                <div class="col-sm-7">
                    <select class="form-control basic-single" required="" name="vendor" id="edit_vendor">
                    <option value="">Please Select One</option>`;

            $.each(vendors, function (i, vendor) {
                if (res.VENDOR == vendor.VENDOR_ID)
                    editFormContent += `<option value="${vendor.VENDOR_ID}" selected="selected">${vendor.VENDOR_NAME}</option>`;
                else
                    editFormContent += `<option value="${vendor.VENDOR_ID}">${vendor.VENDOR_NAME}</option>`;
            });

            editFormContent += '</select></div></div></div>';

            editFormContent += `<div class="col-md-12 col-lg-6">
            <div class="form-group row">
                <label for="edit_commission" class="col-sm-5 col-form-label">Commission <i class="text-danger">*</i></label>
                <div class="col-sm-7">
                    <input name="commission" class="form-control" type="number" placeholder="Commission" id="edit_commission" value="${res.COMMISSION}">
                </div>
            </div>`;

            editFormContent += `<div class="form-group row">
            <label for="edit_notification_before" class="col-sm-5 col-form-label">Notification Before <i class="text-danger">*</i></label>
            <div class="col-sm-7">
                <select class="form-control basic-single" required="" name="notification_before" id="edit_notification_before">
                    <option value="">Please Select One</option>`;

            $.each(notificationTypes, function (i, notificationType) {
                if (notificationType.NOTIFICATION_TYPE_ID == res.NOTIFICATION_BEFORE)
                    editFormContent += `<option value="${notificationType.NOTIFICATION_TYPE_ID}" selected="selected">${notificationType.NOTIFICATION_TYPE_NAME}</option>`;
                else
                    editFormContent += `<option value="${notificationType.NOTIFICATION_TYPE_ID}">${notificationType.NOTIFICATION_TYPE_NAME}</option>`;
            });

            editFormContent += `</select>
                    </div>
                </div>`;

            editFormContent += `<div class="form-group row">
                <label for="edit_email" class="col-sm-5 col-form-label">Email </label>
                <div class="col-sm-2">
                <div class="form-check form-check-inline">
                    <input id="editEmailCheckbox" class="form-check-input" name="is_email" type="checkbox" data-toggle="toggle" data-style="mr-1">
                    <label for="editEmailCheckbox" class="form-check-label">&nbsp;</label>
                </div>
            </div>
            <div class="col-sm-5">
                <input name="email" class="form-control" type="email" placeholder="Email" id="edit_email" value="${res.EMAIL ? res.EMAIL : ''}">
            </div>
            </div>
            <div class="form-group row">
                <label for="edit_sms" class="col-sm-5 col-form-label">SMS </label>
                <div class="col-sm-2">
                <div class="form-check form-check-inline">
                    <input id="editSmsCheckbox" class="form-check-input" type="checkbox" name="is_sms" data-toggle="toggle" data-style="mr-1">
                    <label for="editSmsCheckbox" class="form-check-label">&nbsp;</label>
                </div>
                </div>
                <div class="col-sm-5">
                    <input name="sms" class="form-control" type="text" placeholder="SMS" id="edit_sms" value="${res.MOBILE ? res.MOBILE : ''}">
                </div>
            </div>`;

            editFormContent += `<div class="form-group row">
            <label class="col-sm-5 col-form-label">Uploaded Document</label>
            <div class="col-sm-7">`;

            if (res.DOCUMENT_ATTACHMENT != null && res.DOCUMENT_ATTACHMENT.trim() != '' && res.DOCUMENT_ATTACHMENT != undefined) {
                editFormContent += `<a href="${documentsPath + '/' + res.DOCUMENT_ATTACHMENT}" target="_blank" class="btn btn-info">
                <i class="fas fa-eye"></i> View Current Document
                </a>`;
            }
            else {
                editFormContent += `<a href="javascript:void(0)" class="btn btn-info">
                <i class="fas fa-ban"></i> No Document Uploaded
                </a>`;
            }
            editFormContent += `</div></div>`;

            editFormContent += `<div class="form-group row">
                <label for="edit_document_attachment" class="col-sm-5 col-form-label">New Document Attachment</label>
                <div class="col-sm-7 file-upload-container">
                    <input name="document_attachment" type="file" accept="image/*, application/pdf" />
                </div>
            </div>

                <div class="form-group text-right">
                    <button type="reset" class="btn btn-primary w-md m-b-5" id="resetEditFormBtn">Reset</button>
                    <button type="submit" class="btn btn-success w-md m-b-5">Save</button>
                </div>
            </div>`;

            editFormContent += '</form>';

            $("#edit .modal-body").html(editFormContent);

            // To allow plugins to work on dynamically generated form elements
            $("#updateLegalDocumentForm .basic-single").select2();
            $("#updateLegalDocumentForm .new-datepicker").daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                minYear: 1990,
                locale: {
                    format: 'DD-MMM-YYYY'
                }
            });
            $('#updateLegalDocumentForm .new-datepicker').on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('DD-MMM-YYYY'));
            });
            $('#updateLegalDocumentForm .new-datepicker').on('cancel.daterangepicker', function (ev, picker) {
                $(this).val('');
            });

            if (res.EMAIL_NOTIFICATIONS == 'Y') {
                $("#updateLegalDocumentForm #editEmailCheckbox").bootstrapToggle('on');
                $("#updateLegalDocumentForm #editEmailCheckbox").attr('data-originally-selected', 'Y');
                $("#edit_email").prop('disabled', false);
            }
            else {
                $("#updateLegalDocumentForm #editEmailCheckbox").bootstrapToggle('off');
                $("#updateLegalDocumentForm #editEmailCheckbox").attr('data-originally-selected', 'N');
                $("#edit_email").prop('disabled', true);
            }
            if (res.SMS_NOTIFICATIONS == 'Y') {
                $("#updateLegalDocumentForm #editSmsCheckbox").bootstrapToggle('on');
                $("#updateLegalDocumentForm #editSmsCheckbox").attr('data-originally-selected', 'Y');
                $("#edit_sms").prop('disabled', false);
            }
            else {
                $("#updateLegalDocumentForm #editSmsCheckbox").bootstrapToggle('off');
                $("#updateLegalDocumentForm #editSmsCheckbox").attr('data-originally-selected', 'N');
                $("#edit_sms").prop('disabled', true);
            }
            $("#edit").modal('show');

            // On clicking the reset button on the Edit From
            $("#resetEditFormBtn").click(function () {
                setTimeout(() => {
                    $("#updateLegalDocumentForm .basic-single").trigger('change');
                    $("#updateLegalDocumentForm").validate().resetForm();
                    if ($("#editEmailCheckbox").attr('data-originally-selected') == 'Y')
                        $("#updateLegalDocumentForm #editEmailCheckbox").bootstrapToggle('on');
                    else
                        $("#updateLegalDocumentForm #editEmailCheckbox").bootstrapToggle('off');

                    if ($("#editSmsCheckbox").attr('data-originally-selected') == 'Y')
                        $("#updateLegalDocumentForm #editSmsCheckbox").bootstrapToggle('on');
                    else
                        $("#updateLegalDocumentForm #editSmsCheckbox").bootstrapToggle('off');
                }, 10);
            });

            $("#editEmailCheckbox").change(function () {
                if (this.checked) {
                    $("#edit_email").prop('disabled', false);
                } else {
                    $("#edit_email").prop('disabled', true);
                }
            });

            $("#editSmsCheckbox").change(function () {
                if (this.checked) {
                    $("#edit_sms").prop('disabled', false);
                } else {
                    $("#edit_sms").prop('disabled', true);
                }
            });

            // Enable form validation for dynamically generated form
            reinitValidationForEditForm();
        },
        error: function (jqxhr, status, err) {
            toastr.error("Error getting details. Please try again", "", { closeButton: true });
        }
    });
}

function reinitValidationForEditForm() {
    // To re-initialize validation for dynamically generated edit form
    let validator = $("#updateLegalDocumentForm").validate();
    validator.destroy();
    $("#updateLegalDocumentForm").validate({
        rules: {
            document_type: 'required',
            vehicle: 'required',
            last_issue_date: 'required',
            expire_date: 'required',
            charge_paid: {
                required: true,
                min: 0
            },
            vendor: 'required',
            commission: {
                required: true,
                min: 0
            },
            notification_before: 'required',
            email: {
                required: "#editEmailCheckbox:checked",
                email: true,
                maxlength: 99
            },
            sms: {
                required: "#editSmsCheckbox:checked",
                digits: true,
                maxlength: 15
            },
            document_attachment: {
                validFileType: true,
                validFileSize: true
            }
        },
        errorElement: 'div',
        errorPlacement: function (error, element) {
            $(element).closest('div[class*=col-sm-]').append(error);
        },
        submitHandler: function (form, ev) {
            ev.preventDefault();

            let updatedDocumentFormData = new FormData($(form)[0]);
            $.ajax({
                url: form.action,
                type: form.method,
                data: updatedDocumentFormData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function (res) {
                    if (res.successCode == 1) {
                        toastr.success(res.message, '', { closeButton: true });
                        $("#edit").modal('hide');
                        populateTable($("#legalDocumentsTable").DataTable());
                    } else {
                        toastr.error(res.message, '', { closeButton: true });
                    }
                },
                error: function (jqxhr, textStatus, err) {
                    toastr.error('Error updating details. Please try again', '', { closeButton: true });
                }
            });
        }
    });
}

function toggleInput(input) {
    console.log(input);
}

function changeActivation(id, activeStatus) {
    if (confirm("Are you sure?")) {
        $.ajax({
            url: changeActivationURL,
            type: 'post',
            data: {
                _token: csrfToken,
                legal_document_id: id,
                active_status: activeStatus
            },
            dataType: 'json',
            success: function (res) {
                if (res.successCode == 1) {
                    toastr.success(res.message, '', { closeButton: true });
                    populateTable($("#legalDocumentsTable").DataTable());
                } else {
                    toastr.error(res.message, '', { closeButton: true });
                }
            },
            error: function (jqXHR, status, err) {
                toastr.error('Error updating. Please try again', '', { closeButton: true });
            }
        });
    }
}