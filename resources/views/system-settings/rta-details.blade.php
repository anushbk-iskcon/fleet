@extends('layouts.main.app')

@section('title', 'RTA Details')

@section('breadcrumb-content')
<li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
<li class="breadcrumb-item active" id="moduleName">System Settings</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">System Settings</h1>
<small id="controllerName">RTA Details</small>
@endsection

@section('content')

<div id="add0" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Add RTA Office</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{route('rta-details.add')}}" id="addRTAOfficeForm" class="row" method="post" accept-charset="utf-8">
                    @csrf
                    <div class="col-md-12 col-lg-12">
                        <div class="form-group row">
                            <label for="office_location" class="col-sm-5 col-form-label">Office Location <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="office_location" required class="form-control" type="text" placeholder="Office Location" id="office_location">
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
                <strong>Update RTA Office</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body editinfo">
                <form action="{{route('rta-details.update')}}" id="editRTAOfficeForm" class="row" method="post" accept-charset="utf-8">
                    @csrf
                    <input type="hidden" name="rta_circle_office_id" id="rtaOfficeId" value="">
                    <div class="col-md-12 col-lg-12">
                        <div class="form-group row">
                            <label for="new_office_location" class="col-sm-5 col-form-label">Office Location <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="new_rta_circle_office_name" required class="form-control" type="text" placeholder="Office Location" id="new_office_location">
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
                <h4 class="pl-3">RTA Office Details
                    <small class="float-right">
                        <button type="button" class="btn btn-primary btn-md" data-target="#add0" data-toggle="modal"><i class="ti-plus" aria-hidden="true"></i>
                            Add RTA Office
                        </button>
                    </small>
                </h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="rtaCircleOfficeTable" class="table table-striped table-bordered dt-responsive nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Office Location</th>
                                <th>Action(s)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rtaOffices as $rtaOffice)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>
                                    {{$rtaOffice['RTA_CIRCLE_OFFICE_NAME']}}
                                </td>
                                <td>
                                    <button type="button" class="btn btn-info" data-id="{{$rtaOffice['RTA_CIRCLE_OFFICE_ID']}}" data-name="{{$rtaOffice['RTA_CIRCLE_OFFICE_NAME']}}" title="Edit" onclick="editInfo(this)">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    @if($rtaOffice['IS_ACTIVE'] == 'Y')
                                    <button type="button" class="btn btn-danger" title="Deactivate" data-id="{{$rtaOffice['RTA_CIRCLE_OFFICE_ID']}}" onclick="updateStatus(this)"><i class="ti-close"></i></button>
                                    @else
                                    <button type="button" class="btn btn-success" title="Activate" data-id="{{$rtaOffice['RTA_CIRCLE_OFFICE_ID']}}" onclick="updateStatus(this)"><i class="ti-reload"></i></button>
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
<!-- <script src="{{asset('dist/js/brtaoffice_list.js')}}"></script> -->
@endsection

@section('js-content')
<script>
    $(document).ready(function() {
        let rtaOfficeDetailsTable = $("#rtaCircleOfficeTable").DataTable();

        // To add serial numbers in data table on adding new item
        rtaOfficeDetailsTable.on('draw.dt', function() {
            var PageInfo = $('#rtaCircleOfficeTable').DataTable().page.info();
            rtaOfficeDetailsTable.column(0, {
                page: 'current'
            }).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1 + PageInfo.start;
            });
        });

        $("#addRTAOfficeForm").validate({
            rules: {
                office_location: {
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
                            let actionBtns = '<button type="button" class="btn btn-info" title="Edit" data-name="' + res.data.RTA_CIRCLE_OFFICE_NAME + '" data-id="' + res.data.RTA_CIRCLE_OFFICE_ID + '" onclick="editInfo(this)"><i class="fa fa-edit"></i></button>';
                            actionBtns += ' <button type="button" class="btn btn-danger" title="Deactivate" data-id="' + res.data.RTA_CIRCLE_OFFICE_ID + '" onclick="updateStatus(this)"><i class="ti-close"></i></button>';
                            rtaOfficeDetailsTable.row.add(['', res.data.RTA_CIRCLE_OFFICE_NAME, actionBtns]).draw();
                        } else {
                            toastr.error(res.message, '', {
                                closeButton: true
                            });
                        }
                    },
                    error: function(jqXHR, textStatus, err) {
                        toastr.error("Error adding RTA Office. Please try again.", '', {
                            closeButton: true
                        });
                    }
                });
            }
        });

        $("#editRTAOfficeForm").validate({
            rules: {
                new_rta_circle_office_name: {
                    required: true,
                    minlength: 2,
                    maxlength: 100
                }
            },
            submitHandler: function(form, ev) {
                ev.preventDefault();
                let rtaOfficeId = $(form).find("#rtaOfficeId").val();

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
                            let targetBtn = $("#rtaCircleOfficeTable").find('button[data-id=' + rtaOfficeId + ']');

                            targetBtn.closest('td').prev().html(res.data.RTA_CIRCLE_OFFICE_NAME);
                            targetBtn.data('name', res.data.RTA_CIRCLE_OFFICE_NAME);
                        }
                    },
                    error: function(jqXHR, textStatus, err) {
                        toastr.error("Error updating RTA Office. Please try again.", '', {
                            closeButton: true
                        });
                    }
                });
            }
        });

        // Remove validations, errors and reset add RTA Circle Office form on closing modal
        $("#add0").on('hidden.bs.modal', function(ev) {
            $("#addRTAOfficeForm").trigger('reset');
            $("#addRTAOfficeForm").validate().resetForm();
            $("#office_location").removeClass('error').removeAttr('aria-invalid');
        });

        // On resetting Add RETA Circle Office Form
        $("#resetAddFormBtn").click(function() {
            $("#addRTAOfficeForm").trigger('reset');
            $("#addRTAOfficeForm").validate().resetForm();
            $("#office_location").removeClass('error').removeAttr('aria-invalid');
        });

        // Remove validations, errors and reset Edit RTA Circle Office form on closing modal
        $("#edit").on('hidden.bs.modal', function(ev) {
            $("#editRTAOfficeForm").trigger('reset');
            $("#editRTAOfficeForm").validate().resetForm();
            $("#new_office_location").removeClass('error');
            $("#new_office_location").removeAttr('aria-invalid');
        });

        // On resetting resetEditFormBtn
        $("#resetEditFormBtn").click(function() {
            setTimeout(() => {
                $("#new_office_location").valid();
            }, 10);
        });

    });
</script>

<script>
    function editInfo(el) {
        $("#rtaOfficeId").val($(el).data('id'));
        $("#new_office_location").attr('value', $(el).data('name'));
        $("#edit").modal('show');
    }

    function updateStatus(el) {
        let rtaOfficeId = $(el).data('id');

        toastr.warning("<br /><button type='button' class='btn btn-success mr-2' value='yes'>Yes</button><button class='btn btn-danger' type='button' value='no' >No</button>", 'Are you sure?', {
            allowHtml: true,
            onclick: function(toast) {
                value = toast.target.value;
                if (value == 'yes') {
                    var url = "{{ route('rta-details.status-update') }}";

                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            rta_circle_office_id: rtaOfficeId
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