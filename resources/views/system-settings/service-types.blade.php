@extends('layouts.main.app')

@section('title', 'Service Types')

@section('breadcrumb-content')
<li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
<li class="breadcrumb-item active" id="moduleName">System Settings</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">System Settings</h1>
<small id="controllerName">Service Types</small>
@endsection

@section('content')

<div id="add0" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Add Service Type</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{route('service-types.add')}}" id="addServiceTypeForm" class="row" method="post" accept-charset="utf-8">
                    @csrf
                    <div class="col-md-12 col-lg-12">
                        <div class="form-group row">
                            <label for="service_type_name" class="col-sm-5 col-form-label">Service Type Name <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="service_type_name" required class="form-control" type="text" placeholder="Service Type Name" id="service_type_name">
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
                <strong>Update Service Type</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body editinfo">
                <form action="{{route('service-types.update')}}" id="editServiceTypeForm" class="row" method="post" accept-charset="utf-8">
                    @csrf
                    <input type="hidden" name="service_id" id="serviceTypeId">
                    <div class="col-md-12 col-lg-12">
                        <div class="form-group row">
                            <label for="new_service_type_name" class="col-sm-5 col-form-label">Service Type Name <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="service_type_name" required class="form-control" type="text" placeholder="Service Type Name" id="new_service_type_name">
                            </div>
                        </div>
                        <div class="form-group text-right">
                            <button type="reset" class="btn btn-primary w-md m-b-5" id="resetEditFormBtn">Reset</button>
                            <button type="submit" class="btn btn-success w-md m-b-5">Update</button>
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
                <h4 class="pl-3">Service Types
                    <small class="float-right">
                        <button type="button" class="btn btn-primary btn-md" data-target="#add0" data-toggle="modal">
                            <i class="ti-plus" aria-hidden="true"></i>
                            Add Service Type
                        </button>
                    </small>
                </h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="vehicleServiceTypesTable" class="table display table-bordered table-striped table-hover ">
                        <thead>
                            <tr>
                                <th>Sl No.</th>
                                <th>Service Type</th>
                                <th>Action(s)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($services as $service)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td> {{$service['SERVICE_NAME']}} </td>
                                <td>
                                    <button class="btn btn-info mr-1" data-id="{{$service['SERVICE_ID']}}" data-name="{{$service['SERVICE_NAME']}}" onclick="editInfo(this)" title="Edit">
                                        <i class="ti-pencil"></i>
                                    </button>
                                    @if($service['IS_ACTIVE'] == 'Y')
                                    <button class="btn btn-danger mr-1" data-id="{{$service['SERVICE_ID']}}" onclick="updateStatus(this)" title="Deactivate">
                                        <i class="ti-trash"></i>
                                    </button>
                                    @else
                                    <button class="btn btn-success mr-1" data-id="{{$service['SERVICE_ID']}}" onclick="updateStatus(this)" title="Activate">
                                        <i class="ti-reload"></i>
                                    </button>
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
@endsection
@section('js-content')
<!-- <script src="{{asset('dist/js/service_list.js')}}"></script> -->
<script>
    $(document).ready(function() {
        let servicesTable = $("#vehicleServiceTypesTable").DataTable();

        // To add serial numbers in data table on adding new item
        servicesTable.on('draw.dt', function() {
            var PageInfo = $('#vehicleServiceTypesTable').DataTable().page.info();
            servicesTable.column(0, {
                page: 'current'
            }).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1 + PageInfo.start;
            });
        });

        // Validate and submit add vehicle service type form
        $("#addServiceTypeForm").validate({
            rules: {
                service_type_name: {
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
                            let actionBtns = '<button type="button" class="btn btn-info mr-1" title="Edit" data-name="' + res.data.SERVICE_NAME + '" data-id="' + res.data.SERVICE_ID + '" onclick="editInfo(this)"><i class="ti-pencil"></i></button>';
                            actionBtns += ' <button type="button" class="btn btn-danger mr-1" title="Deactivate" data-id="' + res.data.SERVICE_ID + '" onclick="updateStatus(this)"><i class="ti-trash"></i></button>';
                            servicesTable.row.add(['', res.data.SERVICE_NAME, actionBtns]).draw();
                        } else {
                            toastr.error(res.message, '', {
                                closeButton: true
                            });
                        }
                    },
                    error: function(jqXHR, textStatus, err) {
                        toastr.error("Error adding vehicle service. Please try again", '', {
                            closeButton: true
                        });
                    }
                });
            }
        });

        // On closing add service type modal, rest form and remove validation messages
        $("#add0").on('hidden.bs.modal', function(ev) {
            $("#addServiceTypeForm").trigger('reset');
            $("#addServiceTypeForm").validate().resetForm();
            $("#service_type_name").removeClass('error').removeAttr('aria-invalid');
        });

        // On resetting add Service Type form
        $("#resetAddFormBtn").click(function() {
            $("#addServiceTypeForm").trigger('reset');
            $("#addServiceTypeForm").validate().resetForm();
            $("#service_type_name").removeClass('error').removeAttr('aria-invalid');
        });

        // Validate and submit Edit Service Type Form
        $("#editServiceTypeForm").validate({
            rules: {
                service_type_name: {
                    required: true,
                    minlength: 2,
                    maxlength: 100
                },
            },
            submitHandler: function(form, ev) {
                ev.preventDefault();
                // Get ID to use for updating name in table 
                let serviceId = $(form).find("#serviceTypeId").val();

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
                            let targetBtn = $("#vehicleServiceTypesTable").find('button[data-id=' + serviceId + ']');
                            targetBtn.closest('td').prev().html(res.data.SERVICE_NAME);
                            targetBtn.data('name', res.data.SERVICE_NAME);

                        } else {
                            toastr.error(res.message, '', {
                                closeButton: true
                            });
                        }
                    },
                    error: function(jqXHR, textStatus, err) {
                        toastr.error("Error updating service type. Please try again", "", {
                            closebutton: true
                        });
                    }
                });
            }
        });

        // On closing edit service type modal, reset form and remove validation messages
        $("#edit").on('hidden.bs.modal', function(ev) {
            $("#editServiceTypeForm").trigger('reset');
            $("#editServiceTypeForm").validate().resetForm();
            $("#new_service_type_name").removeClass('error').removeAttr('aria-invalid');
        });

        // On resetting edit service form
        $("#resetEditFormBtn").click(function() {
            setTimeout(() => {
                $("#new_service_type_name").valid();
            }, 10);
        });

    });
</script>

<script>
    function editInfo(el) {
        // Set Initial Form Details using el button's data attributes
        $("#serviceTypeId").val($(el).data('id'));
        $("#new_service_type_name").attr('value', $(el).data('name'));
        $("#edit").modal('show');
    }

    function updateStatus(el) {
        let serviceId = $(el).data('id');

        toastr.warning("<br /><button type='button' class='btn btn-success mr-2' value='yes'>Yes</button><button class='btn btn-danger' type='button' value='no' >No</button>", 'Are you sure?', {
            allowHtml: true,
            onclick: function(toast) {
                value = toast.target.value;
                if (value == 'yes') {
                    var url = "{{ route('service-types.update-status') }}";

                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            service_id: serviceId
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