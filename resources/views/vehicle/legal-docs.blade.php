@extends('layouts.main.app')

@section('title', 'Legal Documents')

@section('breadcrumb-content')
<li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
<li class="breadcrumb-item active" id="moduleName">Vehicle Management</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">Vehicle Management</h1>
<small id="controllerName">Manage Legal Documents</small>
@endsection

@section('content')

<div id="add0" class="modal fade bd-example-modal-lg" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Add Legal Documentation</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="" id="emp_form" class="row" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                    <div class="col-md-12 col-lg-6">
                        <div class="form-group row">
                            <label for="document_type" class="col-sm-5 col-form-label">Document Type </label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" name="document_type" id="document_type">
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
                            <label for="vehicle" class="col-sm-5 col-form-label">Vehicles <i class="text-danger">*</i></label>
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
                            <label for="last_issue_date" class="col-sm-5 col-form-label">Last Issue Date <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="last_issue_date" autocomplete="off" required="" class="form-control newdatetimepicker" type="text" placeholder="Last Issue Date" id="last_issue_date">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="expire_date" class="col-sm-5 col-form-label">Expire Date <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="expire_date" required="" autocomplete="off" class="form-control newdatetimepicker" type="text" placeholder="Expire Date" id="expire_date">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="charge_paid" class="col-sm-5 col-form-label">Charge Paid <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="charge_paid" class="form-control" type="number" placeholder="Charge Paid" id="charge_paid">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="vendor" class="col-sm-5 col-form-label">Vendor <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" required="" name="vendor" id="vendor">
                                    <option value="" selected="selected">Please Select One</option>
                                    <option value="asdfas">asdfas </option>
                                    <option value="honda">honda </option>
                                    <option value="Auto Parts">Auto Parts </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6">
                        <div class="form-group row">
                            <label for="commission" class="col-sm-5 col-form-label">Commission <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="commission" required="" class="form-control" type="number" placeholder="Commission" id="commission">
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

                        <div class="form-group row">
                            <label for="email" class="col-sm-5 col-form-label">Email </label>
                            <div class="col-sm-2">
                                <div class="form-check form-check-inline">
                                    <input id="inlineCheckbox1" class="form-check-input" name="isemail" type="checkbox" data-toggle="toggle" data-style="mr-1">
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
                                    <input id="inlineCheckbox2" class="form-check-input" type="checkbox" name="issms" data-toggle="toggle" data-style="mr-1">
                                    <label for="inlineCheckbox2" class="form-check-label">&nbsp;</label>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <input name="sms" class="form-control" type="text" placeholder="SMS" id="sms">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="document_attachment" class="col-sm-5 col-form-label">Document Attachment</label>
                            <div class="col-sm-7">
                                <input name="document_attachment" type="file" />
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
                            Add Legal Documentation</button>

                    </small></h4>
            </div>
            <div class="card-body row">
                <div class="col-sm-12 col-xl-4">
                    <div class="form-group row mb-1">
                        <label for="vehiclesr" class="col-sm-5 col-form-label justify-content-start text-left">Vehicles </label>
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
                        <label for="exp_date_fr" class="col-sm-5 col-form-label justify-content-start text-left">Expire Date From </label>
                        <div class="col-sm-7">
                            <input name="exp_date_fr" autocomplete="off" class="form-control newdatetimepicker" type="text" placeholder="Expire Date From" id="exp_date_fr">
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <label for="exp_date_to" class="col-sm-5 col-form-label justify-content-start text-left">Expire Date To </label>
                        <div class="col-sm-7">
                            <input name="exp_date_to" autocomplete="off" class="form-control newdatetimepicker" type="text" placeholder="Expire Date To" id="exp_date_to">
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
                <h4 class="pl-3">Legal Documentation List</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="docinfo" class="table table-striped table-bordered dt-responsive nowrap">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Document Type</th>
                                <th>Vehicle</th>
                                <th>Last Issue Date</th>
                                <th>Expire Date</th>
                                <th>Vendor</th>
                                <th>Commission</th>
                                <th>Notification Before</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr role="row" class="odd">
                                <td class="sorting_1" tabindex="0">1</td>
                                <td>NID</td>
                                <td>Nissan</td>
                                <td>2021-02-01</td>
                                <td>2021-02-24</td>
                                <td>Rahim Afroz</td>
                                <td>6787</td>
                                <td>1 Month</td>
                                <td style="display: none;"><input name="url" type="hidden" id="url_3" value="https://vmsdemo.bdtask-demo.com/vehiclemgt/Vehicle_management/updatedocumentfrm"><a onclick="editinfo(3)" style="cursor:pointer;color:#fff;" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/vehiclemgt/Vehicle_management/delete_documentation/3" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a></td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1" tabindex="0">2</td>
                                <td>Trade License</td>
                                <td>Navana</td>
                                <td>2020-02-11</td>
                                <td>2021-02-11</td>
                                <td>Rahim Afroz</td>
                                <td>6787</td>
                                <td>2 Month</td>
                                <td style="display: none;"><input name="url" type="hidden" id="url_4" value="https://vmsdemo.bdtask-demo.com/vehiclemgt/Vehicle_management/updatedocumentfrm"><a onclick="editinfo(4)" style="cursor:pointer;color:#fff;" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/vehiclemgt/Vehicle_management/delete_documentation/4" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a></td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="sorting_1" tabindex="0">3</td>
                                <td>NID</td>
                                <td>BMW</td>
                                <td>2021-02-17</td>
                                <td>2021-02-17</td>
                                <td>Rahim Afroz</td>
                                <td>uyuyt</td>
                                <td>2 Month</td>
                                <td style="display: none;"><input name="url" type="hidden" id="url_5" value="https://vmsdemo.bdtask-demo.com/vehiclemgt/Vehicle_management/updatedocumentfrm"><a onclick="editinfo(5)" style="cursor:pointer;color:#fff;" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/vehiclemgt/Vehicle_management/delete_documentation/5" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a></td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1" tabindex="0">4</td>
                                <td>NID</td>
                                <td>balaka</td>
                                <td>2021-02-25</td>
                                <td>2021-02-25</td>
                                <td>Rahim Afroz</td>
                                <td>400</td>
                                <td>1 Month</td>
                                <td style="display: none;"><input name="url" type="hidden" id="url_6" value="https://vmsdemo.bdtask-demo.com/vehiclemgt/Vehicle_management/updatedocumentfrm"><a onclick="editinfo(6)" style="cursor:pointer;color:#fff;" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/vehiclemgt/Vehicle_management/delete_documentation/6" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a></td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="sorting_1" tabindex="0">5</td>
                                <td>Driving License</td>
                                <td>DEMO2</td>
                                <td>2021-03-02</td>
                                <td>2021-03-02</td>
                                <td>Rahim Afroz</td>
                                <td>43</td>
                                <td>1 Month</td>
                                <td style="display: none;"><input name="url" type="hidden" id="url_7" value="https://vmsdemo.bdtask-demo.com/vehiclemgt/Vehicle_management/updatedocumentfrm"><a onclick="editinfo(7)" style="cursor:pointer;color:#fff;" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/vehiclemgt/Vehicle_management/delete_documentation/7" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a></td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1" tabindex="0">6</td>
                                <td>Trade License</td>
                                <td>DEMO3</td>
                                <td>2021-03-02</td>
                                <td>2021-03-02</td>
                                <td>vandor</td>
                                <td>65</td>
                                <td>2 Month</td>
                                <td style="display: none;"><input name="url" type="hidden" id="url_8" value="https://vmsdemo.bdtask-demo.com/vehiclemgt/Vehicle_management/updatedocumentfrm"><a onclick="editinfo(8)" style="cursor:pointer;color:#fff;" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/vehiclemgt/Vehicle_management/delete_documentation/8" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a></td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="sorting_1" tabindex="0">7</td>
                                <td>Driving License</td>
                                <td>DEMO3</td>
                                <td>2021-03-02</td>
                                <td>2021-03-02</td>
                                <td>Rahim Afroz</td>
                                <td>56</td>
                                <td>1 Month</td>
                                <td style="display: none;"><input name="url" type="hidden" id="url_9" value="https://vmsdemo.bdtask-demo.com/vehiclemgt/Vehicle_management/updatedocumentfrm"><a onclick="editinfo(9)" style="cursor:pointer;color:#fff;" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/vehiclemgt/Vehicle_management/delete_documentation/9" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a></td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1" tabindex="0">8</td>
                                <td>Driving License</td>
                                <td>DEMO3</td>
                                <td>2021-03-02</td>
                                <td>2021-03-02</td>
                                <td>vandor</td>
                                <td>656</td>
                                <td>10 days</td>
                                <td style="display: none;"><input name="url" type="hidden" id="url_10" value="https://vmsdemo.bdtask-demo.com/vehiclemgt/Vehicle_management/updatedocumentfrm"><a onclick="editinfo(10)" style="cursor:pointer;color:#fff;" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/vehiclemgt/Vehicle_management/delete_documentation/10" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a></td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="sorting_1" tabindex="0">9</td>
                                <td>NID</td>
                                <td>AS</td>
                                <td>2021-03-02</td>
                                <td>2021-03-02</td>
                                <td>Auto Parts</td>
                                <td>56</td>
                                <td>2 Month</td>
                                <td style="display: none;"><input name="url" type="hidden" id="url_11" value="https://vmsdemo.bdtask-demo.com/vehiclemgt/Vehicle_management/updatedocumentfrm"><a onclick="editinfo(11)" style="cursor:pointer;color:#fff;" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/vehiclemgt/Vehicle_management/delete_documentation/11" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a></td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1" tabindex="0">10</td>
                                <td>Driving License</td>
                                <td>Kia Soul</td>
                                <td>2023-04-15</td>
                                <td>2023-04-29</td>
                                <td>honda</td>
                                <td>2</td>
                                <td>5 days</td>
                                <td style="display: none;"><input name="url" type="hidden" id="url_12" value="https://vmsdemo.bdtask-demo.com/vehiclemgt/Vehicle_management/updatedocumentfrm"><a onclick="editinfo(12)" style="cursor:pointer;color:#fff;" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/vehiclemgt/Vehicle_management/delete_documentation/12" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a></td>
                            </tr>
                        </tbody>


                    </table> <!-- /.table-responsive -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <script src="https://vmsdemo.bdtask-demo.com/assets/dist/js/documentation_list.js"></script> -->
<script>
    $(document).ready(function() {
        $("#docinfo").DataTable();
    });
</script>
@endsection