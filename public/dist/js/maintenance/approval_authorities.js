$(document).ready(function () {
    let maintenAuthoritiesTable = $("#authinfo").DataTable();

    populateTable(maintenAuthoritiesTable);

    // Validate and submit Add Maintenance Requisition Authority Form
    $("#addMaintenAuthorityForm").validate({
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
                        populateTable(maintenAuthoritiesTable);
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

    $("#add0").on('hidden.bs.modal', function () {
        $("#addMaintenAuthorityForm").trigger('reset');
        $("#addMaintenAuthorityForm").data('validator').resetForm();
        $("#addMaintenAuthorityForm select").removeClass('error');
        $("#addMaintenAuthorityForm").removeAttr('aria-invalid');

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
            // $("#employeeSelect").html("").append("<option value='' selected>Please Select Employee</option>");
        }, 10);
    });

    // On clicking Search (filter) button, filter results
    $("#btn-filter").click(function () {
        populateTable(maintenAuthoritiesTable);
    });

    // On clicking Reset (filter) button, clear all filters and load results
    $("#btn-reset").click(function () {
        $("#filterDept").val("").trigger('change');
        $("#req_phasesr").val("");
        populateTable(maintenAuthoritiesTable);
    });
});

function populateTable(table) {
    $.ajax({
        url: authorityListURl,
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
                    </button> `;
                    if (data.IS_ACTIVE == 'Y')
                        actionBtns += `<button class="btn btn-danger btn-sm mr-1" onclick="changeActivationStatus(${data.AUTHORITY_ID}, 1)"
                    title="Deactivate"><i class="ti-close"></i></button> `;
                    else
                        actionBtns += `<button class="btn btn-danger btn-sm mr-1" onclick="changeActivationStatus(${data.AUTHORITY_ID}, 0)"
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

function loadEmployees() {
    if ($("#department").val()) {
        $.ajax({
            url: loadEmployeesURL,
            type: 'post',
            data: {
                department: $("#department").val(),
                _token: csrfToken
            },
            success: function (res) {
                if (res.successCode == 1) {
                    $("#employeeSelect").html("").append("<option value='' selected>Please Select Employee</option>");
                    if (res.data.length >= 1) {
                        $.each(res.data, function (i, data) {
                            $("#employeeSelect").append('<option value="' + data.employeeId + '|' + data.employeeName + '">' +
                                data.employeeName + '</option>');
                        });
                    }
                } else {
                    $("#employeeSelect").html("").append("<option value='' selected>Please Select Employee</option>");
                    toastr.error("No results found", '', { closeButton: true });
                }
            },
            error: function (jqXHR, textStatus, err) {
                toastr.error("Error getting details. Please try again", "", { closeButton: true });
            }
        });
    }
}

function editInfo(reqAuthId, reqPhase, empId, empName, deptId, deptName) {
    $("#editMaintenAuthorityForm input[name='phase']").each(function () {
        if ($(this).attr('value') == reqPhase) {
            $(this).prop('checked', true);
            $(this).attr('checked', 'checked');
        } else {
            $(this).removeProp('checked');
            $(this).removeAttr('checked');
        }
    });
    $("#editMaintenAuthorityForm input[name='auth_id']").val(reqAuthId);
    let selectedEmployee = empId + '|' + empName;
    let selectedDept = deptId + '|' + deptName;
    console.log(selectedEmployee);
    $("#newDepartment").val(selectedDept).trigger('change');
    $("#newEmployeeSelect").val(selectedEmployee).trigger('change').attr('disabled', 'disabled');
    $("#edit").modal("show");
}

function changeActivationStatus(reqAuthId, activeStatus) {
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
                populateTable($("#authinfo").DataTable());
            } else {
                toastr.error(res.message, '', { closeButton: true });
            }
        }
    });
}