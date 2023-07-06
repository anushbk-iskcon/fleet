@extends('layouts.main.app')

@section('title', 'Manage Parts')

@section('breadcrumb-content')
<li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
<li class="breadcrumb-item active" id="moduleName">Cost & Inventory</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">Cost & Inventory</h1>
<small id="controllerName">Manage Parts</small>
@endsection

@section('content')
<div id="add0" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Add Parts</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="" id="location" class="row" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                    <div class="col-md-12 col-lg-12">
                        <div class="form-group row">
                            <label class="col-sm-5 col-form-label" for="parts_name">Parts Name&nbsp;<i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input type="text" required name="parts_name" id="parts_name" placeholder="Parts Name" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-5 col-form-label" for="description">Description</label>
                            <div class="col-sm-7">
                                <input type="text" name="description" id="description" placeholder="Description" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-5 col-form-label" for="self">Category Name <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" required name="category_name" id="category_name">
                                    <option value="" selected="selected">Please Select One</option>
                                    <option value="MPV">MPV</option>
                                    <option value="Battery">Battery</option>
                                    <option value="Tire">Tire</option>
                                    <option value="Clutch">Clutch</option>
                                    <option value="wheel">wheel</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-5 col-form-label" for="stock_limit">Stock Limit <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input type="text" name="stock_limit" required id="stock_limit" placeholder="Stock Limit" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-5 col-form-label" for="location_name">Location Name <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" required name="location_name" id="location_name">
                                    <option value="" selected="selected">Please Select One</option>
                                    <option value="D-MRT">D-MRT</option>
                                    <option value="MAIN">MAIN</option>
                                    <option value="Rampura">Rampura</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-5 col-form-label" for="remarks">Remarks</label>
                            <div class="col-sm-7">
                                <input type="text" name="remarks" id="remarks" placeholder="Remarks" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="expence_cat" class="col-sm-5 col-form-label">Is Active </label>
                            <div class="col-sm-7">
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" checked="checked" id="yes" name="is_active" class="custom-control-input" value="1">
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
                <strong>Update Parts</strong>
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
                <h4 class="pl-3">Manage Parts <small class="float-right">

                        <button type="button" class="btn btn-primary btn-md" data-target="#add0" data-toggle="modal"><i class="ti-plus" aria-hidden="true"></i>
                            Add Parts</button>
                    </small></h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example_parts" class="table display table-bordered table-striped table-hover ">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Parts Name</th>
                                <th>Description</th>
                                <th>Category Name</th>
                                <th>Stock Limit</th>
                                <th>Location Name</th>
                                <th>Remarks</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>IPB150</td>
                                <td></td>
                                <td>Battery</td>
                                <td>5</td>
                                <td>MAIN</td>
                                <td></td>
                                <td>Active</td>
                                <td>
                                    <input name="url" type="hidden" id="url_2" value="https://vmsdemo.bdtask-demo.com/costinventory/Costinventory/updatepartsfrm" />
                                    <a onclick="editinfo(2)" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil text-white"></i></a>
                                    <a href="" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Part Name</td>
                                <td>Part Name</td>
                                <td>MPV</td>
                                <td>Test Stock Limit</td>
                                <td>MAIN</td>
                                <td>Remark</td>
                                <td>Active</td>
                                <td>
                                    <input name="url" type="hidden" id="url_3" value="https://vmsdemo.bdtask-demo.com/costinventory/Costinventory/updatepartsfrm" />
                                    <a onclick="editinfo(3)" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil text-white"></i></a>
                                    <a href="https://vmsdemo.bdtask-demo.com/costinventory/Costinventory/delete_parts/3" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                </td>
                            </tr>
                        </tbody>
                    </table> <!-- /.table-responsive -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <script src="https://vmsdemo.bdtask-demo.com/assets/dist/js/parts_list.js"></script> -->

<script>
    $(document).ready(function() {
        $("#example_parts").DataTable();
    });
</script>
@endsection