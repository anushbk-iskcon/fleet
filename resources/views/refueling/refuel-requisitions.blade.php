@extends('layouts.main.app')

@section('title', 'Refueling Requisitions')

@section('breadcrumb-content')
<li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
<li class="breadcrumb-item active" id="moduleName">Refueling</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">Refueling</h1>
<small id="controllerName">Refueling Requisitions</small>
@endsection

@section('content')

<div id="add0" class="modal fade bd-example-modal-lg" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Add Refueling Requisition </strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="" id="emp_form" class="row" method="post" accept-charset="utf-8">
                    <div class="col-md-12 col-lg-6">
                        <div class="form-group row">
                            <label for="vehicle_name" class="col-sm-5 col-form-label">Vehicle Name <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" required name="vehicle_name" id="vehicle_name">
                                    <option value="" selected="selected">Please Select One</option>
                                    <option value="Shah Latif Express UP">Shah Latif Express UP </option>
                                    <option value="Sukkur Express UP">Sukkur Express UP </option>
                                    <option value="Khyber Express">Khyber Express </option>
                                    <option value="Fareed Express">Fareed Express </option>
                                    <option value="d">d </option>
                                    <option value="AS">AS </option>
                                    <option value="quad r647">quad r647 </option>
                                    <option value="Kia Soul">Kia Soul </option>
                                    <option value="red">red </option>
                                    <option value="Kia">Kia </option>
                                    <option value="داف">داف </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="qty" class="col-sm-5 col-form-label">Quantity <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="qty" required class="form-control" type="number" placeholder="Quantity" id="qty">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="fuel_station" class="col-sm-5 col-form-label">Fuel Station <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" required name="fuel_station" id="fuel_station">
                                    <option value="" selected="selected">Please Select One</option>
                                    <option value="GM Filling Station">GM Filling Station </option>
                                    <option value="Khalek filling Station">Khalek filling Station </option>
                                    <option value=" cvbc"> cvbc </option>
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-12 col-lg-6">
                        <div class="form-group row">
                            <label for="fuel_type" class="col-sm-5 col-form-label">Fuel Type <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" required name="fuel_type" id="fuel_type">
                                    <option value="" selected="selected">Please Select One</option>
                                    <option value="Diesel">
                                        Diesel</option>
                                    <option value="SP95">
                                        SP95</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="current_odometer" class="col-sm-5 col-form-label">Current Odometer <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="current_odometer" required class="form-control" type="number" placeholder="Current Odometer" id="current_odometer">
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
<div id="edit" class="modal fade bd-example-modal-lg" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Update Refuel Requisition</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body editinfo">

            </div>

        </div>
        <div class="modal-footer">

        </div>

    </div>

</div>
<div class="row">
    <div class="col-sm-12">
        <div class="card mb-3">
            <div class="card-header p-2">
                <h4 class="pl-3">Refuel Requisition List<small class="float-right">
                        <button type="button" class="btn btn-primary btn-md" data-target="#add0" data-toggle="modal"><i class="ti-plus" aria-hidden="true"></i>
                            Add Refueling Requisition </button>
                    </small></h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="refuel_requests" class="table table-striped table-bordered dt-responsive nowrap">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Vehicle Name</th>
                                <th>Fuel Type</th>
                                <th>Odomiter</th>
                                <th>Quantity</th>
                                <th>Fuel Station</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Shah Latif Express UP</td>
                                <td>Diesel</td>
                                <td>2400</td>
                                <td>100</td>
                                <td>Khalek filling Station</td>
                                <td>Release</td>
                                <td>
                                    <input name="url" type="hidden" id="url_1" value="https://vmsdemo.bdtask-demo.com/refueling/refueling/updaterefuelreqfrm" />
                                    <a onclick="editinfo(1)" class="btn btn-xs btn-success btn-sm mr-1 text-white" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                    <a href="https://vmsdemo.bdtask-demo.com/refueling/refueling/delete_refuelreq/1" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                    <div class="text-right" style="display:inline-block;">
                                        <div class="actions" style="display:inline-block;">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus2(0,'tbl_refuel_requisition',1,'refuelreq_id')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus2(1,'tbl_refuel_requisition',1,'refuelreq_id')" class="dropdown-item">Release</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Nissan</td>
                                <td>Diesel</td>
                                <td>2000</td>
                                <td>5</td>
                                <td>Khalek filling Station</td>
                                <td>Release</td>
                                <td>
                                    <input name="url" type="hidden" id="url_2" value="https://vmsdemo.bdtask-demo.com/refueling/refueling/updaterefuelreqfrm" />
                                    <a onclick="editinfo(2)" class="btn btn-xs btn-success btn-sm mr-1 text-white" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                    <a href="https://vmsdemo.bdtask-demo.com/refueling/refueling/delete_refuelreq/2" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                    <div class="text-right" style="display:inline-block;">
                                        <div class="actions" style="display:inline-block;">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus2(0,'tbl_refuel_requisition',2,'refuelreq_id')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus2(1,'tbl_refuel_requisition',2,'refuelreq_id')" class="dropdown-item">Release</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Toyata</td>
                                <td>Octen</td>
                                <td>234</td>
                                <td>10</td>
                                <td>Khalek filling Station</td>
                                <td>Release</td>
                                <td>
                                    <input name="url" type="hidden" id="url_5" value="https://vmsdemo.bdtask-demo.com/refueling/refueling/updaterefuelreqfrm" />
                                    <a onclick="editinfo(5)" class="btn btn-xs btn-success btn-sm mr-1 text-white" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                    <a href="https://vmsdemo.bdtask-demo.com/refueling/refueling/delete_refuelreq/5" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                    <div class="text-right" style="display:inline-block;">
                                        <div class="actions" style="display:inline-block;">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus2(0,'tbl_refuel_requisition',5,'refuelreq_id')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus2(1,'tbl_refuel_requisition',5,'refuelreq_id')" class="dropdown-item">Release</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>MT</td>
                                <td>Petrol</td>
                                <td>500</td>
                                <td>2</td>
                                <td>Khalek filling Station</td>
                                <td>Release</td>
                                <td>
                                    <input name="url" type="hidden" id="url_6" value="https://vmsdemo.bdtask-demo.com/refueling/refueling/updaterefuelreqfrm" />
                                    <a onclick="editinfo(6)" class="btn btn-xs btn-success btn-sm mr-1 text-white" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                    <a href="https://vmsdemo.bdtask-demo.com/refueling/refueling/delete_refuelreq/6" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                    <div class="text-right" style="display:inline-block;">
                                        <div class="actions" style="display:inline-block;">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus2(0,'tbl_refuel_requisition',6,'refuelreq_id')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus2(1,'tbl_refuel_requisition',6,'refuelreq_id')" class="dropdown-item">Release</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>Toyata</td>
                                <td>Octen</td>
                                <td>500</td>
                                <td>2</td>
                                <td>Khalek filling Station</td>
                                <td>Release</td>
                                <td>
                                    <input name="url" type="hidden" id="url_7" value="https://vmsdemo.bdtask-demo.com/refueling/refueling/updaterefuelreqfrm" />
                                    <a onclick="editinfo(7)" class="btn btn-xs btn-success btn-sm mr-1 text-white" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                    <a href="https://vmsdemo.bdtask-demo.com/refueling/refueling/delete_refuelreq/7" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                    <div class="text-right" style="display:inline-block;">
                                        <div class="actions" style="display:inline-block;">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus2(0,'tbl_refuel_requisition',7,'refuelreq_id')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus2(1,'tbl_refuel_requisition',7,'refuelreq_id')" class="dropdown-item">Release</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td>Navana</td>
                                <td>Diesel</td>
                                <td>50000</td>
                                <td>3</td>
                                <td>GM Filling Station</td>
                                <td>Pending</td>
                                <td>
                                    <input name="url" type="hidden" id="url_8" value="https://vmsdemo.bdtask-demo.com/refueling/refueling/updaterefuelreqfrm" />
                                    <a onclick="editinfo(8)" class="btn btn-xs btn-success btn-sm mr-1 text-white" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                    <a href="https://vmsdemo.bdtask-demo.com/refueling/refueling/delete_refuelreq/8" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                    <div class="text-right" style="display:inline-block;">
                                        <div class="actions" style="display:inline-block;">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus2(0,'tbl_refuel_requisition',8,'refuelreq_id')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus2(1,'tbl_refuel_requisition',8,'refuelreq_id')" class="dropdown-item">Release</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>7</td>
                                <td>16 AJR 367</td>
                                <td>Diesel</td>
                                <td>12</td>
                                <td>3</td>
                                <td>GM Filling Station</td>
                                <td>Pending</td>
                                <td>
                                    <input name="url" type="hidden" id="url_9" value="https://vmsdemo.bdtask-demo.com/refueling/refueling/updaterefuelreqfrm" />
                                    <a onclick="editinfo(9)" class="btn btn-xs btn-success btn-sm mr-1 text-white" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                    <a href="https://vmsdemo.bdtask-demo.com/refueling/refueling/delete_refuelreq/9" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                    <div class="text-right" style="display:inline-block;">
                                        <div class="actions" style="display:inline-block;">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus2(0,'tbl_refuel_requisition',9,'refuelreq_id')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus2(1,'tbl_refuel_requisition',9,'refuelreq_id')" class="dropdown-item">Release</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>8</td>
                                <td>Sukkur Express UP</td>
                                <td>Diesel</td>
                                <td>111</td>
                                <td>111</td>
                                <td>Khalek filling Station</td>
                                <td>Pending</td>
                                <td>
                                    <input name="url" type="hidden" id="url_10" value="https://vmsdemo.bdtask-demo.com/refueling/refueling/updaterefuelreqfrm" />
                                    <a onclick="editinfo(10)" class="btn btn-xs btn-success btn-sm mr-1 text-white" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                    <a href="https://vmsdemo.bdtask-demo.com/refueling/refueling/delete_refuelreq/10" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                    <div class="text-right" style="display:inline-block;">
                                        <div class="actions" style="display:inline-block;">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus2(0,'tbl_refuel_requisition',10,'refuelreq_id')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus2(1,'tbl_refuel_requisition',10,'refuelreq_id')" class="dropdown-item">Release</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>9</td>
                                <td>16 AJR 367</td>
                                <td>Diesel</td>
                                <td>12e123</td>
                                <td>100</td>
                                <td>Khalek filling Station</td>
                                <td>Pending</td>
                                <td>
                                    <input name="url" type="hidden" id="url_11" value="https://vmsdemo.bdtask-demo.com/refueling/refueling/updaterefuelreqfrm" />
                                    <a onclick="editinfo(11)" class="btn btn-xs btn-success btn-sm mr-1 text-white" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                    <a href="https://vmsdemo.bdtask-demo.com/refueling/refueling/delete_refuelreq/11" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                    <div class="text-right" style="display:inline-block;">
                                        <div class="actions" style="display:inline-block;">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus2(0,'tbl_refuel_requisition',11,'refuelreq_id')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus2(1,'tbl_refuel_requisition',11,'refuelreq_id')" class="dropdown-item">Release</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>10</td>
                                <td>648</td>
                                <td>Diesel</td>
                                <td>767676</td>
                                <td>400</td>
                                <td>GM Filling Station</td>
                                <td>Release</td>
                                <td>
                                    <input name="url" type="hidden" id="url_12" value="https://vmsdemo.bdtask-demo.com/refueling/refueling/updaterefuelreqfrm" />
                                    <a onclick="editinfo(12)" class="btn btn-xs btn-success btn-sm mr-1 text-white" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                    <a href="https://vmsdemo.bdtask-demo.com/refueling/refueling/delete_refuelreq/12" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                    <div class="text-right" style="display:inline-block;">
                                        <div class="actions" style="display:inline-block;">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus2(0,'tbl_refuel_requisition',12,'refuelreq_id')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus2(1,'tbl_refuel_requisition',12,'refuelreq_id')" class="dropdown-item">Release</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>11</td>
                                <td>16 AJR 367</td>
                                <td>Diesel</td>
                                <td>20003</td>
                                <td>100</td>
                                <td>GM Filling Station</td>
                                <td>Release</td>
                                <td>
                                    <input name="url" type="hidden" id="url_13" value="https://vmsdemo.bdtask-demo.com/refueling/refueling/updaterefuelreqfrm" />
                                    <a onclick="editinfo(13)" class="btn btn-xs btn-success btn-sm mr-1 text-white" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                    <a href="https://vmsdemo.bdtask-demo.com/refueling/refueling/delete_refuelreq/13" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                    <div class="text-right" style="display:inline-block;">
                                        <div class="actions" style="display:inline-block;">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus2(0,'tbl_refuel_requisition',13,'refuelreq_id')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus2(1,'tbl_refuel_requisition',13,'refuelreq_id')" class="dropdown-item">Release</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>12</td>
                                <td>16 AJR 367</td>
                                <td>Diesel</td>
                                <td>200000</td>
                                <td>100</td>
                                <td>GM Filling Station</td>
                                <td>Release</td>
                                <td>
                                    <input name="url" type="hidden" id="url_14" value="https://vmsdemo.bdtask-demo.com/refueling/refueling/updaterefuelreqfrm" />
                                    <a onclick="editinfo(14)" class="btn btn-xs btn-success btn-sm mr-1 text-white" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                    <a href="https://vmsdemo.bdtask-demo.com/refueling/refueling/delete_refuelreq/14" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                    <div class="text-right" style="display:inline-block;">
                                        <div class="actions" style="display:inline-block;">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus2(0,'tbl_refuel_requisition',14,'refuelreq_id')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus2(1,'tbl_refuel_requisition',14,'refuelreq_id')" class="dropdown-item">Release</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>13</td>
                                <td>10 AJR 367</td>
                                <td>SP95</td>
                                <td>253</td>
                                <td>100</td>
                                <td>GM Filling Station</td>
                                <td>Pending</td>
                                <td>
                                    <input name="url" type="hidden" id="url_15" value="https://vmsdemo.bdtask-demo.com/refueling/refueling/updaterefuelreqfrm" />
                                    <a onclick="editinfo(15)" class="btn btn-xs btn-success btn-sm mr-1 text-white" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                    <a href="https://vmsdemo.bdtask-demo.com/refueling/refueling/delete_refuelreq/15" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                    <div class="text-right" style="display:inline-block;">
                                        <div class="actions" style="display:inline-block;">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus2(0,'tbl_refuel_requisition',15,'refuelreq_id')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus2(1,'tbl_refuel_requisition',15,'refuelreq_id')" class="dropdown-item">Release</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>14</td>
                                <td>Fareed Express</td>
                                <td>Diesel</td>
                                <td>90000</td>
                                <td>90</td>
                                <td>GM Filling Station</td>
                                <td>Pending</td>
                                <td>
                                    <input name="url" type="hidden" id="url_16" value="https://vmsdemo.bdtask-demo.com/refueling/refueling/updaterefuelreqfrm" />
                                    <a onclick="editinfo(16)" class="btn btn-xs btn-success btn-sm mr-1 text-white" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                    <a href="https://vmsdemo.bdtask-demo.com/refueling/refueling/delete_refuelreq/16" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                    <div class="text-right" style="display:inline-block;">
                                        <div class="actions" style="display:inline-block;">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus2(0,'tbl_refuel_requisition',16,'refuelreq_id')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus2(1,'tbl_refuel_requisition',16,'refuelreq_id')" class="dropdown-item">Release</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>15</td>
                                <td>10 AJR 367</td>
                                <td>Diesel</td>
                                <td>18</td>
                                <td>3</td>
                                <td>GM Filling Station</td>
                                <td>Pending</td>
                                <td>
                                    <input name="url" type="hidden" id="url_17" value="https://vmsdemo.bdtask-demo.com/refueling/refueling/updaterefuelreqfrm" />
                                    <a onclick="editinfo(17)" class="btn btn-xs btn-success btn-sm mr-1 text-white" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                    <a href="https://vmsdemo.bdtask-demo.com/refueling/refueling/delete_refuelreq/17" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                    <div class="text-right" style="display:inline-block;">
                                        <div class="actions" style="display:inline-block;">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus2(0,'tbl_refuel_requisition',17,'refuelreq_id')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus2(1,'tbl_refuel_requisition',17,'refuelreq_id')" class="dropdown-item">Release</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>16</td>
                                <td>Shah Latif Express UP</td>
                                <td>Diesel</td>
                                <td>20</td>
                                <td>50</td>
                                <td>GM Filling Station</td>
                                <td>Pending</td>
                                <td>
                                    <input name="url" type="hidden" id="url_18" value="https://vmsdemo.bdtask-demo.com/refueling/refueling/updaterefuelreqfrm" />
                                    <a onclick="editinfo(18)" class="btn btn-xs btn-success btn-sm mr-1 text-white" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                    <a href="https://vmsdemo.bdtask-demo.com/refueling/refueling/delete_refuelreq/18" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                    <div class="text-right" style="display:inline-block;">
                                        <div class="actions" style="display:inline-block;">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus2(0,'tbl_refuel_requisition',18,'refuelreq_id')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus2(1,'tbl_refuel_requisition',18,'refuelreq_id')" class="dropdown-item">Release</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>17</td>
                                <td>Shah Latif Express UP</td>
                                <td>Diesel</td>
                                <td>3232</td>
                                <td>2</td>
                                <td>GM Filling Station</td>
                                <td>Pending</td>
                                <td>
                                    <input name="url" type="hidden" id="url_19" value="https://vmsdemo.bdtask-demo.com/refueling/refueling/updaterefuelreqfrm" />
                                    <a onclick="editinfo(19)" class="btn btn-xs btn-success btn-sm mr-1 text-white" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                    <a href="https://vmsdemo.bdtask-demo.com/refueling/refueling/delete_refuelreq/19" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                    <div class="text-right" style="display:inline-block;">
                                        <div class="actions" style="display:inline-block;">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus2(0,'tbl_refuel_requisition',19,'refuelreq_id')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus2(1,'tbl_refuel_requisition',19,'refuelreq_id')" class="dropdown-item">Release</a>
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
<!-- <script src="{{asset('dist/js/refuel_requisition.js')}}"></script> -->
<script>
    $(document).ready(function() {
        let refuelRequestsTable = $("#refuel_requests").DataTable();
    });
</script>
@endsection