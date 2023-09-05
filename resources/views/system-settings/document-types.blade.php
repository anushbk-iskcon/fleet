@extends('layouts.main.app')

@section('title', 'Document Types')

@section('breadcrumb-content')
<li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
<li class="breadcrumb-item active" id="moduleName">System Settings</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">System Settings</h1>
<small id="controllerName">Manage Document Types</small>
@endsection

@section('content')

<div id="add0" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Add Document Type</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{route('document-type-settings.add')}}" id="addDocumentTypeForm" class="row" method="post" accept-charset="utf-8">
                    @csrf
                    <div class="col-md-12 col-lg-12">
                        <div class="form-group row">
                            <label for="document_name" class="col-sm-5 col-form-label">Document Name <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="document_name" required required class="form-control" type="text" placeholder="Document Name" id="document_name">
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
                <strong>Update Document Type</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body editinfo">
                <form action="{{route('document-type-settings.update')}}" id="editDocumentTypeForm" class="row" method="post" accept-charset="utf-8">
                    @csrf
                    <input type="hidden" id="documentTypeId" name="document_type_id">
                    <div class="col-md-12 col-lg-12">
                        <div class="form-group row">
                            <label for="document_name" class="col-sm-5 col-form-label">Document Name <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="document_name" required required class="form-control" type="text" placeholder="Document Name" id="new_document_name">
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
                <h4 class="pl-3">Document Type
                    <small class="float-right">
                        <button type="button" class="btn btn-primary btn-md" data-target="#add0" data-toggle="modal">
                            <i class="ti-plus" aria-hidden="true"></i>
                            Add Document Type
                        </button>
                    </small>
                </h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="documentTypesTable" class="table display table-bordered table-striped table-hover ">
                        <thead>
                            <tr>
                                <th>Sl No.</th>
                                <th>Document Name</th>
                                <th>Action(s)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($documentTypes as $documentType)
                            <tr>
                                <td> {{$loop->iteration}} </td>
                                <td> {{$documentType['DOCUMENT_TYPE_NAME']}} </td>
                                <td>
                                    <button class="btn btn-info mr-1" title="Edit" data-id="{{$documentType['DOCUMENT_TYPE_ID']}}" data-name="{{$documentType['DOCUMENT_TYPE_NAME']}}" onclick="editInfo(this);">
                                        <i class="ti-pencil"></i>
                                    </button>
                                    @if($documentType['IS_ACTIVE'] == 'Y')
                                    <button class="btn btn-danger mr-1" title="Deactivate" data-id="{{$documentType['DOCUMENT_TYPE_ID']}}" onclick="updateStatus(this)">
                                        <i class="ti-close"></i>
                                    </button>
                                    @else
                                    <button class="btn btn-success mr-1" title="Activate" data-id="{{$documentType['DOCUMENT_TYPE_ID']}}" onclick="updateStatus(this)">
                                        <i class="ti-reload"></i>
                                    </button>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            <!-- <tr>
                                <td>1</td>
                                <td>Trade License</td>
                                <td>
                                    <input name="url" type="hidden" id="url_1" value="https://vmsdemo.bdtask-demo.com/setting/Setting/updatedocumentfrm" />
                                    <a onclick="editinfo(1)" class="btn btn-xs btn-success btn-sm mr-1 text-white" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                    <a href="https://vmsdemo.bdtask-demo.com/setting/Setting/delete_documenttype/1" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Driving License</td>
                                <td>
                                    <input name="url" type="hidden" id="url_2" value="https://vmsdemo.bdtask-demo.com/setting/Setting/updatedocumentfrm" />
                                    <a onclick="editinfo(2)" class="btn btn-xs btn-success btn-sm mr-1 text-white" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                    <a href="https://vmsdemo.bdtask-demo.com/setting/Setting/delete_documenttype/2" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                                </td>
                            </tr> -->

                        </tbody>
                    </table> <!-- /.table-responsive -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <script src="{{asset('dist/js/document_list.js')}}"></script> -->
@endsection

@section('js-content')
<script>
    $(document).ready(function() {
        let documentTypesTable = $("#documentTypesTable").DataTable();

        // To add serial numbers in data table on adding new item
        documentTypesTable.on('draw.dt', function() {
            var PageInfo = $('#documentTypesTable').DataTable().page.info();
            documentTypesTable.column(0, {
                page: 'current'
            }).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1 + PageInfo.start;
            });
        });

        // Validate and Submit Add Document Type Form
        $("#addDocumentTypeForm").validate({
            rules: {
                document_name: {
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
                            let actionBtns = '<button type="button" class="btn btn-info mr-1" title="Edit" data-name="' + res.data.DOCUMENT_TYPE_NAME + '" data-id="' + res.data.DOCUMENT_TYPE_ID + '" onclick="editInfo(this)"><i class="ti-pencil"></i></button>';
                            actionBtns += ' <button type="button" class="btn btn-danger mr-1" title="Deactivate" data-id="' + res.data.DOCUMENT_TYPE_ID + '" onclick="updateStatus(this)"><i class="ti-close"></i></button>';
                            documentTypesTable.row.add(['', res.data.DOCUMENT_TYPE_NAME, actionBtns]).draw();
                        } else {
                            toastr.error(res.message, '', {
                                closeButton: true
                            });
                        }
                    },
                    error: function(jqXHR, textStatus, err) {
                        toastr.error('Error adding document type. Please try again', '', {
                            closeButton: true
                        });
                    }
                });
            }
        });

        // On closing Add Document Type Form Modal, reset form and remove validation mesages
        $("#add0").on('hidden.bs.modal', function() {
            $("#addDocumentTypeForm").trigger('reset');
            $("#addDocumentTypeForm").validate().resetForm();
            $("#document_name").removeClass('error');
            $("#document_name").removeAttr('aria-invalid');
        });

        // On resetting Add document Type Form
        $("#resetAddFormBtn").click(function() {
            $("#addDocumentTypeForm").trigger('reset');
            $("#addDocumentTypeForm").validate().resetForm();
            $("#document_name").removeClass('error');
            $("#document_name").removeAttr('aria-invalid');
        });

        // Validate and Submit Edit Maintenance Type Form
        $("#editDocumentTypeForm").validate({
            rules: {
                mainten_name: {
                    required: true,
                    minlength: 2,
                    maxlength: 100
                }
            },
            submitHandler: function(form, ev) {
                ev.preventDefault();
                let documentTypeId = $("#documentTypeId").val();

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
                            let targetBtn = $("#documentTypesTable").find('button[data-id=' + documentTypeId + ']');
                            targetBtn.closest('td').prev().html(res.data.DOCUMENT_TYPE_NAME);
                            targetBtn.data('name', res.data.DOCUMENT_TYPE_NAME);
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

        // On closing Edit Dcoument Type Form Modal, reset form and remove validation mesages
        $("#edit").on('hidden.bs.modal', function() {
            $("#editDocumentTypeForm").trigger('reset');
            $("#editDocumentTypeForm").validate().resetForm();
            $("#new_document_name").removeClass('error');
            $("#new_document_name").removeAttr('aria-invalid');
        });

        $("#resetEditFormBtn").click(function() {
            setTimeout(() => {
                $("#new_document_name").valid();
            }, 10);
        });

    });
</script>

<script>
    function editInfo(el) {
        // el has been passed 'this' to get data-* attributes of clicked button
        // Set initial form details using button's data attributes set while loading/reloading table
        $("#documentTypeId").val($(el).data('id'));
        $("#new_document_name").attr('value', $(el).data('name'));
        $("#edit").modal('show');
    }

    function updateStatus(el) {
        // el has been passed this (clicked button)
        let documentTypeId = $(el).data('id');

        toastr.warning("<br /><button type='button' class='btn btn-success mr-2' value='yes'>Yes</button><button class='btn btn-danger' type='button' value='no' >No</button>", 'Are you sure?', {
            allowHtml: true,
            onclick: function(toast) {
                value = toast.target.value
                if (value == 'yes') {
                    var url = "{{ route('document-type-settings.update-status') }}";

                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            document_type_id: documentTypeId
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