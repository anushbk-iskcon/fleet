@extends('layouts.main.app')

@section('title', 'Driver Performance')

@section('breadcrumb-content')
<li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
<li class="breadcrumb-item active" id="moduleName">Employee Management</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">Employee Management</h1>
<small id="controllerName">Driver Performance</small>
@endsection

@section('content')

<div id="add0" class="modal fade bd-example-modal-lg" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Add Driver Information</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="https://vmsdemo.bdtask-demo.com/empmgt/Driver_controller/create_performance" id="emp_form" class="row" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                    <div class="col-md-12 col-lg-6">
                        <div class="form-group row">
                            <label for="driver_name" class="col-sm-5 col-form-label">Driver Name <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" required="" name="driver_name" id="driver_name">
                                    <option value="" selected="selected">Please Select One</option>
                                    <option value="Demo driver">Demo driver </option>
                                    <option value="driver name">driver name </option>
                                    <option value="Faris Shafi">Faris Shafi </option>
                                    <option value="Khurram">Khurram </option>
                                    <option value="Musa Karim - Fareed Express">Musa Karim - Fareed Express </option>
                                    <option value="Malik - Khyber Express">Malik - Khyber Express </option>
                                    <option value="aman - Shah Latif Express">aman - Shah Latif Express </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="ot_status" class="col-sm-5 col-form-label">Over Time Status <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" required="" name="ot_status" id="ot_status">
                                    <option value="" selected="selected">Please Select One</option>
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="salary_status" class="col-sm-5 col-form-label">Salary Status <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="salary_status1" name="salary_status" class="custom-control-input" value="1" checked="checked">
                                    <label class="custom-control-label" for="salary_status1">Yes</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="salary_status11" name="salary_status" class="custom-control-input" value="0">
                                    <label class="custom-control-label" for="salary_status11">No</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="ot_payment" class="col-sm-5 col-form-label">Overtime Payment <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="ot_payment" required="" class="form-control" type="number" placeholder="Overtime Payment" id="ot_payment">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="performance_bonus" class="col-sm-5 col-form-label">Performance Bonus <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="performance_bonus" required="" class="form-control" type="number" placeholder="Performance Bonus" id="performance_bonus">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6">
                        <div class="form-group row">
                            <label for="pt_amount" class="col-sm-5 col-form-label">Penalty Amount <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="pt_amount" required="" class="form-control" type="number" placeholder="Penalty Amount" id="pt_amount">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="pt_reason" class="col-sm-5 col-form-label">Penalty Reason <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <textarea name="pt_reason" required="" class="form-control" id="pt_reason" placeholder="Penalty Reason" cols="40" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="pt_date" class="col-sm-5 col-form-label">Penalty Date </label>
                            <div class="col-sm-7">
                                <input name="pt_date" class="form-control newdatetimepicker" type="text" placeholder="Penalty Date" id="pt_date">
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
                <strong>Update Driver information</strong>
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
                <h4 class="pl-3">Driver Performance<small class="float-right"><button type="button" class="btn btn-primary btn-md" data-target="#add0" data-toggle="modal"><i class="ti-plus" aria-hidden="true"></i>
                            Add Driver Information</button></small></h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="driverexinfo2" class="table table-striped table-bordered dt-responsive nowrap">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Driver Name</th>
                                <th>Over Time Status</th>
                                <th>Salary Status</th>
                                <th>Overtime Payment</th>
                                <th>Performance Bonus</th>
                                <th>Penalty Amount</th>
                                <th>Penalty Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Demo driver</td>
                                <td>yes</td>
                                <td>No</td>
                                <td>100</td>
                                <td>100.00</td>
                                <td>500.00</td>
                                <td>2023-05-02</td>
                                <td><input name="url" type="hidden" id="url_12" value="https://vmsdemo.bdtask-demo.com/empmgt/Driver_controller/updatedrpfrm" />
                                    <a onclick="editinfo('12')" class="btn btn-xs btn-success btn-sm mr-1" style="cursor:pointer;color:#fff;" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/empmgt/Driver_controller/delete_driverpr/12" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Malik - Khyber Express</td>
                                <td>yes</td>
                                <td>Yes</td>
                                <td>-2</td>
                                <td>1.00</td>
                                <td>1.00</td>
                                <td>2023-03-13</td>
                                <td><input name="url" type="hidden" id="url_11" value="https://vmsdemo.bdtask-demo.com/empmgt/Driver_controller/updatedrpfrm" />
                                    <a onclick="editinfo('11')" class="btn btn-xs btn-success btn-sm mr-1" style="cursor:pointer;color:#fff;" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/empmgt/Driver_controller/delete_driverpr/11" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>dgdfgfdg</td>
                                <td>no</td>
                                <td>Yes</td>
                                <td>500</td>
                                <td>300.00</td>
                                <td>80.00</td>
                                <td>2021-02-16</td>
                                <td><input name="url" type="hidden" id="url_10" value="https://vmsdemo.bdtask-demo.com/empmgt/Driver_controller/updatedrpfrm" />
                                    <a onclick="editinfo('10')" class="btn btn-xs btn-success btn-sm mr-1" style="cursor:pointer;color:#fff;" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/empmgt/Driver_controller/delete_driverpr/10" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>Kamal</td>
                                <td>yes</td>
                                <td>No</td>
                                <td>100</td>
                                <td>500.76</td>
                                <td>99.99</td>
                                <td>2021-02-09</td>
                                <td><input name="url" type="hidden" id="url_6" value="https://vmsdemo.bdtask-demo.com/empmgt/Driver_controller/updatedrpfrm" />
                                    <a onclick="editinfo('6')" class="btn btn-xs btn-success btn-sm mr-1" style="cursor:pointer;color:#fff;" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/empmgt/Driver_controller/delete_driverpr/6" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>Manik</td>
                                <td>yes</td>
                                <td>Yes</td>
                                <td>8678</td>
                                <td>78.00</td>
                                <td>768.00</td>
                                <td>2020-12-03</td>
                                <td><input name="url" type="hidden" id="url_5" value="https://vmsdemo.bdtask-demo.com/empmgt/Driver_controller/updatedrpfrm" />
                                    <a onclick="editinfo('5')" class="btn btn-xs btn-success btn-sm mr-1" style="cursor:pointer;color:#fff;" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/empmgt/Driver_controller/delete_driverpr/5" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td>Test Driver</td>
                                <td>yes</td>
                                <td>Yes</td>
                                <td>786</td>
                                <td>768.00</td>
                                <td>78.00</td>
                                <td>2021-02-11</td>
                                <td><input name="url" type="hidden" id="url_4" value="https://vmsdemo.bdtask-demo.com/empmgt/Driver_controller/updatedrpfrm" />
                                    <a onclick="editinfo('4')" class="btn btn-xs btn-success btn-sm mr-1" style="cursor:pointer;color:#fff;" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/empmgt/Driver_controller/delete_driverpr/4" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>7</td>
                                <td>Manik</td>
                                <td>yes</td>
                                <td>Yes</td>
                                <td>67</td>
                                <td>657.00</td>
                                <td>657.00</td>
                                <td>2021-02-10</td>
                                <td><input name="url" type="hidden" id="url_3" value="https://vmsdemo.bdtask-demo.com/empmgt/Driver_controller/updatedrpfrm" />
                                    <a onclick="editinfo('3')" class="btn btn-xs btn-success btn-sm mr-1" style="cursor:pointer;color:#fff;" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/empmgt/Driver_controller/delete_driverpr/3" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>8</td>
                                <td>Faris Shafi</td>
                                <td>yes</td>
                                <td>Yes</td>
                                <td>346</td>
                                <td>500.00</td>
                                <td>100.00</td>
                                <td>2021-02-10</td>
                                <td><input name="url" type="hidden" id="url_2" value="https://vmsdemo.bdtask-demo.com/empmgt/Driver_controller/updatedrpfrm" />
                                    <a onclick="editinfo('2')" class="btn btn-xs btn-success btn-sm mr-1" style="cursor:pointer;color:#fff;" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/empmgt/Driver_controller/delete_driverpr/2" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                </td>
                            </tr>
                        </tbody>
                    </table> <!-- /.table-responsive -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <script src="https://vmsdemo.bdtask-demo.com/assets/dist/js/driver_performance.js"></script> -->
@endsection