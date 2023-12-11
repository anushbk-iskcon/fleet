@extends('layouts.main.app')

@section('title', 'Trip Types')

@section('css-content')
<style>
    .action-btns-container {
        display: flex;
        flex-wrap: nowrap;
        justify-content: flex-end;
        gap: 20px;
    }

    #tripTypesTable tr td:last-child .btn {
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
<small id="controllerName">Trip Types</small>
@endsection

@section('content')

<div id="add0" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Add Trip Type</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{route('trip-types.add')}}" id="addTripTypeForm" class="row" method="post" accept-charset="utf-8">
                    @csrf
                    <div class="col-md-12 col-lg-12">
                        <div class="form-group row">
                            <label for="trip_type_name" class="col-sm-5 col-form-label">Trip Type Name <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="trip_type_name" required class="form-control" type="text" placeholder="Trip Type Name" id="trip_type_name">
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
                <strong>Update Trip Type</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body editinfo">
                <form action="{{route('trip-types.update')}}" id="editTripTypeForm" class="row" method="post" accept-charset="utf-8">
                    @csrf
                    <input type="hidden" name="trip_type_id" id="tripTypeId">
                    <div class="col-md-12 col-lg-12">
                        <div class="form-group row">
                            <label for="trip_type_name" class="col-sm-5 col-form-label">Trip Type Name <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="trip_type_name" required class="form-control" type="text" placeholder="Trip Type Name" id="new_trip_type_name">
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
                <h4 class="pl-3">Trip Details
                    <small class="float-right">
                        <button type="button" class="btn btn-primary btn-md" data-target="#add0" data-toggle="modal">
                            <i class="ti-plus" aria-hidden="true"></i>
                            Add Trip Type
                        </button>
                    </small>
                </h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="tripTypesTable" class="table display table-bordered table-striped table-hover ">
                        <thead>
                            <tr>
                                <th>Sl No.</th>
                                <th>Trip Type</th>
                                <th>Action(s)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tripTypes as $tripType)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>
                                    {{$tripType['TRIP_NAME']}}
                                </td>
                                <td>
                                    <button class="btn btn-info mr-1" title="Edit" data-id="{{$tripType['TRIP_ID']}}" data-name="{{$tripType['TRIP_NAME']}}" onclick="editInfo(this)">
                                        <i class="ti-pencil"></i>
                                    </button>
                                    @if($tripType['IS_ACTIVE'] == 'Y')
                                    <button class="btn btn-danger mr-1" title="Deactivate" data-id="{{$tripType['TRIP_ID']}}" onclick="updateStatus(this)"><i class="ti-trash"></i></button>
                                    @else
                                    <button class="btn btn-success mr-1" title="Activate" data-id="{{$tripType['TRIP_ID']}}" onclick="updateStatus(this)"><i class="ti-reload"></i></button>
                                    @endif
                                </td>
                            </tr>
                            @endforeach

                            <!-- <tr>
                                <td>1</td>
                                <td>Own Single</td>
                                <td>
                                    <input name="url" type="hidden" id="url_1" value="https://vmsdemo.bdtask-demo.com/setting/Setting/updatetriptypefrm" />
                                    <a onclick="editinfo(1)" class="btn btn-xs btn-success btn-sm mr-1 text-white" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                    <a href="https://vmsdemo.bdtask-demo.com/setting/Setting/delete_triptype/1" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Own Double</td>
                                <td>
                                    <input name="url" type="hidden" id="url_2" value="https://vmsdemo.bdtask-demo.com/setting/Setting/updatetriptypefrm" />
                                    <a onclick="editinfo(2)" class="btn btn-xs btn-success btn-sm mr-1 text-white" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                    <a href="https://vmsdemo.bdtask-demo.com/setting/Setting/delete_triptype/2" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Hire Single</td>
                                <td>
                                    <input name="url" type="hidden" id="url_3" value="https://vmsdemo.bdtask-demo.com/setting/Setting/updatetriptypefrm" />
                                    <a onclick="editinfo(3)" class="btn btn-xs btn-success btn-sm mr-1 text-white" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                    <a href="https://vmsdemo.bdtask-demo.com/setting/Setting/delete_triptype/3" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>Hire Double</td>
                                <td>
                                    <input name="url" type="hidden" id="url_4" value="https://vmsdemo.bdtask-demo.com/setting/Setting/updatetriptypefrm" />
                                    <a onclick="editinfo(4)" class="btn btn-xs btn-success btn-sm mr-1 text-white" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                    <a href="https://vmsdemo.bdtask-demo.com/setting/Setting/delete_triptype/4" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>Rent Single</td>
                                <td>
                                    <input name="url" type="hidden" id="url_5" value="https://vmsdemo.bdtask-demo.com/setting/Setting/updatetriptypefrm" />
                                    <a onclick="editinfo(5)" class="btn btn-xs btn-success btn-sm mr-1 text-white" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                    <a href="https://vmsdemo.bdtask-demo.com/setting/Setting/delete_triptype/5" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td>Rent Double</td>
                                <td>
                                    <input name="url" type="hidden" id="url_6" value="https://vmsdemo.bdtask-demo.com/setting/Setting/updatetriptypefrm" />
                                    <a onclick="editinfo(6)" class="btn btn-xs btn-success btn-sm mr-1 text-white" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                    <a href="https://vmsdemo.bdtask-demo.com/setting/Setting/delete_triptype/6" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                </td>
                            </tr> -->
                        </tbody>
                    </table> <!-- /.table-responsive -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <script src="{{asset('dist/js/triptyper_list.js')}}"></script> -->
@endsection
@section('js-content')
<script>
    $(document).ready(function() {
        let tripTypesTable = $("#tripTypesTable").DataTable({
            "columnDefs": [{
                    "width": "160px",
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
        tripTypesTable.on('draw.dt', function() {
            var PageInfo = $('#tripTypesTable').DataTable().page.info();
            tripTypesTable.column(0, {
                page: 'current'
            }).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1 + PageInfo.start;
            });
        });

        // Validate and submit Add Trip Type form
        $("#addTripTypeForm").validate({
            rules: {
                trip_type_name: {
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
                            let actionBtns = '<button type="button" class="btn btn-info mr-1" title="Edit" data-name="' + res.data.TRIP_NAME + '" data-id="' + res.data.TRIP_ID + '" onclick="editInfo(this)"><i class="ti-pencil"></i></button>';
                            actionBtns += ' <button type="button" class="btn btn-danger mr-1" title="Deactivate" data-id="' + res.data.TRIP_ID + '" onclick="updateStatus(this)"><i class="ti-trash"></i></button>';
                            tripTypesTable.row.add(['', res.data.TRIP_NAME, actionBtns]).draw();
                        } else {
                            toastr.error(res.message, '', {
                                closeButton: true
                            });
                        }
                    },
                    error: function(jqXHR, textStatus, err) {
                        toastr.error("Error adding trip type. Please try again", '', {
                            closeButton: true
                        });
                    }
                });
            }
        });

        // On closing Add Trip type modal, rest form and remove validation messages
        $("#add0").on('hidden.bs.modal', function(ev) {
            $("#addTripTypeForm").trigger('reset');
            $("#addTripTypeForm").validate().resetForm();
            $("#trip_type_name").removeClass('error').removeAttr('aria-invalid');
        });

        // On resetting Add Trip Type Form
        $("#resetAddFormBtn").click(function() {
            $("#addTripTypeForm").trigger('reset');
            $("#addTripTypeForm").validate().resetForm();
            $("#trip_type_name").removeClass('error').removeAttr('aria-invalid');
        });

        // Validate and submit Edit Trip Type Form
        $("#editTripTypeForm").validate({
            rules: {
                trip_type_name: {
                    required: true,
                    minlength: 2,
                    maxlength: 100
                },
            },
            submitHandler: function(form, ev) {
                ev.preventDefault();
                // Get ID to use for updating name in table 
                let tripTypeId = $(form).find("#tripTypeId").val();

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
                            let targetBtn = $("#tripTypesTable").find('button[data-id=' + tripTypeId + ']');
                            targetBtn.closest('td').prev().html(res.data.TRIP_NAME);
                            targetBtn.data('name', res.data.TRIP_NAME);

                        } else {
                            toastr.error(res.message, '', {
                                closeButton: true
                            });
                        }
                    },
                    error: function(jqXHR, textStatus, err) {
                        toastr.error("Error updating trip type. Please try again", "", {
                            closebutton: true
                        });
                    }
                });
            }
        });

        // On closing edit trip type modal, reset form and remove validation messages
        $("#edit").on('hidden.bs.modal', function(ev) {
            $("#editTripTypeForm").trigger('reset');
            $("#editTripTypeForm").validate().resetForm();
            $("#new_trip_type_name").removeClass('error');
            $("#new_trip_type_name").removeAttr('aria-invalid');
        });

        $("#resetEditFormBtn").click(function() {
            setTimeout(() => {
                $("#new_trip_type_name").valid();
            }, 10);
        });


    });
</script>

<script>
    function editInfo(el) {
        // Set Initial Form Details using el button's data attributes
        $("#tripTypeId").val($(el).data('id'));
        $("#new_trip_type_name").attr('value', $(el).data('name'));
        $("#edit").modal('show');
    }

    function updateStatus(el) {
        let tripTypeId = $(el).data('id');

        toastr.warning("<br /><button type='button' class='btn btn-success mr-2' value='yes'>Yes</button><button class='btn btn-danger' type='button' value='no' >No</button>", 'Are you sure?', {
            allowHtml: true,
            onclick: function(toast) {
                value = toast.target.value;
                if (value == 'yes') {
                    var url = "{{ route('trip-types.update-status') }}";

                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            trip_type_id: tripTypeId
                        },
                        success: function(response) {
                            toastr.remove();

                            if (response['IS_ACTIVE'] == 'Y') {
                                $(el).removeClass('btn-success').addClass('btn-danger');
                                $(el).html('<i class="ti-trash"></i>');
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