@extends('layouts.main.app')

@section('title', 'Maintenance Types')

@section('breadcrumb-content')
<li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
<li class="breadcrumb-item active" id="moduleName">System Settings</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">System Settings</h1>
<small id="controllerName">Manage Maintenance Types</small>
@endsection

@section('content')

<div id="add0" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Add Maintenance Type</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{route('maintenance-types.add')}}" id="addMaintenanceTypeForm" class="row" method="post" accept-charset="utf-8">
                    @csrf
                    <div class="col-md-12 col-lg-12">
                        <div class="form-group row">
                            <label for="mainten_name" class="col-sm-5 col-form-label">Maintenance Type Name <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="mainten_name" required class="form-control" type="text" placeholder="Maintenance Type Name" id="mainten_name">
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
                <strong>Update Maintenance Type</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body editinfo">
                <form action="{{route('maintenance-types.update')}}" id="editMaintenanceTypeForm" class="row" method="post" accept-charset="utf-8">
                    @csrf
                    <input type="hidden" name="mainten_id" id="maintenanceTypeId">
                    <div class="col-md-12 col-lg-12">
                        <div class="form-group row">
                            <label for="new_mainten_name" class="col-sm-5 col-form-label">Maintenance Type Name <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="mainten_name" required class="form-control" type="text" placeholder="Maintenance Type Name" id="new_mainten_name">
                            </div>
                        </div>
                        <div class="form-group text-right">
                            <button type="reset" class="btn btn-primary w-md m-b-5">Reset</button>
                            <button type="submit" class="btn btn-success w-md m-b-5">Save</button>
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
            <div class="card-header p-2">
                <h4 class="pl-3">
                    Maintenance Types
                    <small class="float-right">
                        <button type="button" class="btn btn-primary btn-md" data-target="#add0" data-toggle="modal">
                            <i class="ti-plus" aria-hidden="true"></i>
                            Add Maintenance Type
                        </button>
                    </small>
                </h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="maintenanceTypesTable" class="table display table-bordered table-striped table-hover ">
                        <thead>
                            <tr>
                                <th>Sl No.</th>
                                <th>Maintenance Type Name</th>
                                <th>Action(s)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($maintenanceTypes as $maintenanceType)
                            <tr>
                                <td> {{$loop->iteration}} </td>
                                <td> {{$maintenanceType['MAINTENANCE_NAME']}} </td>
                                <td>
                                    <button class="btn btn-info mr-1" title="Edit" data-id="{{$maintenanceType['MAINTENANCE_ID']}}" data-name="{{$maintenanceType['MAINTENANCE_NAME']}}" onclick="editInfo(this)">
                                        <i class="ti-pencil"></i>
                                    </button>
                                    @if($maintenanceType['IS_ACTIVE'] == 'Y')
                                    <button class="btn btn-danger mr-1" title="Deactivate" data-id="{{$maintenanceType['MAINTENANCE_ID']}}" onclick="updateStatus(this);">
                                        <i class="ti-close"></i>
                                    </button>
                                    @else
                                    <button class="btn btn-success mr-1" title="Activate" data-id="{{$maintenanceType['MAINTENANCE_ID']}}" onclick="updateStatus(this);">
                                        <i class="ti-reload"></i>
                                    </button>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            <!-- <tr>
                                <td>1</td>
                                <td>Repair</td>
                                <td>
                                    <input name="url" type="hidden" id="url_1" value="https://vmsdemo.bdtask-demo.com/setting/Setting/updatemtypefrm" />
                                    <a onclick="editinfo(1)" class="btn btn-xs btn-success btn-sm mr-1 text-white" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                    <a href="https://vmsdemo.bdtask-demo.com/setting/Setting/delete_mtype/1" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Servicing</td>
                                <td>
                                    <input name="url" type="hidden" id="url_1" value="https://vmsdemo.bdtask-demo.com/setting/Setting/updatemtypefrm" />
                                    <a onclick="editinfo(1)" class="btn btn-xs btn-success btn-sm mr-1 text-white" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                    <a href="https://vmsdemo.bdtask-demo.com/setting/Setting/delete_mtype/2" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                </td>
                            </tr> -->
                        </tbody>
                    </table> <!-- /.table-responsive -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <script src="{{asset('dist/js/mtype_list.js')}}"></script> -->
@endsection

@section('js-content')
<script>
    $(document).ready(function() {
        let maintenanceTypesTable = $("#maintenanceTypesTable").DataTable();

        // To add serial numbers in data table on adding new item
        maintenanceTypesTable.on('draw.dt', function() {
            var PageInfo = $('#maintenanceTypesTable').DataTable().page.info();
            maintenanceTypesTable.column(0, {
                page: 'current'
            }).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1 + PageInfo.start;
            });
        });

        // Validate and submit Add Maintenance Types Form
        $("#addMaintenanceTypeForm").validate({
            rules: {
                mainten_name: {
                    required: true,
                    minlength: 2,
                    maxlength: 100
                }
            },
            submitHandler: function(form, ev) {
                ev.preventDefault();
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function(res) {
                        if (res.successCode == 1) {
                            toastr.success(res.message, '', {
                                closeButton: true
                            });

                            $("#add0").modal('hide');
                            // Add row to table
                            let actionBtns = '<button type="button" class="btn btn-info mr-1" title="Edit" data-name="' + res.data.MAINTENANCE_NAME + '" data-id="' + res.data.MAINTENANCE_ID + '" onclick="editInfo(this)"><i class="ti-pencil"></i></button>';
                            actionBtns += ' <button type="button" class="btn btn-danger mr-1" title="Deactivate" data-id="' + res.data.MAINTENANCE_ID + '" onclick="updateStatus(this)"><i class="ti-close"></i></button>';
                            maintenanceTypesTable.row.add(['', res.data.MAINTENANCE_NAME, actionBtns]).draw();
                        } else {
                            toastr.error(res.message, '', {
                                closeButton: true
                            });
                        }
                    },
                    error: function(jqXHR, textStatus, err) {
                        toastr.error('Error adding maintenance type. Please try again', '', {
                            closeButton: true
                        });
                    }
                });
            }
        });

        // On closing Add Maintenance Form Modal, reset form and remove validation mesages
        $("#add0").on('hidden.bs.modal', function() {
            $("#addMaintenanceTypeForm").trigger('reset');
            $("#addMaintenanceTypeForm").validate().resetForm();
            $("#mainten_name").removeClass('error');
            $("#mainten_name").removeAttr('aria-invalid');
        });

        // Validate and Submit Edit Maintenance Type Form
        $("#editMaintenanceTypeForm").validate({
            rules: {
                mainten_name: {
                    required: true,
                    minlength: 2,
                    maxlength: 100
                }
            },
            submitHandler: function(form, ev) {
                ev.preventDefault();
                let maintenanceTypeId = $("#maintenanceTypeId").val();

                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function(res) {
                        if (res.successCode == 1) {
                            toastr.success(res.message, '', {
                                closeButton: true
                            });

                            $("#edit").modal('hide');
                            // Update data from resonse in table
                            let targetBtn = $("#maintenanceTypesTable").find('button[data-id=' + maintenanceTypeId + ']');
                            targetBtn.closest('td').prev().html(res.data.MAINTENANCE_NAME);
                            targetBtn.data('name', res.data.MAINTENANCE_NAME);
                        } else {
                            toastr.error(res.message, '', {
                                closeButton: true
                            });
                        }
                    },
                    error: function(jqXHR, status, err) {
                        toastr.error("Error updating. Please try again", '', {
                            closeButton: true
                        });
                    }
                });
            }
        });

        // On closing Edit Maintenance Form Modal, reset form and remove validation mesages
        $("#edit").on('hidden.bs.modal', function() {
            $("#editMaintenanceTypeForm").trigger('reset');
            $("#editMaintenanceTypeForm").validate().resetForm();
            $("#new_mainten_name").removeClass('error');
            $("#new_mainten_name").removeAttr('aria-invalid');
        });

    });
</script>

<script>
    function editInfo(el) {
        // el has been passed 'this' to get data-* attributes of clicked button
        // Set initial form details using button's data attributes set while loading/reloading table
        $("#maintenanceTypeId").val($(el).data('id'));
        $("#new_mainten_name").val($(el).data('name'));
        $("#edit").modal('show');
    }

    function updateStatus(el) {
        // el has been passed this (clicked button)
        let maintenanceTypeId = $(el).data('id');

        toastr.warning("<br /><button type='button' class='btn btn-success mr-2' value='yes'>Yes</button><button class='btn btn-danger' type='button' value='no' >No</button>", 'Are you sure?', {
            allowHtml: true,
            onclick: function(toast) {
                value = toast.target.value
                if (value == 'yes') {
                    var url = "{{ route('maintenance-types.update-status') }}";

                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            mainten_id: maintenanceTypeId
                        },
                        success: function(response) {
                            toastr.remove();

                            if (response['IS_ACTIVE'] == 'Y') {
                                $(el).removeClass('btn-success').addClass('btn-danger');
                                $(el).html('<i class="ti-close"></i>');
                                $(el).attr('title', 'Deactivate');

                            } else {
                                $(el).removeClass('btn-danger').addClass('btn-success');
                                $(el).html('<i class="ti-reload"></i>');
                                $(el).attr('title', 'Activate');
                            }

                            toastr.success('Status Updated', '', {
                                closeButton: true
                            });
                        }
                    });

                } else {
                    toastr.remove();
                }
            }
        });
    }
</script>
@endsection