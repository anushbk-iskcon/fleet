@extends('layouts.main.app')

@section('title', 'Requisition Types')

@section('css-content')
<style>
    .action-btns-container {
        display: flex;
        flex-wrap: nowrap;
        justify-content: flex-end;
        gap: 20px;
    }

    #reqTypesTable tr td:last-child .btn {
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
<small id="controllerName">Requisition Types</small>
@endsection

@section('content')

<div id="add0" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Add Requisition Type</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{route('requisition-types.add')}}" id="addReqTypeForm" class="row" method="post" accept-charset="utf-8">
                    @csrf
                    <div class="col-md-12 col-lg-12">
                        <div class="form-group row">
                            <label for="req_type_name" required class="col-sm-5 col-form-label">Type Name <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="req_type_name" class="form-control" type="text" placeholder="Type Name" id="req_type_name">
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
                <strong>Update Requisition Type</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body editinfo">
                <form action="{{route('requisition-types.update')}}" id="editReqTypeForm" class="row" method="post" accept-charset="utf-8">
                    @csrf
                    <input type="hidden" name="req_type_id" id="reqTypeId">
                    <div class="col-md-12 col-lg-12">
                        <div class="form-group row">
                            <label for="type_name" required class="col-sm-5 col-form-label">Type Name <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="req_type_name" class="form-control" type="text" placeholder="Type Name" id="new_req_type_name">
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
                    Requisition Type
                    <small class="float-right">
                        <button type="button" class="btn btn-primary btn-md" data-target="#add0" data-toggle="modal">
                            <i class="ti-plus" aria-hidden="true"></i>
                            Add Requisition Type
                        </button>
                    </small>
                </h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="reqTypesTable" class="table display table-bordered table-striped table-hover ">
                        <thead>
                            <tr>
                                <th>Sl No.</th>
                                <th>Requisition Type</th>
                                <th>Action(s)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reqTypes as $reqType)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$reqType['REQUISITION_TYPE_NAME']}}</td>
                                <td>
                                    <button class="btn btn-info mr-1" title="Edit" data-id="{{$reqType['REQUISITION_TYPE_ID']}}" data-name="{{$reqType['REQUISITION_TYPE_NAME']}}" onclick="editInfo(this)">
                                        <i class="ti-pencil"></i>
                                    </button>
                                    @if($reqType['IS_ACTIVE'] == 'Y')
                                    <button class="btn btn-danger mr-1" title="Deactivate" data-id="{{$reqType['REQUISITION_TYPE_ID']}}" onclick="updateStatus(this)"><i class="ti-close"></i></button>
                                    @else
                                    <button class="btn btn-success mr-1" title="Activate" data-id="{{$reqType['REQUISITION_TYPE_ID']}}" onclick="updateStatus(this)"><i class="ti-reload"></i></button>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            <!-- <tr>
                                <td>1</td>
                                <td>Vehicle Requisition</td>
                                <td>
                                    <input name="url" type="hidden" id="url_1" value="https://vmsdemo.bdtask-demo.com/setting/Setting/updatereqtypefrm" />
                                    <a onclick="editinfo(1)" class="btn btn-xs btn-success btn-sm mr-1 text-white" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                    <a href="https://vmsdemo.bdtask-demo.com/setting/Setting/delete_reqtype/1" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Maintenance Requisition</td>
                                <td>
                                    <input name="url" type="hidden" id="url_2" value="https://vmsdemo.bdtask-demo.com/setting/Setting/updatereqtypefrm" />
                                    <a onclick="editinfo(2)" class="btn btn-xs btn-success btn-sm mr-1 text-white" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                    <a href="https://vmsdemo.bdtask-demo.com/setting/Setting/delete_reqtype/2" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                </td>
                            </tr> -->
                        </tbody>
                    </table> <!-- /.table-responsive -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <script src="{{asset('dist/js/reqtype_list.js')}}"></script> -->
@endsection
@section('js-content')
<script>
    $(document).ready(function() {
        let reqTypesTable = $("#reqTypesTable").DataTable({
            "columnDefs": [{
                    "max-width": "10%",
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
        reqTypesTable.on('draw.dt', function() {
            var PageInfo = $('#reqTypesTable').DataTable().page.info();
            reqTypesTable.column(0, {
                page: 'current'
            }).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1 + PageInfo.start;
            });
        });

        // Validate and submit Add Requisition Type form
        $("#addReqTypeForm").validate({
            rules: {
                req_type_name: {
                    required: true,
                    minlength: 2,
                    maxlength: 50
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
                            let actionBtns = '<button type="button" class="btn btn-info mr-1" title="Edit" data-name="' + res.data.REQUISITION_TYPE_NAME + '" data-id="' + res.data.REQUISITION_TYPE_ID + '" onclick="editInfo(this)"><i class="ti-pencil"></i></button>';
                            actionBtns += ' <button type="button" class="btn btn-danger mr-1" title="Deactivate" data-id="' + res.data.REQUISITION_TYPE_ID + '" onclick="updateStatus(this)"><i class="ti-close"></i></button>';
                            reqTypesTable.row.add(['', res.data.REQUISITION_TYPE_NAME, actionBtns]).draw();
                        } else {
                            toastr.error(res.message, '', {
                                closeButton: true
                            });
                        }
                    },
                    error: function(jqXHR, textStatus, err) {
                        toastr.error('Error adding requisition type. Please try again.', '', {
                            closeButton: true
                        });
                    }
                });
            }
        });

        // On closing Add Requisition Type modal, reset form and remove validation messages
        $("#add0").on('hidden.bs.modal', function(ev) {
            $("#addReqTypeForm").trigger('reset');
            $("#addReqTypeForm").validate().resetForm();
            $("#req_type_name").removeClass('error');
            $("#req_type_name").removeAttr('aria-invalid');
        });

        // On resetting add form
        $("#resetAddFormBtn").click(function() {
            $("#addReqTypeForm").trigger('reset');
            $("#addReqTypeForm").validate().resetForm();
            $("#req_type_name").removeClass('error');
            $("#req_type_name").removeAttr('aria-invalid');
        });

        // Validate and submit Edit Requisition Type Form
        $("#editReqTypeForm").validate({
            rules: {
                req_type_name: {
                    required: true,
                    minlength: 2,
                    maxlength: 50
                }
            },
            submitHandler: function(form, ev) {
                ev.preventDefault();
                let reqTypeId = $("#reqTypeId").val();

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
                            let targetBtn = $("#reqTypesTable").find('button[data-id=' + reqTypeId + ']');
                            targetBtn.closest('td').prev().html(res.data.REQUISITION_TYPE_NAME);
                            targetBtn.data('name', res.data.REQUISITION_TYPE_NAME);
                        } else {
                            toastr.error(res.message, '', {
                                closeButton: true
                            });
                        }
                    },
                    error: function(jqXHR, textStatus, err) {
                        toastr.error('Error updating. Please try again', '', {
                            closeButton: true
                        });
                    }
                });
            }
        });

        // On closing Edit Requistion Type Modal, remove validation errors and messages
        $("#edit").on('hidden.bs.modal', function(ev) {
            $("#editReqTypeForm").trigger('reset');
            $("#editReqTypeForm").validate().resetForm();
            $("#new_req_type_name").removeClass('error');
            $("#new_req_type_name").removeAttr('aria-invalid');
        });

        // On resetting Edit Form
        $("#resetEditFormBtn").click(function() {
            setTimeout(() => {
                $("#new_req_type_name").valid();
            }, 10);
        });

    });
</script>
<script>
    function editInfo(el) {
        // el has been passed 'this' to get data-* attributes of clicked button
        // Set initial form details using button's data attributes set while loading/reloading table
        $("#reqTypeId").val($(el).data('id'));
        $("#new_req_type_name").attr('value', $(el).data('name'));
        $("#edit").modal('show');
    }

    function updateStatus(el) {
        // el has been passed this (clicked button)
        let reqTypeId = $(el).data('id');

        toastr.warning("<br /><button type='button' class='btn btn-success mr-2' value='yes'>Yes</button><button class='btn btn-danger' type='button' value='no' >No</button>", 'Are you sure?', {
            allowHtml: true,
            onclick: function(toast) {
                value = toast.target.value;
                if (value == 'yes') {
                    var url = "{{ route('requisition-types.update-status') }}";

                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            req_type_id: reqTypeId
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