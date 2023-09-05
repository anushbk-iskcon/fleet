@extends('layouts.main.app')

@section('title', 'Manage Companies')

@section('breadcrumb-content')
<li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
<li class="breadcrumb-item active" id="moduleName">System Settings</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">System Settings</h1>
<small id="controllerName">Manage Companies</small>
@endsection

@section('content')

<div id="add0" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Add Company</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{route('manage-companies.add')}}" id="addCompanyForm" class="row" method="post" accept-charset="utf-8">
                    @csrf
                    <div class="col-md-12 col-lg-12">
                        <div class="form-group row">
                            <label for="companyName" class="col-sm-5 col-form-label">Company Name <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="company_name" required class="form-control" type="text" placeholder="Company Name" id="companyName">
                            </div>
                        </div>
                        <div class="form-group text-right">
                            <button type="reset" class="btn btn-primary w-md m-b-5" id="resetAddForm">Reset</button>
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
                <strong>Update Company</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body editinfo">
                <form action="{{route('manage-companies.update')}}" id="editCompanyForm" class="row" method="post" accept-charset="utf-8">
                    @csrf
                    <input type="hidden" name="company_id" id="editCompanyId">
                    <div class="col-md-12 col-lg-12">
                        <div class="form-group row">
                            <label for="newCompanyName" class="col-sm-5 col-form-label">Company Name <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="company_name" required class="form-control" type="text" placeholder="Company Name" id="newCompanyName">
                            </div>
                        </div>
                        <div class="form-group text-right">
                            <button type="reset" class="btn btn-primary w-md m-b-5" id="resetEditForm">Reset</button>
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
                <h4 class="pl-3">Manage Companies
                    <small class="float-right">
                        <button type="button" class="btn btn-primary btn-md" data-target="#add0" data-toggle="modal">
                            <i class="ti-plus" aria-hidden="true"></i>
                            Add Company
                        </button>
                    </small>
                </h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="companiesTable" class="table display table-bordered table-striped table-hover ">
                        <thead>
                            <tr>
                                <th>Sl No.</th>
                                <th>Company Name</th>
                                <th>Action(s)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($companies as $company)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td> {{$company['COMPANY_NAME']}} </td>
                                <td>
                                    <button type="button" class="btn btn-info mr-1" title="Edit" data-id="{{$company['COMPANY_ID']}}" data-name="{{$company['COMPANY_NAME']}}" onclick="editInfo(this);">
                                        <i class="ti-pencil"></i>
                                    </button>
                                    @if($company['IS_ACTIVE'] == 'Y')
                                    <button type="button" class="btn btn-danger mr-1" title="Deactivate" data-id="{{$company['COMPANY_ID']}}" onclick="updateStatus(this);">
                                        <i class="ti-close"></i>
                                    </button>
                                    @else
                                    <button type="button" class="btn btn-success mr-1" title="Activate" data-id="{{$company['COMPANY_ID']}}" onclick="updateStatus(this);">
                                        <i class="ti-reload"></i>
                                    </button>
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
<!-- <script src="{{asset('dist/js/company_list.js')}}"></script> -->
<script>
    $(document).ready(function() {
        let companiesTable = $("#companiesTable").DataTable();

        // To add serial numbers in data table on adding new item
        companiesTable.on('draw.dt', function() {
            var PageInfo = $('#companiesTable').DataTable().page.info();
            companiesTable.column(0, {
                page: 'current'
            }).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1 + PageInfo.start;
            });
        });

        // Validate and submit Add New Company Form
        $("#addCompanyForm").validate({
            rules: {
                company_name: {
                    required: true,
                    maxlength: 100
                }
            },
            submitHandler: function(form, ev) {
                ev.preventDefault();

                $.ajax({
                    url: form.action,
                    method: form.method,
                    data: $(form).serialize(),
                    dataType: 'json',
                    success: function(res) {
                        if (res.successCode == 1) {
                            toastr.success(res.message, '', {
                                closeButton: true
                            });

                            $("#add0").modal('hide');

                            //Add row to table:
                            let actionBtns = '<button type="button" class="btn btn-info mr-1" title="Edit" data-id="' + res.data.COMPANY_ID + '" data-name="' + res.data.COMPANY_NAME + '" onclick="editInfo(this)"><i class="ti-pencil"></i></button>';
                            actionBtns += ' <button type="button" class="btn btn-danger mr-1" title="Deactivate" data-id="' + res.data.COMPANY_ID + '" onclick="updateStatus(this)"><i class="ti-close"></i></button>';

                            companiesTable.row.add(['', res.data.COMPANY_NAME, actionBtns]).draw();
                        } else {
                            toastr.error(res.message, '', {
                                closeButton: true
                            });
                        }
                    },
                    error: function(jqXHR, textStatus, err) {
                        toastr.error('Error adding company. Please try again', '', {
                            closeButton: true
                        });
                    }
                });
            }
        });

        // On closing Add New Company Form, reset form and remove validation errors
        $("#add0").on('hidden.bs.modal', function() {
            $("#addCompanyForm").trigger('reset');
            $("#addCompanyForm").data('validator').resetForm();
            $("#companyName").removeClass('error').removeAttr('aria-invalid');
        });

        $("#resetAddForm").click(function() {
            $("#addCompanyForm").trigger('reset');
            $("#addCompanyForm").data('validator').resetForm();
            $("#companyName").removeClass('error').removeAttr('aria-invalid');
        });

        // Validate and submit Edit Company Form
        $("#editCompanyForm").validate({
            rules: {
                company_name: {
                    required: true,
                    maxlength: 100
                }
            },
            submitHandler: function(form, ev) {
                ev.preventDefault();
                let editCompanyId = $("#editCompanyId").val();

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
                            let targetBtn = $("#companiesTable").find('button[data-id=' + editCompanyId + ']');
                            targetBtn.closest('td').prev().html(res.data.COMPANY_NAME);
                            targetBtn.data('name', res.data.COMPANY_NAME);

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

        // On closing Edit Company modal, reset form and remove validation errors, if any
        $("#edit").on('hidden.bs.modal', function() {
            $("#editCompanyForm").trigger('reset');
            $("#editCompanyForm").data('validator').resetForm();
            $("#newCompanyName").removeClass('error').removeAttr('aria-invalid');
        });

        // On clicking reset button in EditCompany Form
        $("#resetEditForm").click(function() {
            setTimeout(() => {
                $("#newCompanyName").valid();
            }, 10);
        });

    });

    function editInfo(el) {
        // el has been passed 'this' to get data-* attributes of clicked button
        // Set initial form details using button's data attributes set while loading/reloading table
        $("#editCompanyId").val($(el).data('id'));
        $("#newCompanyName").attr('value', $(el).data('name'));
        $("#edit").modal('show');
    }

    function updateStatus(el) {
        // el has been passed this (clicked button)
        let companyId = $(el).data('id');

        toastr.warning("<br /><button type='button' class='btn btn-success mr-2' value='yes'>Yes</button><button class='btn btn-danger' type='button' value='no'>No</button>", 'Are you sure?', {
            allowHtml: true,
            onclick: function(toast) {
                value = toast.target.value;
                if (value == 'yes') {
                    var url = "{{ route('manage-companies.update-status') }}";

                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            company_id: companyId
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