@extends('layouts.main.app')

@section('title', 'Parts Usage')

@section('breadcrumb-content')
<li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
<li class="breadcrumb-item active" id="moduleName">Purchase</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">Purchase</h1>
<small id="controllerName">Parts Usage List</small>
@endsection

@section('content')
<div id="edit" class="modal fade bd-example-modal-lg" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Details</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body editinfo">

            </div>
        </div>
    </div>
</div>
<div class="col-sm-12">
    <div class="card mb-3">
        <div class="card-header p-2">
            <h4 class="pl-3">Parts Usages List<small class="float-right">

                    <a href="{{route('add-parts-usage')}}" class="btn btn-primary btn-md"><i class="ti-plus" aria-hidden="true"></i>
                        Add Parts Usage
                    </a>
                </small>
            </h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="pusage" class="table display table-bordered table-striped table-hover ">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Invoice</th>
                            <th>Vendor</th>
                            <th>Purchase Date</th>
                            <th>Purpose</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr role="row" class="odd">
                            <td class="sorting_1">1</td>
                            <td>SL-0001</td>
                            <td>Toyata</td>
                            <td>2019-09-12</td>
                            <td>sdfhnjg</td>
                            <td><input name="url" type="hidden" id="url_2" value="https://vmsdemo.bdtask-demo.com/purchase/purchase/updateusagefrm"><a onclick="editinfo(2)" style="cursor:pointer;color:#fff;" class="btn btn-primary btn-sm mr-1"><i class="far fa-eye"></i></a></td>
                        </tr>
                        <tr role="row" class="even">
                            <td class="sorting_1">2</td>
                            <td>SL-0003</td>
                            <td>Toyata</td>
                            <td>2021-02-14</td>
                            <td>yugyutu</td>
                            <td><input name="url" type="hidden" id="url_3" value="https://vmsdemo.bdtask-demo.com/purchase/purchase/updateusagefrm"><a onclick="editinfo(3)" style="cursor:pointer;color:#fff;" class="btn btn-primary btn-sm mr-1"><i class="far fa-eye"></i></a></td>
                        </tr>
                        <tr role="row" class="odd">
                            <td class="sorting_1">3</td>
                            <td>SL-0004</td>
                            <td>Nissan</td>
                            <td>2021-02-14</td>
                            <td>new purpose</td>
                            <td><input name="url" type="hidden" id="url_4" value="https://vmsdemo.bdtask-demo.com/purchase/purchase/updateusagefrm"><a onclick="editinfo(4)" style="cursor:pointer;color:#fff;" class="btn btn-primary btn-sm mr-1"><i class="far fa-eye"></i></a></td>
                        </tr>
                        <tr role="row" class="even">
                            <td class="sorting_1">4</td>
                            <td>SL-0005</td>
                            <td>Toyata</td>
                            <td>2021-02-23</td>
                            <td>new purpose</td>
                            <td><input name="url" type="hidden" id="url_5" value="https://vmsdemo.bdtask-demo.com/purchase/purchase/updateusagefrm"><a onclick="editinfo(5)" style="cursor:pointer;color:#fff;" class="btn btn-primary btn-sm mr-1"><i class="far fa-eye"></i></a></td>
                        </tr>
                        <tr role="row" class="odd">
                            <td class="sorting_1">5</td>
                            <td>SL-0006</td>
                            <td>Toyata</td>
                            <td>2021-02-20</td>
                            <td>ghfhfgh</td>
                            <td><input name="url" type="hidden" id="url_6" value="https://vmsdemo.bdtask-demo.com/purchase/purchase/updateusagefrm"><a onclick="editinfo(6)" style="cursor:pointer;color:#fff;" class="btn btn-primary btn-sm mr-1"><i class="far fa-eye"></i></a></td>
                        </tr>
                        <tr role="row" class="even">
                            <td class="sorting_1">6</td>
                            <td>SL-0007</td>
                            <td>Nissan</td>
                            <td>2021-02-22</td>
                            <td></td>
                            <td><input name="url" type="hidden" id="url_7" value="https://vmsdemo.bdtask-demo.com/purchase/purchase/updateusagefrm"><a onclick="editinfo(7)" style="cursor:pointer;color:#fff;" class="btn btn-primary btn-sm mr-1"><i class="far fa-eye"></i></a></td>
                        </tr>
                        <tr role="row" class="odd">
                            <td class="sorting_1">7</td>
                            <td>SL-0008</td>
                            <td>Nissan</td>
                            <td>2021-02-27</td>
                            <td></td>
                            <td><input name="url" type="hidden" id="url_8" value="https://vmsdemo.bdtask-demo.com/purchase/purchase/updateusagefrm"><a onclick="editinfo(8)" style="cursor:pointer;color:#fff;" class="btn btn-primary btn-sm mr-1"><i class="far fa-eye"></i></a></td>
                        </tr>
                        <tr role="row" class="even">
                            <td class="sorting_1">8</td>
                            <td>SL-0009</td>
                            <td>MT</td>
                            <td>2021-02-27</td>
                            <td></td>
                            <td><input name="url" type="hidden" id="url_9" value="https://vmsdemo.bdtask-demo.com/purchase/purchase/updateusagefrm"><a onclick="editinfo(9)" style="cursor:pointer;color:#fff;" class="btn btn-primary btn-sm mr-1"><i class="far fa-eye"></i></a></td>
                        </tr>
                        <tr role="row" class="odd">
                            <td class="sorting_1">9</td>
                            <td>SL-0010</td>
                            <td>Khyber Express</td>
                            <td>2023-03-05</td>
                            <td></td>
                            <td><input name="url" type="hidden" id="url_10" value="https://vmsdemo.bdtask-demo.com/purchase/purchase/updateusagefrm"><a onclick="editinfo(10)" style="cursor:pointer;color:#fff;" class="btn btn-primary btn-sm mr-1"><i class="far fa-eye"></i></a></td>
                        </tr>
                    </tbody>
                </table> <!-- /.table-responsive -->
            </div>
        </div>
    </div>
</div>
<!-- <script src="https://vmsdemo.bdtask-demo.com/assets/dist/js/usages_list.js"></script> -->
<script>
    $(document).ready(function() {
        $("#pusage").DataTable();
    });
</script>
@endsection