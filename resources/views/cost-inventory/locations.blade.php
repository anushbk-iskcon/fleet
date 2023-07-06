@extends('layouts.main.app')

@section('title', 'Locations')

@section('breadcrumb-content')
<li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
<li class="breadcrumb-item active" id="moduleName">Cost & Inventory</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">Cost & Inventory</h1>
<small id="controllerName">Locations</small>
@endsection

@section('content')
<div id="add0" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Add Location</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="" id="location" class="row" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                    <div class="col-md-12 col-lg-12">
                        <div class="form-group row">
                            <label class="col-sm-5 col-form-label" for="location_name">Location Name&nbsp;<i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input type="text" required name="location_name" id="location_name" placeholder="Location Name" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-5 col-form-label" for="room">Room</label>
                            <div class="col-sm-7">
                                <input type="number" name="room" id="room" placeholder="Room" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-5 col-form-label" for="self">Self</label>
                            <div class="col-sm-7">
                                <input type="number" name="self" id="self" placeholder="Self" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-5 col-form-label" for="drawer">Drawer</label>
                            <div class="col-sm-7">
                                <input type="number" name="drawer" id="drawer" placeholder="Drawer" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-5 col-form-label" for="capacity">Capacity</label>
                            <div class="col-sm-7">
                                <input type="number" name="capacity" id="capacity" placeholder="Capacity" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-5 col-form-label" for="dimension">Dimension</label>
                            <div class="col-sm-7">
                                <input type="number" name="dimension" id="dimension" placeholder="Dimension" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="expence_cat" class="col-sm-5 col-form-label">Is Active </label>
                            <div class="col-sm-7">
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" checked id="yes" name="is_active" class="custom-control-input" value="1">
                                    <label class="custom-control-label" for="yes">Yes</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="no" name="is_active" class="custom-control-input" value="0">
                                    <label class="custom-control-label" for="no">No</label>
                                </div>

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

<div id="edit" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Update Location</strong>
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
                <h4 class="pl-3">Locations<small class="float-right">
                        <button type="button" class="btn btn-primary btn-md" data-target="#add0" data-toggle="modal"><i class="ti-plus" aria-hidden="true"></i>
                            Add Location</button>
                    </small></h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example_location" class="table display table-bordered table-striped table-hover ">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Location Name</th>
                                <th>Room</th>
                                <th>Self</th>
                                <th>Drawer</th>
                                <th>Capacity</th>
                                <th>Dimension</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>D-MRT</td>
                                <td>3</td>
                                <td>5</td>
                                <td>1</td>
                                <td>5</td>
                                <td>5</td>
                                <td>Active</td>
                                <td>
                                    <input name="url" type="hidden" id="url_1" value="https://vmsdemo.bdtask-demo.com/costinventory/Costinventory/updatelocfrm" />
                                    <a onclick="editinfo(1)" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil text-white"></i></a>
                                    <a href="https://vmsdemo.bdtask-demo.com/costinventory/Costinventory/delete_loction/1" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>MAIN</td>
                                <td>3</td>
                                <td>1</td>
                                <td>5</td>
                                <td>5</td>
                                <td>5</td>
                                <td>Active</td>
                                <td>
                                    <input name="url" type="hidden" id="url_2" value="https://vmsdemo.bdtask-demo.com/costinventory/Costinventory/updatelocfrm" />
                                    <a onclick="editinfo(2)" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil text-white"></i></a>
                                    <a href="https://vmsdemo.bdtask-demo.com/costinventory/Costinventory/delete_loction/2" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Rampura</td>
                                <td>105</td>
                                <td>2</td>
                                <td>2</td>
                                <td>100</td>
                                <td>100</td>
                                <td>Inactive</td>
                                <td>
                                    <input name="url" type="hidden" id="url_3" value="https://vmsdemo.bdtask-demo.com/costinventory/Costinventory/updatelocfrm" />
                                    <a onclick="editinfo(3)" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil text-white"></i></a>
                                    <a href="https://vmsdemo.bdtask-demo.com/costinventory/Costinventory/delete_loction/3" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                </td>
                            </tr>
                        </tbody>
                    </table> <!-- /.table-responsive -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <script src="https://vmsdemo.bdtask-demo.com/assets/dist/js/location_list.js"></script> -->
<script>
    $(document).ready(function() {
        $("#example_location").DataTable();
    });
</script>
@endsection