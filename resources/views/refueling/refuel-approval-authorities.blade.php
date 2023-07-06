@extends('layouts.main.app')

@section('title', 'Refuel Approval Authorities')

@section('breadcrumb-content')
<li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
<li class="breadcrumb-item active" id="moduleName">Refueling</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">Refueling</h1>
<small id="controllerName">Refuel Approval Authorities</small>
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
                <form action="https://vmsdemo.bdtask-demo.com/refueling/refueling/add_approval" id="emp_form" class="row" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                    <div class="col-md-12 col-lg-12">
                        <div class="form-group row">
                            <label for="req_type" class="col-sm-3 col-form-label">Requisition Type <i class="text-danger">*</i></label>
                            <div class="col-sm-5">
                                <select class="form-control basic-single" required name="req_type" id="req_type">
                                    <option value="" selected="selected">Please Select One</option>
                                    <option value="Re-Fueling Requisition ">Re-Fueling Requisition </option>
                                    <option value="Maintenance Requisition">Maintenance Requisition </option>
                                    <option value="Vehicle Requisition">Vehicle Requisition </option>
                                </select>
                            </div>

                        </div>
                        <div class="form-group row">
                            <label for="req_phase" class="col-sm-3 col-form-label">Requisition Phase <i class="text-danger">*</i></label>
                            <div class="col-sm-2 checkbox checkbox-primary">
                                <input id="checkbox1" type="checkbox" name="phase[]" value="Pending">
                                <label for="checkbox1">Pending</label>
                            </div>
                            <div class="col-sm-2 checkbox checkbox-primary">
                                <input id="checkbox2" type="checkbox" name="phase[]" value="Reject">
                                <label for="checkbox2">Reject</label>
                            </div>
                            <div class="col-sm-2 checkbox checkbox-primary">
                                <input id="checkbox3" type="checkbox" name="phase[]" value="Approved">
                                <label for="checkbox3">Approved</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="department" class="col-sm-3 col-form-label">Department <i class="text-danger">*</i></label>
                            <div class="col-sm-5">
                                <select class="form-control basic-single" required name="department" id="department" onchange="getemployee()">
                                    <option value="" selected="selected">Please Select One</option>
                                    <option value="Administration">
                                        Administration</option>
                                    <option value="yhyh">
                                        yhyh</option>
                                    <option value="Rose Water">
                                        Rose Water</option>
                                    <option value="Computer">
                                        Computer</option>
                                    <option value="Testing">
                                        Testing</option>
                                    <option value="Planning department">
                                        Planning department</option>
                                    <option value="mmkmk">
                                        mmkmk</option>
                                    <option value="Technical">
                                        Technical</option>
                                    <option value="Marketing & Sales">
                                        Marketing & Sales</option>
                                    <option value="Human Resource">
                                        Human Resource</option>
                                    <option value="Accounting">
                                        Accounting</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="demo" class="col-sm-3 col-form-label">&nbsp;</label>
                            <div class="col-sm-9" id="mtable">



                            </div>
                        </div>
                        <div class="form-group text-right">
                            <button type="reset" class="btn btn-primary w-md m-b-5">Reset</button>
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
                <h4 class="pl-3">Search Here<small class="float-right">
                        <button type="button" class="btn btn-primary btn-md" data-target="#add0" data-toggle="modal"><i class="ti-plus" aria-hidden="true"></i>
                            Add Approval Authority </button>
                    </small></h4>
            </div>
            <div class="card-body row">
                <div class="col-sm-12 col-xl-4">
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
                </div>
                <div class="col-sm-12 col-xl-4">
                    <div class="form-group row mb-1">
                        <label for="req_phasesr" class="col-sm-5 col-form-label justify-content-start text-left">Requisition Phase</label>
                        <div class="col-sm-7">
                            <select class="form-control basic-single" name="req_phasesr" id="req_phasesr">
                                <option value="" selected="selected">Please Select One</option>
                                <option value="Pending">Pending </option>
                                <option value="Reject">Reject </option>
                                <option value="Approved">Approved </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-xl-4">
                    <div class="form-group row mb-1">
                        <label for="status" class="col-sm-5 col-form-label justify-content-start text-left">Status</label>
                        <div class="col-sm-7">
                            <select class="form-control basic-single" name="status" id="status">
                                <option value="" selected="selected">Please Select One</option>
                                <option value="Approved">Approved</option>
                                <option value="Pending">Pending</option>
                                <option value="Rejected">Reject</option>
                            </select>
                        </div>

                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group row  mb-1">
                        <label for="joining_d_to" class="col-sm-5 col-form-label">&nbsp;</label>
                        <div class="col-sm-7 text-right">
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

                </div>

            </div>
            <div class="modal-footer">

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
                    <table id="rauthinfo" class="table display table-bordered table-striped table-hover ">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Requisition Type</th>
                                <th>Requisition Phase</th>
                                <th>Department</th>
                                <th>Employee</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr role="row" class="odd">
                                <td class="sorting_1">1</td>
                                <td>Re-Fueling Requisition </td>
                                <td>Approved</td>
                                <td>Human Resource</td>
                                <td>Rashid,Al Amin,taslimul,demo2,sayed</td>
                                <td><input name="url" type="hidden" id="url_3" value="https://vmsdemo.bdtask-demo.com/refueling/refueling/updateapprovalfrm"><a onclick="editinfo(3)" style="cursor:pointer;color:#fff;" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/refueling/refueling/delete_approval/3" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a></td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1">2</td>
                                <td>Re-Fueling Requisition </td>
                                <td>Approved</td>
                                <td>Human Resource</td>
                                <td>Al Amin,dsfdf</td>
                                <td><input name="url" type="hidden" id="url_4" value="https://vmsdemo.bdtask-demo.com/refueling/refueling/updateapprovalfrm"><a onclick="editinfo(4)" style="cursor:pointer;color:#fff;" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/refueling/refueling/delete_approval/4" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a></td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="sorting_1">3</td>
                                <td>Re-Fueling Requisition </td>
                                <td>Reject,Approved</td>
                                <td>ACCOUNTING</td>
                                <td>Nazmul Hassan</td>
                                <td><input name="url" type="hidden" id="url_6" value="https://vmsdemo.bdtask-demo.com/refueling/refueling/updateapprovalfrm"><a onclick="editinfo(6)" style="cursor:pointer;color:#fff;" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/refueling/refueling/delete_approval/6" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a></td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1">4</td>
                                <td>Re-Fueling Requisition </td>
                                <td>Approved</td>
                                <td>Computer</td>
                                <td>Jasper Cameron</td>
                                <td><input name="url" type="hidden" id="url_9" value="https://vmsdemo.bdtask-demo.com/refueling/refueling/updateapprovalfrm"><a onclick="editinfo(9)" style="cursor:pointer;color:#fff;" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/refueling/refueling/delete_approval/9" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a></td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="sorting_1">5</td>
                                <td>Re-Fueling Requisition </td>
                                <td>Reject</td>
                                <td>Marketing &amp; Sales</td>
                                <td></td>
                                <td><input name="url" type="hidden" id="url_11" value="https://vmsdemo.bdtask-demo.com/refueling/refueling/updateapprovalfrm"><a onclick="editinfo(11)" style="cursor:pointer;color:#fff;" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/refueling/refueling/delete_approval/11" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a></td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1">6</td>
                                <td>Re-Fueling Requisition </td>
                                <td>Pending,Reject,Approved</td>
                                <td>Marketing &amp; Sales</td>
                                <td></td>
                                <td><input name="url" type="hidden" id="url_19" value="https://vmsdemo.bdtask-demo.com/refueling/refueling/updateapprovalfrm"><a onclick="editinfo(19)" style="cursor:pointer;color:#fff;" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/refueling/refueling/delete_approval/19" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a></td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="sorting_1">7</td>
                                <td>Re-Fueling Requisition </td>
                                <td>Pending,Reject</td>
                                <td>Human Resource</td>
                                <td></td>
                                <td><input name="url" type="hidden" id="url_21" value="https://vmsdemo.bdtask-demo.com/refueling/refueling/updateapprovalfrm"><a onclick="editinfo(21)" style="cursor:pointer;color:#fff;" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/refueling/refueling/delete_approval/21" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a></td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1">8</td>
                                <td>Re-Fueling Requisition </td>
                                <td>Reject</td>
                                <td>Human Resource</td>
                                <td>dsfdf</td>
                                <td><input name="url" type="hidden" id="url_28" value="https://vmsdemo.bdtask-demo.com/refueling/refueling/updateapprovalfrm"><a onclick="editinfo(28)" style="cursor:pointer;color:#fff;" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/refueling/refueling/delete_approval/28" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a></td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="sorting_1">9</td>
                                <td>Re-Fueling Requisition </td>
                                <td>Pending</td>
                                <td>Planning department</td>
                                <td></td>
                                <td><input name="url" type="hidden" id="url_30" value="https://vmsdemo.bdtask-demo.com/refueling/refueling/updateapprovalfrm"><a onclick="editinfo(30)" style="cursor:pointer;color:#fff;" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/refueling/refueling/delete_approval/30" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a></td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1">10</td>
                                <td>Re-Fueling Requisition </td>
                                <td>Pending</td>
                                <td>Marketing &amp; Sales</td>
                                <td></td>
                                <td><input name="url" type="hidden" id="url_32" value="https://vmsdemo.bdtask-demo.com/refueling/refueling/updateapprovalfrm"><a onclick="editinfo(32)" style="cursor:pointer;color:#fff;" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/refueling/refueling/delete_approval/32" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a></td>
                            </tr>
                        </tbody>
                    </table> <!-- /.table-responsive -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <script src="{{asset('dist/js/refueling_approval_authority.js')}}"></script> -->
<script>
    $(document).ready(function() {
        $("#rauthinfo").DataTable();
    });
</script>

@endsection