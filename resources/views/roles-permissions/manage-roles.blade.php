@extends('layouts.main.app')

@section('title', 'Manage Roles')

@section('breadcrumb-content')
<li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
<li class="breadcrumb-item active" id="moduleName">Dashboard</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">Dashboard</h1>
<small id="controllerName">Manage User Roles</small>
@endsection

@section('content')

<div class="row">
    <div class="col-lg-12">
    </div>
</div>
<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="card">
            <h4 class="card-header">Manage roles
                <small class="float-right">
                    <a href="{{route('roles.create')}}" class="btn btn-success">Create role</a>
                </small>
            </h4>
            <div class="card-body">
                <table class="table display table-bordered table-striped table-hover bg-white m-0 card-table" id="RoleTbl">
                    <thead>
                        <tr>
                            <th>Sl No.</th>
                            <th>Role Name</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Dynamic table body -->
                        @foreach($roles as $role)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$role['ROLE_NAME']}}</td>
                            <td>{{$role->DESCRIPTION}}</td>
                            <td>
                                <a href="{{route('roles.edit', $role->ROLE_ID)}}" data-toggle="tooltip" data-placement="left" title="Update" class="btn btn-success btn-sm"><i class="ti-pencil-alt" aria-hidden="true"></i></a>
                                <button @if($role['IS_ACTIVE']=='Y' ) onclick="deactivateRole(this)" @else onclick="activateRole(this)" @endif class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="right" data-role-id="{{$role->ROLE_ID}}" title="Deactivate">
                                    @if($role['IS_ACTIVE']=='Y' )
                                    <i class="fa ti-trash" aria-hidden="true"></i>
                                    @else
                                    <i class="fa ti-reload" aria-hidden="true"></i>
                                    @endif
                                </button>
                            </td>
                        </tr>

                        @endforeach

                        <!-- Existing static table
                        <tr>
                            <td>1</td>
                            <td>guest</td>
                            <td></td>
                            <td>
                                <!-- <a href="https://vmsdemo.bdtask-demo.com/dashboard/role/edit_role/1" data-toggle="tooltip" data-placement="left" title="Update" class="btn btn-success btn-sm"><i class="ti-pencil-alt" aria-hidden="true"></i></a> -->
                        <!-- <a href="{{route('roles.edit',1)}}" data-toggle="tooltip" data-placement="left" title="Update" class="btn btn-success btn-sm"><i class="ti-pencil-alt" aria-hidden="true"></i></a> -->
                        <!-- <a href="https://vmsdemo.bdtask-demo.com/dashboard/role/delete_role/1" onclick="return confirm('Are you sure ?')" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="right" title="Delete "><i class="fa ti-trash" aria-hidden="true"></i></a> -->
                        <!-- <a href="#" onclick="return confirm('Are you sure ?')" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="right" title="Delete "><i class="fa ti-trash" aria-hidden="true"></i></a>
                        </td>
                        </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>hr</td>
                            <td></td>
                            <td>
                                <a href="#" data-toggle="tooltip" data-placement="left" title="Update" class="btn btn-success btn-sm"><i class="ti-pencil-alt" aria-hidden="true"></i></a>
                                <a href="#" onclick="return confirm('Are you sure ?')" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="right" title="Delete "><i class="fa ti-trash" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>neww</td>
                            <td></td>
                            <td>
                                <a href="#" data-toggle="tooltip" data-placement="left" title="Update" class="btn btn-success btn-sm"><i class="ti-pencil-alt" aria-hidden="true"></i></a>
                                <a href="#" onclick="return confirm('Are you sure ?')" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="right" title="Delete "><i class="fa ti-trash" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Manager</td>
                            <td>Manager Admin</td>
                            <td>
                                <a href="#" data-toggle="tooltip" data-placement="left" title="Update" class="btn btn-success btn-sm"><i class="ti-pencil-alt" aria-hidden="true"></i></a>
                                <a href="#" onclick="return confirm('Are you sure ?')" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="right" title="Delete "><i class="fa ti-trash" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                        -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    function deactivateRole(el) {
        let role_id = $(el).attr('data-role-id');
        if (confirm("Deactivate role?")) {
            $.ajax({
                url: "{{route('roles.deactivate')}}",
                type: 'PUT',
                data: {
                    _token: "{{csrf_token()}}",
                    role_id: role_id
                },
                success: function(res) {
                    console.log(res);
                    toastr.success(res, '', {
                        closeButton: true
                    });
                    $(el).find('i').removeClass('ti-trash').addClass('ti-reload');
                    $(el).prop('title', 'Activate');
                    $(el).attr('data-original-title', 'Activate');
                    $(el).attr('onclick', 'activateRole(this)');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log("Could not deactivate role");
                    toastr.error("Could not deactivate user", "", {
                        closeButton: true
                    });
                }
            });
        }
    }

    function activateRole(el) {
        let role_id = $(el).attr('data-role-id');
        if (confirm("Activate role?")) {
            $.ajax({
                url: "{{route('roles.activate')}}",
                type: 'PUT',
                data: {
                    _token: "{{csrf_token()}}",
                    role_id: role_id
                },
                success: function(res) {
                    console.log(res);
                    toastr.success(res, '', {
                        closeButton: true
                    });
                    $(el).find('i').removeClass('ti-reload').addClass('ti-trash');
                    $(el).prop('title', 'Deactivate');
                    $(el).attr('data-original-title', 'Deactivate');
                    $(el).attr('onclick', 'deactivateRole(this)');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log("Could not activate role");
                    toastr.error("Could not activate role", "", {
                        closeButton: true
                    });
                }
            });
        }
    }
</script>
@endsection