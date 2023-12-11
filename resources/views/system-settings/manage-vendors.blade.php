@extends('layouts.main.app')

@section('title', 'Manage Vendors')

@section('breadcrumb-content')
<li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
<li class="breadcrumb-item active" id="moduleName">System Settings</li>
@endsection

@section('css-content')
<style>
    .action-btns-container {
        display: flex;
        flex-wrap: nowrap;
        justify-content: flex-end;
        gap: 20px;
    }

    #vendorsTable tr td:last-child .btn {
        margin-right: 20px !important;
    }
</style>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">System Settings</h1>
<small id="controllerName">Manage Vendors</small>
@endsection

@section('content')

<div id="add0" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Add Vendor</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{route('vendor-settings.add')}}" id="addVendorForm" class="row" method="post" accept-charset="utf-8">
                    @csrf
                    <div class="col-md-12 col-lg-12">
                        <div class="form-group row">
                            <label for="vendor_name" class="col-sm-5 col-form-label">Vendor Name <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="vendor_name" required class="form-control" type="text" placeholder="Vendor Name" id="vendor_name">
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
                <strong>Update Vendor</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body editinfo">
                <form action="{{route('vendor-settings.update')}}" id="editVendorForm" class="row" method="post" accept-charset="utf-8">
                    @csrf
                    <input type="hidden" name="vendor_id" id="vendorId">
                    <div class="col-md-12 col-lg-12">
                        <div class="form-group row">
                            <label for="new_vendor_name" class="col-sm-5 col-form-label">Vendor Name <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="new_vendor_name" required class="form-control" type="text" placeholder="Vendor Name" id="new_vendor_name">
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
                <h4 class="pl-3">Manage Vendors
                    <small class="float-right">
                        <button type="button" class="btn btn-primary btn-md" data-target="#add0" data-toggle="modal"><i class="ti-plus" aria-hidden="true"></i>
                            Add Vendor
                        </button>
                    </small>
                </h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="vendorsTable" class="table display table-bordered table-striped table-hover ">
                        <thead>
                            <tr>
                                <th>Sl. No.</th>
                                <th>Vendor Name</th>
                                <th>Action(s)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($vendors as $vendor)
                            <tr>
                                <td> {{$loop->iteration}} </td>
                                <td>
                                    {{$vendor['VENDOR_NAME']}}
                                </td>
                                <td>
                                    <button type="button" class="btn btn-info btn-sm mr-1" data-id="{{$vendor['VENDOR_ID']}}" data-name="{{$vendor['VENDOR_NAME']}}" title="Edit" onclick="editInfo(this)">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    @if($vendor['IS_ACTIVE'] == 'Y')
                                    <button type="button" class="btn btn-danger btn-sm mr-1" title="Deactivate" data-id="{{$vendor['VENDOR_ID']}}" onclick="updateStatus(this)"><i class="ti-close"></i></button>
                                    @else
                                    <button type="button" class="btn btn-success btn-sm mr-1" title="Activate" data-id="{{$vendor['VENDOR_ID']}}" onclick="updateStatus(this)"><i class="ti-reload"></i></button>
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
<script src="{{asset('dist/js/vendor_list.js')}}"></script>

<script>
    $(document).ready(function() {
        let vendorsTable = $("#vendorsTable").DataTable({
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
        vendorsTable.on('draw.dt', function() {
            var PageInfo = $('#vendorsTable').DataTable().page.info();
            vendorsTable.column(0, {
                page: 'current'
            }).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1 + PageInfo.start;
            });
        });

        $("#addVendorForm").validate({
            rules: {
                vendor_name: {
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
                            let actionBtns = '<button type="button" class="btn btn-info btn-sm mr-1" title="Edit" data-name="' + res.data.VENDOR_NAME + '" data-id="' + res.data.VENDOR_ID + '" onclick="editInfo(this)"><i class="fa fa-edit"></i></button>';
                            actionBtns += ' <button type="button" class="btn btn-danger btn-sm mr-1" title="Deactivate" data-id="' + res.data.VENDOR_ID + '" onclick="updateStatus(this)"><i class="ti-close"></i></button>';
                            vendorsTable.row.add(['', res.data.VENDOR_NAME, actionBtns]).draw();
                        } else {
                            toastr.error(res.message, '', {
                                closeButton: true
                            });
                        }
                    },
                    error: function(jqXHR, textStatus, err) {
                        toastr.error('Error adding vendor. Please tyry again', '', {
                            closeButton: true
                        });
                    }
                });
            }
        });

        $("#editVendorForm").validate({
            rules: {
                new_vendor_name: {
                    required: true,
                    minlength: 2,
                    maxlength: 100
                },
            },
            submitHandler: function(form, ev) {
                ev.preventDefault();
                let vendorId = $("#vendorId").val();

                $.ajax({
                    url: form.action,
                    method: form.method,
                    data: $(form).serialize(),
                    success: function(res) {
                        if (res.successCode == 1) {
                            toastr.success(res.message, '', {
                                closeButton: true
                            });

                            $("#edit").modal('hide');
                            let targetBtn = $("#vendorsTable").find('button[data-id=' + vendorId + ']');
                            // To show latest data in view after updating
                            targetBtn.closest('td').prev().html(res.data.VENDOR_NAME);
                            targetBtn.data('name', res.data.VENDOR_NAME);
                        } else {
                            toastr.error(res.message, '', {
                                closeButton: true
                            });
                        }
                    },
                    error: function(jqXHR, textStartus, err) {
                        toastr.error('Error updating vendor. Please try again', '', {
                            closeButton: true
                        });
                    }
                });
            }

        });

        // Remove validations, errors and reset add Vendor form on closing modal
        $("#add0").on('hidden.bs.modal', function(ev) {
            $("#addVendorForm").trigger('reset');
            $("#addVendorForm").validate().resetForm();
            $("#vendor_name").removeClass('error');
            $("#vendor_name").removeAttr('aria-invalid');
        });

        // Remove validation errors on restting add form
        $("#resetAddFormBtn").click(function() {
            $("#addVendorForm").trigger('reset');
            $("#addVendorForm").validate().resetForm();
            $("#vendor_name").removeClass('error');
            $("#vendor_name").removeAttr('aria-invalid');
        });

        // Remove validations, errors and reset Edit Vendor form on closing modal
        $("#edit").on('hidden.bs.modal', function(ev) {
            $("#editVendorForm").trigger('reset');
            $("#editVendorForm").validate().resetForm();
            $("#new_vendor_name").removeClass('error');
            $("#new_vendor_name").removeAttr('aria-invalid');
        });

        // Remove vlaidation erros on resetting edit form
        $("#resetEditFormBtn").click(function() {
            setTimeout(() => {
                $("#new_vendor_name").valid();
            }, 10);
        });

    });
</script>

<script>
    function editInfo(el) {
        $("#vendorId").val($(el).data('id'));
        $("#new_vendor_name").attr('value', $(el).data('name'));
        $("#edit").modal('show');
    }

    function updateStatus(el) {
        let vendorId = $(el).data('id');

        toastr.warning("<br /><button type='button' class='btn btn-success mr-2' value='yes'>Yes</button><button class='btn btn-danger' type='button' value='no' >No</button>", 'Are you sure?', {
            allowHtml: true,
            onclick: function(toast) {
                value = toast.target.value;
                if (value == 'yes') {
                    var url = "{{ route('vendor-settings.status-update') }}";

                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            vendor_id: vendorId
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