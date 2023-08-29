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
            console.log(res);
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
    $.ajax({
        url: getDetailsURL,
        type: 'post',
        data: {
            _token: csrfToken,
            insurance_id: id
        },
        success: function (res) {
            console.log(res);
        },
        error: function () {
            console.log("Error getting details");
        }
    });
}