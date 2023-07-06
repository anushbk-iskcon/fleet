@extends('layouts.main.app')

@section('title', 'Departments')

@section('breadcrumb-content')
<li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
<li class="breadcrumb-item active" id="moduleName">System Settings</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">System Settings</h1>
<small id="controllerName">Departments</small>
@endsection

@section('content')

<div id="add0" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Add Department</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="addDepartment" class="row" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                    @csrf
                    <div class="col-md-12 col-lg-12">
                        <div class="form-group row">
                            <label for="department_name" class="col-sm-5 col-form-label">Department Name <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="department_name_add" required required class="form-control" type="text" placeholder="Department Name" id="department_name_add">
                            </div>
                        </div>
                        <div class="form-group text-right">
                            <button type="reset" class="btn btn-primary w-md m-b-5">Reset</button>
                            <button type="submit" class="btn btn-success w-md m-b-5">Add</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<div id="add1" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Update Department</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="updateDepartment" class="row" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                    @csrf
                    <input type="hidden" name="department_id" id="department_id">
                    <div class="col-md-12 col-lg-12">
                        <div class="form-group row">
                            <label for="department_name_update" class="col-sm-5 col-form-label">Department Name <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="department_name_update" required required class="form-control" type="text" placeholder="Department Name" id="department_name_update">
                            </div>
                        </div>
                        <div class="form-group text-right">
                            <button type="reset" class="btn btn-primary w-md m-b-5">Reset</button>
                            <button type="submit" class="btn btn-success w-md m-b-5">Add</button>
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
                <h4 class="pl-3">Department<small class="float-right">

                        <button type="button" class="btn btn-primary btn-md" data-target="#add0" data-toggle="modal"><i class="ti-plus" aria-hidden="true"></i>
                            Add Department</button>
                    </small></h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example_department" class="table table-striped table-bordered dt-responsive nowrap">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Department Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($departments as $department)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td id="name-{{ $department->DEPARTMENT_ID }}">{{ $department->DEPARTMENT_NAME }}</td>
                                <td id="action-{{ $department->DEPARTMENT_ID }}">
                                    <a data-id="{{ $department->DEPARTMENT_ID }}" data-name="{{ $department->DEPARTMENT_NAME }}" data-toggle="modal" href="#add1" class="btn btn-xs btn-success btn-sm mr-1 text-white" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                    @if($department->IS_ACTIVE == 'Y')
                                    <a href="javascript:void(0);" id="status-{{ $department->DEPARTMENT_ID }}" onclick="deletedDepartment({{$department->DEPARTMENT_ID}})" class="btn btn-xs btn-danger btn-sm"><i id="icon-{{ $department->DEPARTMENT_ID }}" class="ti-close"></i></a>
                                    @else
                                    <a href="javascript:void(0);" id="status-{{ $department->DEPARTMENT_ID }}" onclick="deletedDepartment({{$department->DEPARTMENT_ID}})" class="btn btn-xs btn-success btn-sm"><i id="icon-{{ $department->DEPARTMENT_ID }}" class="ti-check"></i></a>
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
<!-- <script src="{{asset('dist/js/department_list.js')}}"></script> -->
<script>
    $(document).ready(function() {
        /*------------------------------------------------------------------------------------------*/

        var department_table = $("#example_department").DataTable();

        department_table.on('draw.dt', function() {
            var PageInfo = $('#example_department').DataTable().page.info();
            department_table.column(0, {
                page: 'current'
            }).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1 + PageInfo.start;
            });
        });

        /*------------------------------------------------------------------------------------------*/
        $("#addDepartment").validate({
            rules: {
                department_name_add: 'required'
            },
            submitHandler: function(form, ev) {
                ev.preventDefault();
                $.ajax({
                    url: '{{ route("department.store") }}',
                    type: 'post',
                    data: $(form).serialize(),
                    success: function(res) {
                        toastr.success('Department Created', '', {
                            closeButton: true
                        });

                        $('#add0').modal('hide');
                        $("#addDepartment").trigger("reset");

                        let action = '<a data-id="' + res['DEPARTMENT_ID'] + '" data-name="' + res['DEPARTMENT_NAME'] + '" data-toggle="modal"  href="#add1" class="btn btn-xs btn-success btn-sm mr-1 text-white" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="javascript:void(0);" id="status-' + res['DEPARTMENT_ID'] + '" onclick="deletedDepartment(' + res['DEPARTMENT_ID'] + ')" class="btn btn-xs btn-success btn-sm"><i id="icon-' + res['DEPARTMENT_ID'] + '" class="ti-check"></i></a>'

                        department_table.row.add(['', res['DEPARTMENT_NAME'], action]).draw();

                    },
                    error: function(jqXHR, text, err) {
                        toastr.error("Please try again.", '', {
                            closeButton: true
                        });
                    }
                });
            }
        });

        /*------------------------------------------------------------------------------------------*/

        var url = "{{ route('department.update',": department ")}}";
        let departmentId = $('#department_id').val();
        url = url.replace(':department', departmentId);

        $("#updateDepartment").validate({
            rules: {
                department_name_update: 'required'
            },
            submitHandler: function(form, ev) {
                ev.preventDefault();

                var url = "{{ route('department.update', 0)}}";
                let departmentId = $('#department_id').val();
                url = url.replace('0', departmentId);

                $.ajax({
                    url: url,
                    type: 'post',
                    data: $(form).serialize(),
                    success: function(response) {
                        toastr.success('Department Updated', '', {
                            closeButton: true
                        });

                        $('#add1').modal('hide');
                        $("#updateDepartment").trigger("reset");

                        let button = '';

                        if (response['IS_ACTIVE'] == 'Y') {

                            button = '<a href="javascript:void(0);" id="status-' + response['DEPARTMENT_ID'] + '" onclick="deletedDepartment(' + response['DEPARTMENT_ID'] + ')" class="btn btn-xs btn-danger btn-sm"><i id="icon-' + response['DEPARTMENT_ID'] + '" class="ti-close"></i></a>';
                        } else {
                            button = '<a href="javascript:void(0);" id="status-' + response['DEPARTMENT_ID'] + '" onclick="deletedDepartment(' + response['DEPARTMENT_ID'] + ')" class="btn btn-xs btn-success btn-sm"><i id="icon-' + response['DEPARTMENT_ID'] + '" class="ti-check"></i></a>'
                        }

                        let action = '<a data-id="' + response['DEPARTMENT_ID'] + '" data-name="' + response['DEPARTMENT_NAME'] + '" data-toggle="modal"  href="#add1" class="btn btn-xs btn-success btn-sm mr-1 text-white" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>' + button;

                        $('#name-' + response['DEPARTMENT_ID'] + '').html(response['DEPARTMENT_NAME']);
                        $('#action-' + response['DEPARTMENT_ID'] + '').html(action);

                    },
                    error: function(jqXHR, text, err) {
                        toastr.error("Please try again.", '', {
                            closeButton: true
                        });
                    }
                });
            }
        });

        /*------------------------------------------------------------------------------------------*/
        $('#add1').on('show.bs.modal', function(e) {

            //get data-id attribute of the clicked element
            var departmentId = $(e.relatedTarget).data('id');
            var departmentName = $(e.relatedTarget).data('name');

            //populate the textbox
            $(e.currentTarget).find('input[name="department_id"]').val(departmentId);
            $(e.currentTarget).find('input[name="department_name_update"]').val(departmentName);

        });

        /*------------------------------------------------------------------------------------------*/

        $("#add0").on('hidden.bs.modal', function() {
            $("#addDepartment").trigger('reset');
            $("#addDepartment").validate().resetForm();
            $("#department_name_add").removeClass('error');
            $("#department_name_add").removeAttr('aria-invalid');
        });

    });
</script>
<script type="text/javascript">
    function deletedDepartment(departmentId) {
        toastr.warning("<br /><button type='button' class='btn btn-success mr-2' value='yes'>Yes</button><button class='btn btn-danger' type='button' value='no' >No</button>", 'Are you sure?', {
            allowHtml: true,
            onclick: function(toast) {
                value = toast.target.value
                if (value == 'yes') {

                    var url = "{{ route('department.status', 0) }}";
                    url = url.replace('0', departmentId);

                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function(response) {

                            toastr.remove();

                            if (response['IS_ACTIVE'] == 'Y') {
                                $('#status-' + response['DEPARTMENT_ID'] + '').removeClass("btn-success");
                                $('#status-' + response['DEPARTMENT_ID'] + '').addClass("btn-danger");
                                $('#icon-' + response['DEPARTMENT_ID'] + '').removeClass("ti-check");
                                $('#icon-' + response['DEPARTMENT_ID'] + '').addClass("ti-close");
                            } else {
                                $('#status-' + response['DEPARTMENT_ID'] + '').removeClass("btn-danger");
                                $('#status-' + response['DEPARTMENT_ID'] + '').addClass("btn-success");
                                $('#icon-' + response['DEPARTMENT_ID'] + '').removeClass("ti-close");
                                $('#icon-' + response['DEPARTMENT_ID'] + '').addClass("ti-check");

                            }

                            toastr.success('Status Updated', '', {
                                closeButton: true
                            });
                        }
                    });


                }
            }

        });
    }
</script>
@endsection