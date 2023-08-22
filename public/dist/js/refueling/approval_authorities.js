$(document).ready(function () {
    let refuelApprovalAuthTable = $("#rauthinfo").DataTable();

    populateTable(refuelApprovalAuthTable);

    // Validate and submit Add Refueling Requisition Authority Form
    $("#addRefuelApprovalAuthorityForm").validate({
        rules: {
            phase: 'required',
            department: 'required',
            employee: 'required'
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
                    if (res.successCode == 1) {
                        toastr.success(res.message, '', { closeButton: true });
                        populateTable(refuelApprovalAuthTable);
                        $("#add0").modal('hide');
                    } else {
                        toastr.error(res.message, '', { closeButton: true });
                    }
                },
                error: function (jqXHR, textStatus, err) {
                    toastr.error("Error adding approval authority. Please try again", "", { closeButton: true });
                }
            });
        }
    });

    // On changing select2 options for dept and employee, remove validation if selection made
    $("#department").on('change', function () {
        $(this).valid();
    });

    $("#employeeSelect").on('change', function () {
        $(this).valid();
    });

    $("#add0").on('hidden.bs.modal', function () {
        $("#addRefuelApprovalAuthorityForm").trigger('reset');
        $("#addRefuelApprovalAuthorityForm").data('validator').resetForm();
        $("#addRefuelApprovalAuthorityForm select").removeClass('error');
        $("#addRefuelApprovalAuthorityForm").removeAttr('aria-invalid');

        // To prevent select2 boxes still displaying previously selected value on resetting form
        $('#department').val('').trigger('change');
        $("#employeeSelect").val('').trigger('change');

        // Empty and reset employee list if populated by selecting/changing department
        // $("#employeeSelect").html("").append("<option value='' selected>Please Select Employee</option>");
    });

    // On resetting form, to reset department select2 dropdown
    $("#resetAddAuthorityFormBtn").click(function () {
        setTimeout(() => {
            $('#department').val('').trigger('change');
            $("#employeeSelect").val("").trigger('change');
            // $("#employeeSelect").html("").append("<option value='' selected>Please Select Employee</option>");
            $("#addRefuelApprovalAuthorityForm").data('validator').resetForm();
        }, 10);
    });

    // On clicking Search (filter) button, filter results
    $("#btn-filter").click(function () {
        populateTable(refuelApprovalAuthTable);
    });

    // On clicking Reset (filter) button, clear all filters and load results
    $("#btn-reset").click(function () {
        $("#filterDept").val("").trigger('change');
        $("#req_phasesr").val("");
        populateTable(refuelApprovalAuthTable);
    });

    // Validate and submit Edit Refueling Approval Authoritiy Form
    $("#editRefuelApprovalAuthorityForm").validate({
        rules: {
            phase: 'required',
            department: 'required',
            employee: 'required'
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
                    if (res.successCode === 1) {
                        toastr.success(res.message, '', { closeButton: true });
                        populateTable(refuelApprovalAuthTable);
                        $("#edit").modal('hide');
                    } else {
                        toastr.error(res.message, '', { closeButton: true });
                    }
                },
                error: function (jqXhr, textStatus, err) {
                    toastr.error("Error updating. Please try again", '', { closeButton: true });
                }
            });
        }
    });

    // On resetting form, to reset department select2 dropdown to initial value
    $("#resetEditAuthorityFormBtn").click(function () {
        setTimeout(() => {
            $('#newDepartment').trigger('change');
            $("#newDepartment").valid();
        }, 10);
    });

    // On changing select2 options for dept in Edit Approval Authority, remove validation if selection made
    $("#newDepartment").on('select2:close', function () {
        if ($(this).closest('div.col-sm-*').has('.error')) {
            $(this).valid();
        }
    });


});
/* End of document.ready function */

let refuelApprovalAuthTable = $("#rauthinfo").DataTable();

function populateTable(table) {
    $.ajax({
        url: authorityListURL,
        type: 'post',
        data: {
            dept_sr: $("#filterDept").val(),
            req_phasesr: $("#req_phasesr").val(),
            _token: csrfToken
        },
        dataType: 'json',
        success: function (res) {
            table.clear();
            if (res.length >= 1) {
                $.each(res, function (i, data) {
                    let actionBtns = `<button class="btn btn-info btn-sm mr-1" onclick="editInfo(${data.AUTHORITY_ID}, ${data.REQUISITION_PHASE}, ${data.EMPLOYEE_ID}, '${data.EMPLOYEE_NAME}',
                    '${data.DEPARTMENT_CODE}', '${data.DEPARTMENT_NAME}')" title="Edit">
                    <i class="ti-pencil"></i>
                    </button>`;
                    if (data.IS_ACTIVE == 'Y')  // Send Status = 0 for deactivating
                        actionBtns += `<button class="btn btn-danger btn-sm mr-1" onclick="changeActivationStatus(${data.AUTHORITY_ID}, 0)" 
                        title="Deactivate"><i class="ti-close"></i></button> `;
                    else  // Send Status = 1 for activating
                        actionBtns += `<button class="btn btn-danger btn-sm mr-1" onclick="changeActivationStatus(${data.AUTHORITY_ID}, 1)" 
                        title="Activate"><i class="ti-reload"></i></button> `;

                    table.row.add([
                        i + 1,
                        data.REQ_TYPE_NAME,
                        data.PHASE_NAME,
                        data.DEPARTMENT_NAME,
                        data.EMPLOYEE_NAME,
                        actionBtns
                    ]);
                });
            }
            table.draw();
        },
        error: function (jqXHR, text, err) {
            toastr.error("Error getting requisition data. Please try again", "", { closeButton: true });
        }
    });
}

function editInfo(reqAuthId, reqPhase, empId, empName, deptId, deptName) {
    // Select the appropriate checkbox based on current value of req. phase
    $("#editRefuelApprovalAuthorityForm input[name='phase']").each(function () {
        if ($(this).attr('value') == reqPhase) {
            $(this).prop('checked', true);
            $(this).attr('checked', 'checked');
        } else {
            $(this).removeProp('checked');
            $(this).removeAttr('checked');
        }
    });

    // Set value of Requistion Authority ID which is to be updated sent to server
    $("#editRefuelApprovalAuthorityForm input[name='auth_id']").val(reqAuthId);

    let selectedEmployee = empId + '|' + empName;
    let selectedDept = deptId + '|' + deptName;

    // To set the value of department dynamically
    // Dept option value is in format deptCode|deptName to enable storing both details on server
    $("#newDepartment").html("").append('<option value="">Please select</option>');
    $.each(depts, function (i, data) {
        if (data.deptCode == deptId)
            $("#newDepartment").append('<option value="' + selectedDept + '" selected="selected">' + deptName + '</option>');
        else
            $("#newDepartment").append('<option value="' + data.deptCode + '|' + data.deptName + '">' + data.deptName + '</option>');
    });

    $("#newDepartment").removeAttr('aria-invalid').removeClass('error'); // To remove any previous validator error message
    $("#newDepartment").nextAll('div.error').remove();

    $("#newEmployeeSelect").val(selectedEmployee).trigger('change').attr('disabled', 'disabled');
    $("#edit").modal("show");
}

function changeActivationStatus(reqAuthId, activeStatus) {
    if (confirm("Are you sure?")) {
        $.ajax({
            url: changeActivationStatusURL,
            type: 'post',
            data: {
                _token: csrfToken,
                req_auth_id: reqAuthId,
                req_status: activeStatus
            },
            dataType: 'json',
            success: function (res) {
                if (res.successCode == 1) {
                    toastr.success(res.message, '', { closeButton: true });
                    populateTable(refuelApprovalAuthTable);
                } else {
                    toastr.error(res.message, '', { closeButton: true });
                }
            }
        });
    }
}