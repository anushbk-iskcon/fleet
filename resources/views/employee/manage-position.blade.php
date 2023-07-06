@extends('layouts.main.app')

@section('title', 'Manage Position')

@section('breadcrumb-content')
<li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
<li class="breadcrumb-item active" id="moduleName">Employee Management</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">Employee Management</h1>
<small id="controllerName">Manage Positions</small>
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
                <h4>Position List Details</h4>
            </div>
            <style>
                img {
                    height: 80px;
                    width: 100px;
                }
            </style>
            <div class="card-body">
                <table id="exdatatable" class="table table-striped table-bordered nowrap bootstrap4-modal">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Position Name</th>
                            <th>Details</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="odd gradeX">
                            <td>1</td>
                            <td>????</td>
                            <td>???? ?????</td>
                            <td class="center">
                                <a href="https://vmsdemo.bdtask-demo.com/empmgt/employees/update_form/20" class="btn btn-xs btn-success"><i class="ti-pencil"></i></a>
                                <a href="https://vmsdemo.bdtask-demo.com/empmgt/employees/delete_pos/20" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure ?') "><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                        <tr class="even gradeC">
                            <td>2</td>
                            <td>Customer</td>
                            <td>Customer</td>
                            <td class="center">
                                <a href="https://vmsdemo.bdtask-demo.com/empmgt/employees/update_form/19" class="btn btn-xs btn-success"><i class="ti-pencil"></i></a>
                                <a href="https://vmsdemo.bdtask-demo.com/empmgt/employees/delete_pos/19" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure ?') "><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                        <tr class="odd gradeX">
                            <td>3</td>
                            <td>officer</td>
                            <td>officer</td>
                            <td class="center">
                                <a href="https://vmsdemo.bdtask-demo.com/empmgt/employees/update_form/18" class="btn btn-xs btn-success"><i class="ti-pencil"></i></a>
                                <a href="https://vmsdemo.bdtask-demo.com/empmgt/employees/delete_pos/18" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure ?') "><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                        <tr class="even gradeC">
                            <td>4</td>
                            <td>testing</td>
                            <td>testing purpose</td>
                            <td class="center">
                                <a href="https://vmsdemo.bdtask-demo.com/empmgt/employees/update_form/17" class="btn btn-xs btn-success"><i class="ti-pencil"></i></a>
                                <a href="https://vmsdemo.bdtask-demo.com/empmgt/employees/delete_pos/17" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure ?') "><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                        <tr class="odd gradeX">
                            <td>5</td>
                            <td>Palero</td>
                            <td>Test Palero</td>
                            <td class="center">
                                <a href="https://vmsdemo.bdtask-demo.com/empmgt/employees/update_form/16" class="btn btn-xs btn-success"><i class="ti-pencil"></i></a>
                                <a href="https://vmsdemo.bdtask-demo.com/empmgt/employees/delete_pos/16" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure ?') "><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                        <tr class="even gradeC">
                            <td>6</td>
                            <td>Receptionist</td>
                            <td>Test Receptionist</td>
                            <td class="center">
                                <a href="https://vmsdemo.bdtask-demo.com/empmgt/employees/update_form/10" class="btn btn-xs btn-success"><i class="ti-pencil"></i></a>
                                <a href="https://vmsdemo.bdtask-demo.com/empmgt/employees/delete_pos/10" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure ?') "><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                        <tr class="odd gradeX">
                            <td>7</td>
                            <td>Helper</td>
                            <td>Test Helperr</td>
                            <td class="center">
                                <a href="https://vmsdemo.bdtask-demo.com/empmgt/employees/update_form/9" class="btn btn-xs btn-success"><i class="ti-pencil"></i></a>
                                <a href="https://vmsdemo.bdtask-demo.com/empmgt/employees/delete_pos/9" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure ?') "><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                        <tr class="even gradeC">
                            <td>8</td>
                            <td>Accounts</td>
                            <td>Play a key role in every restaurant. </td>
                            <td class="center">
                                <a href="https://vmsdemo.bdtask-demo.com/empmgt/employees/update_form/7" class="btn btn-xs btn-success"><i class="ti-pencil"></i></a>
                                <a href="https://vmsdemo.bdtask-demo.com/empmgt/employees/delete_pos/7" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure ?') "><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                        <tr class="odd gradeX">
                            <td>9</td>
                            <td>Manager</td>
                            <td>Recruits and hires qualified employees, creates in-house job-training programs, and assists employees with their career needs.</td>
                            <td class="center">
                                <a href="https://vmsdemo.bdtask-demo.com/empmgt/employees/update_form/2" class="btn btn-xs btn-success"><i class="ti-pencil"></i></a>
                                <a href="https://vmsdemo.bdtask-demo.com/empmgt/employees/delete_pos/2" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure ?') "><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                        <tr class="even gradeC">
                            <td>10</td>
                            <td>Supervisor</td>
                            <td>Responsible for the pastry shop in a foodservice establishment. Ensures that the products produced in the pastry shop meet the quality standards in conjunction with the executive chef.</td>
                            <td class="center">
                                <a href="https://vmsdemo.bdtask-demo.com/empmgt/employees/update_form/1" class="btn btn-xs btn-success"><i class="ti-pencil"></i></a>
                                <a href="https://vmsdemo.bdtask-demo.com/empmgt/employees/delete_pos/1" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure ?') "><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>

@endsection