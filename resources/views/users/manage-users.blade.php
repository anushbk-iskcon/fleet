@extends('layouts.main.app')

@section('title', 'Manage Users')

@section('breadcrumb-content')
<li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
<li class="breadcrumb-item active" id="moduleName">Dashboard</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">Dashboard</h1>
<small id="controllerName">Manage Users</small>
@endsection

@section('content')

<div class="row">
    <div class="col-lg-12">

    </div>
</div>
<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="card">
            <div class="card-header">
                <h4>Manage Users</h4>
            </div>
            <div class="card-body">
                <table class="table display table-bordered table-striped table-hover bg-white m-0 card-table">
                    <thead>
                        <tr>
                            <th>Sl. No.</th>
                            <th>Image</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>About</th>
                            <th>Last Login</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>
                                <!-- If profile image is not null -->
                                @if($user['PROFILE_IMAGE'])
                                <img src="{{asset('public/upload/profile/users/' .$user['PROFILE_IMAGE'] .'')}}" alt="{{$user['FIRST_NAME'] . ' ' . $user['LAST_NAME']}}" height="60" style="width:60px;">
                                @else
                                <img src="{{asset('public/img/default.jpeg')}}" alt="Image" height="60" style="width:60px;">
                                @endif
                            </td>
                            <td>{{$user['FIRST_NAME'] . " " . $user['LAST_NAME']}}</td>
                            <td>{{$user['EMAIL']}}</td>
                            <td>{{$user['ABOUT']}}</td>
                            <td></td>
                            <td>{{$user['ACTIVE_FLAG'] == 'Y' ? "Active" : "Inactive"}}</td>
                            <td>
                                <a href="{{route('edit-user', $user['USER_ID'])}}" class="btn btn-info m-b-5" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil-alt" aria-hidden="true"></i></a>
                                @if($user['ACTIVE_FLAG'] == 'Y')
                                <!-- <form id=""> -->
                                <button data-userid="{{$user['USER_ID']}}" onclick="deactivateUser(this)" class="btn btn-danger m-b-5" data-toggle="tooltip" data-placement="right" title="Deactivate "><i class="ti-close" aria-hidden="true"></i></button>
                                <!-- </form> -->
                                @else
                                <!-- <form id=""> -->
                                <button data-userid="{{$user['USER_ID']}}" onclick="activateUser(this)" class="btn btn-danger m-b-5" data-toggle="tooltip" data-placement="right" title="Reactivate "><i class="ti-reload" aria-hidden="true"></i></button>
                                <!-- </form> -->
                                @endif
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@if(Session::get('success'))
<script>
    toastr.success(success, '', {
        closeButton: true
    });
</script>
@endif
@if(Session::get('error'))
<script>
    toastr.error(error, '', {
        closeButton: true
    });
</script>
@endif
<script>
    function deactivateUser(el) {
        let user_id = $(el).attr('data-userid');

        console.log(user_id);
        if (confirm("Are you sure you want to deactivate this user?")) {
            //
            $.ajax({
                url: "{{url('deactivate-user')}}",
                type: 'PUT',
                data: {
                    _token: '{{csrf_token()}}',
                    user_id: user_id
                },
                success: function(res) {
                    console.log(res);
                    toastr.success(res, '', {
                        closeButton: true
                    });
                    $(el).find('i').removeClass('ti-close').addClass('ti-reload');
                    $(el).prop('title', 'Activate');
                    $(el).attr('data-original-title', 'Activate');
                    $(el).attr('onclick', 'activateUser(this)');
                    $(el).closest('td').prev().html("Inactive");
                },
                error: function(jqXHR, textstatus, errorThrown) {
                    console.log("Could not deactivate user");
                    toastr.error("Could not deactivate user", "", {
                        closeButton: true
                    });
                }
            })
        }
    }

    function activateUser(el) {
        let user_id = $(el).attr('data-userid');

        console.log(user_id);
        if (confirm("Are you sure you want to activate this user?")) {
            //
            $.ajax({
                url: "{{url('activate-user')}}",
                type: 'PUT',
                data: {
                    _token: '{{csrf_token()}}',
                    user_id: user_id
                },
                success: function(res) {
                    console.log(res);
                    toastr.success(res, '', {
                        closeButton: true
                    });
                    $(el).find('i').removeClass('ti-reload').addClass('ti-close');
                    $(el).prop('title', 'Deactivate');
                    $(el).attr('onclick', 'deactivateUser(this)');
                    $(el).attr('data-original-title', 'Deactivate');
                    $(el).closest('td').prev().html("Active");
                },
                error: function(jqXHR, textstatus, errorThrown) {
                    console.log("Could not activate user");
                    toastr.error("Could not activate user", "", {
                        closeButton: true
                    });
                }
            })
        }
    }
</script>
@endsection