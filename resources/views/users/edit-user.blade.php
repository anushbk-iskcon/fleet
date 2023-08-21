@extends('layouts.main.app')

@section('title', 'Edit User')

@section('breadcrumb-content')
<li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
<li class="breadcrumb-item active" id="moduleName">Dashboard</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">Dashboard</h1>
<small id="controllerName">Edit User</small>
@endsection

@section('content')

<div class="row">
    <div class="col-lg-12">
    </div>
</div>
<div class="row">

    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                Edit User
            </div>
            <div class="card-body">
                <form action="{{route('users.update', $user['USER_ID'])}}" method="post" accept-charset="utf-8" id="editUserForm" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="" />
                    @method('PUT')
                    @csrf
                    <div class="form-group row">
                        <label for="firstname" class="col-sm-3 col-form-label">First Name <i class="text-danger">*</i></label>
                        <div class="col-sm-9">
                            <input name="firstname" required class="form-control" type="text" placeholder="First Name" id="firstname" value="{{$user['FIRST_NAME']}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="lastname" class="col-sm-3 col-form-label">Last Name <i class="text-danger">*</i></label>
                        <div class="col-sm-9">
                            <input name="lastname" required class="form-control" type="text" placeholder="Last Name" id="lastname" value="{{$user['LAST_NAME']}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-sm-3 col-form-label">Email <i class="text-danger">*</i></label>
                        <div class="col-sm-9">
                            <input name="email" required class="form-control" type="email" placeholder="Email" id="email" value="{{$user['EMAIL']}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password" class="col-sm-3 col-form-label">Password </label>
                        <div class="col-sm-9">
                            <input name="password" class="form-control" type="password" placeholder="Password" id="password" value="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="about" class="col-sm-3 col-form-label">About</label>
                        <div class="col-sm-9">
                            <textarea name="about" placeholder="About" class="form-control" id="about" value="{{$user['ABOUT']}}"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="preview" class="col-sm-3 col-form-label">Preview</label>
                        <div class="col-sm-2">
                            @if($user['PROFILE_IMAGE'])
                            <img id="user_picture_change" src="{{asset('public/upload/profile/users/' .$user['PROFILE_IMAGE'] .'')}}" alt="User Profile Picture" class="img-thumbnail" width="125" height="100">
                            @else
                            <img id="user_picture_change" src="{{asset('public/img/default.jpeg')}}" class="img-thumbnail" alt="User Profile Picture" width="125" height="100">
                            @endif
                        </div>
                        <div class="col-sm-7">
                        </div>
                        <input type="hidden" name="old_image" value>
                    </div>
                    <div class="form-group row">
                        <label for="image" class="col-sm-3 col-form-label">Image</label>
                        <div class="col-sm-9">
                            <input type="file" name="image" id="image" onchange="readpicture(this);" accept="image/*" aria-describedby="fileHelp">
                            <small id="fileHelp" class="text-muted"></small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="status" class="col-sm-3 col-form-label">Status <i class="text-danger">*</i></label>
                        <div class="col-sm-9">
                            <div class="radio radio-info radio-inline">
                                <input type="radio" name="status" value="1" @if($user['ACTIVE_FLAG']) checked="checked" @endif id="inlineRadio1" />
                                <label for="inlineRadio1"> Active </label> &nbsp;&nbsp;&nbsp;
                                <input type="radio" name="status" value="0" @if(!$user['ACTIVE_FLAG']) checked="checked" @endif id="inlineRadio2" />
                                <label for="inlineRadio2">Inactive</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-right">
                        <button type="reset" class="btn btn-primary w-md m-b-5">Reset</button>
                        <button type="submit" class="btn btn-success w-md m-b-5">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
@section('js-content')
@if($user['PROFILE_IMAGE'])
<script>
    // Default profile image path for use in user-form.js
    var defaultProfileImg = "{{asset('upload/profile/' .$user['PROFILE_IMAGE'] .'')}}"
</script>
@else
<script>
    // Default profile image path for use in user-form.js
    var defaultProfileImg = "{{asset('img/default.jpeg')}}"
</script>
@endif
<script src="{{asset('dist/js/user/edit-user.js')}}"></script>
<script src="{{asset('dist/js/user/user-form.js')}}"></script>
@endsection