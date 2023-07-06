@extends('layouts.main.app')

@section('title', 'Vehicle Routes')

@section('breadcrumb-content')
<li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
<li class="breadcrumb-item active" id="moduleName">Vehicle Requisition</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">Vehicle Requisition</h1>
<small id="controllerName">Vehicle Route Details</small>
@endsection

@section('content')

<div id="add0" class="modal fade bd-example-modal-lg" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Add Route</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="https://vmsdemo.bdtask-demo.com/vehiclereq/Vehicle_requisition/add_route" id="emp_form" class="row" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                    <div class="col-md-12 col-lg-6">
                        <div class="form-group row">
                            <label for="route_name" class="col-sm-5 col-form-label">Route Name <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="route_name" required="" class="form-control" type="text" placeholder="Route Name" id="route_name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="destination" class="col-sm-5 col-form-label">Destination <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="destination" required="" class="form-control" type="text" placeholder="Destination" id="destination">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="checkbox1" class="col-sm-5 col-form-label">&nbsp;</label>
                            <div class="col-sm-7 checkbox checkbox-primary">
                                <input id="checkbox1" type="checkbox" name="is_active">
                                <label for="checkbox1">Is Active</label>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-12 col-lg-6">
                        <div class="form-group row">
                            <label for="start_p" class="col-sm-5 col-form-label">Start Point <i class="text-danger">*</i> </label>
                            <div class="col-sm-7">
                                <input name="start_p" required="" class="form-control" type="text" placeholder="Start Point" id="start_p">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="descrip" class="col-sm-5 col-form-label">Description <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="descrip" required="" class="form-control" type="text" placeholder="Description" id="descrip">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="checkbox2" class="col-sm-5 col-form-label">&nbsp;</label>
                            <div class="col-sm-7 checkbox checkbox-primary">
                                <input id="checkbox2" type="checkbox" name="create_pickdrop_point">
                                <label for="checkbox2">Create Pick and Drop Point</label>
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
                <strong>Update Route</strong>
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
                <h4 class="pl-3">Search Here<small class="float-right">

                        <button type="button" class="btn btn-primary btn-md" data-target="#add0" data-toggle="modal"><i class="ti-plus" aria-hidden="true"></i>
                            Add Route</button>
                    </small></h4>
            </div>
            <div class="card-body row">
                <div class="col-sm-12 col-xl-4">
                    <div class="form-group row mb-1">
                        <label for="route_namesr" class="col-sm-5 col-form-label justify-content-start text-left">Route Name </label>
                        <div class="col-sm-7">
                            <select class="form-control basic-single" name="route_namesr" id="route_namesr">
                                <option value="" selected="selected">Please Select One</option>
                                <option value="gabtoli to motijeel">gabtoli to motijeel </option>
                                <option value="Jatrabari to Uttara">Jatrabari to Uttara </option>
                                <option value="Mohammanpur to khilgao">Mohammanpur to khilgao </option>
                                <option value="Route1">Route1 </option>
                                <option value="new">new </option>
                                <option value="ddd">ddd </option>
                                <option value="Jatra Bari">Jatra Bari </option>
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
                </div>
                <div class="col-sm-12 col-xl-4">
                    <div class="form-group row mb-1">
                        <label for="status" class="col-sm-5 col-form-label justify-content-start text-left">Status <i class="text-danger">*</i></label>
                        <div class="col-sm-7">
                            <select class="form-control basic-single" name="status" id="status">
                                <option value="" selected="selected">Please Select One</option>
                                <option value="Pending">Pending</option>
                                <option value="Approved">Approved</option>
                                <option value="Reject">Reject</option>
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
                <h4 class="pl-3">Vehicle Route Details</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="routeinfo" class="table table-striped table-bordered dt-responsive nowrap">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Route Name</th>
                                <th>Start Point</th>
                                <th>Destination</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr role="row" class="odd">
                                <td class="sorting_1" tabindex="0">1</td>
                                <td>gabtoli to motijeel</td>
                                <td>gabtoli</td>
                                <td>motijeel</td>
                                <td>Yes</td>
                                <td><input name="url" type="hidden" id="url_1" value="https://vmsdemo.bdtask-demo.com/vehiclereq/Vehicle_requisition/updateroutefrm"><a onclick="editinfo(1)" style="cursor:pointer;color:#fff;" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/vehiclereq/Vehicle_requisition/delete_route/1" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a></td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1" tabindex="0">2</td>
                                <td>Jatrabari to Uttara</td>
                                <td>Jatrabari</td>
                                <td>Uttara</td>
                                <td>Yes</td>
                                <td><input name="url" type="hidden" id="url_2" value="https://vmsdemo.bdtask-demo.com/vehiclereq/Vehicle_requisition/updateroutefrm"><a onclick="editinfo(2)" style="cursor:pointer;color:#fff;" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/vehiclereq/Vehicle_requisition/delete_route/2" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a></td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="sorting_1" tabindex="0">3</td>
                                <td>Mohammanpur to khilgao</td>
                                <td>Mohammanpur </td>
                                <td>khilgao</td>
                                <td>Yes</td>
                                <td><input name="url" type="hidden" id="url_3" value="https://vmsdemo.bdtask-demo.com/vehiclereq/Vehicle_requisition/updateroutefrm"><a onclick="editinfo(3)" style="cursor:pointer;color:#fff;" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/vehiclereq/Vehicle_requisition/delete_route/3" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a></td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1" tabindex="0">4</td>
                                <td>Route1</td>
                                <td>Tangail</td>
                                <td>Dhaka</td>
                                <td>Yes</td>
                                <td><input name="url" type="hidden" id="url_4" value="https://vmsdemo.bdtask-demo.com/vehiclereq/Vehicle_requisition/updateroutefrm"><a onclick="editinfo(4)" style="cursor:pointer;color:#fff;" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/vehiclereq/Vehicle_requisition/delete_route/4" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a></td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="sorting_1" tabindex="0">5</td>
                                <td>new</td>
                                <td>dhaka</td>
                                <td>comilla</td>
                                <td>No</td>
                                <td><input name="url" type="hidden" id="url_6" value="https://vmsdemo.bdtask-demo.com/vehiclereq/Vehicle_requisition/updateroutefrm"><a onclick="editinfo(6)" style="cursor:pointer;color:#fff;" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/vehiclereq/Vehicle_requisition/delete_route/6" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a></td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1" tabindex="0">6</td>
                                <td>ddd</td>
                                <td>ee</td>
                                <td>ee</td>
                                <td>Yes</td>
                                <td><input name="url" type="hidden" id="url_7" value="https://vmsdemo.bdtask-demo.com/vehiclereq/Vehicle_requisition/updateroutefrm"><a onclick="editinfo(7)" style="cursor:pointer;color:#fff;" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/vehiclereq/Vehicle_requisition/delete_route/7" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a></td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="sorting_1" tabindex="0">7</td>
                                <td>Jatra Bari</td>
                                <td>Jatrabari</td>
                                <td>Matuil</td>
                                <td>Yes</td>
                                <td><input name="url" type="hidden" id="url_8" value="https://vmsdemo.bdtask-demo.com/vehiclereq/Vehicle_requisition/updateroutefrm"><a onclick="editinfo(8)" style="cursor:pointer;color:#fff;" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/vehiclereq/Vehicle_requisition/delete_route/8" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a></td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1" tabindex="0">8</td>
                                <td>qwerty</td>
                                <td>qwerty</td>
                                <td>qwerty</td>
                                <td>Yes</td>
                                <td><input name="url" type="hidden" id="url_9" value="https://vmsdemo.bdtask-demo.com/vehiclereq/Vehicle_requisition/updateroutefrm"><a onclick="editinfo(9)" style="cursor:pointer;color:#fff;" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/vehiclereq/Vehicle_requisition/delete_route/9" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a></td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="sorting_1" tabindex="0">9</td>
                                <td>qwerty</td>
                                <td>qwerty</td>
                                <td>qwerty</td>
                                <td>Yes</td>
                                <td><input name="url" type="hidden" id="url_10" value="https://vmsdemo.bdtask-demo.com/vehiclereq/Vehicle_requisition/updateroutefrm"><a onclick="editinfo(10)" style="cursor:pointer;color:#fff;" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/vehiclereq/Vehicle_requisition/delete_route/10" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a></td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1" tabindex="0">10</td>
                                <td>মেঘনা হতে জামগড়া,ফ্যান্টাসি </td>
                                <td>Jatrabari</td>
                                <td>মেঘনা হতে জামগড়া,ফ্যান্টাসি কিংডম</td>
                                <td>Yes</td>
                                <td><input name="url" type="hidden" id="url_11" value="https://vmsdemo.bdtask-demo.com/vehiclereq/Vehicle_requisition/updateroutefrm"><a onclick="editinfo(11)" style="cursor:pointer;color:#fff;" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/vehiclereq/Vehicle_requisition/delete_route/11" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a></td>
                            </tr>
                        </tbody>
                    </table> <!-- /.table-responsive -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <script src="https://vmsdemo.bdtask-demo.com/assets/dist/js/vehiclereq_vroute_list.js"></script> -->
<script>
    $(document).ready(function() {
        $("#routeinfo").DataTable();
    });
</script>

@endsection