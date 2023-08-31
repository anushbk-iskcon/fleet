// For validating file types before upload
$.validator.addMethod('validFileType', function (val, element, param) {
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
    let legalDocumentsTable = $("#legalDocumentsTable").DataTable();

    populateTable(legalDocumentsTable);

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
        success: function (res) {
            console.log(res);
            if (res.length >= 1) {
                table.clear();
                $.each(res, function (i, data) {
                    let actionBtns = `<button class="btn btn-sm btn-info mr-1" onclick="editInfo(${data.LEGAL_DOCUMENT_ID})" title="Edit"><i class="ti-pencil"></i></button>`;

                    table.row.add([
                        i + 1,
                        data.DOCUMENT_TYPE_NAME,
                        data.VEHICLE_NAME,
                        data.LAST_ISSUE_DATE,
                        data.EXPIRE_DATE,
                        data.VENDOR_NAME,
                        data.COMMISSION,
                        data.NOTIFICATION_TYPE_NAME,
                        actionBtns
                    ]);
                });
                table.draw();
            }
        },
        error: function (jqxhr, status, err) {
            toastr.error("Error loading data. Please try again", "", { closeButton: true });
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
        },
        error: function (jqxhr, status, err) {
            toastr.error("Error getting details. Please try again", "", { closeButton: true });
        }
    });
}