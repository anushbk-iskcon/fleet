@extends('layouts.main.app')

@section('title', 'Maintenance Approval Authorities')

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
<li class="breadcrumb-item active" id="moduleName">Maintenance</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">Maintenance</h1>
<small id="controllerName">Maintenance Approval Authorities List</small>
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
                <form action="{{route('maintenance-approval-authorities.add')}}" id="addMaintenAuthorityForm" class="row" method="post" accept-charset="utf-8">
                    @csrf
                    <div class="col-md-12 col-lg-12">
                        <div class="form-group row">
                            <label for="req_type" class="col-sm-3 col-form-label">Requisition Type <i class="text-danger">*</i></label>
                            <div class="col-sm-5">
                                <select class="form-control" required="" name="req_type" id="req_type" disabled>
                                    <option value="">Please Select One</option>
                                    @foreach($reqTypes as $reqType)
                                    <option value="{{$reqType['REQUISITION_TYPE_ID']}}" @if($reqType['REQUISITION_TYPE_ID']==2) selected @endif>
                                        {{$reqType['REQUISITION_TYPE_NAME']}}
                                    </option>
                                    @endforeach
                                </select>
                                {{-- For Sending Requisition Type since select field above is disabled to make it unchangeable --}}
                                <input type="hidden" name="req_type" value="2">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="req_phase" class="col-sm-3 col-form-label">Requisition Phase <i class="text-danger">*</i></label>
                            <div class="col-sm-9">
                                @foreach($phases as $phase)
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input id="radio{{$phase['PHASE_ID']}}" type="radio" class="custom-control-input" name="phase" value="{{$phase['PHASE_ID']}}">
                                    <label class="custom-control-label" for="radio{{$phase['PHASE_ID']}}">{{$phase['PHASE_NAME']}}</label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="department" class="col-sm-3 col-form-label">Department <i class="text-danger">*</i></label>
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
                            <label for="employeeSelect" class="col-sm-3 col-form-label">Employee <i class="text-danger">*</i></label>
                            <div class="col-sm-5">
                                <select name="employee" id="employeeSelect" class="form-control basic-single" required="">
                                    <option value="" selected>Please Select Employee</option>
                                    @foreach($employees['data'] as $employee)
                                    <option value="{{$employee['employeeId'] . '|'. $employee['employeeName']}}">{{$employee['employeeName'] . ' (' . $employee['department'] . ')'}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group text-right">
                            <button type="reset" id="resetAddAuthorityFormBtn" class="btn btn-primary w-md m-b-5">Reset</button>
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
                        <label for="req_phasesr" class="col-sm-5 col-form-label justify-content-start text-left">Requisition Phase</label>
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
                        <label for="status" class="col-sm-3 col-form-label justify-content-start text-left">Department</label>
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
                    <form action="{{route('maintenance-approval-authorities.update')}}" id="editMaintenAuthorityForm" class="row" method="post" accept-charset="utf-8">
                        @csrf
                        <div class="col-md-12 col-lg-12">
                            <div class="form-group row">
                                <label for="req_type" class="col-sm-3 col-form-label">Requisition Type <i class="text-danger">*</i></label>
                                <div class="col-sm-5">
                                    <select class="form-control" required="" name="req_type" id="def_req_type" disabled>
                                        <option value="">Please Select One</option>
                                        @foreach($reqTypes as $reqType)
                                        <option value="{{$reqType['REQUISITION_TYPE_ID']}}" @if($reqType['REQUISITION_TYPE_ID']==2) selected @endif>
                                            {{$reqType['REQUISITION_TYPE_NAME']}}
                                        </option>
                                        @endforeach
                                    </select>
                                    {{-- For Sending Requisition Type since select field above is disabled to make it unchangeable --}}
                                    <input type="hidden" name="req_type" value="2"> {{-- 2 for Maintenance Requisition --}}
                                    <input type="hidden" name="auth_id" value="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="new_req_phase" class="col-sm-3 col-form-label">Requisition Phase <i class="text-danger">*</i></label>
                                <div class="col-sm-9">
                                    @foreach($phases as $phase)
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input id="new_radio{{$phase['PHASE_ID']}}" type="radio" class="custom-control-input" name="phase" value="{{$phase['PHASE_ID']}}">
                                        <label class="custom-control-label" for="new_radio{{$phase['PHASE_ID']}}">{{$phase['PHASE_NAME']}}</label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="department" class="col-sm-3 col-form-label">Department <i class="text-danger">*</i></label>
                                <div class="col-sm-5">
                                    <select class="form-control basic-single" required="" name="department" id="newDepartment">
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
                                <label for="demo" class="col-sm-3 col-form-label">Employee <i class="text-danger">*</i></label>
                                <div class="col-sm-5">
                                    <select name="employee" id="newEmployeeSelect" class="form-control basic-single" required="">
                                        <option value="">Please Select Employee</option>
                                        @foreach($employees['data'] as $employee)
                                        <option value="{{$employee['employeeId'] . '|' . $employee['employeeName']}}">{{$employee['employeeName'] . ' (' . $employee['department'] . ')'}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group text-right">
                                <button type="reset" id="resetEditAuthorityFormBtn" class="btn btn-primary w-md m-b-5">Reset</button>
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
            <div class="card-body">
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
@endsection
@section('js-content')
<!-- <script src="https://vmsdemo.bdtask-demo.com/assets/dist/js/approval_authority.js"></script> -->
<script>
    // To save routes and other global variables
    let csrfToken = "{{csrf_token()}}";
    let loadEmployeesURL = "{{route('maintenance-approval-authorities.get-employees')}}";
    let authorityListURL = "{{route('maintenance-approval-authorities.list')}}";
    let changeActivationStatusURL = "{{route('maintenance-approval-authorities.change-activation')}}";
    let depts = JSON.parse(`{!! json_encode($departments['data']) !!}`);
</script>
<script src="{{asset('public/dist/js/maintenance/approval_authorities.js')}}">
</script>
@endsection