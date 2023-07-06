//To validate input image is only JPG or PNG
$.validator.addMethod('validImage', function (value, element, param) {
    let fileName = ''; let fileExtn = '';
    if (element.files[0]) { // If profile image is present
        fileName = element.files[0].name;
        fileExtn = fileName.substr(fileName.lastIndexOf('.') + 1).toLowerCase();
    }
    return (this.optional(element) || (fileExtn === 'jpg' || fileExtn === 'jpeg' || fileExtn === 'png'));
}, "Profile image should be only JPG or PNG");

$(document).ready(function () {
    // Validate Form to Add Drivers
    $("#add_driver_form").validate({
        rules: {
            driver_name: {
                required: true,
                minlength: 2,
                maxlength: 75
            },
            mobile: {
                required: true
            },
            license_number: {
                required: true,
                maxlength: 50
            },
            license_type: 'required',
            national_id: {
                required: true
            },
            license_issue_date: {
                required: true
            },
            timeslot_start: 'required',
            timeslot_end: 'required',
            join_date: 'required',
            dob: 'required',
            permanent_address: {
                maxlength: 250
            },
            present_address: {
                maxlength: 250
            },
            picture: {
                validImage: true
            }
        },
        submitHandler: function (form, ev) {
            ev.preventDefault();

            let addDriverFormData = new FormData($("#add_driver_form")[0]);
            $.ajax({
                url: form.action,
                method: 'post',
                data: addDriverFormData,
                processData: false,
                contentType: false,
                success: function (res) {
                    console.log(res);
                    toastr.success(res, '', { closeButton: true });
                    $("#add0").modal("hide");
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log("Some error occured");
                    toastr.error("Error adding driver. Please try again", '', { closeButton: true });
                }
            });
        }
    });

    // Validate Form to Update Driver Details
    $("#updateDriverDetailsForm").validate({
        rules: {
            driver_name: {
                required: true,
                minlength: 2,
                maxlength: 75
            },
            mobile: {
                required: true
            },
            license_number: {
                required: true,
                maxlength: 50
            },
            license_type: 'required',
            national_id: {
                required: true
            },
            license_issue_date: {
                required: true
            },
            timeslot_start: 'required',
            timeslot_end: 'required',
            join_date: 'required',
            dob: 'required',
            permanent_address: {
                maxlength: 250
            },
            present_address: {
                maxlength: 250
            },
            picture: {
                validImage: true
            }
        },
        submitHandler: function (form, ev) {
            ev.preventDefault();

            let editDriverFormData = new FormData($("#updateDriverDetailsForm")[0]);
            $.ajax({
                url: form.action,
                method: 'post',
                data: editDriverFormData,
                processData: false,
                contentType: false,
                success: function (res) {
                    console.log(res);
                    toastr.success(res, '', { closeButton: true });
                    $("#editDriverDetailsModal").modal("hide");
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log("Some error occured");
                    toastr.error("Could not update driver details", '', { closeButton: true });
                }
            });
        }
    });

    // Clear and reset form and validatons on closing modal
    $("#add0").on('hidden.bs.modal', function () {
        $("#add_driver_form").trigger('reset');
        $("#add_driver_form").data('validator').resetForm();
        $('.form-control').each(function () {
            $(this).removeClass('error');
        });
    });

});

function loadFile(ev) {
    // if (ev.target.files[0]) {
    //     let currentFile = ev.target.files[0].name;
    //     $("#selectedFileName").html(currentFile);
    //     $("#selectedFileName").prev().find('span').hide();
    // }
    // else {
    //     $("#selectedFileName").html("No file chosen");
    // }
}

function updateDriverDetails(driver_id, driver_name, mobile_number, license_number, license_type, national_id, license_issue_date, work_start_time, work_end_time, join_date, dob, permanent_address, present_address, leave_status, is_active, profile_photo) {
    let updateForm = $("#updateDriverDetailsForm");
    // To set Driver ID For Update Form Action by replacing placeholder 0 or current Driver ID which previously 
    // replaced 0 in formaction by driver_id
    let formAction = updateForm.attr('action');
    let currentId = formAction.substring(formAction.lastIndexOf('/') + 1);
    formAction = formAction.replace(currentId, driver_id);
    updateForm.attr('action', formAction);

    console.log(license_type);

    updateForm.empty().append('<input type="hidden" name="_method" value="PUT">');
    updateForm.append('<input type="hidden" name="_token" value="' + $('meta[name="csrf-token"]').attr('content') + '">');

    let formContent = `<div class="col-md-12 col-lg-6">
    <div class="form-group row">
        <label for="update_driver_name" class="col-sm-5 col-form-label">Driver Name <i class="text-danger">*</i></label>
        <div class="col-sm-7">
            <input name="driver_name" required="" class="form-control" type="text" placeholder="Driver Name" id="update_driver_name" value="${driver_name}" autocomplete="off">
        </div>
    </div>
    <div class="form-group row">
        <label for="update_license_number" class="col-sm-5 col-form-label">License Number <i class="text-danger">*</i></label>
        <div class="col-sm-7">
            <input name="license_number" required="" class="form-control" type="text" placeholder="License Number" id="update_license_number" value="${license_number}" autocomplete="off">
        </div>
    </div>
    <div class="form-group row">
        <label for="update_national_id" class="col-sm-5 col-form-label">National ID <i class="text-danger">*</i></label>
        <div class="col-sm-7">
            <input name="national_id" required="" class="form-control" type="number" placeholder="National ID" id="update_national_id" value="${national_id}" autocomplete="off">
        </div>
    </div>
    <div class="form-group row">
        <label for="timeslot" required="" class="col-sm-5 col-form-label">Working Time Slot <i class="text-danger">*</i></label>
        <div class="col-sm-3 pr-0">
            <input name="timeslot_start" required="" class="form-control timepicker" type="text" placeholder="09:00 AM" id="newTimeslotStart" value="${work_start_time}">
        </div>
        <div class="col-sm-1"><sub>&ndash;</sub></div>
        <div class="col-sm-3 pl-0">
            <input name="timeslot_end" required="" class="form-control timepicker" type="text" placeholder="05:00 PM" id="newTimeslotEnd" value="${work_end_time}">
        </div>
    </div>
    <div class="form-group row">
        <label for="update_dob" class="col-sm-5 col-form-label">Date of Birth </label>
        <div class="col-sm-7">
            <input name="dob" autocomplete="off" class="form-control date-picker" type="text" placeholder="Date of Birth" id="update_dob" value="${dob}">
        </div>
    </div>
    <div class="form-group row">
        <label for="update_present_address" class="col-sm-5 col-form-label">Present Address </label>
        <div class="col-sm-7">
            <input name="present_address" class="form-control" type="text" placeholder="Present Address" id="update_present_address" value="${present_address}">
        </div>
    </div>
    <div class="form-group row">
        <label for="checkbox2" class="col-sm-5 col-form-label">&nbsp;</label>
        <div class="col-sm-7 checkbox checkbox-primary">
            <input id="checkbox_edit_is_active" type="checkbox" name="is_active" ${is_active == 'Y' ? 'checked' : ''}>
            <label for="checkbox_edit_is_active">Is Active</label>
        </div>
    </div>
</div>
<div class="col-md-12 col-lg-6">
    <div class="form-group row">
        <label for="update_mobile" class="col-sm-5 col-form-label">Mobile <i class="text-danger">*</i></label>
        <div class="col-sm-7">
            <input name="mobile" required="" class="form-control" type="number" placeholder="Mobile" id="update_mobile" value="${mobile_number}">
        </div>
    </div>

    <div class="form-group row">
        <label for="update_license_type" class="col-sm-5 col-form-label">License Type <i class="text-danger">*</i></label>
        <div class="col-sm-7">
            <select class="form-control" required="" name="license_type" id="update_license_type">
                <option value="">Please Select One</option>
                <option value="1">LMV</option>
                <option value="2">HMV</option>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label for="update_license_issue_date" class="col-sm-5 col-form-label">License Issue Date </label>
        <div class="col-sm-7">
            <input name="license_issue_date" autocomplete="off" class="form-control date-picker" type="text" placeholder="License Issue Date" id="update_license_issue_date" value="${license_issue_date}">
        </div>
    </div>

    <div class="form-group row">
        <label for="update_join_date" class="col-sm-5 col-form-label">Join Date </label>
        <div class="col-sm-7">
            <input name="join_date" autocomplete="off" class="form-control date-picker" type="text" placeholder="Join Date" id="update_join_date" value="${join_date}">
        </div>
    </div>
    <div class="form-group row">
        <label for="update_permanent_address" class="col-sm-5 col-form-label">Permanent Address </label>
        <div class="col-sm-7">
            <input name="permanent_address" class="form-control" type="text" placeholder="Permanent Address" id="update_permanent_address" value="${permanent_address}">
        </div>
    </div>
    <div class="form-group row">
        <label for="leavestatus" class="col-sm-5 col-form-label">Leave Status </label>
        <div class="col-sm-7">
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="updatedstatusyes" name="leavestatus" class="custom-control-input" value="1" ${leave_status === 'Y' ? 'checked' : ''}>
                <label class="custom-control-label" for="updatedstatusyes">Yes</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="updatedstatusno" name="leavestatus" class="custom-control-input" value="0" ${leave_status === 'N' ? 'checked' : ''}>
                <label class="custom-control-label" for="updatedstatusno">No</label>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label for="newpicture" class="col-sm-5 col-form-label">Photograph </label>
        <div class="col-sm-7" style="display:flex;flex-wrap:wrap;">
            <input type="file" accept="image/*" name="picture" id="newpicture">
        </div>
    </div>

    <div class="form-group text-right">
        <button type="reset" class="btn btn-primary w-md m-b-5">Reset</button>
        <button type="submit" class="btn btn-success w-md m-b-5">Update</button>
    </div>`;

    updateForm.append(formContent);
    $("#update_license_type").val(license_type);

    $('.date-picker').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        autoUpdateInput: false,
        minYear: 1901,
        maxDate: '2100',
        "drops": "down",
        locale: {
            format: 'YYYY-MM-DD'
        },
        maxYear: parseInt(moment().format('YYYY'), 10)
    }, function (start, end, label) {
        var years = moment().diff(start, 'years');
    });
    $('.date-picker').on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format('YYYY-MM-DD'));
    });
    $('.date-picker').on('cancel.daterangepicker', function (ev, picker) {
        $(this).val('');
    });

    $("#editDriverDetailsModal").modal('show');
}

function deactivateDriver(el) {
    let driver_id = $(el).attr('data-driverid');

    console.log(driver_id);
    if (confirm("Are you sure you want to deactivate this driver?")) {
        //
        $.ajax({
            url: deactivateDriverURL,
            type: 'PUT',
            data: {
                _token: csrfToken,
                driver_id: driver_id
            },
            success: function (res) {
                console.log(res);
                toastr.success(res, '', {
                    closeButton: true
                });
                $(el).find('i').removeClass('ti-close').addClass('ti-reload');
                $(el).prop('title', 'Activate');
                $(el).attr('data-original-title', 'Activate');
                $(el).attr('onclick', 'activateDriver(this)');
                $(el).closest('td').prev().html("Inactive");
            },
            error: function (jqXHR, textstatus, errorThrown) {
                console.log("Could not deactivate driver");
                toastr.error("Could not deactivate driver", "", {
                    closeButton: true
                });
            }
        })
    }
}

function activateDriver(el) {
    let driver_id = $(el).attr('data-driverid');

    console.log(driver_id);
    if (confirm("Are you sure you want to activate this driver?")) {
        //
        $.ajax({
            url: activateDriverURL,
            type: 'PUT',
            data: {
                _token: csrfToken,
                driver_id: driver_id
            },
            success: function (res) {
                console.log(res);
                toastr.success(res, '', {
                    closeButton: true
                });
                $(el).find('i').removeClass('ti-reload').addClass('ti-close');
                $(el).prop('title', 'Deactivate');
                $(el).attr('data-original-title', 'Deactivate');
                $(el).attr('onclick', 'deactivateDriver(this)');
                $(el).closest('td').prev().html("Active");
            },
            error: function (jqXHR, textstatus, errorThrown) {
                console.log("Could not activate driver");
                toastr.error("Could not activate driver", "", {
                    closeButton: true
                });
            }
        })
    }
}