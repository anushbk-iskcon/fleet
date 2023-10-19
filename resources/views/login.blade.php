@extends('layouts.login.app')

@section('title','Login - Vahan')

@section('content')

<div class="bg-img-hero position-fixed top-0 right-0 left-0">
    <figure class="position-absolute right-0 bottom-0 left-0 m-0">
        <img src="{{asset('public/img/fig.svg')}}" data-pagespeed-url-hash="2593638024">
    </figure>
</div>
<div class="container py-3 py-sm-7">
    <a class="d-flex justify-content-center mb-3 news365-logo" href>
        <img class="z-index-2" src="{{asset('public/img/logo1.png')}}" alt="Image Description" data-pagespeed-url-hash="799927880">
    </a>
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-5">
            <div class="">
                @if(Session::has('success'))
                <div class="alert alert-dismissible alert-danger">
                    <button class="close" data-dismiss="alert">&times;</button>
                    {{session()->get('success')}}
                </div>
                @endif
            </div>
            <div class="form-card mb-2">
                <div class="form-card_body">
                    <div class="text-center mb-2">
                        <img src="{{asset('public/img/Group 11678.png')}}" alt="" style="height:auto; width:300px;">
                    </div>
                    <form action="" id="loginForm" novalidate method="post" accept-charset="utf-8">
                        @csrf
                        <div class="text-center">
                            <div class="mb-3">
                                <h1 class="display-4 mt-0 font-weight-semi-bold">Sign In</h1>
                                <!-- <p>Please Sign In Using Your Email & Password</p> -->
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="input-label font-weight-bold" for="inputEmail">Your email</label>
                            <input type="email" name="email" autocomplete="off" id="inputEmail" placeholder="Email" required autofocus class="form-control" value="{{old('email')}}">
                            @if($errors->has('email'))
                            <div class="text-danger"> {{$errors->first('email')}} </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="input-label font-weight-bold" for="inputPassword">Password</label>
                            <div class="position-relative">
                                <input type="password" class="form-control password" placeholder="Password" name="password" id="inputPassword" required>
                                <i onclick="passShow()" class="fa fa-eye-slash"></i>
                            </div>
                            @if($errors->has('password'))
                            <div class="text-danger"> {{$errors->first('password')}} </div>
                            @endif
                        </div>
                        <div class="form-group">

                        </div>
                        <button type="submit" class="btn btn-lg btn-block btn-success">Login</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('js-content')
<script>
    $(document).ready(function() {
        $("#loginForm").submit(function() {
            if (($("#inputEmail").val() == '') && ($("#inputPassword").val() == ''))
                return false;

            $(".alert-danger.alert-dismissible").hide();
        });
    });
</script>
@endsection