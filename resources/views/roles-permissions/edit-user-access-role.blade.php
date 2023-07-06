@extends('layouts.main.app')

{{-- Screen to allow Editing Role assigned to a User --}}

@section('title', 'Edit User Access Role')

@section('breadcrumb-content')
<li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
<li class="breadcrumb-item active" id="moduleName">Dashboard</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">Dashboard</h1>
<small id="controllerName">Edit User Access Role</small>
@endsection

@section('content')

<div class="row">
    <div class="col-lg-12">
    </div>
</div>
<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="card">
            <h4 class="card-header"> Assign New Role To User
                <small class="float-right">
                    <a href="{{route('roles.user-access-roles')}}" class="btn btn-success"><i class="ti-plus"></i> User Access Role Details</a>
                </small>
            </h4>

            <form action="" method="post" accept-charset="utf-8" id="updateAssignedRoleForm">
                @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <label for="user_id" class="col-sm-3 col-form-label">User <i class="text-danger">*</i></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="user_name" id="user_name" required readonly value="{{$user->FIRST_NAME . " " . $user->LAST_NAME}}">
                            <input type="hidden" name="user_id" value="{{$user->USER_ID}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="role_id" class="col-sm-3 col-form-label">Role <i class="text-danger">*</i></label>
                        <div class="col-sm-9 mt-2">
                            @foreach($roles as $role)
                            <div class="custom-control custom-radio custom-control-inline">

                                <input type="radio" name="assigned_role" id="role{{$loop->iteration}}" class="custom-control-input" value="{{$role->ROLE_ID}}" @if($currentRole[0]->ROLE_ID == $role->ROLE_ID) checked @endif>
                                <label for="role{{$loop->iteration}}" class="custom-control-label">
                                    {{$role->ROLE_NAME}}
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-success w-md m-b-5">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    // For AJAX request
    let updateUserRoleURL = "{{url('roles/update-user-access')}}";
</script>

@endsection

@section('js-content')
<script>
    $(document).ready(function() {
        $("#updateAssignedRoleForm").validate({
            rules: {
                assigned_role: 'required'
            },
            submitHandler: function(form, ev) {
                ev.preventDefault();
                console.log($(form).serialize());
                $.ajax({
                    url: updateUserRoleURL,
                    type: 'post',
                    data: $(form).serialize(),
                    success: function(res) {
                        console.log(res);
                        toastr.success(res, '', {
                            closeButton: true
                        });
                    },
                    error: function(jqXHR, text, err) {
                        console.log("Error updating role. Please try again.");
                        toastr.error("Error updating role. Please try again.", '', {
                            closeButton: true
                        });
                    }
                });
            }
        });
    });
</script>
@endsection