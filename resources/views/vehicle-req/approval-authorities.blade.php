@extends('layouts.main.app')

@section('title', 'Vehicle Requisition Approval Authorities')

@section('css-content')
<style>
div.error {
    font-size: .8em;
    color: #f66;
}


select.error~.select2 .select2-selection {
    border: 1px solid #f99;
}
</style>
@endsection

@section('breadcrumb-content')
<li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
<li class="breadcrumb-item active" id="moduleName">Vehicle Requisition</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">Vehicle Requisition</h1>
<small id="controllerName">Vehicle Requisition Approval Authorities List</small>
@endsection

@section('content')

<div id="add0" class="modal fade bd-example-modal-lg" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Add Approval Authority </strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{route('vehicle-req-approval-auth.add')}}" id="addMaintenAuthorityForm" class="row"
                    method="post" accept-charset="utf-8">
                    @csrf
                    <div class="col-md-12 col-lg-12">
                        <div class="form-group row">
                            <label for="req_type" class="col-sm-3 col-form-label">Requisition Type <i
                                    class="text-danger">*</i></label>
                            <div class="col-sm-5">
                                <select class="form-control" required="" name="req_type" id="req_type" disabled>
                                    <option value="">Please Select One</option>
                                    @foreach($reqTypes as $reqType)
                                    <option value="{{$reqType['REQUISITION_TYPE_ID']}}"
                                        @if($reqType['REQUISITION_TYPE_ID']==1) selected @endif>
                                        {{$reqType['REQUISITION_TYPE_NAME']}}
                                    </option>
                                    @endforeach
                                </select>
                                {{-- For Sending Requisition Type since select field above is disabled to make it unchangeable --}}
                                <input type="hidden" name="req_type" value="1">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="req_phase" class="col-sm-3 col-form-label">Requisition Phase <i
                                    class="text-danger">*</i></label>
                            <div class="col-sm-9">
                                @foreach($phases as $phase)
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input id="radio{{$phase['PHASE_ID']}}" type="radio" class="custom-control-input"
                                        name="phase" value="{{$phase['PHASE_ID']}}">
                                    <label class="custom-control-label"
                                        for="radio{{$phase['PHASE_ID']}}">{{$phase['PHASE_NAME']}}</label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="department" class="col-sm-3 col-form-label">Department <i
                                    class="text-danger">*</i></label>
                            <div class="col-sm-5">
                                <select class="form-control basic-single" required="" name="department" id="department">
                                    <option value="" selected="selected">Please Select One</option>
                                    @foreach($departments['data'] as $department)
                                    <option value="{{$department['deptCode'] . '|' . $department['deptName']}}">
                                        {{$department['deptName']}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="employeeSelect" class="col-sm-3 col-form-label">Employee <i
                                    class="text-danger">*</i></label>
                            <div class="col-sm-5">
                                <select name="employee" id="employeeSelect" class="form-control basic-single"
                                    required="">
                                    <option value="" selected>Please Select Employee</option>
                                    @foreach($employees['data'] as $employee)
                                    <option value="{{$employee['employeeId'] . '|'. $employee['employeeName']}}">
                                        {{$employee['employeeName'] . ' (' . $employee['department'] . ')'}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group text-right">
                            <button type="reset" id="resetAddAuthorityFormBtn"
                                class="btn btn-primary w-md m-b-5">Reset</button>
                            <button type="submit" class="btn btn-success w-md m-b-5">Add</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="card mb-3">
            <div class="card-header p-2">
                <h4 class="pl-3">
                    Search Here
                    <small class="float-right">
                        <button type="button" class="btn btn-primary btn-md" data-target="#add0" data-toggle="modal">
                            <i class="ti-plus" aria-hidden="true"></i>
                            Add Approval Authority
                        </button>
                    </small>
                </h4>
            </div>
            <div class="card-body row">
                <!-- <div class="col-sm-12 col-xl-4">
                    <div class="form-group row mb-1">
                        <label for="req_typesr" class="col-sm-5 col-form-label justify-content-start text-left">Requisition Type </label>
                        <div class="col-sm-7">
                            <select class="form-control basic-single" name="req_typesr" id="req_typesr">
                                <option value="" selected="selected">Please Select One</option>
                                <option value="Re-Fueling Requisition ">Re-Fueling Requisition </option>
                                <option value="Maintenance Requisition">Maintenance Requisition </option>
                                <option value="Vehicle Requisition">Vehicle Requisition </option>
                            </select>
                        </div>
                    </div>
                </div> -->
                <div class="col-sm-12 col-xl-4">
                    <div class="form-group row mb-1">
                        <label for="req_phasesr"
                            class="col-sm-5 col-form-label justify-content-start text-left">Requisition Phase</label>
                        <div class="col-sm-7">
                            <select class="form-control" name="req_phasesr" id="req_phasesr">
                                <option value="" selected>Please select</option>
                                @foreach($phases as $phase)
                                <option value="{{$phase['PHASE_ID']}}">{{$phase['PHASE_NAME']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-xl-5">
                    <div class="form-group row mb-1">
                        <label for="status"
                            class="col-sm-3 col-form-label justify-content-start text-left">Department</label>
                        <div class="col-sm-9">
                            <select class="form-control basic-single" name="dept_sr" id="filterDept">
                                <option value="" selected>Please select</option>
                                @foreach($departments['data'] as $department)
                                <option value="{{$department['deptCode']}}">{{$department['deptName']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- <div class="col-sm-12">
                            <div class="form-group row  mb-1">
                                <label for="joining_d_to" class="col-sm-5 col-form-label">&nbsp;</label>
                                <div class="col-sm-7 text-right">
                                    <button type="button" class="btn btn-success" id="btn-filter">Search</button>&nbsp;
                                    <button type="button" class="btn btn-inverse" id="btn-reset">Reset</button>
                                </div>
                            </div>
                        </div> -->

                    </div>
                </div>
                <div class="col-sm-12 col-xl-3">
                    <div class="form-group row  mb-1">
                        <div class="col-sm-12 text-right">
                            <button type="button" class="btn btn-success" id="btn-filter">Search</button>&nbsp;
                            <button type="button" class="btn btn-inverse" id="btn-reset">Reset</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="edit" class="modal fade bd-example-modal-lg" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <strong>Update Requisition</strong>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body editinfo">
                    <form action="{{route('vehicle-req-approval-auth.update')}}" id="editMaintenAuthorityForm"
                        class="row" method="post" accept-charset="utf-8">
                        @csrf
                        <div class="col-md-12 col-lg-12">
                            <div class="form-group row">
                                <label for="req_type" class="col-sm-3 col-form-label">Requisition Type <i
                                        class="text-danger">*</i></label>
                                <div class="col-sm-5">
                                    <select class="form-control" required="" name="req_type" id="def_req_type" disabled>
                                        <option value="">Please Select One</option>
                                        @foreach($reqTypes as $reqType)
                                        <option value="{{$reqType['REQUISITION_TYPE_ID']}}"
                                            @if($reqType['REQUISITION_TYPE_ID']==1) selected @endif>
                                            {{$reqType['REQUISITION_TYPE_NAME']}}
                                        </option>
                                        @endforeach
                                    </select>
                                    {{-- For Sending Requisition Type since select field above is disabled to make it unchangeable --}}
                                    <input type="hidden" name="req_type" value="1">
                                    {{-- 2 for Maintenance Requisition --}}
                                    <input type="hidden" name="auth_id" value="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="new_req_phase" class="col-sm-3 col-form-label">Requisition Phase <i
                                        class="text-danger">*</i></label>
                                <div class="col-sm-9">
                                    @foreach($phases as $phase)
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input id="new_radio{{$phase['PHASE_ID']}}" type="radio"
                                            class="custom-control-input" name="phase" value="{{$phase['PHASE_ID']}}">
                                        <label class="custom-control-label"
                                            for="new_radio{{$phase['PHASE_ID']}}">{{$phase['PHASE_NAME']}}</label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="department" class="col-sm-3 col-form-label">Department <i
                                        class="text-danger">*</i></label>
                                <div class="col-sm-5">
                                    <select class="form-control basic-single" required="" name="department"
                                        id="newDepartment">
                                        <option value="">Please Select One</option>
                                        @foreach($departments['data'] as $department)
                                        <option value="{{$department['deptCode'] . '|' . $department['deptName']}}">
                                            {{$department['deptName']}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="demo" class="col-sm-3 col-form-label">Employee <i
                                        class="text-danger">*</i></label>
                                <div class="col-sm-5">
                                    <select name="employee" id="newEmployeeSelect" class="form-control basic-single"
                                        required="">
                                        <option value="">Please Select Employee</option>
                                        @foreach($employees['data'] as $employee)
                                        <option value="{{$employee['employeeId'] . '|' . $employee['employeeName']}}">
                                            {{$employee['employeeName'] . ' (' . $employee['department'] . ')'}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group text-right">
                                <button type="reset" id="resetEditAuthorityFormBtn"
                                    class="btn btn-primary w-md m-b-5">Reset</button>
                                <button type="submit" class="btn btn-success w-md m-b-5">Save</button>
                            </div>

                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-12">
        <div class="card mb-3">
            <div class="card-header p-2">
                <h4 class="pl-3">Approval Authority List</h4>
            </div>
            <div class="card-body pl-4 pr-3">
                <div class="table-responsive">
                    <table id="authinfo" class="table table-striped table-bordered dt-responsive nowrap">
                        <thead>
                            <tr>
                                <th>Sl No.</th>
                                <th>Requisition Type</th>
                                <th>Requisition Phase</th>
                                <th>Department</th>
                                <th>Employee</th>
                                <th>Action(s)</th>
                            </tr>
                        </thead>

                        <tbody>
                            <!-- <tr role="row" class="odd">
                                <td class="sorting_1" tabindex="0">1</td>
                                <td>Maintenance Requisition</td>
                                <td>Approved</td>
                                <td>Administration</td>
                                <td></td>
                                <td>
                                    <input name="url" type="hidden" id="url_24" value="https://vmsdemo.bdtask-demo.com/maintenance/maintenance/updateapprovalfrm">
                                <a onclick="editinfo(24)" style="cursor:pointer;color:#fff;" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                <a href="#" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                            </td>
                            </tr> -->

                        </tbody>

                    </table> <!-- /.table-responsive -->
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    #authinfo{
        width:100%;
    }
</style>
@endsection
@section('js-content')
<!-- <script src="https://vmsdemo.bdtask-demo.com/assets/dist/js/approval_authority.js"></script> -->
<script>
// To save routes and other global variables
let csrfToken = "{{csrf_token()}}";
let loadEmployeesURL = "{{route('vehicle-req-approval-auth.get-employees')}}";
let authorityListURL = "{{route('vehicle-req-approval-auth.list')}}";
let changeActivationStatusURL = "{{route('vehicle-req-approval-auth.change-activation')}}";
let depts = JSON.parse(`{!! json_encode($departments['data']) !!}`);
</script>
<script>
$(document).ready(function() {
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
        errorPlacement: function(error, element) {
            $(element).closest('div[class*=col-sm-]').append(error);
        },
        submitHandler: function(form, ev) {
            ev.preventDefault();

            $.ajax({
                url: form.action,
                type: form.method,
                data: $(form).serialize(),
                dataType: 'json',
                success: function(res) {
                    if (res.successCode == 1) {
                        toastr.success(res.message, '', {
                            closeButton: true
                        });
                        populateTable(maintenAuthoritiesTable);
                        $("#add0").modal('hide');
                    } else {
                        toastr.error(res.message, '', {
                            closeButton: true
                        });
                    }
                },
                error: function(jqXHR, textStatus, err) {
                    toastr.error("Error adding approval authority. Please try again",
                        "", {
                            closeButton: true
                        });
                }
            });
        }
    });

    // On changing select2 options for dept and employee, remove validation if selection made
    $("#department").on('select2:close', function() {
        if ($(this).closest('div.col-sm-*').has('.error')) {
            $(this).valid();
        }
    });

    $("#employeeSelect").on('select2:close', function() {
        if ($(this).closest('div.col-sm-*').has('.error')) {
            $(this).valid();
        }
    });

    $("#add0").on('hidden.bs.modal', function() {
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
    $("#resetAddAuthorityFormBtn").click(function() {
        setTimeout(() => {
            $('#department').val('').trigger('change');
            $("#employeeSelect").val("").trigger('change');
            // $("#employeeSelect").html("").append("<option value='' selected>Please Select Employee</option>");
        }, 10);
    });

    // On clicking Search (filter) button, filter results
    $("#btn-filter").click(function() {
        populateTable(maintenAuthoritiesTable);
    });

    // On clicking Reset (filter) button, clear all filters and load results
    $("#btn-reset").click(function() {
        $("#filterDept").val("").trigger('change');
        $("#req_phasesr").val("");
        populateTable(maintenAuthoritiesTable);
    });

    // Validate and submit Edit Maintenance Approval Authority Form
    $("#editMaintenAuthorityForm").validate({
        rules: {
            phase: 'required',
            department: 'required',
            employee: 'required'
        },
        errorElement: 'div',
        errorPlacement: function(error, element) {
            $(element).closest('div[class*=col-sm-]').append(error);
        },
        submitHandler: function(form, ev) {
            ev.preventDefault();

            $.ajax({
                url: form.action,
                type: form.method,
                data: $(form).serialize(),
                dataType: 'json',
                success: function(res) {
                    if (res.successCode === 1) {
                        toastr.success(res.message, '', {
                            closeButton: true
                        });
                        populateTable(maintenAuthoritiesTable);
                        $("#edit").modal('hide');
                    } else {
                        toastr.error(res.message, '', {
                            closeButton: true
                        });
                    }
                },
                error: function(jqXHR, textStatus, err) {
                    toastr.error("Error updating approval authority. Please try again",
                        '', {
                            closeButton: true
                        });
                }
            });
        }
    });

    // On resetting form, to reset department select2 dropdown to initial value
    $("#resetEditAuthorityFormBtn").click(function() {
        setTimeout(() => {
            $('#newDepartment').trigger('change');
            // $("#employeeSelect").html("").append("<option value='' selected>Please Select Employee</option>");
        }, 10);
    });

    // On changing select2 options for dept in Edit Approval Authority, remove validation if selection made
    $("#newDepartment").on('select2:close', function() {
        if ($(this).closest('div.col-sm-*').has('.error')) {
            $(this).valid();
        }
    });

});

let maintenAuthoritiesTable = $("#authinfo").DataTable();

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
        success: function(res) {
            table.clear();
            if (res.length >= 1) {
                $.each(res, function(i, data) {
                    let actionBtns = `<button class="btn btn-info btn-sm mr-1" onclick="editInfo(${data.AUTHORITY_ID}, ${data.REQUISITION_PHASE}, ${data.EMPLOYEE_ID}, '${data.EMPLOYEE_NAME}',
                    '${data.DEPARTMENT_CODE}', '${data.DEPARTMENT_NAME}')" title="Edit">
                    <i class="ti-pencil"></i>
                    </button> `;
                    if (data.IS_ACTIVE == 'Y') // Send Status = 0 for deactivating
                        actionBtns += `<button class="btn btn-danger btn-sm mr-1" onclick="changeActivationStatus(${data.AUTHORITY_ID}, 0)"
                    title="Deactivate"><i class="ti-close"></i></button> `;
                    else // Send Status = 1 for activating
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
        error: function(jqXHR, text, err) {
            toastr.error("Error getting requisition data. Please try again", "", {
                closeButton: true
            });
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
            success: function(res) {
                if (res.successCode == 1) {
                    $("#employeeSelect").html("").append(
                        "<option value='' selected>Please Select Employee</option>");
                    if (res.data.length >= 1) {
                        $.each(res.data, function(i, data) {
                            $("#employeeSelect").append('<option value="' + data.employeeId + '|' +
                                data.employeeName + '">' +
                                data.employeeName + '</option>');
                        });
                    }
                } else {
                    $("#employeeSelect").html("").append(
                        "<option value='' selected>Please Select Employee</option>");
                    toastr.error("No results found", '', {
                        closeButton: true
                    });
                }
            },
            error: function(jqXHR, textStatus, err) {
                toastr.error("Error getting details. Please try again", "", {
                    closeButton: true
                });
            }
        });
    }
}

function editInfo(reqAuthId, reqPhase, empId, empName, deptId, deptName) {
    // Select the appropriate checkbox based on current value of req. phase
    $("#editMaintenAuthorityForm input[name='phase']").each(function() {
        if ($(this).attr('value') == reqPhase) {
            $(this).prop('checked', true);
            $(this).attr('checked', 'checked');
        } else {
            $(this).removeProp('checked');
            $(this).removeAttr('checked');
        }
    });

    // Set value of Requistion Authority ID which is to be updated sent to server
    $("#editMaintenAuthorityForm input[name='auth_id']").val(reqAuthId);

    let selectedEmployee = empId + '|' + empName;
    let selectedDept = deptId + '|' + deptName;

    // To set the value of department dynamically
    // Dept option value is in format deptCode|deptName to enable storing both details on server
    $("#newDepartment").html("").append('<option value="">Please select</option>');
    $.each(depts, function(i, data) {
        if (data.deptCode == deptId)
            $("#newDepartment").append('<option value="' + selectedDept + '" selected="selected">' + deptName +
                '</option>');
        else
            $("#newDepartment").append('<option value="' + data.deptCode + '|' + data.deptName + '">' + data
                .deptName + '</option>');
    });

    // $("#newDepartment").val(selectedDept).trigger('change');
    // $("#newDepartment").attr('value', selectedDept);
    $("#newDepartment").removeAttr('aria-invalid').removeClass(
    'error'); // To remove any previous validator error message
    $("#newDepartment").nextAll('div.error').remove();
    // $("#newDepartment option:selected").attr('selected', 'selected');
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
            success: function(res) {
                if (res.successCode == 1) {
                    toastr.success(res.message, '', {
                        closeButton: true
                    });
                    populateTable(maintenAuthoritiesTable);
                } else {
                    toastr.error(res.message, '', {
                        closeButton: true
                    });
                }
            }
        });
    }
}
</script>
@endsection