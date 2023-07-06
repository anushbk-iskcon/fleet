@extends('layouts.main.app')

@section('title', 'Pickup Drop Requisitions')

@section('breadcrumb-content')
<li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
<li class="breadcrumb-item active" id="moduleName">Vehicle Requisition</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">Vehicle Requisition</h1>
<small id="controllerName">Pickup / Drop Requisitions</small>
@endsection

@section('content')

<div id="add0" class="modal fade bd-example-modal-lg" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Add Pick and Drop Requisition</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="https://vmsdemo.bdtask-demo.com/vehiclereq/Vehicle_requisition/add_pickdropreq" id="emp_form" class="row" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                    <div class="col-md-12 col-lg-12">
                        <div class="form-group row">
                            <label for="route" class="col-sm-3 col-form-label">Route <i class="text-danger"> <i class="text-danger">*</i></i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" required="" name="route" id="route" onchange="getpoint()">
                                    <option value="" selected="selected">Please Select One</option>
                                    <option value="Airport To Motijheel" data-title="17">Airport To Motijheel</option>
                                    <option value="tguiyo" data-title="16">tguiyo</option>
                                    <option value="FGHJKL" data-title="15">FGHJKL</option>
                                    <option value="rty" data-title="14">rty</option>
                                    <option value="bururi" data-title="13">bururi</option>
                                    <option value="rgrg" data-title="12">rgrg</option>
                                    <option value="মেঘনা হতে জামগড়া,ফ্যান্টাসি " data-title="11">মেঘনা হতে জামগড়া,ফ্যান্টাসি </option>
                                    <option value="qwerty" data-title="10">qwerty</option>
                                    <option value="qwerty" data-title="9">qwerty</option>
                                    <option value="Jatra Bari" data-title="8">Jatra Bari</option>
                                    <option value="ddd" data-title="7">ddd</option>
                                    <option value="new" data-title="6">new</option>
                                    <option value="Route1" data-title="4">Route1</option>
                                    <option value="Mohammanpur to khilgao" data-title="3">Mohammanpur to khilgao</option>
                                    <option value="Jatrabari to Uttara" data-title="2">Jatrabari to Uttara</option>
                                    <option value="gabtoli to motijeel" data-title="1">gabtoli to motijeel</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="start_p" class="col-sm-3 col-form-label">Start Point <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="start_p" class="form-control" type="text" placeholder="Start Point" id="start_p" readonly="readonly">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="end_p" class="col-sm-3 col-form-label">End Point <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="end_p" class="form-control" type="text" placeholder="Start Point" id="end_p" readonly="readonly">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="requiest_by" class="col-sm-3 col-form-label">Requisition For <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" required="" name="requiest_by" id="requiest_by">
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
                            <label for="request_type" class="col-sm-3 col-form-label">Request Type <i class="text-danger">*</i></label>
                            <div class="col-sm-9">
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="regular" name="request_type" class="custom-control-input" value="Regular">
                                    <label class="custom-control-label" for="regular">Regular</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="specificday" name="request_type" class="custom-control-input" value="Specific Day">
                                    <label class="custom-control-label" for="specificday">Specific Day</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="request_type" class="col-sm-3 col-form-label">Requisition Type <i class="text-danger">*</i></label>
                            <div class="col-sm-9">
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="pickup" name="req_type" class="custom-control-input" value="Pick Up">
                                    <label class="custom-control-label" for="pickup">Pick Up</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="dropoff" name="req_type" class="custom-control-input" value="Drop Off">
                                    <label class="custom-control-label" for="dropoff">Drop Off</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="pickdropoff" name="req_type" class="custom-control-input" value="Pick Up & Drop Off">
                                    <label class="custom-control-label" for="pickdropoff">Pick Up & Drop Off</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="effective_date" class="col-sm-3 col-form-label">Effective Date </label>
                            <div class="col-sm-7">
                                <input name="effective_date" autocomplete="off" class="form-control newdatetimepicker" type="text" placeholder="Effective Date" id="effective_date">
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
                <h4 class="pl-3">Search Here <small class="float-right">
                        <button type="button" class="btn btn-primary btn-md" data-target="#add0" data-toggle="modal"><i class="ti-plus" aria-hidden="true"></i>
                            Add Pick and Drop Requisition</button>
                    </small></h4>
            </div>
            <div class="card-body">
                <form action="https://vmsdemo.bdtask-demo.com/vehiclereq/Vehicle_requisition/pickdropreq" class="form-inline row" id="validate" method="post" accept-charset="utf-8">
                    <div class="col-sm-12 col-xl-4">
                        <div class="form-group row mb-1">
                            <label for="routesr" class="col-sm-5 col-form-label justify-content-start text-left">Route </label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" name="routesr" id="routesr">
                                    <option value="" selected="selected">Please Select One</option>
                                    <option value="gabtoli to motijeel">gabtoli to motijeel </option>
                                    <option value="Jatrabari to Uttara">Jatrabari to Uttara </option>
                                    <option value="Mohammanpur to khilgao">Mohammanpur to khilgao </option>
                                    <option value="Route1">Route1 </option>
                                    <option value="new">new </option>
                                    <option value="ddd">ddd </option>
                                    <option value="Jatra Bari">Jatra Bari </option>
                                    <option value="qwerty">qwerty </option>
                                    <option value="qwerty">qwerty </option>
                                    <option value="মেঘনা হতে জামগড়া,ফ্যান্টাসি ">মেঘনা হতে জামগড়া,ফ্যান্টাসি </option>
                                    <option value="rgrg">rgrg </option>
                                    <option value="bururi">bururi </option>
                                    <option value="rty">rty </option>
                                    <option value="FGHJKL">FGHJKL </option>
                                    <option value="tguiyo">tguiyo </option>
                                    <option value="Airport To Motijheel">Airport To Motijheel </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-1">
                            <label for="req_typesr" class="col-sm-5 col-form-label justify-content-start text-left">Requisition Type </label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" name="req_typesr" id="req_typesr">
                                    <option value="" selected="selected">Please Select One</option>
                                    <option value="Pick Up & Drop Off">
                                        Pick Up & Drop Off</option>
                                    <option value="Drop Off">
                                        Drop Off</option>
                                    <option value="Pick Up">
                                        Pick Up</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xl-4">
                        <div class="form-group row mb-1">
                            <label for="requiest_bysr" class="col-sm-5 col-form-label justify-content-start text-left">Requested By <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" name="requiest_bysr" id="requiest_bysr">
                                    <option value="" selected="selected">Please Select One</option>
                                    <option value="Regular">Regular </option>
                                    <option value="Specific Day">Specific Day </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-1">
                            <label for="req_datesr" class="col-sm-5 col-form-label justify-content-start text-left">Requisition Date <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="req_datesr" autocomplete="off" class="form-control newdatetimepicker w-100" type="text" placeholder="Requisition Date" id="req_datesr">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xl-4">
                        <div class="form-group row mb-1">
                            <label for="statussr" class="col-sm-5 col-form-label justify-content-start text-left">Status </label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" name="statussr" id="statussr">
                                    <option value="" selected="selected">Please Select One</option>
                                    <option value="pending">Pending</option>
                                    <option value="release">Release</option>
                                </select>
                            </div>

                        </div>


                    </div>
                    <div class="col-sm-12">
                        <div class="form-group row  mb-1">
                            <label for="joining_d_to" class="col-sm-5 col-form-label">&nbsp;</label>
                            <div class="col-sm-7 text-right">
                                <button type="button" class="btn btn-success" id="pichdropreq" id="btn-filter">Search</button>&nbsp;
                                <button type="button" class="btn btn-inverse" id="btn-reset">Reset</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="edit" class="modal fade bd-example-modal-lg" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <strong>Update Pick & Drop off</strong>
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
                <h4 class="pl-3">Pick & Drop Requisition</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="vreqpickdrop" class="table display table-bordered table-striped table-hover ">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Route</th>
                                <th>Requisition Date</th>
                                <th>Requisition Type</th>
                                <th>Requested By </th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr role="row" class="odd">
                                <td class="sorting_1">1</td>
                                <td>Route1</td>
                                <td>2019-08-29</td>
                                <td>Pick Up &amp; Drop Off</td>
                                <td>Regular</td>
                                <td>Pending</td>
                                <td><input name="url" type="hidden" id="url_3" value="https://vmsdemo.bdtask-demo.com/vehiclereq/Vehicle_requisition/updatepickdropreqfrm"><a onclick="editinfo(3)" style="cursor:pointer;color:#fff;" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/vehiclereq/Vehicle_requisition/delete_pickdropreq/3" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                    <div class="text-right" style="display:inline-block;">
                                        <div class="actions" style="display:inline-block;">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus2(0,'tbl_pickdrop_requisition',3,'pickdropreqid')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus2(1,'tbl_pickdrop_requisition',3,'pickdropreqid')" class="dropdown-item">Release</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1">2</td>
                                <td>new</td>
                                <td>2019-09-07</td>
                                <td>Drop Off</td>
                                <td>Regular</td>
                                <td>Release</td>
                                <td><input name="url" type="hidden" id="url_4" value="https://vmsdemo.bdtask-demo.com/vehiclereq/Vehicle_requisition/updatepickdropreqfrm"><a onclick="editinfo(4)" style="cursor:pointer;color:#fff;" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/vehiclereq/Vehicle_requisition/delete_pickdropreq/4" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                    <div class="text-right" style="display:inline-block;">
                                        <div class="actions" style="display:inline-block;">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus2(0,'tbl_pickdrop_requisition',4,'pickdropreqid')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus2(1,'tbl_pickdrop_requisition',4,'pickdropreqid')" class="dropdown-item">Release</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="sorting_1">3</td>
                                <td>gabtoli to motijeel</td>
                                <td>2019-11-17</td>
                                <td>Pick Up &amp; Drop Off</td>
                                <td>Regular</td>
                                <td>Release</td>
                                <td><input name="url" type="hidden" id="url_5" value="https://vmsdemo.bdtask-demo.com/vehiclereq/Vehicle_requisition/updatepickdropreqfrm"><a onclick="editinfo(5)" style="cursor:pointer;color:#fff;" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/vehiclereq/Vehicle_requisition/delete_pickdropreq/5" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                    <div class="text-right" style="display:inline-block;">
                                        <div class="actions" style="display:inline-block;">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus2(0,'tbl_pickdrop_requisition',5,'pickdropreqid')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus2(1,'tbl_pickdrop_requisition',5,'pickdropreqid')" class="dropdown-item">Release</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1">4</td>
                                <td>Route1</td>
                                <td>2021-02-12</td>
                                <td>Pick Up</td>
                                <td>Specific Day</td>
                                <td>Release</td>
                                <td><input name="url" type="hidden" id="url_6" value="https://vmsdemo.bdtask-demo.com/vehiclereq/Vehicle_requisition/updatepickdropreqfrm"><a onclick="editinfo(6)" style="cursor:pointer;color:#fff;" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/vehiclereq/Vehicle_requisition/delete_pickdropreq/6" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                    <div class="text-right" style="display:inline-block;">
                                        <div class="actions" style="display:inline-block;">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus2(0,'tbl_pickdrop_requisition',6,'pickdropreqid')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus2(1,'tbl_pickdrop_requisition',6,'pickdropreqid')" class="dropdown-item">Release</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="sorting_1">5</td>
                                <td>dhaka to chottogram</td>
                                <td>2021-02-23</td>
                                <td>Drop Off</td>
                                <td>Specific Day</td>
                                <td>Release</td>
                                <td><input name="url" type="hidden" id="url_7" value="https://vmsdemo.bdtask-demo.com/vehiclereq/Vehicle_requisition/updatepickdropreqfrm"><a onclick="editinfo(7)" style="cursor:pointer;color:#fff;" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/vehiclereq/Vehicle_requisition/delete_pickdropreq/7" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                    <div class="text-right" style="display:inline-block;">
                                        <div class="actions" style="display:inline-block;">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus2(0,'tbl_pickdrop_requisition',7,'pickdropreqid')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus2(1,'tbl_pickdrop_requisition',7,'pickdropreqid')" class="dropdown-item">Release</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1">6</td>
                                <td>Route1</td>
                                <td>2021-02-23</td>
                                <td>Pick Up &amp; Drop Off</td>
                                <td>Regular</td>
                                <td>Release</td>
                                <td><input name="url" type="hidden" id="url_8" value="https://vmsdemo.bdtask-demo.com/vehiclereq/Vehicle_requisition/updatepickdropreqfrm"><a onclick="editinfo(8)" style="cursor:pointer;color:#fff;" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/vehiclereq/Vehicle_requisition/delete_pickdropreq/8" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                    <div class="text-right" style="display:inline-block;">
                                        <div class="actions" style="display:inline-block;">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus2(0,'tbl_pickdrop_requisition',8,'pickdropreqid')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus2(1,'tbl_pickdrop_requisition',8,'pickdropreqid')" class="dropdown-item">Release</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="sorting_1">7</td>
                                <td>ddd</td>
                                <td>2023-01-25</td>
                                <td>Pick Up</td>
                                <td>Regular</td>
                                <td>Pending</td>
                                <td><input name="url" type="hidden" id="url_9" value="https://vmsdemo.bdtask-demo.com/vehiclereq/Vehicle_requisition/updatepickdropreqfrm"><a onclick="editinfo(9)" style="cursor:pointer;color:#fff;" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/vehiclereq/Vehicle_requisition/delete_pickdropreq/9" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                    <div class="text-right" style="display:inline-block;">
                                        <div class="actions" style="display:inline-block;">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus2(0,'tbl_pickdrop_requisition',9,'pickdropreqid')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus2(1,'tbl_pickdrop_requisition',9,'pickdropreqid')" class="dropdown-item">Release</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1">8</td>
                                <td>Jatra Bari</td>
                                <td>2023-02-02</td>
                                <td>Pick Up &amp; Drop Off</td>
                                <td>Specific Day</td>
                                <td>Pending</td>
                                <td><input name="url" type="hidden" id="url_10" value="https://vmsdemo.bdtask-demo.com/vehiclereq/Vehicle_requisition/updatepickdropreqfrm"><a onclick="editinfo(10)" style="cursor:pointer;color:#fff;" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/vehiclereq/Vehicle_requisition/delete_pickdropreq/10" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                    <div class="text-right" style="display:inline-block;">
                                        <div class="actions" style="display:inline-block;">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus2(0,'tbl_pickdrop_requisition',10,'pickdropreqid')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus2(1,'tbl_pickdrop_requisition',10,'pickdropreqid')" class="dropdown-item">Release</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="sorting_1">9</td>
                                <td>Jatra Bari</td>
                                <td>2023-02-18</td>
                                <td>Pick Up &amp; Drop Off</td>
                                <td>Specific Day</td>
                                <td>Pending</td>
                                <td><input name="url" type="hidden" id="url_12" value="https://vmsdemo.bdtask-demo.com/vehiclereq/Vehicle_requisition/updatepickdropreqfrm"><a onclick="editinfo(12)" style="cursor:pointer;color:#fff;" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/vehiclereq/Vehicle_requisition/delete_pickdropreq/12" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                    <div class="text-right" style="display:inline-block;">
                                        <div class="actions" style="display:inline-block;">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus2(0,'tbl_pickdrop_requisition',12,'pickdropreqid')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus2(1,'tbl_pickdrop_requisition',12,'pickdropreqid')" class="dropdown-item">Release</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1">10</td>
                                <td>qwerty</td>
                                <td>2023-02-18</td>
                                <td>Drop Off</td>
                                <td>Regular</td>
                                <td>Pending</td>
                                <td><input name="url" type="hidden" id="url_13" value="https://vmsdemo.bdtask-demo.com/vehiclereq/Vehicle_requisition/updatepickdropreqfrm"><a onclick="editinfo(13)" style="cursor:pointer;color:#fff;" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/vehiclereq/Vehicle_requisition/delete_pickdropreq/13" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                    <div class="text-right" style="display:inline-block;">
                                        <div class="actions" style="display:inline-block;">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus2(0,'tbl_pickdrop_requisition',13,'pickdropreqid')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus2(1,'tbl_pickdrop_requisition',13,'pickdropreqid')" class="dropdown-item">Release</a>
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
<!-- <script src="https://vmsdemo.bdtask-demo.com/assets/dist/js/vehiclereq_pickdropreq_list.js"></script> -->
<script>
    $(document).ready(function() {
        $("#vreqpickdrop").DataTable();
    });
</script>
@endsection