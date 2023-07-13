@extends('layouts.main.app')

@section('title', 'Reminders')

@section('breadcrumb-content')
<li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
<li class="breadcrumb-item active" id="moduleName">Vehicle Management</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">Vehicle Management</h1>
<small id="controllerName">Manage Reminders</small>
@endsection

@section('content')


<div id="add0" class="modal fade bd-example-modal-lg" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Add Reminder</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="https://vmsdemo.bdtask-demo.com/vehiclemgt/Vehicle_management/add_reminder" id="emp_form" class="row" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                    <div class="col-md-12 col-lg-6">
                        <div class="form-group row">
                            <label for="vehicle" class="col-sm-5 col-form-label">Vehicle <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" required="" name="vehicle" id="vehicle">
                                    <option value="" selected="selected">Please Select One</option>
                                    <option value="داف">داف </option>
                                    <option value="Kia">Kia </option>
                                    <option value="red">red </option>
                                    <option value="Kia Soul">Kia Soul </option>
                                    <option value="quad r647">quad r647 </option>
                                    <option value="AS">AS </option>
                                    <option value="d">d </option>
                                    <option value="Fareed Express">Fareed Express </option>
                                    <option value="Khyber Express">Khyber Express </option>
                                    <option value="Sukkur Express UP">Sukkur Express UP </option>
                                    <option value="Shah Latif Express UP">Shah Latif Express UP </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="document_type" class="col-sm-5 col-form-label">Document Type<i class="text-danger">*</i> </label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" required="" name="document_type" id="document_type">
                                    <option value="" selected="selected">Please Select One</option>
                                    <option value="Vehicle">
                                        Vehicle</option>
                                    <option value="NID">
                                        NID</option>
                                    <option value="Driving License">
                                        Driving License</option>
                                    <option value="Trade License">
                                        Trade License</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="notification_before" class="col-sm-5 col-form-label">Notification Before <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" required="" name="notification_before" id="notification_before">
                                    <option value="" selected="selected">Please Select One</option>
                                    <option value="7 days">
                                        7 days</option>
                                    <option value="hello">
                                        hello</option>
                                    <option value="2 Month">
                                        2 Month</option>
                                    <option value="1 Month">
                                        1 Month</option>
                                    <option value="10 days">
                                        10 days</option>
                                    <option value="15 days">
                                        15 days</option>
                                    <option value="5 days">
                                        5 days</option>
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-12 col-lg-6">
                        <div class="form-group row">
                            <label for="email" class="col-sm-5 col-form-label">Email </label>
                            <div class="col-sm-2">
                                <div class="form-check form-check-inline">
                                    <input id="inlineCheckbox1" class="form-check-input" type="checkbox" data-toggle="toggle" name="isemail" data-style="mr-1">
                                    <label for="inlineCheckbox1" class="form-check-label">&nbsp;</label>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <input name="email" class="form-control" type="email" placeholder="Email" id="email">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-sm-5 col-form-label">SMS </label>
                            <div class="col-sm-2">
                                <div class="form-check form-check-inline">
                                    <input id="inlineCheckbox2" class="form-check-input" type="checkbox" data-toggle="toggle" name="issms" data-style="mr-1">
                                    <label for="inlineCheckbox2" class="form-check-label">&nbsp;</label>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <input name="sms" class="form-control" type="text" placeholder="SMS" id="sms">
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
                <strong>Update Legal Documentation</strong>
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
                <h4 class="pl-3">Search Here <small class="float-right">
                        <button type="button" class="btn btn-primary btn-md" data-target="#add0" data-toggle="modal"><i class="ti-plus" aria-hidden="true"></i>
                            Add Reminder</button>

                    </small></h4>
            </div>
            <div class="card-body row">
                <div class="col-sm-12 col-xl-4">
                    <div class="form-group row mb-1">
                        <label for="vehiclesr" class="col-sm-5 col-form-label justify-content-start text-left">Vehicle </label>
                        <div class="col-sm-7">
                            <select class="form-control basic-single" name="vehiclesr" id="vehiclesr">
                                <option value="" selected="selected">Please Select One</option>
                                <option value="داف">داف </option>
                                <option value="Kia">Kia </option>
                                <option value="red">red </option>
                                <option value="Kia Soul">Kia Soul </option>
                                <option value="quad r647">quad r647 </option>
                                <option value="AS">AS </option>
                                <option value="d">d </option>
                                <option value="Fareed Express">Fareed Express </option>
                                <option value="Khyber Express">Khyber Express </option>
                                <option value="Sukkur Express UP">Sukkur Express UP </option>
                                <option value="Shah Latif Express UP">Shah Latif Express UP </option>
                            </select>
                        </div>
                    </div>

                </div>
                <div class="col-sm-12 col-xl-4">
                    <div class="form-group row mb-1">
                        <label for="document_typesr" class="col-sm-5 col-form-label justify-content-start text-left">Document Type </label>
                        <div class="col-sm-7">
                            <select class="form-control basic-single" name="document_typesr" id="document_typesr">
                                <option value="" selected="selected">Please Select One</option>
                                <option value="Vehicle">
                                    Vehicle</option>
                                <option value="NID">
                                    NID</option>
                                <option value="Driving License">
                                    Driving License</option>
                                <option value="Trade License">
                                    Trade License</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-xl-4">
                    <div class="form-group row mb-1">
                        <div class="col-sm-8 text-right">
                            <button type="button" class="btn btn-success" id="btn-filter">Search</button>&nbsp;
                            <button type="button" class="btn btn-inverse" id="btn-reset">Reset</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="card mb-3">
            <div class="card-header p-2">
                <h4 class="pl-3">Reminder List</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="remind" class="table table-striped table-bordered dt-responsive nowrap">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Vehicle</th>
                                <th>Document Type</th>
                                <th>Alert Type</th>
                                <th>Expire Date</th>
                                <th>Mobile</th>
                                <th>Email</th>
                                <th>Remaining Days</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr role="row" class="odd">
                                <td class="sorting_1" tabindex="0">1</td>
                                <td>Test Express</td>
                                <td>NID</td>
                                <td>Both Email and Sms</td>
                                <td>2021-02-24</td>
                                <td>6575673424234</td>
                                <td>dfd@gmail.con</td>
                                <td>817</td>
                                <td style="display: none;"><input name="url" type="hidden" id="url_17" value="https://vmsdemo.bdtask-demo.com/vehiclemgt/Vehicle_management/updatereminderfrm"><a onclick="editinfo(17)" style="cursor:pointer;color:#fff;" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/vehiclemgt/Vehicle_management/delete_reminder/17" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a></td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1" tabindex="0">2</td>
                                <td>Test Express UP</td>
                                <td>Trade License</td>
                                <td>Both Email and Sms</td>
                                <td>2021-02-11</td>
                                <td>6575673424234</td>
                                <td>rr@gmail.com</td>
                                <td>830</td>
                                <td style="display: none;"><input name="url" type="hidden" id="url_15" value="https://vmsdemo.bdtask-demo.com/vehiclemgt/Vehicle_management/updatereminderfrm"><a onclick="editinfo(15)" style="cursor:pointer;color:#fff;" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/vehiclemgt/Vehicle_management/delete_reminder/15" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a></td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="sorting_1" tabindex="0">3</td>
                                <td>Test 3</td>
                                <td>NID</td>
                                <td>Both Email and Sms</td>
                                <td>2021-02-17</td>
                                <td>6575673424234</td>
                                <td>dfd@gmail.con</td>
                                <td>824</td>
                                <td style="display: none;"><input name="url" type="hidden" id="url_17" value="https://vmsdemo.bdtask-demo.com/vehiclemgt/Vehicle_management/updatereminderfrm"><a onclick="editinfo(17)" style="cursor:pointer;color:#fff;" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/vehiclemgt/Vehicle_management/delete_reminder/17" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a></td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1" tabindex="0">4</td>
                                <td>Test 4</td>
                                <td>NID</td>
                                <td>Both Email and Sms</td>
                                <td>2021-02-25</td>
                                <td>6575673424234</td>
                                <td>dfd@gmail.con</td>
                                <td>816</td>
                                <td style="display: none;"><input name="url" type="hidden" id="url_17" value="https://vmsdemo.bdtask-demo.com/vehiclemgt/Vehicle_management/updatereminderfrm"><a onclick="editinfo(17)" style="cursor:pointer;color:#fff;" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/vehiclemgt/Vehicle_management/delete_reminder/17" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a></td>
                            </tr>

                        </tbody>
                    </table> <!-- /.table-responsive -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <script src="https://vmsdemo.bdtask-demo.com/assets/dist/js/reminder_list.js"></script> -->
<script>
    $(document).ready(function() {
        $("#remind").DataTable();
    });
</script>
@endsection