@extends('layouts.main.app')

@section('title', 'All Expenses')

@section('breadcrumb-content')
<li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
<li class="breadcrumb-item active" id="moduleName">Cost & Inventory</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">Cost & Inventory</h1>
<small id="controllerName">All Expenses List</small>
@endsection

@section('content')

<div class="row">
    <div class="col-lg-12">
    </div>
</div>
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
            <h4 class="pl-3">Expense List<small class="float-right"><a href="{{route('manage-expense-types')}}" class="btn btn-primary btn-md"><i class="ti-plus" aria-hidden="true"></i>
                        Manage Expense Type</a></small></h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="allExpensesTable" class="table display table-bordered table-striped table-hover ">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Invoice</th>
                            <th>Expense Group</th>
                            <th>Vehicle Name</th>
                            <th>Trip Type</th>
                            <th>Expense Date</th>
                            <th>By Whom</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>120</td>
                            <td>Fuel</td>
                            <td>Fareed Express</td>
                            <td>Rent Double</td>
                            <td>2023-04-07</td>
                            <td>Kamrul</td>
                            <td>
                                <input name="url" type="hidden" id="url_14" value="https://vmsdemo.bdtask-demo.com/costinventory/Costinventory/updateexpfrm" />
                                <a href="https://vmsdemo.bdtask-demo.com/costinventory/costinventory/editexpfrm/14" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                <a onclick="editinfo(14)" class="btn btn-primary btn-sm mr-1 "><i class="far fa-eye text-white"></i></a>
                                <a href="https://vmsdemo.bdtask-demo.com/costinventory/Costinventory/delete_expense/14" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>123</td>
                            <td>Fuel</td>
                            <td>داف</td>
                            <td>Rent Double</td>
                            <td>2023-04-04</td>
                            <td>أمير أبو اسنينة</td>
                            <td>
                                <input name="url" type="hidden" id="url_13" value="https://vmsdemo.bdtask-demo.com/costinventory/Costinventory/updateexpfrm" />
                                <a href="https://vmsdemo.bdtask-demo.com/costinventory/costinventory/editexpfrm/13" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                <a onclick="editinfo(13)" class="btn btn-primary btn-sm mr-1 "><i class="far fa-eye text-white"></i></a>
                                <a href="https://vmsdemo.bdtask-demo.com/costinventory/Costinventory/delete_expense/13" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>67575676</td>
                            <td>Maintenance</td>
                            <td>DEMO3</td>
                            <td>Rent Single</td>
                            <td>2020-04-15</td>
                            <td>Kamrul</td>
                            <td>
                                <input name="url" type="hidden" id="url_12" value="https://vmsdemo.bdtask-demo.com/costinventory/Costinventory/updateexpfrm" />
                                <a href="https://vmsdemo.bdtask-demo.com/costinventory/costinventory/editexpfrm/12" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                <a onclick="editinfo(12)" class="btn btn-primary btn-sm mr-1 "><i class="far fa-eye text-white"></i></a>
                                <a href="https://vmsdemo.bdtask-demo.com/costinventory/Costinventory/delete_expense/12" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>4546467</td>
                            <td>Maintenance</td>
                            <td>DEMO2</td>
                            <td>Rent Single</td>
                            <td>2020-05-13</td>
                            <td>asas</td>
                            <td>
                                <input name="url" type="hidden" id="url_11" value="https://vmsdemo.bdtask-demo.com/costinventory/Costinventory/updateexpfrm" />
                                <a href="https://vmsdemo.bdtask-demo.com/costinventory/costinventory/editexpfrm/11" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                <a onclick="editinfo(11)" class="btn btn-primary btn-sm mr-1 "><i class="far fa-eye text-white"></i></a>
                                <a href="https://vmsdemo.bdtask-demo.com/costinventory/Costinventory/delete_expense/11" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>6786789</td>
                            <td>Maintenance</td>
                            <td>DEMO3</td>
                            <td>Rent Single</td>
                            <td>2021-03-14</td>
                            <td>Kamrul</td>
                            <td>
                                <input name="url" type="hidden" id="url_10" value="https://vmsdemo.bdtask-demo.com/costinventory/Costinventory/updateexpfrm" />
                                <a href="https://vmsdemo.bdtask-demo.com/costinventory/costinventory/editexpfrm/10" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                <a onclick="editinfo(10)" class="btn btn-primary btn-sm mr-1 "><i class="far fa-eye text-white"></i></a>
                                <a href="https://vmsdemo.bdtask-demo.com/costinventory/Costinventory/delete_expense/10" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>67867878</td>
                            <td>Maintenance</td>
                            <td>DEMO1</td>
                            <td>Own Double</td>
                            <td>2020-12-16</td>
                            <td>asas</td>
                            <td>
                                <input name="url" type="hidden" id="url_9" value="https://vmsdemo.bdtask-demo.com/costinventory/Costinventory/updateexpfrm" />
                                <a href="https://vmsdemo.bdtask-demo.com/costinventory/costinventory/editexpfrm/9" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                <a onclick="editinfo(9)" class="btn btn-primary btn-sm mr-1 "><i class="far fa-eye text-white"></i></a>
                                <a href="https://vmsdemo.bdtask-demo.com/costinventory/Costinventory/delete_expense/9" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td>435345n</td>
                            <td>Maintenance</td>
                            <td>BMW</td>
                            <td>Hire Double</td>
                            <td>2020-11-11</td>
                            <td>abc</td>
                            <td>
                                <input name="url" type="hidden" id="url_8" value="https://vmsdemo.bdtask-demo.com/costinventory/Costinventory/updateexpfrm" />
                                <a href="https://vmsdemo.bdtask-demo.com/costinventory/costinventory/editexpfrm/8" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                <a onclick="editinfo(8)" class="btn btn-primary btn-sm mr-1 "><i class="far fa-eye text-white"></i></a>
                                <a href="https://vmsdemo.bdtask-demo.com/costinventory/Costinventory/delete_expense/8" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>8</td>
                            <td>435345n</td>
                            <td>Maintenance</td>
                            <td>BMW</td>
                            <td>Rent Single</td>
                            <td>2020-10-08</td>
                            <td>Kamrul</td>
                            <td>
                                <input name="url" type="hidden" id="url_7" value="https://vmsdemo.bdtask-demo.com/costinventory/Costinventory/updateexpfrm" />
                                <a href="https://vmsdemo.bdtask-demo.com/costinventory/costinventory/editexpfrm/7" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                <a onclick="editinfo(7)" class="btn btn-primary btn-sm mr-1 "><i class="far fa-eye text-white"></i></a>
                                <a href="https://vmsdemo.bdtask-demo.com/costinventory/Costinventory/delete_expense/7" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>9</td>
                            <td>435345</td>
                            <td>Fuel</td>
                            <td>kuyyi</td>
                            <td>Rent Double</td>
                            <td>2020-09-08</td>
                            <td>Nazmul Hassan</td>
                            <td>
                                <input name="url" type="hidden" id="url_6" value="https://vmsdemo.bdtask-demo.com/costinventory/Costinventory/updateexpfrm" />
                                <a href="https://vmsdemo.bdtask-demo.com/costinventory/costinventory/editexpfrm/6" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                <a onclick="editinfo(6)" class="btn btn-primary btn-sm mr-1 "><i class="far fa-eye text-white"></i></a>
                                <a href="https://vmsdemo.bdtask-demo.com/costinventory/Costinventory/delete_expense/6" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>10</td>
                            <td>6456546</td>
                            <td>Maintenance</td>
                            <td>BMW</td>
                            <td>Rent Double</td>
                            <td>2020-08-12</td>
                            <td>taslimul</td>
                            <td>
                                <input name="url" type="hidden" id="url_5" value="https://vmsdemo.bdtask-demo.com/costinventory/Costinventory/updateexpfrm" />
                                <a href="https://vmsdemo.bdtask-demo.com/costinventory/costinventory/editexpfrm/5" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                <a onclick="editinfo(5)" class="btn btn-primary btn-sm mr-1 "><i class="far fa-eye text-white"></i></a>
                                <a href="https://vmsdemo.bdtask-demo.com/costinventory/Costinventory/delete_expense/5" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>11</td>
                            <td>Test Invoice</td>
                            <td>Maintenance</td>
                            <td>MT</td>
                            <td>Rent Double</td>
                            <td>2020-07-15</td>
                            <td>Nazmul Hassan</td>
                            <td>
                                <input name="url" type="hidden" id="url_4" value="https://vmsdemo.bdtask-demo.com/costinventory/Costinventory/updateexpfrm" />
                                <a href="https://vmsdemo.bdtask-demo.com/costinventory/costinventory/editexpfrm/4" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                <a onclick="editinfo(4)" class="btn btn-primary btn-sm mr-1 "><i class="far fa-eye text-white"></i></a>
                                <a href="https://vmsdemo.bdtask-demo.com/costinventory/Costinventory/delete_expense/4" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>12</td>
                            <td>78576547</td>
                            <td>Fuel</td>
                            <td>Navana</td>
                            <td>Rent Single</td>
                            <td>2020-06-16</td>
                            <td>Nazmul Hassan</td>
                            <td>
                                <input name="url" type="hidden" id="url_3" value="https://vmsdemo.bdtask-demo.com/costinventory/Costinventory/updateexpfrm" />
                                <a href="https://vmsdemo.bdtask-demo.com/costinventory/costinventory/editexpfrm/3" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                <a onclick="editinfo(3)" class="btn btn-primary btn-sm mr-1 "><i class="far fa-eye text-white"></i></a>
                                <a href="https://vmsdemo.bdtask-demo.com/costinventory/Costinventory/delete_expense/3" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>13</td>
                            <td>3434613</td>
                            <td>Maintenance</td>
                            <td>Toyata</td>
                            <td>Hire Single</td>
                            <td>2021-02-17</td>
                            <td>Jubaer Hossain</td>
                            <td>
                                <input name="url" type="hidden" id="url_2" value="https://vmsdemo.bdtask-demo.com/costinventory/Costinventory/updateexpfrm" />
                                <a href="https://vmsdemo.bdtask-demo.com/costinventory/costinventory/editexpfrm/2" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                <a onclick="editinfo(2)" class="btn btn-primary btn-sm mr-1 "><i class="far fa-eye text-white"></i></a>
                                <a href="https://vmsdemo.bdtask-demo.com/costinventory/Costinventory/delete_expense/2" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>14</td>
                            <td>3434647</td>
                            <td>Other</td>
                            <td>DEMO3</td>
                            <td>Rent Double</td>
                            <td>2021-01-06</td>
                            <td>Jubaer Hossain</td>
                            <td>
                                <input name="url" type="hidden" id="url_1" value="https://vmsdemo.bdtask-demo.com/costinventory/Costinventory/updateexpfrm" />
                                <a href="https://vmsdemo.bdtask-demo.com/costinventory/costinventory/editexpfrm/1" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a>
                                <a onclick="editinfo(1)" class="btn btn-primary btn-sm mr-1 "><i class="far fa-eye text-white"></i></a>
                                <a href="https://vmsdemo.bdtask-demo.com/costinventory/Costinventory/delete_expense/1" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#allExpensesTable").DataTable();
    });
</script>

@endsection