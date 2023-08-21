@extends('layouts.main.app')

@section('title', 'Assign Roles')

@section('breadcrumb-content')
<li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
<li class="breadcrumb-item active" id="moduleName">Dashboard</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">Dashboard</h1>
<small id="controllerName">Assign Role to User</small>
@endsection

@section('content')

<div class="row">
    <div class="col-lg-12">
    </div>
</div>
<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="card">
            <h4 class="card-header"> Assign Role To User
                <small class="float-right">
                    <a href="{{route('roles.user-access-roles')}}" class="btn btn-success"><i class="ti-plus"></i> User Access Role Details</a>
                </small>
            </h4>
            <form action="" method="post" accept-charset="utf-8" id="assignRoleForm">
                @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <label for="user_id" class="col-sm-3 col-form-label">User <i class="text-danger">*</i></label>
                        <div class="col-sm-9">
                            <select class="form-control basic-single" name="user_id" id="user_id" required>
                                <option value="">Please Select One</option>
                                @foreach($users as $user)
                                <option value="{{$user->USER_ID}}">{{$user->FIRST_NAME . " " . $user->LAST_NAME}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="role_id" class="col-sm-3 col-form-label">Role <i class="text-danger">*</i></label>
                        <div class="col-sm-9 mt-2">
                            @foreach($roles as $role)
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" name="assigned_role" class="custom-control-input" id="role{{$loop->iteration}}" value="{{$role->ROLE_ID}}">
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
    // For AJAX request in assign-role.js
    let assignUserRoleURL = "{{route('roles.assign-user-role')}}";
</script>
@endsection
@section('js-content')
<script src="{{asset('public/dist/js/roles/assign-role.js')}}"></script>
@endsection