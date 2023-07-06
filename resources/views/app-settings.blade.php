@extends('layouts.main.app')

@section('title', 'Application Settings')

@section('breadcrumb-content')
<li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
<li class="breadcrumb-item active" id="moduleName">Dashboard</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">Dashboard</h1>
<small id="controllerName">Application Settings</small>
@endsection

@section('content')

<div class="row">
    <div class="col-lg-12">
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <h4 class="card-header">Application Settings</h4>
            <div class="card-body">
                <form action="" class="form-inner" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                    <input type="hidden" name="id" value="2" />
                    <div class="form-group row">
                        <label for="title" class="col-sm-3 col-form-label">Application Title <i class="text-danger">*</i></label>
                        <div class="col-sm-9">
                            <input name="title" type="text" class="form-control" id="title" placeholder="Application Title" value="Fleet">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="stname" class="col-sm-3 col-form-label">Store Name</label>
                        <div class="col-sm-9">
                            <input name="stname" type="text" class="form-control" id="stname" placeholder="Store Name" value="KTP">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="address" class="col-sm-3 col-form-label">Address</label>
                        <div class="col-sm-9">
                            <input name="address" type="text" class="form-control" id="address" placeholder="Address" value>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                            <input name="email" type="text" class="form-control" id="email" placeholder="Email" value>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="phone" class="col-sm-3 col-form-label">Phone</label>
                        <div class="col-sm-9">
                            <input name="phone" type="text" class="form-control" id="phone" placeholder="Phone" value>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="faviconPreview" class="col-sm-3 col-form-label"></label>
                        <div class="col-sm-9">
                            <img src="https://vmsdemo.bdtask-demo.com/assets/img/icons/2023-05-31/o2.png" alt="Favicon" class="img-thumbnail" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="favicon" class="col-sm-3 col-form-label">Favicon </label>
                        <div class="col-sm-9">
                            <input type="file" name="favicon" id="favicon">
                            <input type="hidden" name="old_favicon" value="assets/img/icons/2023-05-31/o2.png">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="logoPreview" class="col-sm-3 col-form-label"></label>
                        <div class="col-sm-9">
                            <img src="https://vmsdemo.bdtask-demo.com/assets/img/icons/2023-05-31/o.png" alt="Picture" class="img-thumbnail" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="logo" class="col-sm-3 col-form-label">Logo</label>
                        <div class="col-sm-9">
                            <input type="file" name="logo" id="logo">
                            <input type="hidden" name="old_logo" value="assets/img/icons/2023-05-31/o.png">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="logoPreview" class="col-sm-3 col-form-label"></label>
                        <div class="col-sm-9">
                            <img src="https://vmsdemo.bdtask-demo.com/assets/img/icons/2023-05-31/o1.png" alt="Picture" class="img-thumbnail" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="logo" class="col-sm-3 col-form-label">Splash Logo</label>
                        <div class="col-sm-9">
                            <input type="file" name="splash_logo" id="logo">
                            <input type="hidden" name="old_splash_logo" value="assets/img/icons/2023-05-31/o1.png">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="storevat" class="col-sm-3 col-form-label">VAT Setting(%)</label>
                        <div class="col-sm-9">
                            <input name="storevat" type="text" class="form-control" id="storevat" placeholder="VAT" value="15">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="footer_text" class="col-sm-3 col-form-label">currency</label>
                        <div class="col-sm-9">
                            <select name="currency" class="form-control">
                                <option value>Select currency</option>
                                <option value="1">Indian Rupee</option>
                                <option value="2">USD</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="footer_text" class="col-sm-3 col-form-label">Language</label>
                        <div class="col-sm-9">
                            <select name="language" class="form-control">
                                <option value="english" selected="selected">English</option>
                                <option value="hi">Hindi</option>
                                <option value="bangla">Bangla</option>
                                <option value="odia">Odia</option>
                                <option value="gujarati">Gujarati</option>
                                <option value="marathi">Marathi</option>
                                <option value="arabic">Arabic</option>
                                <option value="spanish">Spanish</option>
                                <option value="french">French</option>
                                <option value="de">German</option>
                                <option value="pt">Portuguese</option>
                                <option value="th">Thai</option>
                                <option value="tr">Turkish </option>
                                <option value="telugu">Telugu</option>
                                <option value="tamil">Tamil</option>
                                <option value="kannada">Kannada</option>
                                <option value="malayalam">Malayalam</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="footer_text" class="col-sm-3 col-form-label">Date Format</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="timeformat">
                                <option value> Select Date Format </option>
                                <option value="d/m/Y" selected> dd/mm/yyyy </option>
                                <option value="Y/m/d"> yyyy/mm/dd </option>
                                <option value="d-m-Y">
                                    dd-mm-yyyy
                                </option>
                                <option value="Y-m-d">
                                    yyyy-mm-dd
                                </option>
                                <option value="m/d/Y">
                                    mm/dd/yyyy
                                </option>
                                <option value="d M,Y">
                                    dd M, yyyy
                                </option>
                                <option value="d F,Y">
                                    dd MM, yyyy
                                </option>
                                <option value="d-M-Y">dd-MMM-yyyy</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="footer_text" class="col-sm-3 col-form-label">Application Alignment</label>
                        <div class="col-sm-9">
                            <select name="site_align" class="selectpicker form-control" data-live-search="true" id="site_align">
                                <option value="LTR" selected="selected">Left To Right</option>
                                <option value="RTL">Right To Left</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="power_text" class="col-sm-3 col-form-label">Powered By Text</label>
                        <div class="col-sm-9">
                            <textarea name="power_text" class="form-control" placeholder="Powered By Text" maxlength="140" rows="7">Powered by ...</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="footer_text" class="col-sm-3 col-form-label">Footer Text</label>
                        <div class="col-sm-9">
                            <textarea name="footer_text" class="form-control" placeholder="Footer Text" maxlength="140" rows="7">2023</textarea>
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