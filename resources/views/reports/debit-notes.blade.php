@extends('layouts.main.app')

@section('title', 'Debit Reports')

@section('breadcrumb-content')
<li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
<li class="breadcrumb-item active" id="moduleName">Reports</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">Reports</h1>
<small id="controllerName">Debit Notes</small>
@endsection

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="card mb-3">
            <div class="card-header p-2">
                <h4 class="pl-3">Search Here</h4>
            </div>
            <div class="card-body">
                <form action="" class="form-inline row" id="validate" method="post" accept-charset="utf-8">
                    <div class="col-sm-3">
                        <div class="form-group row mb-1">
                            <div class="col-sm-12">
                                <label for="debitNoteDept" class="form-label justify-content-start text-left">Department </label>
                                <select class="form-control basic-single" name="department" id="debitNoteDept">
                                    <option value="" selected="selected">Please Select One</option>
                                    @foreach($departments['data'] as $department)
                                    <option value="{{$department['deptCode']}}">
                                        {{$department['deptName']}}
                                    </option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group row mb-1">
                            <div class="col-sm-12">
                                <label for="debit_note_year" class="form-label justify-content-start text-left">Year </label>
                                <select class="form-control basic-single" name="year" id="debit_note_year">
                                    <option value="">Please Select One</option>
                                    @for($year = date('Y'); $year >=2023 ; $year--)
                                    <option value="{{$year}}" @if($year==date('Y')) {{'selected'}} @endif>{{$year}}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group row mb-1">
                            <div class="col-sm-12">
                                <label for="debit_note_month" class="form-label justify-content-start text-left">Month </label>
                                <select class="form-control basic-single" name="debit_note_month" id="debit_note_month">
                                    <option value="" selected="selected">Please Select One</option>
                                    @php
                                    $monthsArray = ['January', 'February', 'March',
                                    'April', 'May', 'June',
                                    'July', 'August', 'September',
                                    'October', 'November', 'December'];
                                    @endphp
                                    @foreach($monthsArray as $month)
                                    <option value="{{$loop->iteration}}">{{$month}}</option>
                                    @if(date('m') == $loop->iteration) @break @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group row mb-1">
                            <div class="col-sm-12 text-right">
                                <button type="button" class="btn btn-success" id="btn-filter">Search</button>&nbsp;
                                <button type="button" class="btn btn-inverse" id="btn-reset">Reset</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="card mb-3">
            <div class="card-header p-2">
                <h4 class="pl-3">Debit Notes</h4>
            </div>
            <div class="card-body">
                <div id="pdf">
                    <div class="row justify-content-center">
                        <div class="col-md-9 mb-1 text-right">
                            <form action="{{route('generate.pdf')}}" method="post" target="_blank">
                                @csrf
                                <input type="hidden" name="dept_code" id="deptCode" value="">
                                <input type="hidden" name="dept_name" id="deptName" value="">
                                <input type="hidden" name="debit_note_month" id="debitNoteMonth" value="">
                                <input type="hidden" name="debit_note_year" id="debitNoteYear" value="">
                                <button type="submit" class="btn btn-primary" target="_blank"><i class="fa fa-download"></i></button>
                            </form>
                        </div>
                        <div class="col-md-9">
                            <div class="custom-border" style="border: 3px solid black;padding: 15px 0 100px 0;">
                                <div class="row pl-3 pr-5" style="padding-left:10px;padding-right:10px;">
                                    <div class="col-md-12 text-center mb-5" style="text-align:center;margin-bottom:30px;">
                                        <p style="display: inline-block;border-bottom: 2px solid black;font-weight: 700;font-size:25px!important;margin-bottom: 0!important;">
                                            International Society for Krishna Consciousness</p>
                                        <p style="margin-bottom: 0;margin-top: 1px;font-weight: 500;font-size:13px!important;">
                                            Hare Krishna
                                            Hill, Chord Road, Rajaji Nagar, Bangalore
                                            -10</p>
                                        <span style="border-bottom: 1px solid black;font-weight: 700;font-size:14px!important;">Supplier
                                            Entity code:- FM 00</span>
                                    </div>
                                    <div class="col-md-6" style="width:100%;display:inline-block;">
                                        <p style="font-size:14px;">Date:- 05 May 2024</p>
                                    </div>
                                    <div class="col-md-6 text-right" style="width:100%;display:inline-block;text-align:right;">
                                        <p style="font-size:14px;">Interunit transfer No:- T pt/Apr 2024</p>
                                    </div>
                                    <div class="col-md-6" style="width:100%;display:inline-block;">
                                        <p style="font-size:14px;">To,<br>
                                            <b>Entity:- National Institute of Value Education</b><br>
                                            Hare Krishna Hill, Bangalore- 10
                                        </p>
                                    </div>
                                    <div class="col-md-6 my-auto" style="width:100%;display:inline-block;text-align:right;">
                                        <p style="font-size:14px;">Entity Code:- CE 00</p>
                                    </div>
                                    <div class="col-md-12 mb-5 mt-5" style="text-align:left;padding-left:20px;padding-right:20px;">
                                        <h5 style="border-bottom:1px solid;display:inline-block;font-size:16px;font-weight:bold;">Sub:- Inter dept
                                            transfer for
                                            the month of Apr 2024</h5>
                                        <table style="width: 100%; border-collapse: collapse;">
                                            <thead>
                                                <tr style="background-color: #f2f2f2;">
                                                    <th style="border: 1px solid #ddd; padding: 4px;font-size:15px;text-align:center;">Sl
                                                        No</th>
                                                    <th style="border: 1px solid #ddd; padding: 4px;font-size:15px;text-align:left;">
                                                        Details
                                                    </th>
                                                    <th style="border: 1px solid #ddd; padding: 4px;font-size:15px;text-align:left;">UOM
                                                    </th>
                                                    <th style="border: 1px solid #ddd; padding: 4px;font-size:15px;text-align:right;">Qty
                                                    </th>
                                                    <th style="border: 1px solid #ddd; padding: 4px;font-size:15px;text-align:right;">
                                                        Rate</th>
                                                    <th style="border: 1px solid #ddd; padding: 4px;font-size:15px;text-align:right;">
                                                        Cost</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td style="border: 1px solid #ddd; padding: 4px;text-align:center;font-size:14px;">
                                                        1</td>
                                                    <td style="border: 1px solid #ddd; padding: 4px;text-align:left;font-size:14px;">
                                                        Gas</td>
                                                    <td style="border: 1px solid #ddd; padding: 4px;text-align:left;font-size:14px;">
                                                        Kg</td>
                                                    <td style="border: 1px solid #ddd; padding: 4px;text-align:right;font-size:14px;">
                                                        -</td>
                                                    <td style="border: 1px solid #ddd; padding: 4px;text-align:right;font-size:14px;">
                                                        68.65</td>
                                                    <td style="border: 1px solid #ddd; padding: 4px;text-align:right;font-size:14px;">
                                                        0</td>
                                                </tr>
                                                <tr>
                                                    <td style="border: 1px solid #ddd; padding: 4px;text-align:center;font-size:14px;">
                                                        2</td>
                                                    <td style="border: 1px solid #ddd; padding: 4px;text-align:left;font-size:14px;">
                                                        Petrol</td>
                                                    <td style="border: 1px solid #ddd; padding: 4px;text-align:left;font-size:14px;">
                                                        Ltr</td>
                                                    <td style="border: 1px solid #ddd; padding: 4px;text-align:right;font-size:14px;">
                                                        -</td>
                                                    <td style="border: 1px solid #ddd; padding: 4px;text-align:right;font-size:14px;">
                                                        102.65</td>
                                                    <td style="border: 1px solid #ddd; padding: 4px;text-align:right;font-size:14px;">
                                                        0</td>
                                                </tr>
                                                <tr>
                                                    <td style="border: 1px solid #ddd; padding: 4px;text-align:center;font-size:14px;">
                                                        3</td>
                                                    <td style="border: 1px solid #ddd; padding: 4px;text-align:left;font-size:14px;">
                                                        Diesel</td>
                                                    <td style="border: 1px solid #ddd; padding: 4px;text-align:left;font-size:14px;">
                                                        Ltr</td>
                                                    <td style="border: 1px solid #ddd; padding: 4px;text-align:right;font-size:14px;">
                                                        200.53</td>
                                                    <td style="border: 1px solid #ddd; padding: 4px;text-align:right;font-size:14px;">
                                                        87.65</td>
                                                    <td style="border: 1px solid #ddd; padding: 4px;text-align:right;font-size:14px;">
                                                        17623.25</td>
                                                </tr>
                                                <tr>
                                                    <td style="border: 1px solid #ddd; padding: 4px;text-align:center;">
                                                    </td>
                                                    <td style="border: 1px solid #ddd; padding: 4px;text-align:center;">
                                                    </td>
                                                    <td style="border: 1px solid #ddd; padding: 4px;text-align:center;">
                                                    </td>
                                                    <td style="border: 1px solid #ddd; padding: 4px;text-align:right;font-size:14px;" colspan="2"><b>Amount Debitable</b></td>
                                                    <td style="border: 1px solid #ddd; padding: 4px;text-align:right;font-size:14px;">
                                                        <b>3245,00</b>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-6" style="width:100%;display:inline-block;">
                                        <p style="font-size:14px;">
                                            Division Head<br>
                                            Supplier Dept
                                        </p>
                                    </div>
                                    <div class="col-md-6" style="width:100%;display:inline-block;text-align:right;">
                                        <p style="font-size:14px;">
                                            Division Head<br>
                                            User Dept
                                        </p>
                                    </div>
                                    <div class="col-md-12 text-center mb-5" style="text-align:center;margin-top:30px;padding-left:20px;padding-right:20px;">
                                        <span style="border-bottom: 1px solid black;font-weight: 700;font-size:14px!important;">Transfer
                                            Declaration</span>
                                        <p style="text-align:left;font-size:15px!important;">We acknowledge the receipt
                                            of the
                                            above mention
                                            materials and hereby request finance to transfer the sum of Rs. 3522/-</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    #dvrport {
        width: 100%;
    }

    .basic-single {
        width: 100% !important;
    }
</style>
<!-- <script src="{{asset('dist/js/driver_report.js')}}"></script> -->
<script>
    $(document).ready(function() {
        $("#dvrport").DataTable();

        $("#btn-filter").click(function(e) {
            $("#deptCode").val($('#debitNoteDept').val());
            $("#deptName").val($('#debitNoteDept').find(':selected').text().trim());
            $("#debitNoteMonth").val($("#debit_note_month").val());
            $("#debitNoteYear").val($("#debit_note_year").val());
        });

        $("#debit_note_year").change(function() {
            if ($(this).val() != currentYear) {
                $("#debit_note_month").empty();
                $("#debit_note_month").append(`<option value="">Please Select One</option>`);
                for (let i = 0; i <= 11; i++) {
                    $("#debit_note_month").append(`<option value="${i+1}">${monthsArray[i]}</option>`);
                }
            } else {
                $("#debit_note_month").empty();
                $("#debit_note_month").append(`<option value="">Please Select One</option>`);
                for (let i = 0; i <= 11; i++) {
                    $("#debit_note_month").append(`<option value="${i+1}">${monthsArray[i]}</option>`);
                    if (i == currentMonth) break;
                }
            }
        })
    });

    const currentDate = new Date();
    const currentYear = currentDate.getFullYear();
    const currentMonth = currentDate.getMonth();
    const monthsArray = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
</script>
@endsection