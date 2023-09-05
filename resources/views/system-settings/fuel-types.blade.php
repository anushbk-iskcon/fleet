@extends('layouts.main.app')

@section('title', 'Fuel Types')

@section('breadcrumb-content')
<li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
<li class="breadcrumb-item active" id="moduleName">System Settings</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">System Settings</h1>
<small id="controllerName">Fuel Types</small>
@endsection

@section('content')

<div id="add0" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Add Fuel Type</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{route('fuel-types.add')}}" id="addFuelTypeForm" class="row" method="post" accept-charset="utf-8">
                    @csrf
                    <div class="col-md-12 col-lg-12">
                        <div class="form-group row">
                            <label for="fuel_type_name" class="col-sm-5 col-form-label">Fuel Type Name <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="fuel_type_name" required class="form-control" type="text" placeholder="Fuel Type Name" id="fuel_type_name">
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
                <strong>Update Fuel Type</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body editinfo">
                <form action="{{route('fuel-types.update')}}" id="editFuelTypeForm" class="row" method="post" accept-charset="utf-8">
                    @csrf
                    <input type="hidden" name="fuel_type_id" id="fuelTypeId">
                    <div class="col-md-12 col-lg-12">
                        <div class="form-group row">
                            <label for="new_fuel_type_name" class="col-sm-5 col-form-label">Fuel Type Name <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="fuel_type_name" required class="form-control" type="text" placeholder="Fuel Type Name" id="new_fuel_type_name">
                            </div>
                        </div>
                        <div class="form-group text-right">
                            <button type="reset" class="btn btn-primary w-md m-b-5" id="resetEditFormBtn">Reset</button>
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
                    Fuel Types
                    <small class="float-right">
                        <button type="button" class="btn btn-primary btn-md" data-target="#add0" data-toggle="modal"><i class="ti-plus" aria-hidden="true"></i>
                            Add Fuel Type
                        </button>
                    </small>
                </h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="fuelTypeTable" class="table display table-bordered table-striped table-hover ">
                        <thead>
                            <tr>
                                <th>Sl No.</th>
                                <th>Fuel Type</th>
                                <th>Action(s)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($fuelTypes as $fuelType)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$fuelType['FUEL_TYPE_NAME']}}</td>
                                <td>
                                    <button class="btn btn-info mr-1" data-id="{{$fuelType['FUEL_ID']}}" data-name="{{$fuelType['FUEL_TYPE_NAME']}}" title="Edit" onclick="editInfo(this)"><i class="fa fa-edit"></i></button>
                                    @if($fuelType['IS_ACTIVE'] == 'Y')
                                    <button class="btn btn-danger mr-1" data-id="{{$fuelType['FUEL_ID']}}" title="Deactivate" onclick="updateStatus(this)"><i class="ti-close"></i></button>
                                    @else
                                    <button class="btn btn-success mr-1" data-id="{{$fuelType['FUEL_ID']}}" title="Activate" onclick="updateStatus(this)"><i class="ti-reload"></i></button>
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
<!-- <script src="{{asset('dist/js/fueltype_list.js')}}"></script> -->
<script>
    $(document).ready(function() {
        let fuelTypesTable = $("#fuelTypeTable").DataTable();

        // To add serial numbers in data table on adding new item
        fuelTypesTable.on('draw.dt', function() {
            var PageInfo = $('#fuelTypeTable').DataTable().page.info();
            fuelTypesTable.column(0, {
                page: 'current'
            }).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1 + PageInfo.start;
            });
        });

        // Validate and submit Add Fuel Type Form
        $("#addFuelTypeForm").validate({
            rules: {
                fuel_type_name: {
                    required: true,
                    minlength: 2,
                    maxlength: 100
                },
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
                            let actionBtns = '<button type="button" class="btn btn-info mr-1" title="Edit" data-name="' + res.data.FUEL_TYPE_NAME + '" data-id="' + res.data.FUEL_ID + '" onclick="editInfo(this)"><i class="fa fa-edit"></i></button>';
                            actionBtns += ' <button type="button" class="btn btn-danger mr-1" title="Deactivate" data-id="' + res.data.FUEL_ID + '" onclick="updateStatus(this)"><i class="ti-close"></i></button>';
                            fuelTypesTable.row.add(['', res.data.FUEL_TYPE_NAME, actionBtns]).draw();
                        } else {
                            toastr.error(res.message, '', {
                                closeButton: true
                            });
                        }
                    },
                    error: function(jqXHR, textStatus, err) {
                        toastr.error("Error adding fuel type. Please try again", "", {
                            closebutton: true
                        });
                    }
                });
            }
        });

        // On closing add fuel type modal, rest form and remove validation messages
        $("#add0").on('hidden.bs.modal', function(ev) {
            $("#addFuelTypeForm").trigger('reset');
            $("#addFuelTypeForm").validate().resetForm();
            $("#fuel_type_name").removeClass('error').removeAttr('aria-invalid');
        });

        // On resetting Add Fuel Type Form
        $("#resetAddFormBtn").click(function() {
            $("#addFuelTypeForm").trigger('reset');
            $("#addFuelTypeForm").validate().resetForm();
            $("#fuel_type_name").removeClass('error').removeAttr('aria-invalid');
        });

        // Validate and submit Update Fuel Type Form
        $("#editFuelTypeForm").validate({
            rules: {
                fuel_type_name: {
                    required: true,
                    minlength: 2,
                    maxlength: 100
                },
            },
            submitHandler: function(form, ev) {
                ev.preventDefault();
                // Get ID to use for updating name in table 
                let fuelTypeId = $(form).find("#fuelTypeId").val();

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
                            let targetBtn = $("#fuelTypeTable").find('button[data-id=' + fuelTypeId + ']');
                            targetBtn.closest('td').prev().html(res.data.FUEL_TYPE_NAME);
                            targetBtn.data('name', res.data.FUEL_TYPE_NAME);

                        } else {
                            toastr.error(res.message, '', {
                                closeButton: true
                            });
                        }
                    },
                    error: function(jqXHR, textStatus, err) {
                        toastr.error("Error adding fuel type. Please try again", "", {
                            closebutton: true
                        });
                    }
                });
            }
        });

        // On closing edit fuel type modal, rest form and remove validation messages
        $("#edit").on('hidden.bs.modal', function(ev) {
            $("#editFuelTypeForm").trigger('reset');
            $("#editFuelTypeForm").validate().resetForm();
            $("#new_fuel_type_name").removeClass('error').removeAttr('aria-invalid');
        });

        // On resetting edit fuel type form
        $("#resetEditFormBtn").click(function() {
            setTimeout(() => {
                $("#new_fuel_type_name").valid();
            }, 10);
        });

    });
</script>

<script>
    function editInfo(el) {
        // Set Initial Form Details using el button's data attributes
        $("#fuelTypeId").val($(el).data('id'));
        $("#new_fuel_type_name").attr('value', $(el).data('name'));
        $("#edit").modal('show');
    }

    function updateStatus(el) {
        let fuelTypeId = $(el).data('id');

        toastr.warning("<br /><button type='button' class='btn btn-success mr-2' value='yes'>Yes</button><button class='btn btn-danger' type='button' value='no' >No</button>", 'Are you sure?', {
            allowHtml: true,
            onclick: function(toast) {
                value = toast.target.value;
                if (value == 'yes') {
                    var url = "{{ route('fuel-types.update-status') }}";

                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            fuel_id: fuelTypeId
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