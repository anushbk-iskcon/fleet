@extends('layouts.main.app')

@section('title', 'Divisions')

@section('css-content')
<style>
    .action-btns-container {
        display: flex;
        flex-wrap: nowrap;
        justify-content: flex-end;
        gap: 20px;
    }

    #example_division tr td:last-child .btn {
        margin-right: 20px !important;
    }
</style>
@endsection

@section('breadcrumb-content')
<li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
<li class="breadcrumb-item active" id="moduleName">System Settings</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">System Settings</h1>
<small id="controllerName">Divisions</small>
@endsection

@section('content')

<div id="add0" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Add Division</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{route('divisions.add')}}" id="addDivisionForm" class="row" method="post" accept-charset="utf-8">
                    @csrf
                    <div class="col-md-12 col-lg-12">
                        <div class="form-group row">
                            <label for="division_name" class="col-sm-5 col-form-label">Division Name <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="division_name" required required class="form-control" type="text" placeholder="Division Name" id="division_name">
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
                <strong>Division Update </strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body editinfo">
                <form action="{{route('divisions.update')}}" id="editDivisionForm" class="row" method="post" accept-charset="utf-8">
                    @csrf
                    <input type="hidden" name="division_id" id="divisionId" value="">
                    <div class="col-md-12 col-lg-12">
                        <div class="form-group row">
                            <label for="new_division_name" class="col-sm-5 col-form-label">Division Name <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="new_division_name" required required class="form-control" type="text" placeholder="Division Name" id="new_division_name">
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
        <div class="modal-footer">

        </div>

    </div>

</div>

<div class="row">
    <div class="col-sm-12">
        <div class="card mb-3">
            <div class="card-header p-2">
                <h4 class="pl-3">
                    Division
                    <small class="float-right">
                        <button type="button" class="btn btn-primary btn-md" data-target="#add0" data-toggle="modal"><i class="ti-plus" aria-hidden="true"></i>
                            Add Division
                        </button>
                    </small>
                </h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example_division" class="table table-striped table-bordered dt-responsive nowrap">
                        <thead>
                            <tr>
                                <th>Sl No</th>
                                <th>Division Name</th>
                                <th>Action(s)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($vehicleDivisions as $vehicleDivision)
                            <tr>
                                <td>
                                    {{$loop->iteration}}
                                </td>
                                <td>
                                    {{$vehicleDivision['VEHICLE_DIVISION_NAME']}}
                                </td>
                                <td>
                                    <button type="button" class="btn btn-info" data-id="{{$vehicleDivision['VEHICLE_DIVISION_ID']}}" data-name="{{$vehicleDivision['VEHICLE_DIVISION_NAME']}}" title="Edit" onclick="editInfo(this)">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    @if($vehicleDivision['IS_ACTIVE'] == 'Y')
                                    <button type="button" class="btn btn-danger" title="Deactivate" data-id="{{$vehicleDivision['VEHICLE_DIVISION_ID']}}" onclick="updateStatus(this)"><i class="ti-close"></i></button>
                                    @else
                                    <button type="button" class="btn btn-success" title="Activate" data-id="{{$vehicleDivision['VEHICLE_DIVISION_ID']}}" onclick="updateStatus(this)"><i class="ti-reload"></i></button>
                                    @endif
                                </td>
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
<!-- <script src="{{asset('dist/js/division_list.js')}}"></script> -->
<script>
    $(document).ready(function() {
        let divisionsTable = $("#example_division").DataTable({
            "columnDefs": [{
                    "width": "140px",
                    "targets": 0
                },
                {
                    "orderable": false,
                    "width": "160px",
                    "className": "text-center",
                    "targets": 2
                }
            ],
            "autoWidth": false
        });

        // To add serial numbers in data table on adding new item
        divisionsTable.on('draw.dt', function() {
            var PageInfo = $('#example_division').DataTable().page.info();
            divisionsTable.column(0, {
                page: 'current'
            }).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1 + PageInfo.start;
            });
        });


        $("#addDivisionForm").validate({
            rules: {
                division_name: {
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
                            let actionBtns = '<button type="button" class="btn btn-info" title="Edit" data-name="' + res.data.VEHICLE_DIVISION_NAME + '" data-id="' + res.data.VEHICLE_DIVISION_ID + '" onclick="editInfo(this)"><i class="fa fa-edit"></i></button>';
                            actionBtns += ' <button type="button" class="btn btn-danger" title="Deactivate" data-id="' + res.data.VEHICLE_DIVISION_ID + '" onclick="updateStatus(this)"><i class="ti-close"></i></button>';
                            divisionsTable.row.add(['', res.data.VEHICLE_DIVISION_NAME, actionBtns]).draw();
                        } else {
                            toastr.error(res.message, '', {
                                closeButton: true
                            });
                        }
                    },
                    error: function(jqXHR, textStatus, err) {
                        toastr.error("Error adding divison. Please try again", '', {
                            closeButton: true
                        });
                    }
                });
            }
        });

        $("#editDivisionForm").validate({
            rules: {
                new_division_name: {
                    required: true,
                    minlength: 2,
                    maxlength: 100
                }
            },
            submitHandler: function(form, ev) {
                ev.preventDefault();
                let divisionId = $(form).find("#divisionId").val();

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
                            let targetBtn = $("#example_division").find('button[data-id=' + divisionId + ']');
                            console.log(targetBtn);
                            targetBtn.closest('td').prev().html(res.data.VEHICLE_DIVISION_NAME);
                            targetBtn.data('name', res.data.VEHICLE_DIVISION_NAME);
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

        // Remove validations, errors and reset add vehicle divison form on closing modal
        $("#add0").on('hidden.bs.modal', function(ev) {
            $("#addDivisionForm").trigger('reset');
            $("#addDivisionForm").validate().resetForm();
            $("#division_name").removeClass('error');
            $("#division_name").removeAttr('aria-invalid');
        });

        // Remove vlaidation mesages on resetting add vehcile division form
        $("#resetAddFormBtn").click(function() {
            $("#addDivisionForm").trigger('reset');
            $("#addDivisionForm").validate().resetForm();
            $("#division_name").removeClass('error');
            $("#division_name").removeAttr('aria-invalid');
        })

        // Remove validations, errors and reset add vehicle division form on closing modal
        $("#edit").on('hidden.bs.modal', function(ev) {
            $("#editDivisionForm").trigger('reset');
            $("#editDivisionForm").validate().resetForm();
            $("#new_division_name").removeClass('error');
            $("#new_division_name").removeAttr('aria-invalid');
        });

        // On resetting Edit Vehcile Divison form
        $("#resetEditFormBtn").click(function() {
            setTimeout(() => {
                $("#new_division_name").valid();
            }, 10);
        })

    });
</script>

<script>
    function editInfo(el) {
        $("#divisionId").val($(el).data('id'));
        $("#new_division_name").attr('value', $(el).data('name'));
        $("#edit").modal('show');
    }

    function updateStatus(el) {
        let divisionId = $(el).data('id');

        toastr.warning("<br /><button type='button' class='btn btn-success mr-2' value='yes'>Yes</button><button class='btn btn-danger' type='button' value='no' >No</button>", 'Are you sure?', {
            allowHtml: true,
            onclick: function(toast) {
                value = toast.target.value;
                if (value == 'yes') {
                    var url = "{{ route('divisions.status-update') }}";

                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            division_id: divisionId
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