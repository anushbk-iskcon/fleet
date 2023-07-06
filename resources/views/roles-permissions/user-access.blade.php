@extends('layouts.main.app')

@section('title', 'User Access Roles')

@section('breadcrumb-content')
<li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
<li class="breadcrumb-item active" id="moduleName">Dashboard</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">Dashboard</h1>
<small id="controllerName">User Access Roles</small>
@endsection

@section('content')

<div class="row">
    <div class="col-lg-12">
    </div>
</div>
<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="card">
            <h4 class="card-header">User Access Role Details
                <small class="float-right">
                    <a href="{{route('roles.assign-role-to-user')}}" class="btn btn-success">Assign role</a>
                </small>
            </h4>
            <div class="card-body">
                <table class="table display table-bordered table-striped table-hover bg-white m-0 card-table" id="RoleTbl">
                    <thead>
                        <tr>
                            <th>Sl No.</th>
                            <th>Username</th>
                            <th>Role Name</th>
                            <th>Action(s)</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($userRoles as $userAccessRole)
                        <tr>
                            <td> {{$loop->iteration}} </td>
                            <td> {{$userAccessRole->FIRST_NAME . " " . $userAccessRole->LAST_NAME }} </td>
                            <td> {{$userAccessRole->ROLE_NAME}} </td>
                            <td>
                                <a href="{{route('edit-user-acess-role', $userAccessRole->USER_ID)}}" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil-alt" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>

@endsection