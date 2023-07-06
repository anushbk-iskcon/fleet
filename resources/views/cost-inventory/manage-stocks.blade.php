@extends('layouts.main.app')

@section('title', 'Manage Stock')

@section('breadcrumb-content')
<li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
<li class="breadcrumb-item active" id="moduleName">Cost & Inventory</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">Cost & Inventory</h1>
<small id="controllerName">Stock List</small>
@endsection

@section('content')


<div class="row">
    <div class="col-sm-12">
        <div class="card mb-3">
            <div class="card-header p-2">
                <h4 class="pl-3">Search Here</h4>
            </div>
            <div class="card-body row">
                <div class="col-sm-12 col-xl-4">
                    <div class="form-group row mb-1">
                        <label for="category_name" class="col-sm-4 col-form-label justify-content-start text-left">Category Name </label>
                        <div class="col-sm-8">
                            <select class="form-control basic-single" name="category_name" id="category_name" onchange="getproduct()">
                                <option value="" selected="selected">Please Select One</option>
                                <option value="MPV">
                                    MPV</option>
                                <option value="Battery">
                                    Battery</option>
                                <option value="Tire">
                                    Tire</option>
                                <option value="Clutch">
                                    Clutch</option>
                                <option value="wheel">
                                    wheel</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <label for="item_name" class="col-sm-4 col-form-label justify-content-start text-left">Item Name </label>
                        <div class="col-sm-8" id="fullitem">
                            <select class="form-control basic-single" name="item_name" id="item_name">
                                <option value="" selected="selected">Please Select One</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-xl-4">
                    <div class="form-group row mb-1">
                        <label for="from" class="col-sm-4 col-form-label justify-content-start text-left">From </label>
                        <div class="col-sm-8">
                            <input name="from" autocomplete="off" class="form-control lnewdatetimepicker" type="text" placeholder="From" id="from" value="">
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <label for="to" class="col-sm-4 col-form-label justify-content-start text-left">To </label>
                        <div class="col-sm-8">
                            <input name="to" autocomplete="off" class="form-control lnewdatetimepicker" type="text" placeholder="To" id="to" value="">
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-xl-4">
                    <div class="form-group row mb-1">
                        <div class="col-sm-7 text-right">
                            <button type="button" class="btn btn-success" id="btn-filter">Search</button>&nbsp;
                            <button type="button" class="btn btn-inverse" id="btn-reset">Reset</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="card mb-3">
            <div class="card-header p-2">
                <h4 class="pl-3">Stock List</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="stock" class="table table-striped table-bordered dt-responsive nowrap">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Category Name</th>
                                <th>Item Name</th>
                                <th>In Quantity</th>
                                <th>Out Quantity</th>
                                <th>Current Quantity</th>
                                <th>Stock Value</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr role="row" class="odd">
                                <td class="sorting_1" tabindex="0">1</td>
                                <td>a</td>
                                <td></td>
                                <td>2</td>
                                <td></td>
                                <td>2</td>
                                <td style="">4.00</td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1" tabindex="0">2</td>
                                <td>ABC</td>
                                <td>Def</td>
                                <td>5</td>
                                <td></td>
                                <td>5</td>
                                <td style="">445.00</td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="sorting_1" tabindex="0">3</td>
                                <td>Battery</td>
                                <td></td>
                                <td>8</td>
                                <td></td>
                                <td>8</td>
                                <td style="">55.00</td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1" tabindex="0">4</td>
                                <td>Battery 007</td>
                                <td>Batter A-01</td>
                                <td>2</td>
                                <td></td>
                                <td>2</td>
                                <td style="">500.00</td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="sorting_1" tabindex="0">5</td>
                                <td>Clutch</td>
                                <td></td>
                                <td>4</td>
                                <td></td>
                                <td>4</td>
                                <td style="">0.00</td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1" tabindex="0">6</td>
                                <td>def</td>
                                <td>ghjj</td>
                                <td>4</td>
                                <td></td>
                                <td>4</td>
                                <td style="">4,000,000.00</td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="sorting_1" tabindex="0">7</td>
                                <td>dfgdg</td>
                                <td></td>
                                <td>0</td>
                                <td>6767</td>
                                <td>-6767</td>
                                <td style="">nan</td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1" tabindex="0">8</td>
                                <td>getrty</td>
                                <td>Seat Belt</td>
                                <td>10</td>
                                <td>2</td>
                                <td>8</td>
                                <td style="">640.00</td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="sorting_1" tabindex="0">9</td>
                                <td>ghj</td>
                                <td>ghj</td>
                                <td>5</td>
                                <td></td>
                                <td>5</td>
                                <td style="">150.00</td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1" tabindex="0">10</td>
                                <td>kkk</td>
                                <td>kkk</td>
                                <td>6</td>
                                <td></td>
                                <td>6</td>
                                <td style="">4,074,000.00</td>
                            </tr>
                        </tbody>

                    </table> <!-- /.table-responsive -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <script src="https://vmsdemo.bdtask-demo.com/assets/dist/js/stock_list.js"></script> -->
<script>
    $(document).ready(function() {
        $("#stock").DataTable();
    });
</script>
@endsection