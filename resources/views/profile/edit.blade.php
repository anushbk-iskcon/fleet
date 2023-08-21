@extends('layouts.main.app')

@section('title', 'Edit Profile')

@section('breadcrumb-content')
<li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
<li id="moduleName" class="breadcrumb-item active">
    Dashboard
</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">Dashboard</h1>
<small id="controllerName">Edit Profile</small>
@endsection

@section('content')

<div class="row">
    <div class="col-lg-12">
    </div>
</div>
<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="card">
            <h4 class="card-header">Profile Setting</h4>
            <div class="card-body">
                <form action="{{route('update-profile')}}" id="updateProfileForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="3" />
                    <div class="form-group row">
                        <label for="firstname" class="col-sm-3 col-form-label">First Name <i class="text-danger">*</i></label>
                        <div class="col-sm-9">
                            <input name="firstname" class="form-control" required type="text" placeholder="First Name" id="firstname" value="{{$user['FIRST_NAME']}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="lastname" class="col-sm-3 col-form-label">Last Name <i class="text-danger">*</i></label>
                        <div class="col-sm-9">
                            <input name="lastname" required class="form-control" type="text" placeholder="Last Name" id="lastname" value="{{$user['LAST_NAME']}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-sm-3 col-form-label">Email Address <i class="text-danger">*</i></label>
                        <div class="col-sm-9">
                            <input name="email" required class="form-control" type="email" placeholder="Email Address" id="email" value="{{$user['EMAIL']}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password" class="col-sm-3 col-form-label">Password </label>
                        <div class="col-sm-9">
                            <input name="password" class="form-control" type="password" placeholder="Password" id="password">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="about" class="col-sm-3 col-form-label">About</label>
                        <div class="col-sm-9">
                            <textarea name="about" placeholder="About" class="form-control" id="about">{{$user['ABOUT']}}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="preview" class="col-sm-3 col-form-label">Preview</label>
                        <div class="col-sm-9">
                            @if($user['PROFILE_IMAGE'])
                            <img id="user_picture_change" src="{{asset('public/upload/profile/users/' .$user['PROFILE_IMAGE'] .'')}}" class="img-thumbnail" width="125" height="100">
                            @else
                            <img id="user_picture_change" src="{{asset('public/img/default.jpeg')}}" class="img-thumbnail" width="125" height="100">
                            @endif
                        </div>
                        <input type="hidden" name="old_image" value="{{$user['PROFILE_IMAGE']}}">
                    </div>
                    <div class="form-group row">
                        <label for="image" class="col-sm-3 col-form-label">Image</label>
                        <div class="col-sm-9">
                            <input type="file" name="image" id="image" onchange="readpicture(this);" accept="image/*" aria-describedby="fileHelp">
                            <small id="fileHelp" class="text-muted"></small>
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
    var defaultProfileImg = "{{asset('public/upload/profile/users/' .$user['PROFILE_IMAGE'] .'')}}"
</script>
@else
<script>
    var defaultProfileImg = "{{asset('public/img/default.jpeg')}}"
</script>
@endif
<script src="{{asset('public/dist/js/profile/profile-update.js')}}"></script>
<script src="{{asset('public/dist/js/user/user-form.js')}}"></script>
@endsection