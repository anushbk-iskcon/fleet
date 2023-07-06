@extends('layouts.main.app')

@section('title', 'Manage Departments')

@section('breadcrumb-content')
<li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
<li class="breadcrumb-item active" id="moduleName">Employee Management</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">Employee Management</h1>
<small id="controllerName">Manage Departments</small>
@endsection

@section('content')

<div class="row">
    <div class="col-lg-12">
    </div>
</div>
<div class="row">

    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <table width="100%" id="exdatatable" class="table table-striped table-bordered nowrap bootstrap4-modal">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Department Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="odd gradeX">
                            <td>1</td>
                            <td>Administration</td>
                            <td class="center">
                                <a href="#" class="btn btn-xs btn-success"><i class="ti-pencil"></i></a>
                                <a href="#" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure ?') "><i class="ti-close"></i></a>
                            </td>
                        </tr>
                        <tr class="even gradeC">
                            <td>2</td>
                            <td>yhyh</td>
                            <td class="center">
                                <a href="#" class="btn btn-xs btn-success"><i class="ti-pencil"></i></a>
                                <a href="#" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure ?') "><i class="ti-close"></i></a>
                            </td>
                        </tr>
                        <tr class="odd gradeX">
                            <td>3</td>
                            <td>Rose Water</td>
                            <td class="center">
                                <a href="#" class="btn btn-xs btn-success"><i class="ti-pencil"></i></a>
                                <a href="https://vmsdemo.bdtask-demo.com/empmgt/Department_controller/delete_dept/27" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure ?') "><i class="ti-close"></i></a>
                            </td>
                        </tr>
                        <tr class="even gradeC">
                            <td>4</td>
                            <td>Computer</td>
                            <td class="center">
                                <a href="https://vmsdemo.bdtask-demo.com/empmgt/Department_controller/update_dept_form/24" class="btn btn-xs btn-success"><i class="ti-pencil"></i></a>
                                <a href="https://vmsdemo.bdtask-demo.com/empmgt/Department_controller/delete_dept/24" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure ?') "><i class="ti-close"></i></a>
                            </td>
                        </tr>
                        <tr class="odd gradeX">
                            <td>5</td>
                            <td>Testing</td>
                            <td class="center">
                                <a href="https://vmsdemo.bdtask-demo.com/empmgt/Department_controller/update_dept_form/23" class="btn btn-xs btn-success"><i class="ti-pencil"></i></a>
                                <a href="https://vmsdemo.bdtask-demo.com/empmgt/Department_controller/delete_dept/23" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure ?') "><i class="ti-close"></i></a>
                            </td>
                        </tr>
                        <tr class="even gradeC">
                            <td>6</td>
                            <td>Planning department</td>
                            <td class="center">
                                <a href="https://vmsdemo.bdtask-demo.com/empmgt/Department_controller/update_dept_form/22" class="btn btn-xs btn-success"><i class="ti-pencil"></i></a>
                                <a href="https://vmsdemo.bdtask-demo.com/empmgt/Department_controller/delete_dept/22" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure ?') "><i class="ti-close"></i></a>
                            </td>
                        </tr>
                        <tr class="odd gradeX">
                            <td>7</td>
                            <td>mmkmk</td>
                            <td class="center">
                                <a href="https://vmsdemo.bdtask-demo.com/empmgt/Department_controller/update_dept_form/21" class="btn btn-xs btn-success"><i class="ti-pencil"></i></a>
                                <a href="https://vmsdemo.bdtask-demo.com/empmgt/Department_controller/delete_dept/21" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure ?') "><i class="ti-close"></i></a>
                            </td>
                        </tr>
                        <tr class="even gradeC">
                            <td>8</td>
                            <td>Technical</td>
                            <td class="center">
                                <a href="https://vmsdemo.bdtask-demo.com/empmgt/Department_controller/update_dept_form/14" class="btn btn-xs btn-success"><i class="ti-pencil"></i></a>
                                <a href="https://vmsdemo.bdtask-demo.com/empmgt/Department_controller/delete_dept/14" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure ?') "><i class="ti-close"></i></a>
                            </td>
                        </tr>
                        <tr class="odd gradeX">
                            <td>9</td>
                            <td>Marketing & Sales</td>
                            <td class="center">
                                <a href="https://vmsdemo.bdtask-demo.com/empmgt/Department_controller/update_dept_form/13" class="btn btn-xs btn-success"><i class="ti-pencil"></i></a>
                                <a href="https://vmsdemo.bdtask-demo.com/empmgt/Department_controller/delete_dept/13" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure ?') "><i class="ti-close"></i></a>
                            </td>
                        </tr>
                        <tr class="even gradeC">
                            <td>10</td>
                            <td>Human Resource</td>
                            <td class="center">
                                <a href="https://vmsdemo.bdtask-demo.com/empmgt/Department_controller/update_dept_form/9" class="btn btn-xs btn-success"><i class="ti-pencil"></i></a>
                                <a href="https://vmsdemo.bdtask-demo.com/empmgt/Department_controller/delete_dept/9" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure ?') "><i class="ti-close"></i></a>
                            </td>
                        </tr>
                        <tr class="odd gradeX">
                            <td>11</td>
                            <td>Accounting</td>
                            <td class="center">
                                <a href="https://vmsdemo.bdtask-demo.com/empmgt/Department_controller/update_dept_form/8" class="btn btn-xs btn-success"><i class="ti-pencil"></i></a>
                                <a href="https://vmsdemo.bdtask-demo.com/empmgt/Department_controller/delete_dept/8" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure ?') "><i class="ti-close"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection