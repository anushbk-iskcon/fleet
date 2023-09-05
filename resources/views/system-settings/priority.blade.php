@extends('layouts.main.app')

@section('title', 'Priority Settings')

@section('breadcrumb-content')
<li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
<li class="breadcrumb-item active" id="moduleName">System Settings</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">System Settings</h1>
<small id="controllerName">Manage Priority</small>
@endsection

@section('content')
<div id="add0" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Add Priority</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{route('priority.add')}}" id="addPriorityForm" class="row" method="post" accept-charset="utf-8">
                    @csrf
                    <div class="col-md-12 col-lg-12">
                        <div class="form-group row">
                            <label for="priority_name" class="col-sm-5 col-form-label">Priority Name <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="priority_name" required class="form-control" type="text" placeholder="Priority Name" id="priority_name">
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
                <strong>Update Priority</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body editinfo">
                <form action="{{route('priority.update')}}" id="editPriorityForm" class="row" method="post" accept-charset="utf-8">
                    @csrf
                    <input type="hidden" name="priority_id" id="newPriorityId">
                    <div class="col-md-12 col-lg-12">
                        <div class="form-group row">
                            <label for="new_priority_name" class="col-sm-5 col-form-label">Priority Name <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="priority_name" required class="form-control" type="text" placeholder="Priority Name" id="new_priority_name">
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
                    Manage Priority
                    <small class="float-right">
                        <button type="button" class="btn btn-primary btn-md" data-target="#add0" data-toggle="modal">
                            <i class="ti-plus" aria-hidden="true"></i>
                            Add Priority
                        </button>
                    </small>
                </h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="priorityTable" class="table display table-bordered table-striped table-hover ">
                        <thead>
                            <tr>
                                <th>Sl No.</th>
                                <th>Priority Name</th>
                                <th>Action(s)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($priorities as $priority)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$priority['PRIORITY_NAME']}}</td>
                                <td>
                                    <button class="btn btn-info mr-1" title="Edit" data-id="{{$priority['PRIORITY_ID']}}" data-name="{{$priority['PRIORITY_NAME']}}" onclick="editInfo(this)">
                                        <i class="ti-pencil"></i>
                                    </button>
                                    @if($priority['IS_ACTIVE'] == 'Y')
                                    <button class="btn btn-danger mr-1" title="Deactivate" data-id="{{$priority['PRIORITY_ID']}}" onclick="updateStatus(this)"><i class="ti-close"></i></button>
                                    @else
                                    <button class="btn btn-success mr-1" title="Activate" data-id="{{$priority['PRIORITY_ID']}}" onclick="updateStatus(this)"><i class="ti-reload"></i></button>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            <!-- <tr>
                                <td>1</td>
                                <td>Low</td>
                                <td>
                                    <input name="url" type="hidden" id="url_1" value="https://vmsdemo.bdtask-demo.com/setting/Setting/updatepriorityfrm" />
                                    <a onclick="editinfo(1)" class="btn btn-xs btn-success btn-sm mr-1 text-white" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                    <a href="https://vmsdemo.bdtask-demo.com/setting/Setting/delete_priority/1" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                </td>
                            </tr>
                             -->
                        </tbody>
                    </table> <!-- /.table-responsive -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js-content')
<!-- <script src="{{asset('dist/js/priority_list.js')}}"></script> -->

<script>
    $(document).ready(function() {
        let priorityTable = $("#priorityTable").DataTable();

        // To add serial numbers in data table on adding new item
        priorityTable.on('draw.dt', function() {
            var PageInfo = $('#priorityTable').DataTable().page.info();
            priorityTable.column(0, {
                page: 'current'
            }).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1 + PageInfo.start;
            });
        });

        // Validate and submit Add Priority Types form
        $("#addPriorityForm").validate({
            rules: {
                priority_name: {
                    required: true,
                    minlength: 1,
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
                            let actionBtns = '<button type="button" class="btn btn-info mr-1" title="Edit" data-name="' + res.data.PRIORITY_NAME + '" data-id="' + res.data.PRIORITY_ID + '" onclick="editInfo(this)"><i class="ti-pencil"></i></button>';
                            actionBtns += ' <button type="button" class="btn btn-danger mr-1" title="Deactivate" data-id="' + res.data.PRIORITY_ID + '" onclick="updateStatus(this)"><i class="ti-close"></i></button>';
                            priorityTable.row.add(['', res.data.PRIORITY_NAME, actionBtns]).draw();
                        } else {
                            toastr.error(res.message, '', {
                                closeButton: true
                            });
                        }
                    },
                    error: function(jqXHR, textStatus, err) {
                        toastr.error('Error adding priority. Please try again.', '', {
                            closeButton: true
                        });
                    }
                });
            }
        });

        // On closing Add Priority modal, reset form and remove validation messages
        $("#add0").on('hidden.bs.modal', function(ev) {
            $("#addPriorityForm").trigger('reset');
            $("#addPriorityForm").validate().resetForm();
            $("#priority_name").removeClass('error').removeAttr('aria-invalid');
        });

        // On resetting Add Priority form
        $("#resetAddFormBtn").click(function() {
            $("#addPriorityForm").trigger('reset');
            $("#addPriorityForm").validate().resetForm();
            $("#priority_name").removeClass('error').removeAttr('aria-invalid');
        });

        // Validate and submit Edit Priority Form
        $("#editPriorityForm").validate({
            rules: {
                priority_name: {
                    required: true,
                    minlength: 1,
                    maxlength: 50
                }
            },
            submitHandler: function(form, ev) {
                ev.preventDefault();
                let priorityId = $("#newPriorityId").val();

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
                            let targetBtn = $("#priorityTable").find('button[data-id=' + priorityId + ']');
                            targetBtn.closest('td').prev().html(res.data.PRIORITY_NAME);
                            targetBtn.data('name', res.data.PRIORITY_NAME);
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

        // On closing Edit Priority Modal, remove validation errors and messages
        $("#edit").on('hidden.bs.modal', function(ev) {
            $("#editPriorityForm").trigger('reset');
            $("#editPriorityForm").validate().resetForm();
            $("#new_priority_name").removeClass('error').removeAttr('aria-invalid');
        });

        // On resetting Edit Priority Form
        $("#resetEditFormBtn").click(function() {
            setTimeout(() => {
                $("#new_priority_name").valid();
            }, 10);
        });

    });
</script>
<script>
    function editInfo(el) {
        // el has been passed 'this' to get data-* attributes of clicked button
        // Set initial form details using button's data attributes set while loading/reloading table
        $("#newPriorityId").val($(el).data('id'));
        $("#new_priority_name").attr('value', $(el).data('name'));
        $("#edit").modal('show');
    }

    function updateStatus(el) {
        // el has been passed this (clicked button)
        let priorityId = $(el).data('id');

        toastr.warning("<br /><button type='button' class='btn btn-success mr-2' value='yes'>Yes</button><button class='btn btn-danger' type='button' value='no' >No</button>", 'Are you sure?', {
            allowHtml: true,
            onclick: function(toast) {
                value = toast.target.value;
                if (value == 'yes') {
                    var url = "{{ route('priority.update-status') }}";

                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            priority_id: priorityId
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