$(document).ready(function () {
    let refuelSettingTable = $("#refuelSettingTable").DataTable();

    $("#addRefuelSettingForm").validate({
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
        $('.basic-single').trigger('change');
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
        success: function (res) {
            // table.clear();
            if (res.length >= 1) {
                // $.each(res, function (i, data) {
                //     let actionBtns = `<button class="btn btn-sm btn-info mr-1" onclick="editInfo()" title="Edit"><i class="ti-pencil"></i></button>`;
                //     if (data.IS_ACTIVE == 'Y')
                //         actionBtns += `<button class="btn btn-sm btn-info mr-1 onclick="updateActivation(0, ${})" title="Deactivate">
                // <i class="ti-close"></i></button>`;
                //     else
                //         actionBtns += `<button class="btn btn-sm btn-info mr-1 onclick="updateActivation(1, ${})" title="Activate">
                // <i class="ti-reload"></i></button>`;

                // // Add row
                // });
            }
            // table.draw();
        },
        error: function (jqXHR, textStatus, err) {
            toastr.error("Error trying to get data. Please try again", "", { closeButton: true });
        }
    })
}

// Get Details to Edit Refuel Setting Form
function editInfo(refuelSettingId) {
    // AJAX request to get details

    $("#edit .modal-body").clear();
    $("#edit .modal-body").append('<form id="editRefuelSettingForm" action="">');
    $("#edit .modal-body").append('<input type="hidden" name="_token" value="' + csrfToken + '">');
    $("#edit .modal-body").append(res);
    $("#edit .modal-body").append('</form>');
    $("#edit").modal('show');
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
                if (res.successCode == 1) {
                    toastr.success(res.message, '', { closeButton: true });
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
