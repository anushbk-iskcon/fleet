@extends('layouts.main.app')

@section('title', 'Manage License')

@section('breadcrumb-content')
<li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
<li class="breadcrumb-item active" id="moduleName">Employee Management</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">Employee Management</h1>
<small id="controllerName">Manage Lincenses</small>
@endsection

@section('content')

<div id="add3" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Add License Type</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="" id="addLicenseTypeForm" class="row" method="post" accept-charset="utf-8">
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label for="license_name" class="col-sm-5 col-form-label">License Name <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="license_name" required class="form-control" type="text" placeholder="License Name" id="license_name">
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
                <strong>Update License</strong>
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
                <h4 class="pl-3">Manage License
                    <small class="float-right">
                        <a href="{{route('drivers.index')}}" class="btn btn-primary btn-md">
                            Manage Drivers
                        </a>&nbsp;
                    </small>
                </h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="license_list" class="table display table-bordered table-striped table-hover ">
                        <thead>
                            <tr>
                                <th>Sl No.</th>
                                <th>License Name</th>
                                <th>Action(s)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>3</td>
                                <td><input name="url" type="hidden" id="url_14" value="https://vmsdemo.bdtask-demo.com/empmgt/Driver_controller/updateltyfrm" />
                                    <a onclick="editinfo(14)" class="btn btn-xs btn-success btn-sm mr-1 text-white" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>test</td>
                                <td><input name="url" type="hidden" id="url_13" value="https://vmsdemo.bdtask-demo.com/empmgt/Driver_controller/updateltyfrm" />
                                    <a onclick="editinfo(13)" class="btn btn-xs btn-success btn-sm mr-1 text-white" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>TEST</td>
                                <td><input name="url" type="hidden" id="url_12" value="https://vmsdemo.bdtask-demo.com/empmgt/Driver_controller/updateltyfrm" />
                                    <a onclick="editinfo(12)" class="btn btn-xs btn-success btn-sm mr-1 text-white" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>test</td>
                                <td><input name="url" type="hidden" id="url_11" value="https://vmsdemo.bdtask-demo.com/empmgt/Driver_controller/updateltyfrm" />
                                    <a onclick="editinfo(11)" class="btn btn-xs btn-success btn-sm mr-1 text-white" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>LTV</td>
                                <td><input name="url" type="hidden" id="url_10" value="https://vmsdemo.bdtask-demo.com/empmgt/Driver_controller/updateltyfrm" />
                                    <a onclick="editinfo(10)" class="btn btn-xs btn-success btn-sm mr-1 text-white" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td>Normal License </td>
                                <td><input name="url" type="hidden" id="url_9" value="https://vmsdemo.bdtask-demo.com/empmgt/Driver_controller/updateltyfrm" />
                                    <a onclick="editinfo(9)" class="btn btn-xs btn-success btn-sm mr-1 text-white" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>7</td>
                                <td>iuyiyui</td>
                                <td><input name="url" type="hidden" id="url_8" value="https://vmsdemo.bdtask-demo.com/empmgt/Driver_controller/updateltyfrm" />
                                    <a onclick="editinfo(8)" class="btn btn-xs btn-success btn-sm mr-1 text-white" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>8</td>
                                <td>zfdsfsdf</td>
                                <td><input name="url" type="hidden" id="url_7" value="https://vmsdemo.bdtask-demo.com/empmgt/Driver_controller/updateltyfrm" />
                                    <a onclick="editinfo(7)" class="btn btn-xs btn-success btn-sm mr-1 text-white" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>9</td>
                                <td>zfdsfsdf</td>
                                <td><input name="url" type="hidden" id="url_6" value="https://vmsdemo.bdtask-demo.com/empmgt/Driver_controller/updateltyfrm" />
                                    <a onclick="editinfo(6)" class="btn btn-xs btn-success btn-sm mr-1 text-white" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>10</td>
                                <td> vcgfhfgy</td>
                                <td><input name="url" type="hidden" id="url_5" value="https://vmsdemo.bdtask-demo.com/empmgt/Driver_controller/updateltyfrm" />
                                    <a onclick="editinfo(5)" class="btn btn-xs btn-success btn-sm mr-1 text-white" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>11</td>
                                <td>Test License</td>
                                <td><input name="url" type="hidden" id="url_4" value="https://vmsdemo.bdtask-demo.com/empmgt/Driver_controller/updateltyfrm" />
                                    <a onclick="editinfo(4)" class="btn btn-xs btn-success btn-sm mr-1 text-white" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>12</td>
                                <td>PROFESSIONAL DRIVING LICENSE</td>
                                <td><input name="url" type="hidden" id="url_3" value="https://vmsdemo.bdtask-demo.com/empmgt/Driver_controller/updateltyfrm" />
                                    <a onclick="editinfo(3)" class="btn btn-xs btn-success btn-sm mr-1 text-white" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>13</td>
                                <td>NON PROFESSIONAL DRIVING LICENSE</td>
                                <td><input name="url" type="hidden" id="url_2" value="https://vmsdemo.bdtask-demo.com/empmgt/Driver_controller/updateltyfrm" />
                                    <a onclick="editinfo(2)" class="btn btn-xs btn-success btn-sm mr-1 text-white" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>14</td>
                                <td>LEARNER DRIVING LICENSE</td>
                                <td><input name="url" type="hidden" id="url_1" value="https://vmsdemo.bdtask-demo.com/empmgt/Driver_controller/updateltyfrm" />
                                    <a onclick="editinfo(1)" class="btn btn-xs btn-success btn-sm mr-1 text-white" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
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
@section('js-content')
@if(Session::has('success'))
<script>
    toastr.success('{{session("success")}}', '', {
        closeButton: true
    });
</script>
@endif
@if(Session::has('failure'))
<script>
    toastr.error('{{session("failure")}}', '', {
        closeButton: true
    });
</script>
@endif
<script>
    $(document).ready(function() {
        $("#license_list").DataTable();
    });
</script>
@endsection