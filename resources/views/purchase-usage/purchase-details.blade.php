@extends('layouts.main.app')

@section('title', 'Purchase Details')

@section('breadcrumb-content')
<li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
<li class="breadcrumb-item active" id="moduleName">Purchase</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">Purchase</h1>
<small id="controllerName">All Purchase Details</small>
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
            <h4 class="pl-3">Purchase Details<small class="float-right">
                    <a href="{{route('add-purchase')}}" class="btn btn-primary btn-md"><i class="ti-plus" aria-hidden="true"></i>
                        Add Purchase</a>
                </small></h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="purc" class="table display table-bordered table-striped table-hover ">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Invoice</th>
                            <th>Vendor</th>
                            <th>Purchase Date</th>
                            <th>Total Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr role="row" class="odd">
                            <td class="sorting_1">1</td>
                            <td>7857654</td>
                            <td>Auto Parts</td>
                            <td>2021-02-22</td>
                            <td>1425.00</td>
                            <td><input name="url" type="hidden" id="url_1" value="https://vmsdemo.bdtask-demo.com/purchase/purchase/updatepurchasefrm"><a href="https://vmsdemo.bdtask-demo.com/purchase/purchase/editpurchasefrm/1" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a onclick="editinfo(1)" style="cursor:pointer;color:#fff;" class="btn btn-primary btn-sm mr-1"><i class="far fa-eye"></i></a><a href="https://vmsdemo.bdtask-demo.com/purchase/purchase/delete_purchase/1" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a></td>
                        </tr>
                        <tr role="row" class="even">
                            <td class="sorting_1">2</td>
                            <td>0032543</td>
                            <td>Rahim Afroz</td>
                            <td>2021-02-20</td>
                            <td>530.00</td>
                            <td><input name="url" type="hidden" id="url_2" value="https://vmsdemo.bdtask-demo.com/purchase/purchase/updatepurchasefrm"><a href="https://vmsdemo.bdtask-demo.com/purchase/purchase/editpurchasefrm/2" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a onclick="editinfo(2)" style="cursor:pointer;color:#fff;" class="btn btn-primary btn-sm mr-1"><i class="far fa-eye"></i></a><a href="https://vmsdemo.bdtask-demo.com/purchase/purchase/delete_purchase/2" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a></td>
                        </tr>
                        <tr role="row" class="odd">
                            <td class="sorting_1">3</td>
                            <td>435345n</td>
                            <td>honda</td>
                            <td>2021-02-23</td>
                            <td>3340.00</td>
                            <td><input name="url" type="hidden" id="url_7" value="https://vmsdemo.bdtask-demo.com/purchase/purchase/updatepurchasefrm"><a href="https://vmsdemo.bdtask-demo.com/purchase/purchase/editpurchasefrm/7" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a onclick="editinfo(7)" style="cursor:pointer;color:#fff;" class="btn btn-primary btn-sm mr-1"><i class="far fa-eye"></i></a><a href="https://vmsdemo.bdtask-demo.com/purchase/purchase/delete_purchase/7" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a></td>
                        </tr>
                        <tr role="row" class="even">
                            <td class="sorting_1">4</td>
                            <td>435345</td>
                            <td>Rahim Afroz</td>
                            <td>2021-02-27</td>
                            <td>0.00</td>
                            <td><input name="url" type="hidden" id="url_8" value="https://vmsdemo.bdtask-demo.com/purchase/purchase/updatepurchasefrm"><a href="https://vmsdemo.bdtask-demo.com/purchase/purchase/editpurchasefrm/8" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a onclick="editinfo(8)" style="cursor:pointer;color:#fff;" class="btn btn-primary btn-sm mr-1"><i class="far fa-eye"></i></a><a href="https://vmsdemo.bdtask-demo.com/purchase/purchase/delete_purchase/8" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a></td>
                        </tr>
                        <tr role="row" class="odd">
                            <td class="sorting_1">5</td>
                            <td>435345n</td>
                            <td>Rahim Afroz</td>
                            <td>2021-02-27</td>
                            <td>325.00</td>
                            <td><input name="url" type="hidden" id="url_10" value="https://vmsdemo.bdtask-demo.com/purchase/purchase/updatepurchasefrm"><a href="https://vmsdemo.bdtask-demo.com/purchase/purchase/editpurchasefrm/10" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a onclick="editinfo(10)" style="cursor:pointer;color:#fff;" class="btn btn-primary btn-sm mr-1"><i class="far fa-eye"></i></a><a href="https://vmsdemo.bdtask-demo.com/purchase/purchase/delete_purchase/10" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a></td>
                        </tr>
                        <tr role="row" class="even">
                            <td class="sorting_1">6</td>
                            <td>gf-432545</td>
                            <td>vandor</td>
                            <td>2021-02-27</td>
                            <td>650.00</td>
                            <td><input name="url" type="hidden" id="url_11" value="https://vmsdemo.bdtask-demo.com/purchase/purchase/updatepurchasefrm"><a href="https://vmsdemo.bdtask-demo.com/purchase/purchase/editpurchasefrm/11" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a onclick="editinfo(11)" style="cursor:pointer;color:#fff;" class="btn btn-primary btn-sm mr-1"><i class="far fa-eye"></i></a><a href="https://vmsdemo.bdtask-demo.com/purchase/purchase/delete_purchase/11" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a></td>
                        </tr>
                        <tr role="row" class="odd">
                            <td class="sorting_1">7</td>
                            <td>34</td>
                            <td>Honda</td>
                            <td>0000-00-00</td>
                            <td>4.00</td>
                            <td><input name="url" type="hidden" id="url_12" value="https://vmsdemo.bdtask-demo.com/purchase/purchase/updatepurchasefrm"><a href="https://vmsdemo.bdtask-demo.com/purchase/purchase/editpurchasefrm/12" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a onclick="editinfo(12)" style="cursor:pointer;color:#fff;" class="btn btn-primary btn-sm mr-1"><i class="far fa-eye"></i></a><a href="https://vmsdemo.bdtask-demo.com/purchase/purchase/delete_purchase/12" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a></td>
                        </tr>
                        <tr role="row" class="even">
                            <td class="sorting_1">8</td>
                            <td>345566</td>
                            <td>Auto Parts</td>
                            <td>2023-02-25</td>
                            <td>2000.00</td>
                            <td><input name="url" type="hidden" id="url_13" value="https://vmsdemo.bdtask-demo.com/purchase/purchase/updatepurchasefrm"><a href="https://vmsdemo.bdtask-demo.com/purchase/purchase/editpurchasefrm/13" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a onclick="editinfo(13)" style="cursor:pointer;color:#fff;" class="btn btn-primary btn-sm mr-1"><i class="far fa-eye"></i></a><a href="https://vmsdemo.bdtask-demo.com/purchase/purchase/delete_purchase/13" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a></td>
                        </tr>
                        <tr role="row" class="odd">
                            <td class="sorting_1">9</td>
                            <td>123213</td>
                            <td>Auto Parts</td>
                            <td>2023-03-05</td>
                            <td>700.00</td>
                            <td><input name="url" type="hidden" id="url_14" value="https://vmsdemo.bdtask-demo.com/purchase/purchase/updatepurchasefrm"><a href="https://vmsdemo.bdtask-demo.com/purchase/purchase/editpurchasefrm/14" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a onclick="editinfo(14)" style="cursor:pointer;color:#fff;" class="btn btn-primary btn-sm mr-1"><i class="far fa-eye"></i></a><a href="https://vmsdemo.bdtask-demo.com/purchase/purchase/delete_purchase/14" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a></td>
                        </tr>
                        <tr role="row" class="even">
                            <td class="sorting_1">10</td>
                            <td>12345</td>
                            <td>honda</td>
                            <td>2023-03-15</td>
                            <td>12600000.00</td>
                            <td><input name="url" type="hidden" id="url_15" value="https://vmsdemo.bdtask-demo.com/purchase/purchase/updatepurchasefrm"><a href="https://vmsdemo.bdtask-demo.com/purchase/purchase/editpurchasefrm/15" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a onclick="editinfo(15)" style="cursor:pointer;color:#fff;" class="btn btn-primary btn-sm mr-1"><i class="far fa-eye"></i></a><a href="https://vmsdemo.bdtask-demo.com/purchase/purchase/delete_purchase/15" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a></td>
                        </tr>
                    </tbody>
                </table> <!-- /.table-responsive -->
            </div>
        </div>
    </div>
</div>
<!-- <script src="https://vmsdemo.bdtask-demo.com/assets/dist/js/purchase_list.js"></script> -->
<script>
    $(document).ready(function() {
        $("#purc").DataTable();
    });
</script>
@endsection