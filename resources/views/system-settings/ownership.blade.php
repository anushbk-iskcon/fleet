@extends('layouts.main.app')

@section('title', 'Ownerships')

@section('breadcrumb-content')
<li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
<li class="breadcrumb-item active" id="moduleName">System Settings</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">System Settings</h1>
<small id="controllerName">Ownerships</small>
@endsection

@section('content')

<div id="add0" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Add Ownership</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="addownership" class="row" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                    @csrf
                    <div class="col-md-12 col-lg-12">
                        <div class="form-group row">
                            <label for="ownership_name" class="col-sm-5 col-form-label">Ownership Name <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="ownership_name_add" required class="form-control" type="text" placeholder="Ownership Name" id="ownership_name_add">
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
                <strong>Update Ownership</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="" id="updateOwnership" class="row" method="post" accept-charset="utf-8">
                    <input type="hidden" name="ownership_id" id="ownership_id">
                    @csrf
                    @method('put')
                    <div class="col-md-12 col-lg-12">
                        <div class="form-group row">
                            <label for="ownership_name_update" class="col-sm-5 col-form-label">Ownership Name <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="ownership_name_update" required required class="form-control" type="text" placeholder="Ownership Name" id="ownership_name_update">
                            </div>
                        </div>
                        <div class="form-group text-right">
                            <button type="reset" class="btn btn-primary w-md m-b-5">Reset</button>
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
                <h4 class="pl-3">Ownership<small class="float-right">

                        <button type="button" class="btn btn-primary btn-md" data-target="#add0" data-toggle="modal"><i class="ti-plus" aria-hidden="true"></i>
                            Add Ownership</button>
                    </small></h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example_ownership" class="table table-striped table-bordered dt-responsive nowrap">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Ownership Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ownerships as $ownership)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $ownership->OWNERSHIP_NAME }}</td>
                                <td>
                                    <a data-id="{{ $ownership->OWNERSHIP_ID }}" data-name="{{ $ownership->OWNERSHIP_NAME }}" data-toggle="modal" href="#add1" class="btn btn-xs btn-success btn-sm mr-1 text-white" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                    @if($ownership->IS_ACTIVE == 'Y')
                                    <a href="javascript:void(0);" id="status-{{ $ownership->OWNERSHIP_ID }}" onclick="deletedownership({{$ownership->OWNERSHIP_ID}})" class="btn btn-xs btn-danger btn-sm"><i id="icon-{{ $ownership->OWNERSHIP_ID }}" class="ti-close" title="Deactivate"></i></a>
                                    @else
                                    <a href="javascript:void(0);" id="status-{{ $ownership->OWNERSHIP_ID }}" onclick="deletedownership({{$ownership->OWNERSHIP_ID}})" class="btn btn-xs btn-success btn-sm"><i id="icon-{{ $ownership->OWNERSHIP_ID }}" class="ti-check" title="Activate"></i></a>
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
<!-- <script src="{{asset('dist/js/ownership_list.js')}}"></script> -->
<script>
    $(document).ready(function() {

        var ownership_table = $("#example_ownership").DataTable();

        ownership_table.on('draw.dt', function() {
            var PageInfo = $('#example_ownership').DataTable().page.info();
            ownership_table.column(0, {
                page: 'current'
            }).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1 + PageInfo.start;
            });
        });

        /*------------------------------------------------------------------------------------------*/
        $("#addownership").validate({
            rules: {
                ownership_name_add: 'required'
            },
            submitHandler: function(form, ev) {
                ev.preventDefault();
                $.ajax({
                    url: '{{ route("ownership.store") }}',
                    type: 'post',
                    data: $(form).serialize(),
                    success: function(res) {
                        toastr.success('Ownership Created', '', {
                            closeButton: true
                        });

                        $('#add0').modal('hide');
                        $("#addownership").trigger("reset");

                        let action = '<a data-id="' + res['OWNERSHIP_ID'] + '" data-name="' + res['OWNERSHIP_NAME'] + '" data-toggle="modal"  href="#add1" class="btn btn-xs btn-success btn-sm mr-1 text-white" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="javascript:void(0);" id="status-' + res['OWNERSHIP_ID'] + '" onclick="deletedOwnership(' + res['OWNERSHIP_ID'] + ')" class="btn btn-xs btn-success btn-sm"><i id="icon-' + res['OWNERSHIP_ID'] + '" class="ti-close" title="Deactivate"></i></a>'

                        ownership_table.row.add(['', res['OWNERSHIP_NAME'], action]).draw();

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

        $("#add0").on('hidden.bs.modal', function(e) {
            $("#addownership").trigger('reset');
            $("#addownership").validate().resetForm();
            $("#ownership_name_add").removeClass('error');
            $("#ownership_name_add").removeAttr('aria-invalid');
        });

        /*------------------------------------------------------------------------------------------*/

        $('#add1').on('show.bs.modal', function(e) {

            //get data-id attribute of the clicked element
            var ownershipId = $(e.relatedTarget).data('id');
            var ownershipName = $(e.relatedTarget).data('name');

            //populate the textbox
            $(e.currentTarget).find('input[name="ownership_id"]').val(ownershipId);
            $(e.currentTarget).find('input[name="ownership_name_update"]').val(ownershipName);

        });

        /*------------------------------------------------------------------------------------------*/

        $("#updateOwnership").validate({
            rules: {
                ownership_name_update: {
                    required: true,
                    minlength: 2,
                    maxlength: 100
                }
            },
            submitHandler: function(form, ev) {
                ev.preventDefault();
                let ownershipId = $(form).find("#ownership_id").val();
                let updateOwnershipURL = "{{route('ownership.update', 0)}}";
                updateOwnershipURL = updateOwnershipURL.replace('0', ownershipId);
                console.log(updateOwnershipURL);
                $.ajax({
                    url: updateOwnershipURL,
                    type: 'put',
                    data: $(form).serialize(),
                    success: function(res) {
                        toastr.success('Successfully updated ownership', '', {
                            closeButton: true
                        });
                        console.log(res);
                        $("#add1").modal('hide');
                        let targetBtn = $("#example_ownership").find('a[data-id=' + ownershipId + ']');
                        let rowToUpdate = targetBtn.closest('tr').find('td')[1];
                        $(rowToUpdate).html(res.OWNERSHIP_NAME);
                        targetBtn.data('name', res.OWNERSHIP_NAME);
                    },
                    error: function(jqXHR, textStatus, err) {
                        toastr.error('Some error occured. Please try again', '', {
                            closeButton: true
                        });
                    }
                })
            }
        });


        /*------------------------------------------------------------------------------------------*/

        $("#add1").on('hidden.bs.modal', function(e) {
            $("#updateOwnership").trigger('reset');
            $("#updateOwnership").validate().resetForm();
            $("#ownership_name_update").removeClass('error');
            $("#ownership_name_update").removeAttr('aria-invalid');
        });

        /*------------------------------------------------------------------------------------------*/


    });
</script>
<script type="text/javascript">
    function deletedownership(ownershipId) {
        toastr.warning("<br /><button type='button' class='btn btn-success mr-2' value='yes'>Yes</button><button class='btn btn-danger' type='button' value='no' >No</button>", 'Are you sure?', {
            allowHtml: true,
            onclick: function(toast) {
                value = toast.target.value
                if (value == 'yes') {

                    var url = "{{ route('ownership.status', 0) }}";
                    url = url.replace('0', ownershipId);

                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function(response) {

                            toastr.remove();

                            if (response['IS_ACTIVE'] == 'Y') {
                                $('#status-' + response['OWNERSHIP_ID'] + '').removeClass("btn-success");
                                $('#status-' + response['OWNERSHIP_ID'] + '').addClass("btn-danger");
                                $('#icon-' + response['OWNERSHIP_ID'] + '').removeClass("ti-check");
                                $('#icon-' + response['OWNERSHIP_ID'] + '').addClass("ti-close");
                                $('#icon-' + response['OWNERSHIP_ID'] + '').attr("title", "Deactivate");

                            } else {
                                $('#status-' + response['OWNERSHIP_ID'] + '').removeClass("btn-danger");
                                $('#status-' + response['OWNERSHIP_ID'] + '').addClass("btn-success");
                                $('#icon-' + response['OWNERSHIP_ID'] + '').removeClass("ti-close");
                                $('#icon-' + response['OWNERSHIP_ID'] + '').addClass("ti-check");
                                $('#icon-' + response['OWNERSHIP_ID'] + '').attr("title", "Activate");
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