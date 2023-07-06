@extends('layouts.main.app')

@section('title', 'Expense Types')

@section('breadcrumb-content')
<li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
<li class="breadcrumb-item active" id="moduleName">Cost & Inventory</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">Cost & Inventory</h1>
<small id="controllerName">Manage Expense Types</small>
@endsection

@section('content')

<div id="add0" class="modal fade bd-example-modal-lg" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Add New Expense</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="" id="emp_form" class="row" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                    <div class="col-md-12 col-lg-12">
                        <div class="form-group row">
                            <label for="expense_name" class="col-sm-3 col-form-label">Expense Name <i class="text-danger">*</i></label>
                            <div class="col-sm-5">
                                <input name="expense_name" required="" class="form-control" type="text" placeholder="Expense Name" id="expense_name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="expence_cat" class="col-sm-3 col-form-label">Expense category <i class="text-danger">*</i></label>
                            <div class="col-sm-9">
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="fuel" name="expence_cat" class="custom-control-input" value="Fuel">
                                    <label class="custom-control-label" for="fuel">Fuel</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="maintenance" name="expence_cat" class="custom-control-input" value="Maintenance">
                                    <label class="custom-control-label" for="maintenance">Maintenance</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="other" name="expence_cat" class="custom-control-input" value="Other">
                                    <label class="custom-control-label" for="other">Other</label>
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
<div id="edit" class="modal fade bd-example-modal-lg" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Update Expense Type</strong>
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
                <h4 class="pl-3">Manage Expense Type<small class="float-right">

                        <button type="button" class="btn btn-primary btn-md" data-target="#add0" data-toggle="modal"><i class="ti-plus" aria-hidden="true"></i>
                            Add New Expense</button> &nbsp;

                        <a href="{{route('add-new-expense')}}" class="btn btn-primary btn-md">
                            <i class="ti-plus" aria-hidden="true"></i>
                            Add Expense
                        </a>&nbsp;

                        <a href="{{route('all-expenses-list')}}" class="btn btn-primary btn-md"><i class="ti-plus" aria-hidden="true"></i>
                            Expense List</a>

                    </small></h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table display table-bordered table-striped table-hover ">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Name</th>
                                <th>Expense Group</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Spare Parts for Rear Window</td>
                                <td>Maintenance</td>
                                <td>
                                    <input name="url" type="hidden" id="url_15" value="https://vmsdemo.bdtask-demo.com/costinventory/Costinventory/updateexptfrm" />
                                    <a onclick="editinfo(15)" class="btn btn-xs btn-success btn-sm mr-1 text-white" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                    <a href="https://vmsdemo.bdtask-demo.com/costinventory/Costinventory/delete_exptype/15" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>abc</td>
                                <td>Maintenance</td>
                                <td>
                                    <input name="url" type="hidden" id="url_14" value="https://vmsdemo.bdtask-demo.com/costinventory/Costinventory/updateexptfrm" />
                                    <a onclick="editinfo(14)" class="btn btn-xs btn-success btn-sm mr-1 text-white" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                    <a href="https://vmsdemo.bdtask-demo.com/costinventory/Costinventory/delete_exptype/14" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>test</td>
                                <td>Fuel</td>
                                <td>
                                    <input name="url" type="hidden" id="url_12" value="https://vmsdemo.bdtask-demo.com/costinventory/Costinventory/updateexptfrm" />
                                    <a onclick="editinfo(12)" class="btn btn-xs btn-success btn-sm mr-1 text-white" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                    <a href="https://vmsdemo.bdtask-demo.com/costinventory/Costinventory/delete_exptype/12" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>gear</td>
                                <td>Fuel</td>
                                <td>
                                    <input name="url" type="hidden" id="url_11" value="https://vmsdemo.bdtask-demo.com/costinventory/Costinventory/updateexptfrm" />
                                    <a onclick="editinfo(11)" class="btn btn-xs btn-success btn-sm mr-1 text-white" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                    <a href="https://vmsdemo.bdtask-demo.com/costinventory/Costinventory/delete_exptype/11" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>partner</td>
                                <td>Maintenance</td>
                                <td>
                                    <input name="url" type="hidden" id="url_10" value="https://vmsdemo.bdtask-demo.com/costinventory/Costinventory/updateexptfrm" />
                                    <a onclick="editinfo(10)" class="btn btn-xs btn-success btn-sm mr-1 text-white" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                    <a href="https://vmsdemo.bdtask-demo.com/costinventory/Costinventory/delete_exptype/10" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td>dfghfhfgh</td>
                                <td>Maintenance</td>
                                <td>
                                    <input name="url" type="hidden" id="url_9" value="https://vmsdemo.bdtask-demo.com/costinventory/Costinventory/updateexptfrm" />
                                    <a onclick="editinfo(9)" class="btn btn-xs btn-success btn-sm mr-1 text-white" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                    <a href="https://vmsdemo.bdtask-demo.com/costinventory/Costinventory/delete_exptype/9" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>7</td>
                                <td>other</td>
                                <td>Maintenance</td>
                                <td>
                                    <input name="url" type="hidden" id="url_6" value="https://vmsdemo.bdtask-demo.com/costinventory/Costinventory/updateexptfrm" />
                                    <a onclick="editinfo(6)" class="btn btn-xs btn-success btn-sm mr-1 text-white" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                    <a href="https://vmsdemo.bdtask-demo.com/costinventory/Costinventory/delete_exptype/6" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>8</td>
                                <td>Test Expense</td>
                                <td>Maintenance</td>
                                <td>
                                    <input name="url" type="hidden" id="url_5" value="https://vmsdemo.bdtask-demo.com/costinventory/Costinventory/updateexptfrm" />
                                    <a onclick="editinfo(5)" class="btn btn-xs btn-success btn-sm mr-1 text-white" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                    <a href="https://vmsdemo.bdtask-demo.com/costinventory/Costinventory/delete_exptype/5" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>9</td>
                                <td>Landscape architect</td>
                                <td>Maintenance</td>
                                <td>
                                    <input name="url" type="hidden" id="url_4" value="https://vmsdemo.bdtask-demo.com/costinventory/Costinventory/updateexptfrm" />
                                    <a onclick="editinfo(4)" class="btn btn-xs btn-success btn-sm mr-1 text-white" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                    <a href="https://vmsdemo.bdtask-demo.com/costinventory/Costinventory/delete_exptype/4" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>10</td>
                                <td>Tips</td>
                                <td>Fuel</td>
                                <td>
                                    <input name="url" type="hidden" id="url_3" value="https://vmsdemo.bdtask-demo.com/costinventory/Costinventory/updateexptfrm" />
                                    <a onclick="editinfo(3)" class="btn btn-xs btn-success btn-sm mr-1 text-white" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                    <a href="https://vmsdemo.bdtask-demo.com/costinventory/Costinventory/delete_exptype/3" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>11</td>
                                <td>Comission</td>
                                <td>Fuel</td>
                                <td>
                                    <input name="url" type="hidden" id="url_2" value="https://vmsdemo.bdtask-demo.com/costinventory/Costinventory/updateexptfrm" />
                                    <a onclick="editinfo(2)" class="btn btn-xs btn-success btn-sm mr-1 text-white" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                    <a href="https://vmsdemo.bdtask-demo.com/costinventory/Costinventory/delete_exptype/2" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                </td>
                            </tr>
                        </tbody>
                    </table> <!-- /.table-responsive -->
                </div>
            </div>
        </div>
    </div>
</div>

@endsection