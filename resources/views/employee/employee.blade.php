@extends('layouts.main.app')

@section('title', 'Employee Management')

@section('breadcrumb-content')
<li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
<li class="breadcrumb-item active" id="moduleName">Employee Management</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">Employee Management</h1>
<small id="controllerName">Manage Employees</small>
@endsection

@section('content')
<div id="add0" class="modal fade bd-example-modal-xl" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Add Employee</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="https://vmsdemo.bdtask-demo.com/empmgt/Employees/create_employee" id="emp_form" class="row" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                    <div class="col-md-12 col-lg-6">
                        <div class="form-group row">
                            <label for="emp_name" class="col-sm-5 col-form-label">Employee Name <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="emp_name" required="" id="emp_name" class="form-control" type="text" placeholder="Employee Name" id="emp_name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="pay_roll_type" class="col-sm-5 col-form-label">Pay Roll Type <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" required="" name="pay_roll_type" id="pay_roll_type">
                                    <option value="" selected="selected">Please Select One</option>
                                    <option value="External">External</option>
                                    <option value="Internal">Internal</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="department" class="col-sm-5 col-form-label">Department <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" required="" name="department" id="department">
                                    <option value="" selected="selected">Please Select One</option>
                                    <option value="Accounting">
                                        Accounting</option>
                                    <option value="Human Resource">
                                        Human Resource</option>
                                    <option value="Marketing & Sales">
                                        Marketing & Sales</option>
                                    <option value="Technical">
                                        Technical</option>
                                    <option value="mmkmk">
                                        mmkmk</option>
                                    <option value="Planning department">
                                        Planning department</option>
                                    <option value="Testing">
                                        Testing</option>
                                    <option value="Computer">
                                        Computer</option>
                                    <option value="Rose Water">
                                        Rose Water</option>
                                    <option value="yhyh">
                                        yhyh</option>
                                    <option value="Administration">
                                        Administration</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-sm-5 col-form-label">Email <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="email" required="" class="form-control" type="email" placeholder="Email" id="email">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email2" class="col-sm-5 col-form-label">Email Optional </label>
                            <div class="col-sm-7">
                                <input name="email2" class="form-control" type="email" placeholder="Email Optional" id="email2">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="blood" class="col-sm-5 col-form-label">Blood Group </label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" name="blood" id="blood">
                                    <option value="" selected="selected">Please Select One</option>
                                    <option value="A+">A+</option>
                                    <option value="A-">A-</option>
                                    <option value="B+">B+</option>
                                    <option value="B-">B-</option>
                                    <option value="O+">O+</option>
                                    <option value="O-">O-</option>
                                    <option value="AB+">AB+</option>
                                    <option value="AB-">AB-</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="working_slot_from" class="col-sm-5 col-form-label">Working Slot From </label>
                            <div class="col-sm-7">
                                <input name="working_slot_from" class="form-control ttimepicker" type="text" placeholder="Working Slot From" id="working_slot_from">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="fater_name" class="col-sm-5 col-form-label">Father Name </label>
                            <div class="col-sm-7">
                                <input name="fater_name" class="form-control" type="text" placeholder="Father Name" id="fater_name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="present_cont" class="col-sm-5 col-form-label">Present Contact Number </label>
                            <div class="col-sm-7">
                                <input name="present_cont" class="form-control" type="number" placeholder="Present Contact Number" id="present_cont">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="present_address" class="col-sm-5 col-form-label">Present Address </label>
                            <div class="col-sm-7">
                                <input name="present_address" class="form-control" type="text" placeholder="Present Address" id="present_address">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="present_city" class="col-sm-5 col-form-label">Present City </label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" name="present_city" id="present_city">
                                    <option value="" selected="selected">Please Select One</option>
                                    <option value="Dhaka">Dhaka</option>
                                    <option value="Faridpur">Faridpur</option>
                                    <option value="Gazipur">Gazipur</option>
                                    <option value="Gopalganj">Gopalganj</option>
                                    <option value="Jamalpur">Jamalpur</option>
                                    <option value="Kishoreganj">Kishoreganj</option>
                                    <option value="Madaripur">Madaripur</option>
                                    <option value="Manikganj">Manikganj</option>
                                    <option value="Munshiganj">Munshiganj</option>
                                    <option value="Mymensingh">Mymensingh</option>
                                    <option value="Narayanganj">Narayanganj</option>
                                    <option value="Narsingdi">Narsingdi</option>
                                    <option value="Netrokona">Netrokona</option>
                                    <option value="Rajbari">Rajbari</option>
                                    <option value="Shariatpur">Shariatpur</option>
                                    <option value="Sherpur">Sherpur</option>
                                    <option value="Tangail">Tangail</option>
                                    <option value="Bogura">Bogura</option>
                                    <option value="Joypurhat">Joypurhat</option>
                                    <option value="Naogaon">Naogaon</option>
                                    <option value="Natore">Natore</option>
                                    <option value="Chapainawabganj">Chapainawabganj</option>
                                    <option value="Pabna">Pabna</option>
                                    <option value="Rajshahi">Rajshahi</option>
                                    <option value="Sirajgonj">Sirajgonj</option>
                                    <option value="Dinajpur">Dinajpur</option>
                                    <option value="Gaibandha">Gaibandha</option>
                                    <option value="Kurigram">Kurigram</option>
                                    <option value="Lalmonirhat">Lalmonirhat</option>
                                    <option value="Nilphamari">Nilphamari</option>
                                    <option value="Panchagarh">Panchagarh</option>
                                    <option value="Rangpur">Rangpur</option>
                                    <option value="Thakurgaon">Thakurgaon</option>
                                    <option value="Barguna">Barguna</option>
                                    <option value="Barishal">Barishal</option>
                                    <option value="Bhola">Bhola</option>
                                    <option value="Jhalokati">Jhalokati</option>
                                    <option value="Patuakhali">Patuakhali</option>
                                    <option value="Pirojpur">Pirojpur</option>
                                    <option value="Bandarban">Bandarban</option>
                                    <option value="Brahmanbaria">Brahmanbaria</option>
                                    <option value="Chandpur">Chandpur</option>
                                    <option value="Chattogram">Chattogram</option>
                                    <option value="Cumilla">Cumilla</option>
                                    <option value="Cox's Bazar">Cox's Bazar</option>
                                    <option value="Feni">Feni</option>
                                    <option value="Khagrachhari">Khagrachhari</option>
                                    <option value="Lakshmipur">Lakshmipur</option>
                                    <option value="Noakhali">Noakhali</option>
                                    <option value="Rangamati">Rangamati</option>
                                    <option value="Habiganj">Habiganj</option>
                                    <option value="Moulvibazar">Moulvibazar</option>
                                    <option value="Sunamganj">Sunamganj</option>
                                    <option value="Sylhet">Sylhet</option>
                                    <option value="Bagerhat">Bagerhat</option>
                                    <option value="Chuadanga">Chuadanga</option>
                                    <option value="Jashore">Jashore</option>
                                    <option value="Jhenaidah">Jhenaidah</option>
                                    <option value="Khulna">Khulna</option>
                                    <option value="Kushtia">Kushtia</option>
                                    <option value="Magura">Magura</option>
                                    <option value="Meherpur">Meherpur</option>
                                    <option value="Narail">Narail</option>
                                    <option value="Satkhira">Satkhira</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="referance" class="col-sm-5 col-form-label">Reference Name </label>
                            <div class="col-sm-7">
                                <input name="referance" class="form-control" type="text" placeholder="Reference Name" id="referance">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="ref_address" class="col-sm-5 col-form-label">Reference Address </label>
                            <div class="col-sm-7">
                                <input name="ref_address" class="form-control" type="text" placeholder="Reference Address" id="present_address">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="ref_email" class="col-sm-5 col-form-label">Reference Email </label>
                            <div class="col-sm-7">
                                <input name="ref_email" class="form-control" type="email" placeholder="Reference Email " id="ref_email">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6">
                        <div class="form-group row">
                            <label for="emp_nid" class="col-sm-5 col-form-label">Employee NID <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="emp_nid" required="" class="form-control" type="number" placeholder="Employee NID" id="emp_nid">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="designation" class="col-sm-5 col-form-label">Designation <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" required="" name="designation" id="designation">
                                    <option value="" selected="selected">Please Select One</option>
                                    <option value="Supervisor">Supervisor </option>
                                    <option value="Manager">Manager </option>
                                    <option value="Accounts">Accounts </option>
                                    <option value="Helper">Helper </option>
                                    <option value="Receptionist">Receptionist </option>
                                    <option value="Palero">Palero </option>
                                    <option value="testing">testing </option>
                                    <option value="officer">officer </option>
                                    <option value="Customer">Customer </option>
                                    <option value="????">???? </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="phone" class="col-sm-5 col-form-label">Employee Mobile <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="phone" required="" class="form-control" type="number" placeholder="Employee Mobile" id="phone">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="phone2" class="col-sm-5 col-form-label">Employee Mobile Optional </label>
                            <div class="col-sm-7">
                                <input name="phone2" class="form-control" type="number" placeholder="Employee Mobile Optional " id="phone2">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="join_date" class="col-sm-5 col-form-label">Join Date <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="join_date" required autocomplete="off" class="form-control newdatetimepicker" type="text" placeholder="Join Date" id="join_date">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="dob" class="col-sm-5 col-form-label">Date of Birth <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="dob" required autocomplete="off" class="form-control newdatetimepicker" type="text" placeholder="Date of Birth" id="dob">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="working_slot_to" class="col-sm-5 col-form-label">Working Slot To </label>
                            <div class="col-sm-7">
                                <input name="working_slot_to" class="form-control ttimepicker" type="text" placeholder="Working Slot To" id="working_slot_to">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="mother_name" class="col-sm-5 col-form-label">Mother Name </label>
                            <div class="col-sm-7">
                                <input name="mother_name" class="form-control" type="text" placeholder="Mother Name" id="mother_name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="permanent_contact" class="col-sm-5 col-form-label">Permanent Contact Number </label>
                            <div class="col-sm-7">
                                <input name="permanent_contact" class="form-control" type="text" placeholder="Permanent Contact Number" id="permanent_contact">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="permanent_address" class="col-sm-5 col-form-label">Permanent Address </label>
                            <div class="col-sm-7">
                                <input name="permanent_address" class="form-control" type="text" placeholder="Permanent Address" id="permanent_address">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="permanent_city" class="col-sm-5 col-form-label">Permanent City </label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" name="permanent_city" id="permanent_city">
                                    <option value="" selected="selected">Please Select One</option>
                                    <option value="Bangalore">Bengaluru</option>
                                    <option value="Hyderabad">Hyderabad</option>
                                    <option value="Mumbai">Mumbai</option>
                                    <option value="Kolkata">Kolkata</option>
                                    <option value="Chennai">Chennai</option>
                                    <option value="Mysore">Mysore</option>
                                    <option value="Brindavan">Brindavan</option>
                                    <option value="Pune">Pune</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="ref_mobile" class="col-sm-5 col-form-label">Reference Mobile </label>
                            <div class="col-sm-7">
                                <input name="ref_mobile" class="form-control" type="number" placeholder="Reference Mobile" id="ref_mobile">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="picture" class="col-sm-5 col-form-label">Photograph </label>
                            <div class="col-sm-7">
                                <input type="file" accept="image/*" name="picture" onchange="loadFile(event)">
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
            <div class="card-header">
                <h4>Search Here<small class="float-right">

                        <button type="button" class="btn btn-primary btn-md" data-target="#add0" data-toggle="modal"><i class="ti-plus" aria-hidden="true"></i>
                            Add Employee</button>
                    </small></h4>
            </div>
            <div class="card-body">
                <form action="" class="form-inline row" id="validate" method="post" accept-charset="utf-8">
                    <div class="col-sm-12 col-xl-4">
                        <div class="form-group row mb-1">
                            <label for="emp_type" class="col-sm-5 col-form-label justify-content-start text-left">Employee Type </label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" name="emp_types" id="emp_types">
                                    <option value="" selected="selected">Please Select One</option>
                                    <option value="External">External </option>
                                    <option value="Internal">Internal </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-1">
                            <label for="blood" class="col-sm-5 col-form-label justify-content-start text-left">Blood Group </label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" name="shbloodg" id="shbloodg">
                                    <option value="" selected="selected">Please Select One</option>
                                    <option value="A-">A- </option>
                                    <option value=""> </option>
                                    <option value="A+">A+ </option>
                                    <option value="O+">O+ </option>
                                    <option value="AB+">AB+ </option>
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="col-sm-12 col-xl-4">
                        <div class="form-group row mb-1">
                            <label for="department" class="col-sm-5 col-form-label justify-content-start text-left">Department <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" required="" name="departmentsh" id="departmentsh">
                                    <option value="" selected="selected">Please Select One</option>
                                    <option value="Accounting">
                                        Accounting</option>
                                    <option value="Human Resource">
                                        Human Resource</option>
                                    <option value="Marketing & Sales">
                                        Marketing & Sales</option>
                                    <option value="Technical">
                                        Technical</option>
                                    <option value="mmkmk">
                                        mmkmk</option>
                                    <option value="Planning department">
                                        Planning department</option>
                                    <option value="Testing">
                                        Testing</option>
                                    <option value="Computer">
                                        Computer</option>
                                    <option value="Rose Water">
                                        Rose Water</option>
                                    <option value="yhyh">
                                        yhyh</option>
                                    <option value="Administration">
                                        Administration</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-1">
                            <label for="designation" class="col-sm-5 col-form-label justify-content-start text-left">Designation <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" required="" name="designationsh" id="designationsh">
                                    <option value="" selected="selected">Please Select One</option>
                                    <option value="Supervisor">Supervisor </option>
                                    <option value="Manager">Manager </option>
                                    <option value="Accounts">Accounts </option>
                                    <option value="Helper">Helper </option>
                                    <option value="Receptionist">Receptionist </option>
                                    <option value="Palero">Palero </option>
                                    <option value="testing">testing </option>
                                    <option value="officer">officer </option>
                                    <option value="Customer">Customer </option>
                                    <option value="????">???? </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xl-4">
                        <div class="row">
                            <div class="col-sm-12 col-xl-12">
                                <div class="form-group row mb-1">
                                    <label for="join_datefrsh" class="col-sm-5 col-form-label justify-content-start text-left">Joining Date From </label>
                                    <div class="col-sm-7">
                                        <input name="join_datefrsh" autocomplete="off" class="form-control newdatetimepicker  w-100" type="text" placeholder="Joining Date From" id="join_datefrsh">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-xl-12">
                                <div class="form-group row mb-1">
                                    <label for="joining_d_to" class="col-sm-5 col-form-label justify-content-start text-left">Joining Date To </label>
                                    <div class="col-sm-7">
                                        <input name="joining_d_to" autocomplete="off" class="form-control newdatetimepicker w-100" type="text" placeholder="Joining Date To" id="joining_d_to">
                                    </div>
                                </div>
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
                </form>
            </div>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="card mb-3">
            <div class="card-header p-2">
                <h4 class="pl-3">Manage Employee</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="empsear" class="table table-striped table-bordered dt-responsive nowrap ">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Name</th>
                                <th>NID</th>
                                <th>Type</th>
                                <th>Department</th>
                                <th>Designation</th>
                                <th>Mobile</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            <tr role="row" class="odd">
                                <td class="sorting_1" tabindex="0">1</td>
                                <td>Balram</td>
                                <td>5551177244338801</td>
                                <td>External</td>
                                <td>Human Resource</td>
                                <td>Helper</td>
                                <td>01923001234</td>
                                <td><a href="#" class="btn btn-xs btn-success btn-sm mr-1"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/empmgt/Employees/delete_employhistory/E0CRB403" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a></td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1" tabindex="0">2</td>
                                <td>Uday</td>
                                <td>0214253645674577</td>
                                <td>External</td>
                                <td>Human Resource</td>
                                <td>Supervisor</td>
                                <td>01738465735</td>
                                <td><a href="#" class="btn btn-xs btn-success btn-sm mr-1"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/empmgt/Employees/delete_employhistory/EKDXW58G" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a></td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="sorting_1" tabindex="0">3</td>
                                <td>Demo</td>
                                <td>987214253667854</td>
                                <td>External</td>
                                <td>ACCOUNTING</td>
                                <td>Supervisor</td>
                                <td>01738465711</td>
                                <td><a href="#" class="btn btn-xs btn-success btn-sm mr-1"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/empmgt/Employees/delete_employhistory/ETMYQ36Y" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a></td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1" tabindex="0">4</td>
                                <td>Test Employee</td>
                                <td>53453434</td>
                                <td>External</td>
                                <td>ACCOUNTING</td>
                                <td>Supervisor</td>
                                <td>01785522541</td>
                                <td><a href="#" class="btn btn-xs btn-success btn-sm mr-1"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/empmgt/Employees/delete_employhistory/EDWWDMAV" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a></td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="sorting_1" tabindex="0">5</td>
                                <td>abc</td>
                                <td>657657567</td>
                                <td>External</td>
                                <td>ACCOUNTING</td>
                                <td>Manager</td>
                                <td>12345678</td>
                                <td><a href="https://vmsdemo.bdtask-demo.com/empmgt/Employees/update_employee_form/EJ5MOH4S" class="btn btn-xs btn-success btn-sm mr-1"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/empmgt/Employees/delete_employhistory/EJ5MOH4S" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a></td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1" tabindex="0">6</td>
                                <td>Test2</td>
                                <td>765757657</td>
                                <td>Internal</td>
                                <td>Human Resource</td>
                                <td>Manager</td>
                                <td>12345678</td>
                                <td><a href="https://vmsdemo.bdtask-demo.com/empmgt/Employees/update_employee_form/ECN3UOZ8" class="btn btn-xs btn-success btn-sm mr-1"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/empmgt/Employees/delete_employhistory/ECN3UOZ8" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a></td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="sorting_1" tabindex="0">7</td>
                                <td>demo2</td>
                                <td>56465656</td>
                                <td>Internal</td>
                                <td>Human Resource</td>
                                <td>Manager</td>
                                <td>645645546</td>
                                <td><a href="https://vmsdemo.bdtask-demo.com/empmgt/Employees/update_employee_form/E62WYC4J" class="btn btn-xs btn-success btn-sm mr-1"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/empmgt/Employees/delete_employhistory/E62WYC4J" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a></td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1" tabindex="0">8</td>
                                <td>Sample</td>
                                <td>4567</td>
                                <td>External</td>
                                <td>Technical</td>
                                <td>Manager</td>
                                <td>346567678</td>
                                <td><a href="https://vmsdemo.bdtask-demo.com/empmgt/Employees/update_employee_form/EODSVEIF" class="btn btn-xs btn-success btn-sm mr-1"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/empmgt/Employees/delete_employhistory/EODSVEIF" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a></td>
                            </tr>
                        </tbody>

                    </table> <!-- /.table-responsive -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <script src="{{asset('dist/js/employee_view.js')}}"></script> -->
<script>
    $(document).ready(function() {
        $("#empsear").DataTable();
    });
</script>


@endsection