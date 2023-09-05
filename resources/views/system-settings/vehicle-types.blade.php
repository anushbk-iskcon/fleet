@extends('layouts.main.app')

@section('title', 'Vehicle Types')

@section('breadcrumb-content')
<li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
<li class="breadcrumb-item active" id="moduleName">System Settings</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">System Settings</h1>
<small id="controllerName">Manage Vehicle Types</small>
@endsection

@section('content')

<div id="add0" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Add Vehicle Type</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{route('vehicle-type.add')}}" id="addVehicleTypeForm" class="row" method="post" accept-charset="utf-8">
                    @csrf
                    <div class="col-md-12 col-lg-12">
                        <div class="form-group row">
                            <label for="vehicletype_name" class="col-sm-5 col-form-label">Vehicle Type Name <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="vehicletype_name" required class="form-control" type="text" placeholder="Vehicle Type Name" id="vehicletype_name">
                            </div>
                        </div>
                        <div class="form-group text-right">
                            <button type="reset" class="btn btn-primary w-md m-b-5" id="resetAddFormBtn">Reset</button>
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
                <strong>Update Vehicle Type</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body editinfo">
                <form action="{{route('vehicle-type.update')}}" id="editVehicleTypeForm" class="row" method="post" accept-charset="utf-8">
                    @csrf
                    <input type="hidden" name="vehicle_type_id" id="updateVehicleTypeId">
                    <div class="col-md-12 col-lg-12">
                        <div class="form-group row">
                            <label for="newVehicleTypeName" class="col-sm-5 col-form-label">Vehicle Type Name <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="new_vehicletype_name" required class="form-control" type="text" placeholder="Vehicle Type Name" id="newVehicleTypeName">
                            </div>
                        </div>
                        <div class="form-group text-right">
                            <button type="reset" class="btn btn-primary w-md m-b-5" id="resetEditFormBtn">Clear</button>
                            <button type="submit" class="btn btn-success w-md m-b-5">Update</button>
                        </div>
                    </div>

                </form>
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
                <h4 class="pl-3">Vehicle Type<small class="float-right">

                        <button type="button" class="btn btn-primary btn-md" data-target="#add0" data-toggle="modal"><i class="ti-plus" aria-hidden="true"></i>
                            Add Vehicle Type</button>
                    </small></h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example_vehicletype" class="table display table-bordered table-striped table-hover ">
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>Vehicle Type Name</th>
                                <th>Action(s)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($vehicleTypes as $vehicleType)
                            <tr>
                                <td>
                                    {{$loop->iteration}}
                                </td>
                                <td>
                                    {{$vehicleType['VEHICLE_TYPE_NAME']}}
                                </td>
                                <td>
                                    <button type="button" class="btn btn-info" data-id="{{$vehicleType['VEHICLE_TYPE_ID']}}" data-name="{{$vehicleType['VEHICLE_TYPE_NAME']}}" title="Edit" onclick="editInfo(this)">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    @if($vehicleType['IS_ACTIVE'] == 'Y')
                                    <button type="button" class="btn btn-danger" title="Deactivate" data-id="{{$vehicleType['VEHICLE_TYPE_ID']}}" onclick="updateStatus(this)"><i class="ti-close"></i></button>
                                    @else
                                    <button type="button" class="btn btn-success" title="Activate" data-id="{{$vehicleType['VEHICLE_TYPE_ID']}}" onclick="updateStatus(this)"><i class="ti-reload"></i></button>
                                    @endif
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table> <!-- /.table-responsive -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <script src="{{asset('dist/js/vehicletype_list.js')}}"></script> -->
<script>
    $(document).ready(function() {
        let vehicleTypesTable = $("#example_vehicletype").DataTable();

        // To add serial numbers in data table on adding new item
        vehicleTypesTable.on('draw.dt', function() {
            var PageInfo = $('#example_vehicletype').DataTable().page.info();
            vehicleTypesTable.column(0, {
                page: 'current'
            }).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1 + PageInfo.start;
            });
        });

        $("#addVehicleTypeForm").validate({
            rules: {
                vehicletype_name: {
                    required: true,
                    minlength: 2,
                    maxlength: 100
                }
            },
            submitHandler: function(form, ev) {
                ev.preventDefault();
                $.ajax({
                    url: form.action,
                    method: form.method,
                    data: $(form).serialize(),
                    success: function(res) {
                        if (res.successCode == 1) {
                            toastr.success(res.message, '', {
                                closeButton: true
                            });

                            $("#add0").modal('hide');
                            let actionBtns = '<button type="button" class="btn btn-info" title="Edit" data-name="' + res.vehicleType.VEHICLE_TYPE_NAME + '" data-id="' + res.vehicleType.VEHICLE_TYPE_ID + '" onclick="editInfo(this)"><i class="fa fa-edit"></i></button>';
                            actionBtns += ' <button type="button" class="btn btn-danger" title="Deactivate" data-id="' + res.vehicleType.VEHICLE_TYPE_ID + '" onclick="updateStatus(this)"><i class="ti-close"></i></button>';
                            vehicleTypesTable.row.add(['', res.vehicleType.VEHICLE_TYPE_NAME, actionBtns]).draw();
                        } else {
                            toastr.error(res.message, '', {
                                closeButton: true
                            });
                        }
                    },
                    error: function(jqXHR, textStatus, err) {
                        toastr.error("Error adding vehicle type. Please try again", '', {
                            closeButton: true
                        });
                    }
                });
            }
        });

        $("#editVehicleTypeForm").validate({
            rules: {
                new_vehicletype_name: {
                    required: true,
                    minlength: 2,
                    maxlength: 100
                }
            },
            submitHandler: function(form, ev) {
                ev.preventDefault();
                let vehicleTypeId = $(form).find("#updateVehicleTypeId").val();
                console.log(vehicleTypeId);
                $.ajax({
                    url: form.action,
                    method: form.method,
                    data: $(form).serialize(),
                    success: function(res) {
                        if (res.successCode == 1) {
                            toastr.success(res.message, '', {
                                closeButton: true
                            });

                            console.log(res);
                            $("#edit").modal('hide');
                            let targetBtn = $("#example_vehicletype").find('button[data-id=' + vehicleTypeId + ']');

                            targetBtn.closest('td').prev().html(res.vehicleType.VEHICLE_TYPE_NAME);
                            targetBtn.data('name', res.vehicleType.VEHICLE_TYPE_NAME);
                        } else {
                            toastr.error(res.message, '', {
                                closeButton: true
                            });
                        }
                    },
                    error: function(jqXHR, textStatus, err) {
                        toastr.error("Error updating. Please try again", '', {
                            closeButton: true
                        });
                    }
                });
            }
        });

        // Remove validations, errors and reset add vehicle type form on closing modal
        $("#add0").on('hidden.bs.modal', function(ev) {
            $("#addVehicleTypeForm").trigger('reset');
            $("#addVehicleTypeForm").validate().resetForm();
            $("#vehicletype_name").removeClass('error').removeAttr('aria-invalid');
        });

        // On resetting add vehice type form
        $("#resetAddFormBtn").click(function() {
            $("#addVehicleTypeForm").trigger('reset');
            $("#addVehicleTypeForm").validate().resetForm();
            $("#vehicletype_name").removeClass('error').removeAttr('aria-invalid');
        });

        // Remove validations, errors and reset add vehicle type form on closing modal
        $("#edit").on('hidden.bs.modal', function(ev) {
            $("#editVehicleTypeForm").trigger('reset');
            $("#editVehicleTypeForm").validate().resetForm();
            $("#newVehicleTypeName").removeClass('error');
            $("#newVehicleTypeName").removeAttr('aria-invalid');
        });

        // On resetting Edit Vehicle Type Modal
        $("#resetEditFromBtn").click(function() {
            setTimeout(() => {
                $("#newVehicleTypeName").valid();
            }, 10);
        });

    });
</script>

<script>
    function editInfo(el) {
        $("#updateVehicleTypeId").val($(el).data('id'));
        $("#newVehicleTypeName").attr('value', $(el).data('name'));
        $("#edit").modal('show');
    }

    function updateStatus(el) {
        let vehicleTypeId = $(el).data('id');

        toastr.warning("<br /><button type='button' class='btn btn-success mr-2' value='yes'>Yes</button><button class='btn btn-danger' type='button' value='no' >No</button>", 'Are you sure?', {
            allowHtml: true,
            onclick: function(toast) {
                value = toast.target.value
                if (value == 'yes') {
                    var url = "{{ route('vehicle-type.status-update') }}";

                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            vehicle_type_id: vehicleTypeId
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