@extends('layouts.main.app')

@section('title', 'Vehicle Requisitions')

@section('breadcrumb-content')
<li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
<li class="breadcrumb-item active" id="moduleName">Vehicle Requisition</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">Vehicle Requisition</h1>
<small id="controllerName">Manage Vehicle Requisitions</small>
@endsection

@section('content')
<div id="add0" class="modal fade bd-example-modal-lg" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Add Requisition</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{route('add_requisition')}}" id="emp_form" class="row" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                    <div class="col-md-12 col-lg-6">
                        <div class="form-group row">
                            <label for="req_for" class="col-sm-5 col-form-label">Requisition For <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" required="" name="req_for" id="req_for">
                                    <option value="" selected="selected">Select Employee</option>
                                    <option value="18">
                                        Jasper Cameron_(Computer_EYELDZTR) </option>
                                    <option value="17">
                                        toto_(Technical_EXO9WJ1H) </option>
                                    <option value="6">
                                        Kamrul_(ACCOUNTING_ETMYQ36Y) </option>
                                    <option value="20">
                                        rohit_(Accounting_EQW70GU6) </option>
                                    <option value="15">
                                        sayed_(Human Resource_EQ4QCE9D) </option>
                                    <option value="16">
                                        أمير أبو اسنينة_(????? ?????_EPXJHTX3) </option>
                                    <option value="14">
                                        Rahim_(Technical_EODSVEIF) </option>
                                    <option value="19">
                                        Sandip Sharma_(Marketing & Sales_ELHLYIMC) </option>
                                    <option value="5">
                                        Al Amin_(Human Resource_EKDXW58G) </option>
                                    <option value="8">
                                        abc_(ACCOUNTING_EJ5MOH4S) </option>
                                    <option value="7">
                                        Test Employee_(ACCOUNTING_EDWWDMAV) </option>
                                    <option value="9">
                                        taslimul_(Human Resource_ECN3UOZ8) </option>
                                    <option value="13">
                                        demo2_(Human Resource_E62WYC4J) </option>
                                    <option value="4">
                                        Rashid_(Human Resource_E0CRB403) </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="vehicle_type" class="col-sm-5 col-form-label">Vehicle Type <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" required="" name="vehicle_type" id="vehicle_type">
                                    <option value="" selected="selected">Please Select One</option>
                                    <option value="407">
                                        407</option>
                                    <option value="honda">
                                        honda</option>
                                    <option value="no ac">
                                        no ac</option>
                                    <option value="ac">
                                        ac</option>
                                    <option value="Pick Up">
                                        Pick Up</option>
                                    <option value="Sedanse">
                                        Sedanse</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="where_fr" class="col-sm-5 col-form-label">Where From <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="where_fr" required="" class="form-control" type="text" placeholder="Where From" id="where_fr">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="where_to" required="" class="col-sm-5 col-form-label">Where To <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="where_to" required="" class="form-control" type="text" placeholder="Where To" id="where_to">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="pickup" class="col-sm-5 col-form-label">Pick Up </label>
                            <div class="col-sm-7">
                                <input name="pickup" class="form-control" type="text" placeholder="Pick Up" id="pickup">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="req_date" class="col-sm-5 col-form-label">Requisition Date </label>
                            <div class="col-sm-7">
                                <input name="req_date" class="form-control  vnewdatetimepicker" autocomplete="off" type="text" placeholder="Requisition Date" id="req_date">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="time_fr" class="col-sm-5 col-form-label">Time From </label>
                            <div class="col-sm-7">
                                <input name="time_fr" class="form-control ttimepicker" type="text" placeholder="Time From" id="time_fr">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6">
                        <div class="form-group row">
                            <label for="time_to" class="col-sm-5 col-form-label">Time To </label>
                            <div class="col-sm-7">
                                <input name="time_to" class="form-control ttimepicker" type="text" placeholder="Time To" id="time_to">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="tolerance" class="col-sm-5 col-form-label">Tolerance Duration <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="tolerance" required="" class="form-control" type="text" placeholder="Tolerance Duration" id="tolerance">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nunpassenger" class="col-sm-5 col-form-label">No of Passenger </label>
                            <div class="col-sm-7">
                                <input name="nunpassenger" class="form-control" type="number" placeholder="No of Passenger" id="nunpassenger">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="drivenby" class="col-sm-5 col-form-label">Driven By <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" required="" name="drivenby" id="drivenby">
                                    <option value="" selected="selected">Please Select One</option>
                                    <option value="12">
                                        Demo driver_(8546798512)</option>
                                    <option value="11">
                                        driver name_(01313368009)</option>
                                    <option value="9">
                                        Faris Shafi_(03012234567)</option>
                                    <option value="8">
                                        Khurram_(0301234567)</option>
                                    <option value="4">
                                        Musa Karim - Fareed Express_(03011223344)</option>
                                    <option value="3">
                                        Malik - Khyber Express_(03091234567)</option>
                                    <option value="2">
                                        aman - Shah Latif Express_(03097894562)</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="purpose" class="col-sm-5 col-form-label">Purpose <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" required="" name="purpose" id="purpose">
                                    <option value="" selected="selected">Please Select One</option>
                                    <option value="4">
                                        site seeing</option>
                                    <option value="3">
                                        official</option>
                                    <option value="2">
                                        Picnic</option>
                                    <option value="1">
                                        Travelee</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="details" class="col-sm-5 col-form-label">Details <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="details" required="" class="form-control" type="text" placeholder="Details" id="details">
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
                            Add Requisition</button>
                    </small></h4>
            </div>
            <div class="card-body row">
                <div class="col-sm-12 col-xl-4">
                    <div class="form-group row mb-1">
                        <label for="req_forsr" class="col-sm-5 col-form-label justify-content-start text-left">Requisition For </label>
                        <div class="col-sm-7">
                            <select class="form-control basic-single" name="req_forsr" id="req_forsr">
                                <option value="" selected="selected">Please Select One</option>
                                <option value="Jasper Cameron">
                                    Jasper Cameron_(Computer_EYELDZTR) </option>
                                <option value="toto">
                                    toto_(Technical_EXO9WJ1H) </option>
                                <option value="Kamrul">
                                    Kamrul_(ACCOUNTING_ETMYQ36Y) </option>
                                <option value="rohit">
                                    rohit_(Accounting_EQW70GU6) </option>
                                <option value="sayed">
                                    sayed_(Human Resource_EQ4QCE9D) </option>
                                <option value="أمير أبو اسنينة">
                                    أمير أبو اسنينة_(????? ?????_EPXJHTX3) </option>
                                <option value="Rahim">
                                    Rahim_(Technical_EODSVEIF) </option>
                                <option value="Sandip Sharma">
                                    Sandip Sharma_(Marketing & Sales_ELHLYIMC) </option>
                                <option value="Al Amin">
                                    Al Amin_(Human Resource_EKDXW58G) </option>
                                <option value="abc">
                                    abc_(ACCOUNTING_EJ5MOH4S) </option>
                                <option value="Test Employee">
                                    Test Employee_(ACCOUNTING_EDWWDMAV) </option>
                                <option value="taslimul">
                                    taslimul_(Human Resource_ECN3UOZ8) </option>
                                <option value="demo2">
                                    demo2_(Human Resource_E62WYC4J) </option>
                                <option value="Rashid">
                                    Rashid_(Human Resource_E0CRB403) </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <label for="vehicle_typesr" class="col-sm-5 col-form-label justify-content-start text-left">Vehicle Type </label>
                        <div class="col-sm-7">
                            <select class="form-control basic-single" name="vehicle_typesr" id="vehicle_typesr">
                                <option value="" selected="selected">Please Select One</option>
                                <option value="407">
                                    407</option>
                                <option value="honda">
                                    honda</option>
                                <option value="no ac">
                                    no ac</option>
                                <option value="ac">
                                    ac</option>
                                <option value="Pick Up">
                                    Pick Up</option>
                                <option value="Sedanse">
                                    Sedanse</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 col-xl-4">
                    <div class="form-group row mb-1">
                        <label for="from" class="col-sm-5 col-form-label justify-content-start text-left">From </label>
                        <div class="col-sm-7">
                            <input name="from" autocomplete="off" class="form-control vnewdatetimepicker w-100" type="text" placeholder="From" id="from">
                        </div>

                    </div>
                    <div class="form-group row mb-1">
                        <label for="to" class="col-sm-5 col-form-label justify-content-start text-left">To </label>
                        <div class="col-sm-7">
                            <input name="to" autocomplete="off" class="form-control vnewdatetimepicker w-100" type="text" placeholder="To" id="to">
                        </div>

                    </div>
                </div>
                <div class="col-sm-12 col-xl-4">
                    <div class="form-group row mb-1">
                        <label for="status" class="col-sm-5 col-form-label justify-content-start text-left">Status <i class="text-danger">*</i></label>
                        <div class="col-sm-7">
                            <select class="form-control basic-single" name="status" id="status">
                                <option value="" selected="selected">Please Select One</option>
                                <option value="pending">Pending</option>
                                <option value="released">Release </option>
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
                <h4 class="pl-3">Requisition List</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="reqlist" class="table display table-bordered table-striped table-hover ">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Requisition For</th>
                                <th>Requisition Date</th>
                                <th>Driver Name</th>
                                <th>Requested By </th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            <tr role="row" class="odd">
                                <td class="sorting_1">1</td>
                                <td>Kamrul</td>
                                <td>2023-02-15</td>
                                <td>aman - Shah Latif Express</td>
                                <td>aman - Shah Latif Express</td>
                                <td>Release</td>
                                <td><input name="url" type="hidden" id="url_8" value="https://vmsdemo.bdtask-demo.com/vehiclereq/Vehicle_requisition/updatereqfrm"><a onclick="editinfo(8)" style="cursor:pointer;color:#fff;" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/vehiclereq/Vehicle_requisition/delete_requisition/8" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                    <div class="text-right" style="display:inline-block;">
                                        <div class="actions" style="display:inline-block;">
                                            <div class="dropdown action-item" data-toggle="dropdown" aria-expanded="false">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(30px, 37px, 0px);">
                                                    <a onclick="changestatus2(0,'tbl_requisition',8,'requisitionId')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus2(1,'tbl_requisition',8,'requisitionId')" class="dropdown-item">Release</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1">2</td>
                                <td></td>
                                <td>2021-02-11</td>
                                <td>Malik - Khyber Express</td>
                                <td>Malik - Khyber Express</td>
                                <td>Release</td>
                                <td><input name="url" type="hidden" id="url_3" value="https://vmsdemo.bdtask-demo.com/vehiclereq/Vehicle_requisition/updatereqfrm"><a onclick="editinfo(3)" style="cursor:pointer;color:#fff;" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/vehiclereq/Vehicle_requisition/delete_requisition/3" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                    <div class="text-right" style="display:inline-block;">
                                        <div class="actions" style="display:inline-block;">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus2(0,'tbl_requisition',3,'requisitionId')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus2(1,'tbl_requisition',3,'requisitionId')" class="dropdown-item">Release</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="sorting_1">3</td>
                                <td>Kamrul</td>
                                <td>2021-02-25</td>
                                <td>Malik - Khyber Express</td>
                                <td>Malik - Khyber Express</td>
                                <td>Release</td>
                                <td><input name="url" type="hidden" id="url_5" value="https://vmsdemo.bdtask-demo.com/vehiclereq/Vehicle_requisition/updatereqfrm"><a onclick="editinfo(5)" style="cursor:pointer;color:#fff;" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/vehiclereq/Vehicle_requisition/delete_requisition/5" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                    <div class="text-right" style="display:inline-block;">
                                        <div class="actions" style="display:inline-block;">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus2(0,'tbl_requisition',5,'requisitionId')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus2(1,'tbl_requisition',5,'requisitionId')" class="dropdown-item">Release</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1">4</td>
                                <td>Kamrul</td>
                                <td>2021-03-02</td>
                                <td>Musa Karim - Fareed Express</td>
                                <td>Musa Karim - Fareed Express</td>
                                <td>Release</td>
                                <td><input name="url" type="hidden" id="url_6" value="https://vmsdemo.bdtask-demo.com/vehiclereq/Vehicle_requisition/updatereqfrm"><a onclick="editinfo(6)" style="cursor:pointer;color:#fff;" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/vehiclereq/Vehicle_requisition/delete_requisition/6" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                    <div class="text-right" style="display:inline-block;">
                                        <div class="actions" style="display:inline-block;">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus2(0,'tbl_requisition',6,'requisitionId')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus2(1,'tbl_requisition',6,'requisitionId')" class="dropdown-item">Release</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="sorting_1">5</td>
                                <td>Kamrul</td>
                                <td>2023-03-07</td>
                                <td>Khurram</td>
                                <td>Khurram</td>
                                <td>Release</td>
                                <td><input name="url" type="hidden" id="url_12" value="https://vmsdemo.bdtask-demo.com/vehiclereq/Vehicle_requisition/updatereqfrm"><a onclick="editinfo(12)" style="cursor:pointer;color:#fff;" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/vehiclereq/Vehicle_requisition/delete_requisition/12" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                    <div class="text-right" style="display:inline-block;">
                                        <div class="actions" style="display:inline-block;">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus2(0,'tbl_requisition',12,'requisitionId')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus2(1,'tbl_requisition',12,'requisitionId')" class="dropdown-item">Release</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1">6</td>
                                <td>Kamrul</td>
                                <td>2023-03-16</td>
                                <td>Faris Shafi</td>
                                <td>Faris Shafi</td>
                                <td>Pending</td>
                                <td><input name="url" type="hidden" id="url_15" value="https://vmsdemo.bdtask-demo.com/vehiclereq/Vehicle_requisition/updatereqfrm"><a onclick="editinfo(15)" style="cursor:pointer;color:#fff;" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/vehiclereq/Vehicle_requisition/delete_requisition/15" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                    <div class="text-right" style="display:inline-block;">
                                        <div class="actions" style="display:inline-block;">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus2(0,'tbl_requisition',15,'requisitionId')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus2(1,'tbl_requisition',15,'requisitionId')" class="dropdown-item">Release</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="sorting_1">7</td>
                                <td>Kamrul</td>
                                <td>2023-03-17</td>
                                <td>Faris Shafi</td>
                                <td>Faris Shafi</td>
                                <td>Pending</td>
                                <td><input name="url" type="hidden" id="url_16" value="https://vmsdemo.bdtask-demo.com/vehiclereq/Vehicle_requisition/updatereqfrm"><a onclick="editinfo(16)" style="cursor:pointer;color:#fff;" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/vehiclereq/Vehicle_requisition/delete_requisition/16" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                    <div class="text-right" style="display:inline-block;">
                                        <div class="actions" style="display:inline-block;">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus2(0,'tbl_requisition',16,'requisitionId')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus2(1,'tbl_requisition',16,'requisitionId')" class="dropdown-item">Release</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1">8</td>
                                <td>Kamrul</td>
                                <td>2023-03-24</td>
                                <td>Faris Shafi</td>
                                <td>Faris Shafi</td>
                                <td>Release</td>
                                <td><input name="url" type="hidden" id="url_18" value="https://vmsdemo.bdtask-demo.com/vehiclereq/Vehicle_requisition/updatereqfrm"><a onclick="editinfo(18)" style="cursor:pointer;color:#fff;" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/vehiclereq/Vehicle_requisition/delete_requisition/18" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                    <div class="text-right" style="display:inline-block;">
                                        <div class="actions" style="display:inline-block;">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus2(0,'tbl_requisition',18,'requisitionId')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus2(1,'tbl_requisition',18,'requisitionId')" class="dropdown-item">Release</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="sorting_1">9</td>
                                <td>Jasper Cameron</td>
                                <td>2023-04-07</td>
                                <td>Faris Shafi</td>
                                <td>Faris Shafi</td>
                                <td>Pending</td>
                                <td><input name="url" type="hidden" id="url_20" value="https://vmsdemo.bdtask-demo.com/vehiclereq/Vehicle_requisition/updatereqfrm"><a onclick="editinfo(20)" style="cursor:pointer;color:#fff;" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/vehiclereq/Vehicle_requisition/delete_requisition/20" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                    <div class="text-right" style="display:inline-block;">
                                        <div class="actions" style="display:inline-block;">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus2(0,'tbl_requisition',20,'requisitionId')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus2(1,'tbl_requisition',20,'requisitionId')" class="dropdown-item">Release</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1">10</td>
                                <td>Jasper Cameron</td>
                                <td>0000-00-00</td>
                                <td>driver name</td>
                                <td>driver name</td>
                                <td>Pending</td>
                                <td><input name="url" type="hidden" id="url_22" value="https://vmsdemo.bdtask-demo.com/vehiclereq/Vehicle_requisition/updatereqfrm"><a onclick="editinfo(22)" style="cursor:pointer;color:#fff;" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/vehiclereq/Vehicle_requisition/delete_requisition/22" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                    <div class="text-right" style="display:inline-block;">
                                        <div class="actions" style="display:inline-block;">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus2(0,'tbl_requisition',22,'requisitionId')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus2(1,'tbl_requisition',22,'requisitionId')" class="dropdown-item">Release</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>

                    </table> <!-- /.table-responsive -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <script src="https://vmsdemo.bdtask-demo.com/assets/dist/js/vehiclereq_requisition_list.js"></script> -->
<script>
    $(document).ready(function() {
        $("#reqlist").DataTable();
    });
</script>
@endsection