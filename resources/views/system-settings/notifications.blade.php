@extends('layouts.main.app')

@section('title', 'Manage Notifications')

@section('css-content')
<style>
    .action-btns-container {
        display: flex;
        flex-wrap: nowrap;
        justify-content: flex-end;
        gap: 20px;
    }

    #notificationTypesTable tr td:last-child .btn {
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
<small id="controllerName">Manage Notifications</small>
@endsection

@section('content')

<div id="add0" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Add Notification</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{route('notification-settings.add')}}" id="addNotificationTypeForm" class="row" method="post" accept-charset="utf-8">
                    @csrf
                    <div class="col-md-12 col-lg-12">
                        <div class="form-group row">
                            <label for="notification_name" class="col-sm-5 col-form-label">Notification Name <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="notification_name" required class="form-control" type="text" placeholder="Notification Name" id="notification_name">
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
                <strong>Update Notification</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body editinfo">
                <form action="{{route('notification-settings.update')}}" id="editNotificationTypeForm" class="row" method="post" accept-charset="utf-8">
                    @csrf
                    <input type="hidden" name="notification_type_id" id="notificationTypeId">
                    <div class="col-md-12 col-lg-12">
                        <div class="form-group row">
                            <label for="notification_name" class="col-sm-5 col-form-label">Notification Name <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="notification_name" required class="form-control" type="text" placeholder="Notification Name" id="new_notification_name">
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
                <h4 class="pl-3">Notifications
                    <small class="float-right">
                        <button type="button" class="btn btn-primary btn-md" data-target="#add0" data-toggle="modal">
                            <i class="ti-plus" aria-hidden="true"></i>
                            Add Notification
                        </button>
                    </small>
                </h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="notificationTypesTable" class="table display table-bordered table-striped table-hover ">
                        <thead>
                            <tr>
                                <th>Sl No.</th>
                                <th>Notification Name</th>
                                <th>Action(s)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($notificationTypes as $notificationType)
                            <tr>
                                <td> {{$loop->iteration}} </td>
                                <td> {{$notificationType['NOTIFICATION_TYPE_NAME']}} </td>
                                <td>
                                    <button class="btn btn-info mr-1" data-id="{{$notificationType['NOTIFICATION_TYPE_ID']}}" data-name="{{$notificationType['NOTIFICATION_TYPE_NAME']}}" onclick="editInfo(this);">
                                        <i class="ti-pencil"></i>
                                    </button>
                                    @if($notificationType['IS_ACTIVE'] == 'Y')
                                    <button class="btn btn-danger mr-1" data-id="{{$notificationType['NOTIFICATION_TYPE_ID']}}" onclick="updateStatus(this);"><i class="ti-close"></i></button>
                                    @else
                                    <button class="btn btn-success mr-1" data-id="{{$notificationType['NOTIFICATION_TYPE_ID']}}" onclick="updateStatus(this);"><i class="ti-reload"></i></button>
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
<!-- <script src="{{asset('dist/js/notification_list.js')}}"></script> -->
<script>
    $(document).ready(function() {
        let notificationTypesTable = $("#notificationTypesTable").DataTable({
            "columnDefs": [{
                    "max-width": "10%",
                    "targets": 0
                },
                {
                    "orderable": false,
                    "width": "160px",
                    "className": "text-right",
                    "targets": 2
                }
            ],
            "autoWidth": false
        });

        // To add serial numbers in data table on adding new item
        notificationTypesTable.on('draw.dt', function() {
            var PageInfo = $('#notificationTypesTable').DataTable().page.info();
            notificationTypesTable.column(0, {
                page: 'current'
            }).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1 + PageInfo.start;
            });
        });

        // Validate and submit Add Notification Types Form
        $("#addNotificationTypeForm").validate({
            rules: {
                notification_name: {
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
                            let actionBtns = '<button type="button" class="btn btn-info mr-1" title="Edit" data-name="' + res.data.NOTIFICATION_TYPE_NAME + '" data-id="' + res.data.NOTIFICATION_TYPE_ID + '" onclick="editInfo(this)"><i class="ti-pencil"></i></button>';
                            actionBtns += ' <button type="button" class="btn btn-danger mr-1" title="Deactivate" data-id="' + res.data.NOTIFICATION_TYPE_ID + '" onclick="updateStatus(this)"><i class="ti-close"></i></button>';
                            notificationTypesTable.row.add(['', res.data.NOTIFICATION_TYPE_NAME, actionBtns]).draw();
                        } else {
                            toastr.error(res.message, '', {
                                closeButton: true
                            });
                        }
                    },
                    error: function(jqXHR, textStatus, err) {
                        toastr.error('Error adding notification type. Please try again', '', {
                            closeButton: true
                        });
                    }
                });
            }
        });

        // On closing Add Notification Type Form Modal, reset form and remove validation mesages
        $("#add0").on('hidden.bs.modal', function() {
            $("#addNotificationTypeForm").trigger('reset');
            $("#addNotificationTypeForm").validate().resetForm();
            $("#notification_name").removeClass('error');
            $("#notification_name").removeAttr('aria-invalid');
        });

        // On resetting add new recurring period form
        $("#resetAddFormBtn").click(function() {
            $("#addNotificationTypeForm").trigger('reset');
            $("#addNotificationTypeForm").validate().resetForm();
            $("#notification_name").removeClass('error');
            $("#notification_name").removeAttr('aria-invalid');
        });

        // Validate and Submit Edit Notification Type Form
        $("#editNotificationTypeForm").validate({
            rules: {
                notification_name: {
                    required: true,
                    minlength: 2,
                    maxlength: 100
                }
            },
            submitHandler: function(form, ev) {
                ev.preventDefault();
                let notificationTypeId = $("#notificationTypeId").val();

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
                            let targetBtn = $("#notificationTypesTable").find('button[data-id=' + notificationTypeId + ']');
                            targetBtn.closest('td').prev().html(res.data.NOTIFICATION_TYPE_NAME);
                            targetBtn.data('name', res.data.NOTIFICATION_TYPE_NAME);
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

        // On closing Edit Notification Type Form Modal, reset form and remove validation mesages
        $("#edit").on('hidden.bs.modal', function() {
            $("#editNotificationTypeForm").trigger('reset');
            $("#editNotificationTypeForm").validate().resetForm();
            $("#new_notification_name").removeClass('error');
            $("#new_notification_name").removeAttr('aria-invalid');
        });

        $("#resetEditFormBtn").click(function() {
            setTimeout(() => {
                $("#new_notification_name").valid();
            }, 10);
        });

    });
</script>

<script>
    function editInfo(el) {
        // el has been passed 'this' to get data-* attributes of clicked button
        // Set initial form details using button's data attributes set while loading/reloading table
        $("#notificationTypeId").val($(el).data('id'));
        $("#new_notification_name").attr('value', $(el).data('name'));
        $("#edit").modal('show');
    }

    function updateStatus(el) {
        // el has been passed this (clicked button)
        let notificationTypeId = $(el).data('id');

        toastr.warning("<br /><button type='button' class='btn btn-success mr-2' value='yes'>Yes</button><button class='btn btn-danger' type='button' value='no' >No</button>", 'Are you sure?', {
            allowHtml: true,
            onclick: function(toast) {
                value = toast.target.value;
                if (value == 'yes') {
                    var url = "{{ route('notification-settings.update-status') }}";

                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            notification_type_id: notificationTypeId
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