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
    let refuelSettingTable = $("#refuelSettingTable").DataTable();

    populateTable(refuelSettingTable);

    $("#add0").on('shown.bs.modal', function (ev) {
        // To enable datepickers on Add Refuel Setting Form
        $("#addRefuelSettingForm .new-datepicker").daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            autoUpdateInput: false,
            autoApply: false,
            minYear: 2000,
            drops: "down",
            locale: {
                format: 'DD-MMM-YYYY'
            },
        });
        $('#addRefuelSettingForm .new-datepicker').on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('DD-MMM-YYYY'));
        });
        $('#addRefuelSettingForm .new-datepicker').on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
        });
    });

    $("#addRefuelSettingForm").validate({
        rules: {
            vehicle: 'required',
            fuel_type: 'required',
            // fuel_station: 'required',
            refueling_date: 'required',
            last_reading: {
                min: 0
            },
            last_unit: { min: 0 },
            place: {
                required: true,
                maxlength: 50
            },
            security_name: {
                required: {
                    depends: function (element) {
                        return $("#station_name").val() != '';
                    }
                }
            },
            driver: 'required',
            odometer_at_refueling: {
                number: true
            },
            unit_taken: {
                required: true,
                min: 0
            },
            amount_per_unit: {
                required: true,
                min: 0
            },
            total_amount: {
                required: true,
                min: 0
            },
            max_unit: {
                required: true,
                min: 0
            },
            fuel_slip_scan_copy: {
                validFileType: true,
                validFileSize: true
            }
        },
        messages: {
            security_name: {
                required: 'Required when Fuel Station is selected'
            }
        },
        errorElement: 'div',
        errorPlacement: function (error, element) {
            $(element).closest('div[class*=col-sm-]').append(error);
        },
        submitHandler: function (form, ev) {
            ev.preventDefault();

            let addRefuelSettingFormData = new FormData($(form)[0]);

            $.ajax({
                url: form.action,
                type: form.method,
                data: addRefuelSettingFormData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function (res) {
                    if (res.successCode == 1) {
                        toastr.success(res.message, '', { closeButton: true });
                        $("#add0").modal('hide');
                        populateTable(refuelSettingTable);
                    } else {
                        toastr.error(res.message, '', { closeButton: true });
                    }
                },
                error: function () {
                    toastr.error("Error adding Refuel Setting. Please try again", '', { closeButton: true });
                }
            });
        }
    });

    $("#addRefuelSettingForm .basic-single").on('change', function () {
        $(this).valid(); // To remove validation error messages if select2 selections are made
    });

    $("#resetAddRefuelSettingForm").click(function () {
        setTimeout(() => {
            $("#addRefuelSettingForm .basic-single").each(function () {
                $(this).trigger('change');
                // $(this).removeClass('error').removeAttr('aria-invalid');
                // $(this).next().next('div.error').hide();
                $("#addRefuelSettingForm").validate().resetForm();
            });
        }, 10);
    });

    $("#add0").on('hidden.bs.modal', function () {
        $("#addRefuelSettingForm").trigger('reset');
        $("#addRefuelSettingForm").data('validator').resetForm();
        $("#addRefuelSettingForm .form-control").removeClass('error').removeAttr('aria-invalid');
        $('#addRefuelSettingForm .basic-single').trigger('change');
    });

    // To validate and submit Edit Refuel Setting form
    $("#editRefuelSettingForm").validate({
        rules: {
            vehicle: 'required',
            fuel_type: 'required',
            fuel_station: 'required',
            budget_given: {
                required: true,
                number: true
            },
            place: 'required',
            kilometer_per_unit: 'required',
            driver: 'required',
            driver_mobile: 'required',
            max_unit: 'required'
        },
        errorElement: 'div',
        errorPlacement: function (error, element) {
            $(element).closest('div[class*=col-sm-]').append(error);
        },
        submitHandler: function (form, ev) {
            ev.preventDefault();

            console.log("Validating Form");
            // Rest of submit handler left out since validation is re-initialized
        }
    });

});

// To load data into Data Table
function populateTable(table) {
    $.ajax({
        url: refuelSettingListURL,
        type: 'post',
        data: {
            _token: csrfToken
        },
        dataType: 'json',
        beforeSend: function () {
            $("#table-loader").show();
        },
        success: function (res) {
            table.clear();
            if (res.length >= 1) {
                $.each(res, function (i, data) {
                    let actionBtns = `<button class="btn btn-sm btn-info mr-1" onclick="editInfo(${data.REFUEL_SETTING_ID})" title="Edit"><i class="ti-pencil"></i></button> `;
                    if (data.IS_ACTIVE == 'Y')
                        actionBtns += `<button class="btn btn-sm btn-danger mr-1" onclick="changeActivationstatus(0, ${data.REFUEL_SETTING_ID})" title="Deactivate">
                    <i class="ti-close"></i></button> `;
                    else
                        actionBtns += `<button class="btn btn-sm btn-danger mr-1" onclick="changeActivationstatus(1, ${data.REFUEL_SETTING_ID})" title="Activate">
                    <i class="ti-reload"></i></button> `;

                    // Add row
                    table.row.add([
                        i + 1,
                        data.VEHICLE_NAME,
                        data.LAST_READING,
                        // data.STRICT_CONSUMPTION == 'Y' ? 'Yes' : 'No',
                        // data.DRIVER_MOBILE,
                        data.FUEL_TYPE_NAME,
                        // data.REFUEL_LIMIT_TYPE,
                        actionBtns
                    ]);
                });
            }
            table.draw();
        },
        error: function (jqXHR, textStatus, err) {
            toastr.error("Error trying to get data. Please try again", "", { closeButton: true });
        },
        complete: function () {
            $("#table-loader").hide();
        }
    })
}

// Get Details to Edit Refuel Setting Form
function editInfo(refuelSettingId) {
    // AJAX request to get details
    $.ajax({
        url: refuelSettingEditURL,
        type: 'post',
        data: {
            refuel_setting_id: refuelSettingId,
            _token: csrfToken
        },
        beforeSend: function () {
            $('.customloader').show();
        },
        success: function (res) {
            $("#edit .modal-body").empty();
            $("#edit .modal-body").html(res);
            $("#edit .basic-single").select2();

            // For Date picker functionality
            $('#edit .edit-datepicker').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                autoUpdateInput: false,
                minYear: 2000,
                "drops": "down",
                locale: {
                    format: 'DD-MMM-YYYY'
                }
            }, function (start, end, label) {
                var years = moment().diff(start, 'years');
            });
            $('#edit .edit-datepicker').on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('DD-MMM-YYYY'));
            });
            $('#edit .edit-datepicker').on('cancel.daterangepicker', function (ev, picker) {
                $(this).val('');
            });

            $("#resetEditForm").click(function () {
                setTimeout(() => {
                    $("#editRefuelSettingForm").validate().resetForm();
                    $("#editRefuelSettingForm .basic-single").trigger('change');
                }, 10);
            });

            $("#edit").modal('show');
            $('.customloader').hide();
            reinitValidationForEditForm();
        },
        error: function () {
            toastr.error("Error getting details. Please try again");
        }
    });

}

// Activate / Deactivate Refuel Setting
function changeActivationstatus(newStatus, id) {
    // newStatus = 1 to Activate, = 0 to De-activate
    if (confirm("Are you sure?")) {
        $.ajax({
            url: activationStatusChangeURL,
            type: 'post',
            data: {
                refuel_setting_id: id,
                activation_status: newStatus,
                _token: csrfToken
            },
            dataType: 'json',
            success: function (res) {
                let refuelSettingsTable = $("#refuelSettingTable").DataTable();
                if (res.successCode == 1) {
                    toastr.success(res.message, '', { closeButton: true });
                    populateTable(refuelSettingsTable);
                } else {
                    toastr.error(res.message, '', { closeButton: true });
                }
            },
            error: function (jqXHR, textstatus, err) {
                toastr.error('Error updating. Please try again', '', { closeButton: true });
            }
        });
    }
}

function reinitValidationForEditForm() {
    var validator = $("#editRefuelSettingForm").validate();
    validator.destroy();
    $("#editRefuelSettingForm").validate({
        rules: {
            vehicle: 'required',
            fuel_type: 'required',
            // fuel_station: 'required',
            refueling_date: 'required',
            last_reading: {
                min: 0
            },
            last_unit: { min: 0 },
            place: {
                required: true,
                maxlength: 50
            },
            security_name: {
                required: {
                    depends: function (element) {
                        return $("#edit_station_name").val() != '';
                    }
                }
            },
            driver: 'required',
            odometer_at_refueling: {
                number: true
            },
            unit_taken: {
                required: true,
                min: 0
            },
            amount_per_unit: {
                required: true,
                min: 0
            },
            total_amount: {
                required: true,
                min: 0
            },
            max_unit: {
                required: true,
                min: 0
            },
            fuel_slip_scan_copy: {
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

            let editRefuelSettingFormData = new FormData($(form)[0]);
            let refuelSettingTable = $("#refuelSettingTable").DataTable();

            $.ajax({
                url: form.action,
                type: form.method,
                data: editRefuelSettingFormData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function (res) {
                    if (res.successCode == 1) {
                        toastr.success(res.message, '', { closeButton: true });
                        $("#edit").modal('hide');
                        populateTable(refuelSettingTable);
                    } else {
                        toastr.error(res.message, '', { closeButton: true });
                    }
                },
                error: function () {
                    toastr.error("Error Updating Refuel Setting. Please try again", '', { closeButton: true });
                }
            });
        }
    });
}
