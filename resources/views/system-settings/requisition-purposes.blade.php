@extends('layouts.main.app')

@section('title', 'Requisition Purposes')

@section('breadcrumb-content')
<li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
<li class="breadcrumb-item active" id="moduleName">System Settings</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">System Settings</h1>
<small id="controllerName">Requisition Purposes</small>
@endsection

@section('content')
<div id="add0" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Add purpose</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{route('requisition-purposes.add')}}" id="addReqPurposeForm" class="row" method="post" accept-charset="utf-8">
                    @csrf
                    <div class="col-md-12 col-lg-12">
                        <div class="form-group row">
                            <label for="req_purpose" class="col-sm-5 col-form-label">Requisition Purpose <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="req_purpose" required class="form-control" type="text" placeholder="Requisition Purpose" id="req_purpose">
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
                <strong>Update Purpose</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body editinfo">
                <form action="{{route('requisition-purposes.update')}}" id="editReqPurposeForm" class="row" method="post" accept-charset="utf-8">
                    @csrf
                    <input type="hidden" name="req_purpose_id" id="reqPurposeId">
                    <div class="col-md-12 col-lg-12">
                        <div class="form-group row">
                            <label for="req_purpose" class="col-sm-5 col-form-label">Requisition Purpose <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="req_purpose" required class="form-control" type="text" placeholder="Requisition Purpose" id="new_req_purpose">
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
                    Requisition Purposes
                    <small class="float-right">
                        <button type="button" class="btn btn-primary btn-md" data-target="#add0" data-toggle="modal">
                            <i class="ti-plus" aria-hidden="true"></i>
                            Add purpose
                        </button>
                    </small>
                </h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="reqPurposeTable" class="table display table-bordered table-striped table-hover ">
                        <thead>
                            <tr>
                                <th>Sl No.</th>
                                <th>Requisition Purpose</th>
                                <th>Action(s)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($purposes as $purpose)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$purpose['REQUISITION_PURPOSE_NAME']}}</td>
                                <td>
                                    <button class="btn btn-info mr-1" title="Edit" data-id="{{$purpose['REQUISITION_PURPOSE_ID']}}" data-name="{{$purpose['REQUISITION_PURPOSE_NAME']}}" onclick="editInfo(this)">
                                        <i class="ti-pencil"></i>
                                    </button>
                                    @if($purpose['IS_ACTIVE'] == 'Y')
                                    <button class="btn btn-danger mr-1" title="Deactivate" data-id="{{$purpose['REQUISITION_PURPOSE_ID']}}" onclick="updateStatus(this)"><i class="ti-close"></i></button>
                                    @else
                                    <button class="btn btn-success mr-1" title="Activate" data-id="{{$purpose['REQUISITION_PURPOSE_ID']}}" onclick="updateStatus(this)"><i class="ti-reload"></i></button>
                                    @endif
                                </td>
                            </tr>
                            @endforeach

                            <!-- <tr>
                                <td>1</td>
                                <td>Travel</td>
                                <td>
                                    <input name="url" type="hidden" id="url_1" value="https://vmsdemo.bdtask-demo.com/setting/Setting/updatereqpurposefrm" />
                                    <a onclick="editinfo(1)" class="btn btn-xs btn-success btn-sm mr-1 text-white" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                    <a href="https://vmsdemo.bdtask-demo.com/setting/Setting/delete_reqpurpose/1" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                </td>
                            </tr> -->
                        </tbody>
                    </table> <!-- /.table-responsive -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <script src="{{asset('dist/js/reqpurpose_list.js')}}"></script> -->
@endsection

@section('js-content')
<script>
    $(document).ready(function() {
        let reqPurposeTable = $("#reqPurposeTable").DataTable();

        // To add serial numbers in data table on adding new item
        reqPurposeTable.on('draw.dt', function() {
            var PageInfo = $('#reqPurposeTable').DataTable().page.info();
            reqPurposeTable.column(0, {
                page: 'current'
            }).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1 + PageInfo.start;
            });
        });

        // Validate and submit Add Requisition Type form
        $("#addReqPurposeForm").validate({
            rules: {
                req_purpose: {
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
                            let actionBtns = '<button type="button" class="btn btn-info mr-1" title="Edit" data-name="' + res.data.REQUISITION_PURPOSE_NAME + '" data-id="' + res.data.REQUISITION_PURPOSE_ID + '" onclick="editInfo(this)"><i class="ti-pencil"></i></button>';
                            actionBtns += ' <button type="button" class="btn btn-danger mr-1" title="Deactivate" data-id="' + res.data.REQUISITION_PURPOSE_ID + '" onclick="updateStatus(this)"><i class="ti-close"></i></button>';
                            reqPurposeTable.row.add(['', res.data.REQUISITION_PURPOSE_NAME, actionBtns]).draw();
                        } else {
                            toastr.error(res.message, '', {
                                closeButton: true
                            });
                        }
                    },
                    error: function(jqXHR, textStatus, err) {
                        toastr.error('Error adding purpose. Please try again.', '', {
                            closeButton: true
                        });
                    }
                });
            }
        });

        // On closing Add Requisition Type modal, reset form and remove validation messages
        $("#add0").on('hidden.bs.modal', function(ev) {
            $("#addReqPurposeForm").trigger('reset');
            $("#addReqPurposeForm").validate().resetForm();
            $("#req_purpose").removeClass('error');
            $("#req_purpose").removeAttr('aria-invalid');
        });

        // On resetting Add Requisition type Form
        $("#resetAddFormBtn").click(function() {
            $("#addReqPurposeForm").trigger('reset');
            $("#addReqPurposeForm").validate().resetForm();
            $("#req_purpose").removeClass('error');
            $("#req_purpose").removeAttr('aria-invalid');
        });

        // Validate and submit Edit Requisition Type Form
        $("#editReqPurposeForm").validate({
            rules: {
                req_type_name: {
                    required: true,
                    minlength: 2,
                    maxlength: 50
                }
            },
            submitHandler: function(form, ev) {
                ev.preventDefault();
                let reqPurposeId = $("#reqPurposeId").val();

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
                            let targetBtn = $("#reqPurposeTable").find('button[data-id=' + reqPurposeId + ']');
                            targetBtn.closest('td').prev().html(res.data.REQUISITION_PURPOSE_NAME);
                            targetBtn.data('name', res.data.REQUISITION_PURPOSE_NAME);
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
            $("#editReqPurposeForm").trigger('reset');
            $("#editReqPurposeForm").validate().resetForm();
            $("#new_req_purpose").removeClass('error');
            $("#new_req_purpose").removeAttr('aria-invalid');
        });

        // On resetting Edit Requisiuton Purpoose Form
        $("#resetEditFormBtn").click(function() {
            setTimeout(() => {
                $("#new_req_purpose").valid();
            }, 10);
        });

    });
</script>

<script>
    function editInfo(el) {
        // el has been passed 'this' to get data-* attributes of clicked button
        // Set initial form details using button's data attributes set while loading/reloading table
        $("#reqPurposeId").val($(el).data('id'));
        $("#new_req_purpose").attr('value', $(el).data('name'));
        $("#edit").modal('show');
    }

    function updateStatus(el) {
        // el has been passed this (clicked button)
        let reqPurposeId = $(el).data('id');

        toastr.warning("<br /><button type='button' class='btn btn-success mr-2' value='yes'>Yes</button><button class='btn btn-danger' type='button' value='no' >No</button>", 'Are you sure?', {
            allowHtml: true,
            onclick: function(toast) {
                value = toast.target.value
                if (value == 'yes') {
                    var url = "{{ route('requisition-purposes.update-status') }}";

                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            req_purpose_id: reqPurposeId
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