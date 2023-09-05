@extends('layouts.main.app')

@section('title', 'Recurring Periods')

@section('breadcrumb-content')
<li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
<li class="breadcrumb-item active" id="moduleName">System Settings</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">System Settings</h1>
<small id="controllerName">Manage Recurring Periods</small>
@endsection

@section('content')

<div id="add0" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Add Recurring Period</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{route('recurring-periods.add')}}" id="addRecurringPeriodForm" class="row" method="post" accept-charset="utf-8">
                    @csrf
                    <div class="col-md-12 col-lg-12">
                        <div class="form-group row">
                            <label for="recurringPeriodName" class="col-sm-5 col-form-label">Recurring Period Name <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="recurring_period_name" required class="form-control" type="text" placeholder="Recurring Period Name" id="recurringPeriodName">
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
                <strong>Update Recurring Period</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body editinfo">
                <form action="{{route('recurring-periods.update')}}" id="editRecurringPeriodForm" class="row" method="post" accept-charset="utf-8">
                    @csrf
                    <input type="hidden" name="recurring_period_id" id="recurringPeriodId">
                    <div class="col-md-12 col-lg-12">
                        <div class="form-group row">
                            <label for="newRecurringPeriodName" class="col-sm-5 col-form-label">Recurring Period Name <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="recurring_period_name" required class="form-control" type="text" placeholder="Recurring Period Name" id="newRecurringPeriodName">
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
                    Manage Recurring Periods
                    <small class="float-right">
                        <button type="button" class="btn btn-primary btn-md" data-target="#add0" data-toggle="modal">
                            <i class="ti-plus" aria-hidden="true"></i>
                            Add Recurring Period
                        </button>
                    </small>
                </h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="recurringPeriodTable" class="table display table-bordered table-striped table-hover ">
                        <thead>
                            <tr>
                                <th>Sl No.</th>
                                <th>Recurring Period Name</th>
                                <th>Action(s)</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($recurringPeriods as $recurringPeriod)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$recurringPeriod['RECURRING_PERIOD_NAME']}}</td>
                                <td>
                                    <button type="button" class="btn btn-info mr-1" title="Edit" data-id="{{$recurringPeriod['RECURRING_PERIOD_ID']}}" data-name="{{$recurringPeriod['RECURRING_PERIOD_NAME']}}" onclick="editInfo(this);">
                                        <i class="ti-pencil"></i>
                                    </button>
                                    @if($recurringPeriod['IS_ACTIVE'] == 'Y')
                                    <button type="button" class="btn btn-danger mr-1" title="Deactivate" data-id="{{$recurringPeriod['RECURRING_PERIOD_ID']}}" onclick="updateStatus(this);">
                                        <i class="ti-close"></i>
                                    </button>
                                    @else
                                    <button type="button" class="btn btn-success mr-1" title="Activate" data-id="{{$recurringPeriod['RECURRING_PERIOD_ID']}}" onclick="updateStatus(this);">
                                        <i class="ti-reload"></i>
                                    </button>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            <!-- <tr>
                                <td>1</td>
                                <td>10 Days</td>
                                <td>
                                    <input name="url" type="hidden" id="url_1" value="https://vmsdemo.bdtask-demo.com/setting/Setting/updateperiodfrm" />
                                    <a onclick="editinfo(1)" class="btn btn-xs btn-success btn-sm mr-1 text-white" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                    <a href="https://vmsdemo.bdtask-demo.com/setting/Setting/delete_period/1" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>1 Month</td>
                                <td>
                                    <input name="url" type="hidden" id="url_2" value="https://vmsdemo.bdtask-demo.com/setting/Setting/updateperiodfrm" />
                                    <a onclick="editinfo(2)" class="btn btn-xs btn-success btn-sm mr-1 text-white" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                    <a href="https://vmsdemo.bdtask-demo.com/setting/Setting/delete_period/2" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>1 Year</td>
                                <td>
                                    <input name="url" type="hidden" id="url_3" value="https://vmsdemo.bdtask-demo.com/setting/Setting/updateperiodfrm" />
                                    <a onclick="editinfo(3)" class="btn btn-xs btn-success btn-sm mr-1 text-white" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                    <a href="https://vmsdemo.bdtask-demo.com/setting/Setting/delete_period/3" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>11</td>
                                <td>
                                    <input name="url" type="hidden" id="url_4" value="https://vmsdemo.bdtask-demo.com/setting/Setting/updateperiodfrm" />
                                    <a onclick="editinfo(4)" class="btn btn-xs btn-success btn-sm mr-1 text-white" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                    <a href="https://vmsdemo.bdtask-demo.com/setting/Setting/delete_period/4" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                </td>
                            </tr> -->
                        </tbody>
                    </table> <!-- /.table-responsive -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js-content')
<!-- <script src="{{asset('dist/js/recurringperiod_list.js')}}"></script> -->
<script>
    $(document).ready(function() {
        let recurringPeriodTable = $("#recurringPeriodTable").DataTable();

        // To add serial numbers in data table on adding new item
        recurringPeriodTable.on('draw.dt', function() {
            var PageInfo = $('#recurringPeriodTable').DataTable().page.info();
            recurringPeriodTable.column(0, {
                page: 'current'
            }).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1 + PageInfo.start;
            });
        });

        // Validate and submit Add New Recurring Period Form
        $("#addRecurringPeriodForm").validate({
            rules: {
                recurring_period_name: {
                    required: true,
                    maxlength: 100
                }
            },
            submitHandler: function(form, ev) {
                ev.preventDefault();

                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    dataType: 'json',
                    success: function(res) {
                        if (res.successCode == 1) {
                            toastr.success(res.message, '', {
                                closeButton: true
                            });

                            $("#add0").modal('hide');

                            //Add row to table:
                            let actionBtns = '<button type="button" class="btn btn-info mr-1" title="Edit" data-id="' + res.data.RECURRING_PERIOD_ID + '" data-name="' + res.data.RECURRING_PERIOD_NAME + '" onclick="editInfo(this)"><i class="ti-pencil"></i></button>';
                            actionBtns += ' <button type="button" class="btn btn-danger mr-1" title="Deactivate" data-id="' + res.data.RECURRING_PERIOD_ID + '" onclick="updateStatus(this)"><i class="ti-close"></i></button>';

                            recurringPeriodTable.row.add(['', res.data.RECURRING_PERIOD_NAME, actionBtns]).draw();
                        } else {
                            toastr.error(res.message, '', {
                                closeButton: true
                            });
                        }
                    },
                    error: function(jqXHR, textStatus, err) {
                        toastr.error('Error adding Recurring Period. Please try again', '', {
                            closeButton: true
                        });
                    }
                });
            }
        });

        //On closing Add New Recurring Period modal, reset form and remove validation errors
        $("#add0").on('hidden.bs.modal', function() {
            $("#addRecurringPeriodForm").trigger('reset');
            $("#addRecurringPeriodForm").data('validator').resetForm();
            $("#recurringPeriodName").removeClass('error').removeAttr('aria-invalid');
        });

        // On clicking reset add recurring period form button
        $("#resetAddFormBtn").click(function() {
            $("#addRecurringPeriodForm").trigger('reset');
            $("#addRecurringPeriodForm").data('validator').resetForm();
            $("#recurringPeriodName").removeClass('error').removeAttr('aria-invalid');
        });

        // Validate and submit Edit Recurring Period Form
        $("#editRecurringPeriodForm").validate({
            rules: {
                recurring_period_name: {
                    required: true,
                    maxlength: 100
                }
            },
            submitHandler: function(form, ev) {
                ev.preventDefault();
                let recurringPeriodId = $("#recurringPeriodId").val();

                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    dataType: 'json',
                    success: function(res) {
                        if (res.successCode == 1) {
                            toastr.success(res.message, '', {
                                closeButton: true
                            });

                            $("#edit").modal('hide');
                            let targetBtn = $("#recurringPeriodTable").find('button[data-id=' + recurringPeriodId + ']');
                            targetBtn.closest('td').prev().html(res.data.RECURRING_PERIOD_NAME);
                            targetBtn.data('name', res.data.RECURRING_PERIOD_NAME);

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

        // On closing Edit Recurring Period modal, reset form and remove validation errors, if any
        $("#edit").on('hidden.bs.modal', function() {
            $("#editRecurringPeriodForm").trigger('reset');
            $("#editRecurringPeriodForm").data('validator').resetForm();
            $("#newRecurringPeriodName").removeClass('error').removeAttr('aria-invalid');
        });

        $("#resetEditFormBtn").click(function() {
            setTimeout(() => {
                $("#newRecurringPeriodName").valid()
            }, 10);
        });

    });

    function editInfo(el) {
        // el has been passed 'this' to get data-* attributes of clicked button
        // Set initial form details using button's data attributes set while loading/reloading table
        $("#recurringPeriodId").val($(el).data('id'));
        $("#newRecurringPeriodName").attr('value', $(el).data('name'));
        $("#edit").modal('show');
    }

    function updateStatus(el) {
        // el has been passed this (clicked button)
        let recurringPeriodId = $(el).data('id');

        toastr.warning("<br /><button type='button' class='btn btn-success mr-2' value='yes'>Yes</button><button class='btn btn-danger' type='button' value='no' >No</button>", 'Are you sure?', {
            allowHtml: true,
            onclick: function(toast) {
                value = toast.target.value;
                if (value == 'yes') {
                    var url = "{{ route('recurring-periods.update-status') }}";

                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            recurring_period_id: recurringPeriodId
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