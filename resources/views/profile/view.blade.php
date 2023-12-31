@extends('layouts.main.app')

@section('title', 'Profile')

@section('breadcrumb-content')
<li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
<li id="moduleName" class="breadcrumb-item active">
    Dashboard
</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">Dashboard</h1>
<small id="controllerName">Profile</small>
@endsection

@section('content')

<div class="row">
    <div class="col-lg-12">
    </div>
</div>
<div class="card-new">
    <div class="row justify-content-center">
        <div class="col-sm-4">
            <div class="card">
                <div class="panel panel-bd lobidrag">
                    <div class="card-header">
                        <h4>Profile</h4>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-sm-12">
                            <div class="card-body">
                                <div class="card-content-summary">
                                    <p class="text-center">
                                        @if($user['PROFILE_IMAGE'])
                                        <img src="{{asset('public/upload/profile/users/' .$user['PROFILE_IMAGE'] .'')}}"
                                            alt="User Image" height="150">
                                        @else
                                        <img src="{{asset('public/img/default.jpeg')}}" alt="User Image" height="150">
                                        @endif
                                    </p>
                                    <h4 class="m-t-0 text-center">{{$user['FIRST_NAME'] . " " . $user['LAST_NAME']}}
                                    </h4>
                                    <p>
                                        {{$user['ABOUT']}}
                                    </p>
                                </div>
                            </div>
                            <div class="card-body">
                                <dl class="dl-horizontal">
                                    <dt>Email </dt>
                                    <dd> {{$user['EMAIL']}} </dd>
                                    <dt>Role </dt>
                                    <dd>
                                        {{session('userRole')}}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js-content')

@endsection