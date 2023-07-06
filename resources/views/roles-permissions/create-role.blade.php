@extends('layouts.main.app')

@section('title', 'Create Role')

@section('breadcrumb-content')
<li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
<li class="breadcrumb-item active" id="moduleName">Dashboard</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">Dashboard</h1>
<small id="controllerName">Create User Role</small>
@endsection

@section('content')

<div class="row">
    <div class="col-lg-12">

    </div>
</div>
<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="card">
            <h4 class="card-header">Create User Role</h4>
            <form action="{{route('roles.store')}}" method="post" id="createRoleForm" accept-charset="utf-8">
                @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <label for="role_name" class="col-sm-3  col-form-label">Role Name <i class="text-danger">*</i></label>
                        <div class="col-sm-9">
                            <input name="role_name" required type="text" class="form-control" id="role_name" placeholder="Role Name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="role_description" class="col-sm-3  col-form-label">Description </label>
                        <div class="col-sm-9">
                            <textarea class="form-control" rows="2" name="role_description" id="role_description"></textarea>
                        </div>
                    </div>

                    <!-- Newly created tables for Permissions Selections -->
                    @php $i=0 @endphp
                    @foreach($menuTitles as $menutitle)

                    <table class="table table-bordered table-hover" id="RoleTbl{{$i}}">
                        <h2>{!!$menutitle->MENU_TITLE!!}</h2>
                        <thead>
                            <tr>
                                <th>Sl No.</th>
                                <th>Menu Title</th>
                                <th>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="allcheck" name="allcreate" value="1" id="allcreate_{{$i}}" title="create" usemap="{{$i}}">
                                        <label for="allcreate_{{$i}}"><strong>Can Create</strong></label>
                                    </div>
                                </th>
                                <th>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="allcheck" name="allread" value="1" id="allread_{{$i}}" title="read" usemap="{{$i}}">
                                        <label for="allread_{{$i}}"><strong>Can Read</strong></label>
                                    </div>
                                </th>
                                <th>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="allcheck" name="alledit" value="1" id="alledit_{{$i}}" title="edit" usemap="{{$i}}">
                                        <label for="alledit_{{$i}}"><strong>Can Edit</strong></label>
                                    </div>
                                </th>
                                <th>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="allcheck" name="alldelete" value="1" id="alldelete_{{$i}}" title="del" usemap="{{$i}}">
                                        <label for="alldelete_{{$i}}"><strong>Can Delete</strong></label>
                                    </div>
                                </th>

                            </tr>
                        </thead>
                        <tbody>
                            @php $j = 1; $k=0; @endphp
                            @foreach($menupermissions as $menuSubtitle)
                            @if($menuSubtitle->MENU_TITLE == $menutitle->MENU_TITLE)
                            <tr>
                                <td>{{$j++}}</td>
                                <td class="text-">
                                    {!!$menuSubtitle->MENU_SUBTITLE!!}
                                    <input type="hidden" name="role_permission[{{$k}}][permission_id]" value="{{$menuSubtitle->PERMISSION_ID}}">
                                    <input type="hidden" name="role_permission[{{$k}}][title]" value="{{$menuSubtitle->MENU_TITLE}}">
                                    <input type="hidden" name="role_permission[{{$k}}][subtitle]" value="{{$menuSubtitle->MENU_SUBTITLE}}">
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="hidden" name="role_permission[{{$k}}][create]" value="0">
                                        <input type="checkbox" class="create_{{$i}}" name="role_permission[{{$k}}][create]" id="check_create_[{{$i}}][{{$j}}]" value="1">
                                        <label for="check_create_[{{$i}}][{{$j}}]"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="hidden" name="role_permission[{{$k}}][read]" value="0">
                                        <input type="checkbox" class="read_{{$i}}" name="role_permission[{{$k}}][read]" id="check_read_[{{$i}}][{{$j}}]" value="1">
                                        <label for="check_read_[{{$i}}][{{$j}}]"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="hidden" name="role_permission[{{$k}}][edit]" value="0">
                                        <input type="checkbox" class="edit_{{$i}}" name="role_permission[{{$k}}][edit]" id="check_edit_[{{$i}}][{{$j}}]" value="1">
                                        <label for="check_edit_[{{$i}}][{{$j}}]"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="hidden" name="role_permission[{{$k}}][delete]" value="0">
                                        <input type="checkbox" class="del_{{$i}}" name="role_permission[{{$k}}][delete]" id="check_delete_[{{$i}}][{{$j}}]" value="1">
                                        <label for="check_delete_[{{$i}}][{{$j}}]"></label>
                                    </div>
                                </td>
                            </tr>
                            @endif
                            @php $k++ @endphp
                            @endforeach
                        </tbody>
                    </table>
                    @php $i++ @endphp
                    @endforeach


                    <!-- Existing Module-wise Permissions Selections -->
                    <!--
                    <input type="hidden" name="module[]" value="costinventory">
                    <table class="table table-bordered table-hover" id="RoleTbl">
                        <h2>Cost & Inventory</h2>
                        <thead>
                            <tr>
                                <th>Sl No.</th>
                                <th>Menu Title</th>
                                <th>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="allcheck" name="allcreate" value="1" id="allcreate_0" title="create" usemap="0">
                                        <label for="allcreate_0"><strong>Can Create</strong></label>
                                    </div>
                                </th>
                                <th>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="allcheck" name="allread" value="1" id="allread_0" title="read" usemap="0">
                                        <label for="allread_0"><strong>Can read</strong></label>
                                    </div>
                                </th>
                                <th>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="allcheck" name="alledit" value="1" id="alledit_0" title="edit" usemap="0">
                                        <label for="alledit_0"><strong>Can Edit</strong></label>
                                    </div>
                                </th>
                                <th>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="allcheck" name="alldelete" value="1" id="alldelete_0" title="del" usemap="0">
                                        <label for="alldelete_0"><strong>Can Delete</strong></label>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td class="text-">
                                    Cost & Inventory
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="create_0" name="create[0][0][]" value="1" id="create[0]0">
                                        <label for="create[0]0"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="read_0" name="read[0][0][]" value="1" id="read[0]0">
                                        <label for="read[0]0"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="edit_0" name="edit[0][0][]" value="1" id="edit[0]0">
                                        <label for="edit[0]0"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="del_0" name="delete[0][0][]" value="1" id="delete[0]0">
                                        <label for="delete[0]0"></label>
                                    </div>
                                </td>
                                <input type="hidden" name="menu_id[0][0][]" value="22">
                            </tr>
                            <tr>
                                <td>2</td>
                                <td class="text-">
                                    Manage Expense Type
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="create_0" name="create[0][1][]" value="1" id="create[0]1">
                                        <label for="create[0]1"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="read_0" name="read[0][1][]" value="1" id="read[0]1">
                                        <label for="read[0]1"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="edit_0" name="edit[0][1][]" value="1" id="edit[0]1">
                                        <label for="edit[0]1"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="del_0" name="delete[0][1][]" value="1" id="delete[0]1">
                                        <label for="delete[0]1"></label>
                                    </div>
                                </td>
                                <input type="hidden" name="menu_id[0][1][]" value="23">
                            </tr>
                            <tr>
                                <td>3</td>
                                <td class="text-right">
                                    Manage Parts</td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="create_0" name="create[0][2][]" value="1" id="create[0]2">
                                        <label for="create[0]2"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="read_0" name="read[0][2][]" value="1" id="read[0]2">
                                        <label for="read[0]2"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="edit_0" name="edit[0][2][]" value="1" id="edit[0]2">
                                        <label for="edit[0]2"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="del_0" name="delete[0][2][]" value="1" id="delete[0]2">
                                        <label for="delete[0]2"></label>
                                    </div>
                                </td>
                                <input type="hidden" name="menu_id[0][2][]" value="24">
                            </tr>
                            <tr>
                                <td>4</td>
                                <td class="text-right">
                                    Category</td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="create_0" name="create[0][3][]" value="1" id="create[0]3">
                                        <label for="create[0]3"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="read_0" name="read[0][3][]" value="1" id="read[0]3">
                                        <label for="read[0]3"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="edit_0" name="edit[0][3][]" value="1" id="edit[0]3">
                                        <label for="edit[0]3"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="del_0" name="delete[0][3][]" value="1" id="delete[0]3">
                                        <label for="delete[0]3"></label>
                                    </div>
                                </td>
                                <input type="hidden" name="menu_id[0][3][]" value="25">
                            </tr>
                            <tr>
                                <td>5</td>
                                <td class="text-right">
                                    Location</td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="create_0" name="create[0][4][]" value="1" id="create[0]4">
                                        <label for="create[0]4"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="read_0" name="read[0][4][]" value="1" id="read[0]4">
                                        <label for="read[0]4"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="edit_0" name="edit[0][4][]" value="1" id="edit[0]4">
                                        <label for="edit[0]4"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="del_0" name="delete[0][4][]" value="1" id="delete[0]4">
                                        <label for="delete[0]4"></label>
                                    </div>
                                </td>
                                <input type="hidden" name="menu_id[0][4][]" value="26">
                            </tr>
                            <tr>
                                <td>6</td>
                                <td class="text-right">
                                    Stock Management
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="create_0" name="create[0][5][]" value="1" id="create[0]5">
                                        <label for="create[0]5"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="read_0" name="read[0][5][]" value="1" id="read[0]5">
                                        <label for="read[0]5"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="edit_0" name="edit[0][5][]" value="1" id="edit[0]5">
                                        <label for="edit[0]5"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="del_0" name="delete[0][5][]" value="1" id="delete[0]5">
                                        <label for="delete[0]5"></label>
                                    </div>
                                </td>
                                <input type="hidden" name="menu_id[0][5][]" value="27">
                            </tr>
                        </tbody>
                    </table>
                    <input type="hidden" name="module[]" value="empmgt">
                    <table class="table table-bordered table-hover" id="RoleTbl">
                        <h2>Employee Management</h2>
                        <thead>
                            <tr>
                                <th>Sl No.</th>
                                <th> Menu Title</th>
                                <th>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="allcheck" name="allcreate" value="1" id="allcreate_1" title="create" usemap="1">
                                        <label for="allcreate_1"><strong>Can Create</strong></label>
                                    </div>
                                </th>
                                <th>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="allcheck" name="allread" value="1" id="allread_1" title="read" usemap="1">
                                        <label for="allread_1"><strong>Can read</strong></label>
                                    </div>
                                </th>
                                <th>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="allcheck" name="alledit" value="1" id="alledit_1" title="edit" usemap="1">
                                        <label for="alledit_1"><strong>Can Edit</strong></label>
                                    </div>
                                </th>
                                <th>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="allcheck" name="alldelete" value="1" id="alldelete_1" title="del" usemap="1">
                                        <label for="alldelete_1"><strong>Can Delete</strong></label>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td class="text-">
                                    Employee Management
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="create_1" name="create[1][0][]" value="1" id="create[1]0">
                                        <label for="create[1]0"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="read_1" name="read[1][0][]" value="1" id="read[1]0">
                                        <label for="read[1]0"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="edit_1" name="edit[1][0][]" value="1" id="edit[1]0">
                                        <label for="edit[1]0"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="del_1" name="delete[1][0][]" value="1" id="delete[1]0">
                                        <label for="delete[1]0"></label>
                                    </div>
                                </td>
                                <input type="hidden" name="menu_id[1][0][]" value="1">
                            </tr>
                            <tr>
                                <td>2</td>
                                <td class="text-right">
                                    Manage Employee</td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="create_1" name="create[1][1][]" value="1" id="create[1]1">
                                        <label for="create[1]1"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="read_1" name="read[1][1][]" value="1" id="read[1]1">
                                        <label for="read[1]1"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="edit_1" name="edit[1][1][]" value="1" id="edit[1]1">
                                        <label for="edit[1]1"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="del_1" name="delete[1][1][]" value="1" id="delete[1]1">
                                        <label for="delete[1]1"></label>
                                    </div>
                                </td>
                                <input type="hidden" name="menu_id[1][1][]" value="2">
                            </tr>
                            <tr>
                                <td>3</td>
                                <td class="text-right">Position</td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="create_1" name="create[1][2][]" value="1" id="create[1]2">
                                        <label for="create[1]2"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="read_1" name="read[1][2][]" value="1" id="read[1]2">
                                        <label for="read[1]2"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="edit_1" name="edit[1][2][]" value="1" id="edit[1]2">
                                        <label for="edit[1]2"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="del_1" name="delete[1][2][]" value="1" id="delete[1]2">
                                        <label for="delete[1]2"></label>
                                    </div>
                                </td>
                                <input type="hidden" name="menu_id[1][2][]" value="3">
                            </tr>
                            <tr>
                                <td>4</td>
                                <td class="text-right">
                                    Department
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="create_1" name="create[1][3][]" value="1" id="create[1]3">
                                        <label for="create[1]3"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="read_1" name="read[1][3][]" value="1" id="read[1]3">
                                        <label for="read[1]3"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="edit_1" name="edit[1][3][]" value="1" id="edit[1]3">
                                        <label for="edit[1]3"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="del_1" name="delete[1][3][]" value="1" id="delete[1]3">
                                        <label for="delete[1]3"></label>
                                    </div>
                                </td>
                                <input type="hidden" name="menu_id[1][3][]" value="4">
                            </tr>
                        </tbody>
                    </table>
                    <input type="hidden" name="module[]" value="hrm">
                    <table class="table table-bordered table-hover" id="RoleTbl">
                        <h2></h2>
                        <thead>
                            <tr>
                                <th>Sl No.</th>
                                <th> Menu Title</th>
                                <th>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="allcheck" name="allcreate" value="1" id="allcreate_2" title="create" usemap="2">
                                        <label for="allcreate_2"><strong>Can Create</strong></label>
                                    </div>
                                </th>
                                <th>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="allcheck" name="allread" value="1" id="allread_2" title="read" usemap="2">
                                        <label for="allread_2"><strong>Can read</strong></label>
                                    </div>
                                </th>
                                <th>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="allcheck" name="alledit" value="1" id="alledit_2" title="edit" usemap="2">
                                        <label for="alledit_2"><strong>Can Edit</strong></label>
                                    </div>
                                </th>
                                <th>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="allcheck" name="alldelete" value="1" id="alldelete_2" title="del" usemap="2">
                                        <label for="alldelete_2"><strong>Can Delete</strong></label>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td class="text-right">
                                    Manage Driver</td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="create_2" name="create[2][0][]" value="1" id="create[2]0">
                                        <label for="create[2]0"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="read_2" name="read[2][0][]" value="1" id="read[2]0">
                                        <label for="read[2]0"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="edit_2" name="edit[2][0][]" value="1" id="edit[2]0">
                                        <label for="edit[2]0"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="del_2" name="delete[2][0][]" value="1" id="delete[2]0">
                                        <label for="delete[2]0"></label>
                                    </div>
                                </td>
                                <input type="hidden" name="menu_id[2][0][]" value="5">
                            </tr>
                            <tr>
                                <td>2</td>
                                <td class="text-right">
                                    Manage License
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="create_2" name="create[2][1][]" value="1" id="create[2]1">
                                        <label for="create[2]1"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="read_2" name="read[2][1][]" value="1" id="read[2]1">
                                        <label for="read[2]1"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="edit_2" name="edit[2][1][]" value="1" id="edit[2]1">
                                        <label for="edit[2]1"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="del_2" name="delete[2][1][]" value="1" id="delete[2]1">
                                        <label for="delete[2]1"></label>
                                    </div>
                                </td>
                                <input type="hidden" name="menu_id[2][1][]" value="6">
                            </tr>
                            <tr>
                                <td>3</td>
                                <td class="text-">
                                    Manage Req. Approval
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="create_2" name="create[2][2][]" value="1" id="create[2]2">
                                        <label for="create[2]2"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="read_2" name="read[2][2][]" value="1" id="read[2]2">
                                        <label for="read[2]2"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="edit_2" name="edit[2][2][]" value="1" id="edit[2]2">
                                        <label for="edit[2]2"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="del_2" name="delete[2][2][]" value="1" id="delete[2]2">
                                        <label for="delete[2]2"></label>
                                    </div>
                                </td>
                                <input type="hidden" name="menu_id[2][2][]" value="70">
                            </tr>
                        </tbody>
                    </table>
                    <input type="hidden" name="module[]" value="maintenance">
                    <table class="table table-bordered table-hover" id="RoleTbl">
                        <h2>Maintenance</h2>
                        <thead>
                            <tr>
                                <th>Sl No.</th>
                                <th> Menu Title</th>
                                <th>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="allcheck" name="allcreate" value="1" id="allcreate_3" title="create" usemap="3">
                                        <label for="allcreate_3"><strong>Can Create</strong></label>
                                    </div>
                                </th>
                                <th>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="allcheck" name="allread" value="1" id="allread_3" title="read" usemap="3">
                                        <label for="allread_3"><strong>Can read</strong></label>
                                    </div>
                                </th>
                                <th>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="allcheck" name="alledit" value="1" id="alledit_3" title="edit" usemap="3">
                                        <label for="alledit_3"><strong>Can Edit</strong></label>
                                    </div>
                                </th>
                                <th>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="allcheck" name="alldelete" value="1" id="alldelete_3" title="del" usemap="3">
                                        <label for="alldelete_3"><strong>Can Delete</strong></label>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td class="text-">
                                    Maintenance
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="create_3" name="create[3][0][]" value="1" id="create[3]0">
                                        <label for="create[3]0"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="read_3" name="read[3][0][]" value="1" id="read[3]0">
                                        <label for="read[3]0"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="edit_3" name="edit[3][0][]" value="1" id="edit[3]0">
                                        <label for="edit[3]0"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="del_3" name="delete[3][0][]" value="1" id="delete[3]0">
                                        <label for="delete[3]0"></label>
                                    </div>
                                </td>
                                <input type="hidden" name="menu_id[3][0][]" value="17">
                            </tr>
                            <tr>
                                <td>2</td>
                                <td class="text-">
                                    Maintenance Req. Details</td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="create_3" name="create[3][1][]" value="1" id="create[3]1">
                                        <label for="create[3]1"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="read_3" name="read[3][1][]" value="1" id="read[3]1">
                                        <label for="read[3]1"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="edit_3" name="edit[3][1][]" value="1" id="edit[3]1">
                                        <label for="edit[3]1"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="del_3" name="delete[3][1][]" value="1" id="delete[3]1">
                                        <label for="delete[3]1"></label>
                                    </div>
                                </td>
                                <input type="hidden" name="menu_id[3][1][]" value="18">
                            </tr>
                            <tr>
                                <td>3</td>
                                <td class="text-right">
                                    Approval Authority List
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="create_3" name="create[3][2][]" value="1" id="create[3]2">
                                        <label for="create[3]2"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="read_3" name="read[3][2][]" value="1" id="read[3]2">
                                        <label for="read[3]2"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="edit_3" name="edit[3][2][]" value="1" id="edit[3]2">
                                        <label for="edit[3]2"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="del_3" name="delete[3][2][]" value="1" id="delete[3]2">
                                        <label for="delete[3]2"></label>
                                    </div>
                                </td>
                                <input type="hidden" name="menu_id[3][2][]" value="19">
                            </tr>
                            <tr>
                                <td>4</td>
                                <td class="text-right">
                                    Maintenance Service List
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="create_3" name="create[3][3][]" value="1" id="create[3]3">
                                        <label for="create[3]3"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="read_3" name="read[3][3][]" value="1" id="read[3]3">
                                        <label for="read[3]3"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="edit_3" name="edit[3][3][]" value="1" id="edit[3]3">
                                        <label for="edit[3]3"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="del_3" name="delete[3][3][]" value="1" id="delete[3]3">
                                        <label for="delete[3]3"></label>
                                    </div>
                                </td>
                                <input type="hidden" name="menu_id[3][3][]" value="20">
                            </tr>
                            <tr>
                                <td>5</td>
                                <td class="text-right">
                                    PM Service List</td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="create_3" name="create[3][4][]" value="1" id="create[3]4">
                                        <label for="create[3]4"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="read_3" name="read[3][4][]" value="1" id="read[3]4">
                                        <label for="read[3]4"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="edit_3" name="edit[3][4][]" value="1" id="edit[3]4">
                                        <label for="edit[3]4"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="del_3" name="delete[3][4][]" value="1" id="delete[3]4">
                                        <label for="delete[3]4"></label>
                                    </div>
                                </td>
                                <input type="hidden" name="menu_id[3][4][]" value="21">
                            </tr>
                        </tbody>
                    </table>
                    <input type="hidden" name="module[]" value="purchase">
                    <table class="table table-bordered table-hover" id="RoleTbl">
                        <h2>Purchase & Usage</h2>
                        <thead>
                            <tr>
                                <th>Sl No.</th>
                                <th> Menu Title</th>
                                <th>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="allcheck" name="allcreate" value="1" id="allcreate_4" title="create" usemap="4">
                                        <label for="allcreate_4"><strong>Can Create</strong></label>
                                    </div>
                                </th>
                                <th>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="allcheck" name="allread" value="1" id="allread_4" title="read" usemap="4">
                                        <label for="allread_4"><strong>Can read</strong></label>
                                    </div>
                                </th>
                                <th>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="allcheck" name="alledit" value="1" id="alledit_4" title="edit" usemap="4">
                                        <label for="alledit_4"><strong>Can Edit</strong></label>
                                    </div>
                                </th>
                                <th>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="allcheck" name="alldelete" value="1" id="alldelete_4" title="del" usemap="4">
                                        <label for="alldelete_4"><strong>Can Delete</strong></label>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td class="text-">
                                    Purchase & Usage</td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="create_4" name="create[4][0][]" value="1" id="create[4]0">
                                        <label for="create[4]0"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="read_4" name="read[4][0][]" value="1" id="read[4]0">
                                        <label for="read[4]0"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="edit_4" name="edit[4][0][]" value="1" id="edit[4]0">
                                        <label for="edit[4]0"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="del_4" name="delete[4][0][]" value="1" id="delete[4]0">
                                        <label for="delete[4]0"></label>
                                    </div>
                                </td>
                                <input type="hidden" name="menu_id[4][0][]" value="28">
                            </tr>
                            <tr>
                                <td>2</td>
                                <td class="text-">
                                    Purchase Details</td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="create_4" name="create[4][1][]" value="1" id="create[4]1">
                                        <label for="create[4]1"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="read_4" name="read[4][1][]" value="1" id="read[4]1">
                                        <label for="read[4]1"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="edit_4" name="edit[4][1][]" value="1" id="edit[4]1">
                                        <label for="edit[4]1"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="del_4" name="delete[4][1][]" value="1" id="delete[4]1">
                                        <label for="delete[4]1"></label>
                                    </div>
                                </td>
                                <input type="hidden" name="menu_id[4][1][]" value="29">
                            </tr>
                            <tr>
                                <td>3</td>
                                <td class="text-right">
                                    Add Purchase</td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="create_4" name="create[4][2][]" value="1" id="create[4]2">
                                        <label for="create[4]2"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="read_4" name="read[4][2][]" value="1" id="read[4]2">
                                        <label for="read[4]2"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="edit_4" name="edit[4][2][]" value="1" id="edit[4]2">
                                        <label for="edit[4]2"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="del_4" name="delete[4][2][]" value="1" id="delete[4]2">
                                        <label for="delete[4]2"></label>
                                    </div>
                                </td>
                                <input type="hidden" name="menu_id[4][2][]" value="30">
                            </tr>
                            <tr>
                                <td>4</td>
                                <td class="text-right">
                                    Parts Usages List</td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="create_4" name="create[4][3][]" value="1" id="create[4]3">
                                        <label for="create[4]3"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="read_4" name="read[4][3][]" value="1" id="read[4]3">
                                        <label for="read[4]3"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="edit_4" name="edit[4][3][]" value="1" id="edit[4]3">
                                        <label for="edit[4]3"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="del_4" name="delete[4][3][]" value="1" id="delete[4]3">
                                        <label for="delete[4]3"></label>
                                    </div>
                                </td>
                                <input type="hidden" name="menu_id[4][3][]" value="31">
                            </tr>
                            <tr>
                                <td>5</td>
                                <td class="text-right">
                                    Add Parts Usage</td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="create_4" name="create[4][4][]" value="1" id="create[4]4">
                                        <label for="create[4]4"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="read_4" name="read[4][4][]" value="1" id="read[4]4">
                                        <label for="read[4]4"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="edit_4" name="edit[4][4][]" value="1" id="edit[4]4">
                                        <label for="edit[4]4"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="del_4" name="delete[4][4][]" value="1" id="delete[4]4">
                                        <label for="delete[4]4"></label>
                                    </div>
                                </td>
                                <input type="hidden" name="menu_id[4][4][]" value="32">
                            </tr>
                        </tbody>
                    </table>
                    <input type="hidden" name="module[]" value="refueling">
                    <table class="table table-bordered table-hover" id="RoleTbl">
                        <h2>Refueling</h2>
                        <thead>
                            <tr>
                                <th>Sl No.</th>
                                <th> Menu Title</th>
                                <th>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="allcheck" name="allcreate" value="1" id="allcreate_5" title="create" usemap="5">
                                        <label for="allcreate_5"><strong>Can Create</strong></label>
                                    </div>
                                </th>
                                <th>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="allcheck" name="allread" value="1" id="allread_5" title="read" usemap="5">
                                        <label for="allread_5"><strong>Can read</strong></label>
                                    </div>
                                </th>
                                <th>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="allcheck" name="alledit" value="1" id="alledit_5" title="edit" usemap="5">
                                        <label for="alledit_5"><strong>Can Edit</strong></label>
                                    </div>
                                </th>
                                <th>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="allcheck" name="alldelete" value="1" id="alldelete_5" title="del" usemap="5">
                                        <label for="alldelete_5"><strong>Can Delete</strong></label>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td class="text-">
                                    Refueling</td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="create_5" name="create[5][0][]" value="1" id="create[5]0">
                                        <label for="create[5]0"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="read_5" name="read[5][0][]" value="1" id="read[5]0">
                                        <label for="read[5]0"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="edit_5" name="edit[5][0][]" value="1" id="edit[5]0">
                                        <label for="edit[5]0"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="del_5" name="delete[5][0][]" value="1" id="delete[5]0">
                                        <label for="delete[5]0"></label>
                                    </div>
                                </td>
                                <input type="hidden" name="menu_id[5][0][]" value="33">
                            </tr>
                            <tr>
                                <td>2</td>
                                <td class="text-">
                                    Refuel Setting</td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="create_5" name="create[5][1][]" value="1" id="create[5]1">
                                        <label for="create[5]1"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="read_5" name="read[5][1][]" value="1" id="read[5]1">
                                        <label for="read[5]1"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="edit_5" name="edit[5][1][]" value="1" id="edit[5]1">
                                        <label for="edit[5]1"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="del_5" name="delete[5][1][]" value="1" id="delete[5]1">
                                        <label for="delete[5]1"></label>
                                    </div>
                                </td>
                                <input type="hidden" name="menu_id[5][1][]" value="34">
                            </tr>
                            <tr>
                                <td>3</td>
                                <td class="text-right">
                                    Manage Fuel Station </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="create_5" name="create[5][2][]" value="1" id="create[5]2">
                                        <label for="create[5]2"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="read_5" name="read[5][2][]" value="1" id="read[5]2">
                                        <label for="read[5]2"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="edit_5" name="edit[5][2][]" value="1" id="edit[5]2">
                                        <label for="edit[5]2"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="del_5" name="delete[5][2][]" value="1" id="delete[5]2">
                                        <label for="delete[5]2"></label>
                                    </div>
                                </td>
                                <input type="hidden" name="menu_id[5][2][]" value="35">
                            </tr>
                            <tr>
                                <td>4</td>
                                <td class="text-right">
                                    Refuel Requisition Details</td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="create_5" name="create[5][3][]" value="1" id="create[5]3">
                                        <label for="create[5]3"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="read_5" name="read[5][3][]" value="1" id="read[5]3">
                                        <label for="read[5]3"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="edit_5" name="edit[5][3][]" value="1" id="edit[5]3">
                                        <label for="edit[5]3"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="del_5" name="delete[5][3][]" value="1" id="delete[5]3">
                                        <label for="delete[5]3"></label>
                                    </div>
                                </td>
                                <input type="hidden" name="menu_id[5][3][]" value="36">
                            </tr>
                            <tr>
                                <td>5</td>
                                <td class="text-right">
                                    Refuel Requisition Track List</td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="create_5" name="create[5][4][]" value="1" id="create[5]4">
                                        <label for="create[5]4"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="read_5" name="read[5][4][]" value="1" id="read[5]4">
                                        <label for="read[5]4"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="edit_5" name="edit[5][4][]" value="1" id="edit[5]4">
                                        <label for="edit[5]4"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="del_5" name="delete[5][4][]" value="1" id="delete[5]4">
                                        <label for="delete[5]4"></label>
                                    </div>
                                </td>
                                <input type="hidden" name="menu_id[5][4][]" value="37">
                            </tr>
                            <tr>
                                <td>6</td>
                                <td class="text-right">
                                    Approval Authority List</td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="create_5" name="create[5][5][]" value="1" id="create[5]5">
                                        <label for="create[5]5"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="read_5" name="read[5][5][]" value="1" id="read[5]5">
                                        <label for="read[5]5"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="edit_5" name="edit[5][5][]" value="1" id="edit[5]5">
                                        <label for="edit[5]5"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="del_5" name="delete[5][5][]" value="1" id="delete[5]5">
                                        <label for="delete[5]5"></label>
                                    </div>
                                </td>
                                <input type="hidden" name="menu_id[5][5][]" value="38">
                            </tr>
                        </tbody>
                    </table>
                    <input type="hidden" name="module[]" value="reports">
                    <table class="table table-bordered table-hover" id="RoleTbl">
                        <h2>Reports</h2>
                        <thead>
                            <tr>
                                <th>Sl No.</th>
                                <th> Menu Title</th>
                                <th>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="allcheck" name="allcreate" value="1" id="allcreate_6" title="create" usemap="6">
                                        <label for="allcreate_6"><strong>Can Create</strong></label>
                                    </div>
                                </th>
                                <th>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="allcheck" name="allread" value="1" id="allread_6" title="read" usemap="6">
                                        <label for="allread_6"><strong>Can read</strong></label>
                                    </div>
                                </th>
                                <th>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="allcheck" name="alledit" value="1" id="alledit_6" title="edit" usemap="6">
                                        <label for="alledit_6"><strong>Can Edit</strong></label>
                                    </div>
                                </th>
                                <th>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="allcheck" name="alldelete" value="1" id="alldelete_6" title="del" usemap="6">
                                        <label for="alldelete_6"><strong>Can Delete</strong></label>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td class="text-">
                                    Reports
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="create_6" name="create[6][0][]" value="1" id="create[6]0">
                                        <label for="create[6]0"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="read_6" name="read[6][0][]" value="1" id="read[6]0">
                                        <label for="read[6]0"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="edit_6" name="edit[6][0][]" value="1" id="edit[6]0">
                                        <label for="edit[6]0"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="del_6" name="delete[6][0][]" value="1" id="delete[6]0">
                                        <label for="delete[6]0"></label>
                                    </div>
                                </td>
                                <input type="hidden" name="menu_id[6][0][]" value="44">
                            </tr>
                            <tr>
                                <td>2</td>
                                <td class="text-">
                                    Employee Report</td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="create_6" name="create[6][1][]" value="1" id="create[6]1">
                                        <label for="create[6]1"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="read_6" name="read[6][1][]" value="1" id="read[6]1">
                                        <label for="read[6]1"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="edit_6" name="edit[6][1][]" value="1" id="edit[6]1">
                                        <label for="edit[6]1"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="del_6" name="delete[6][1][]" value="1" id="delete[6]1">
                                        <label for="delete[6]1"></label>
                                    </div>
                                </td>
                                <input type="hidden" name="menu_id[6][1][]" value="45">
                            </tr>
                            <tr>
                                <td>3</td>
                                <td class="text-right">
                                    Renewal Report</td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="create_6" name="create[6][2][]" value="1" id="create[6]2">
                                        <label for="create[6]2"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="read_6" name="read[6][2][]" value="1" id="read[6]2">
                                        <label for="read[6]2"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="edit_6" name="edit[6][2][]" value="1" id="edit[6]2">
                                        <label for="edit[6]2"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="del_6" name="delete[6][2][]" value="1" id="delete[6]2">
                                        <label for="delete[6]2"></label>
                                    </div>
                                </td>
                                <input type="hidden" name="menu_id[6][2][]" value="46">
                            </tr>
                            <tr>
                                <td>4</td>
                                <td class="text-right">
                                    Pick & Drop Req. List</td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="create_6" name="create[6][3][]" value="1" id="create[6]3">
                                        <label for="create[6]3"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="read_6" name="read[6][3][]" value="1" id="read[6]3">
                                        <label for="read[6]3"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="edit_6" name="edit[6][3][]" value="1" id="edit[6]3">
                                        <label for="edit[6]3"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="del_6" name="delete[6][3][]" value="1" id="delete[6]3">
                                        <label for="delete[6]3"></label>
                                    </div>
                                </td>
                                <input type="hidden" name="menu_id[6][3][]" value="47">
                            </tr>
                            <tr>
                                <td>5</td>
                                <td class="text-right">
                                    Refuel Requisition Reports</td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="create_6" name="create[6][4][]" value="1" id="create[6]4">
                                        <label for="create[6]4"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="read_6" name="read[6][4][]" value="1" id="read[6]4">
                                        <label for="read[6]4"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="edit_6" name="edit[6][4][]" value="1" id="edit[6]4">
                                        <label for="edit[6]4"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="del_6" name="delete[6][4][]" value="1" id="delete[6]4">
                                        <label for="delete[6]4"></label>
                                    </div>
                                </td>
                                <input type="hidden" name="menu_id[6][4][]" value="48">
                            </tr>
                            <tr>
                                <td>6</td>
                                <td class="text-right">
                                    Milage List
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="create_6" name="create[6][5][]" value="1" id="create[6]5">
                                        <label for="create[6]5"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="read_6" name="read[6][5][]" value="1" id="read[6]5">
                                        <label for="read[6]5"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="edit_6" name="edit[6][5][]" value="1" id="edit[6]5">
                                        <label for="edit[6]5"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="del_6" name="delete[6][5][]" value="1" id="delete[6]5">
                                        <label for="delete[6]5"></label>
                                    </div>
                                </td>
                                <input type="hidden" name="menu_id[6][5][]" value="49">
                            </tr>
                            <tr>
                                <td>7</td>
                                <td class="text-right">
                                    Expense Details</td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="create_6" name="create[6][6][]" value="1" id="create[6]6">
                                        <label for="create[6]6"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="read_6" name="read[6][6][]" value="1" id="read[6]6">
                                        <label for="read[6]6"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="edit_6" name="edit[6][6][]" value="1" id="edit[6]6">
                                        <label for="edit[6]6"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="del_6" name="delete[6][6][]" value="1" id="delete[6]6">
                                        <label for="delete[6]6"></label>
                                    </div>
                                </td>
                                <input type="hidden" name="menu_id[6][6][]" value="50">
                            </tr>
                            <tr>
                                <td>8</td>
                                <td class="text-right">
                                    Maintenance Requisition Reports
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="create_6" name="create[6][7][]" value="1" id="create[6]7">
                                        <label for="create[6]7"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="read_6" name="read[6][7][]" value="1" id="read[6]7">
                                        <label for="read[6]7"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="edit_6" name="edit[6][7][]" value="1" id="edit[6]7">
                                        <label for="edit[6]7"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="del_6" name="delete[6][7][]" value="1" id="delete[6]7">
                                        <label for="delete[6]7"></label>
                                    </div>
                                </td>
                                <input type="hidden" name="menu_id[6][7][]" value="51">
                            </tr>
                        </tbody>
                    </table>
                    <input type="hidden" name="module[]" value="setting">
                    <table class="table table-bordered table-hover" id="RoleTbl">
                        <h2>System Setting</h2>
                        <thead>
                            <tr>
                                <th>Sl No.</th>
                                <th> Menu Title</th>
                                <th>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="allcheck" name="allcreate" value="1" id="allcreate_7" title="create" usemap="7">
                                        <label for="allcreate_7"><strong>Can Create</strong></label>
                                    </div>
                                </th>
                                <th>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="allcheck" name="allread" value="1" id="allread_7" title="read" usemap="7">
                                        <label for="allread_7"><strong>Can read</strong></label>
                                    </div>
                                </th>
                                <th>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="allcheck" name="alledit" value="1" id="alledit_7" title="edit" usemap="7">
                                        <label for="alledit_7"><strong>Can Edit</strong></label>
                                    </div>
                                </th>
                                <th>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="allcheck" name="alldelete" value="1" id="alldelete_7" title="del" usemap="7">
                                        <label for="alldelete_7"><strong>Can Delete</strong></label>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td class="text-">
                                    System Settings
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="create_7" name="create[7][0][]" value="1" id="create[7]0">
                                        <label for="create[7]0"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="read_7" name="read[7][0][]" value="1" id="read[7]0">
                                        <label for="read[7]0"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="edit_7" name="edit[7][0][]" value="1" id="edit[7]0">
                                        <label for="edit[7]0"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="del_7" name="delete[7][0][]" value="1" id="delete[7]0">
                                        <label for="delete[7]0"></label>
                                    </div>
                                </td>
                                <input type="hidden" name="menu_id[7][0][]" value="52">
                            </tr>
                            <tr>
                                <td>2</td>
                                <td class="text-">
                                    Manage Company
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="create_7" name="create[7][1][]" value="1" id="create[7]1">
                                        <label for="create[7]1"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="read_7" name="read[7][1][]" value="1" id="read[7]1">
                                        <label for="read[7]1"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="edit_7" name="edit[7][1][]" value="1" id="edit[7]1">
                                        <label for="edit[7]1"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="del_7" name="delete[7][1][]" value="1" id="delete[7]1">
                                        <label for="delete[7]1"></label>
                                    </div>
                                </td>
                                <input type="hidden" name="menu_id[7][1][]" value="53">
                            </tr>
                            <tr>
                                <td>3</td>
                                <td class="text-right">
                                    Manege Recurring Period</td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="create_7" name="create[7][2][]" value="1" id="create[7]2">
                                        <label for="create[7]2"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="read_7" name="read[7][2][]" value="1" id="read[7]2">
                                        <label for="read[7]2"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="edit_7" name="edit[7][2][]" value="1" id="edit[7]2">
                                        <label for="edit[7]2"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="del_7" name="delete[7][2][]" value="1" id="delete[7]2">
                                        <label for="delete[7]2"></label>
                                    </div>
                                </td>
                                <input type="hidden" name="menu_id[7][2][]" value="54">
                            </tr>
                            <tr>
                                <td>4</td>
                                <td class="text-right">
                                    Notification
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="create_7" name="create[7][3][]" value="1" id="create[7]3">
                                        <label for="create[7]3"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="read_7" name="read[7][3][]" value="1" id="read[7]3">
                                        <label for="read[7]3"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="edit_7" name="edit[7][3][]" value="1" id="edit[7]3">
                                        <label for="edit[7]3"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="del_7" name="delete[7][3][]" value="1" id="delete[7]3">
                                        <label for="delete[7]3"></label>
                                    </div>
                                </td>
                                <input type="hidden" name="menu_id[7][3][]" value="55">
                            </tr>
                            <tr>
                                <td>5</td>
                                <td class="text-right">Document Type</td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="create_7" name="create[7][4][]" value="1" id="create[7]4">
                                        <label for="create[7]4"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="read_7" name="read[7][4][]" value="1" id="read[7]4">
                                        <label for="read[7]4"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="edit_7" name="edit[7][4][]" value="1" id="edit[7]4">
                                        <label for="edit[7]4"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="del_7" name="delete[7][4][]" value="1" id="delete[7]4">
                                        <label for="delete[7]4"></label>
                                    </div>
                                </td>
                                <input type="hidden" name="menu_id[7][4][]" value="56">
                            </tr>
                            <tr>
                                <td>6</td>
                                <td class="text-right">Manage Vendor</td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="create_7" name="create[7][5][]" value="1" id="create[7]5">
                                        <label for="create[7]5"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="read_7" name="read[7][5][]" value="1" id="read[7]5">
                                        <label for="read[7]5"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="edit_7" name="edit[7][5][]" value="1" id="edit[7]5">
                                        <label for="edit[7]5"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="del_7" name="delete[7][5][]" value="1" id="delete[7]5">
                                        <label for="delete[7]5"></label>
                                    </div>
                                </td>
                                <input type="hidden" name="menu_id[7][5][]" value="57">
                            </tr>
                            <tr>
                                <td>7</td>
                                <td class="text-right">Vehicle Type</td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="create_7" name="create[7][6][]" value="1" id="create[7]6">
                                        <label for="create[7]6"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="read_7" name="read[7][6][]" value="1" id="read[7]6">
                                        <label for="read[7]6"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="edit_7" name="edit[7][6][]" value="1" id="edit[7]6">
                                        <label for="edit[7]6"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="del_7" name="delete[7][6][]" value="1" id="delete[7]6">
                                        <label for="delete[7]6"></label>
                                    </div>
                                </td>
                                <input type="hidden" name="menu_id[7][6][]" value="58">
                            </tr>
                            <tr>
                                <td>8</td>
                                <td class="text-right">
                                    Requisition Purpose
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="create_7" name="create[7][7][]" value="1" id="create[7]7">
                                        <label for="create[7]7"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="read_7" name="read[7][7][]" value="1" id="read[7]7">
                                        <label for="read[7]7"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="edit_7" name="edit[7][7][]" value="1" id="edit[7]7">
                                        <label for="edit[7]7"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="del_7" name="delete[7][7][]" value="1" id="delete[7]7">
                                        <label for="delete[7]7"></label>
                                    </div>
                                </td>
                                <input type="hidden" name="menu_id[7][7][]" value="59">
                            </tr>
                            <tr>
                                <td>9</td>
                                <td class="text-right">Requisition Type</td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="create_7" name="create[7][8][]" value="1" id="create[7]8">
                                        <label for="create[7]8"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="read_7" name="read[7][8][]" value="1" id="read[7]8">
                                        <label for="read[7]8"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="edit_7" name="edit[7][8][]" value="1" id="edit[7]8">
                                        <label for="edit[7]8"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="del_7" name="delete[7][8][]" value="1" id="delete[7]8">
                                        <label for="delete[7]8"></label>
                                    </div>
                                </td>
                                <input type="hidden" name="menu_id[7][8][]" value="60">
                            </tr>
                            <tr>
                                <td>10</td>
                                <td class="text-right">Manage Phase</td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="create_7" name="create[7][9][]" value="1" id="create[7]9">
                                        <label for="create[7]9"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="read_7" name="read[7][9][]" value="1" id="read[7]9">
                                        <label for="read[7]9"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="edit_7" name="edit[7][9][]" value="1" id="edit[7]9">
                                        <label for="edit[7]9"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="del_7" name="delete[7][9][]" value="1" id="delete[7]9">
                                        <label for="delete[7]9"></label>
                                    </div>
                                </td>
                                <input type="hidden" name="menu_id[7][9][]" value="61">
                            </tr>
                            <tr>
                                <td>11</td>
                                <td class="text-right">Maintenance Types</td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="create_7" name="create[7][10][]" value="1" id="create[7]10">
                                        <label for="create[7]10"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="read_7" name="read[7][10][]" value="1" id="read[7]10">
                                        <label for="read[7]10"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="edit_7" name="edit[7][10][]" value="1" id="edit[7]10">
                                        <label for="edit[7]10"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="del_7" name="delete[7][10][]" value="1" id="delete[7]10">
                                        <label for="delete[7]10"></label>
                                    </div>
                                </td>
                                <input type="hidden" name="menu_id[7][10][]" value="62">
                            </tr>
                            <tr>
                                <td>12</td>
                                <td class="text-right">Manage Priority</td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="create_7" name="create[7][11][]" value="1" id="create[7]11">
                                        <label for="create[7]11"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="read_7" name="read[7][11][]" value="1" id="read[7]11">
                                        <label for="read[7]11"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="edit_7" name="edit[7][11][]" value="1" id="edit[7]11">
                                        <label for="edit[7]11"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="del_7" name="delete[7][11][]" value="1" id="delete[7]11">
                                        <label for="delete[7]11"></label>
                                    </div>
                                </td>
                                <input type="hidden" name="menu_id[7][11][]" value="63">
                            </tr>
                            <tr>
                                <td>13</td>
                                <td class="text-right">Service Types</td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="create_7" name="create[7][12][]" value="1" id="create[7]12">
                                        <label for="create[7]12"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="read_7" name="read[7][12][]" value="1" id="read[7]12">
                                        <label for="read[7]12"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="edit_7" name="edit[7][12][]" value="1" id="edit[7]12">
                                        <label for="edit[7]12"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="del_7" name="delete[7][12][]" value="1" id="delete[7]12">
                                        <label for="delete[7]12"></label>
                                    </div>
                                </td>
                                <input type="hidden" name="menu_id[7][12][]" value="64">
                            </tr>
                            <tr>
                                <td>14</td>
                                <td class="text-right">Fuel Types</td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="create_7" name="create[7][13][]" value="1" id="create[7]13">
                                        <label for="create[7]13"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="read_7" name="read[7][13][]" value="1" id="read[7]13">
                                        <label for="read[7]13"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="edit_7" name="edit[7][13][]" value="1" id="edit[7]13">
                                        <label for="edit[7]13"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="del_7" name="delete[7][13][]" value="1" id="delete[7]13">
                                        <label for="delete[7]13"></label>
                                    </div>
                                </td>
                                <input type="hidden" name="menu_id[7][13][]" value="65">
                            </tr>
                            <tr>
                                <td>15</td>
                                <td class="text-right">Trip Details</td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="create_7" name="create[7][14][]" value="1" id="create[7]14">
                                        <label for="create[7]14"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="read_7" name="read[7][14][]" value="1" id="read[7]14">
                                        <label for="read[7]14"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="edit_7" name="edit[7][14][]" value="1" id="edit[7]14">
                                        <label for="edit[7]14"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="del_7" name="delete[7][14][]" value="1" id="delete[7]14">
                                        <label for="delete[7]14"></label>
                                    </div>
                                </td>
                                <input type="hidden" name="menu_id[7][14][]" value="66">
                            </tr>
                            <tr>
                                <td>16</td>
                                <td class="text-right">Division</td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="create_7" name="create[7][15][]" value="1" id="create[7]15">
                                        <label for="create[7]15"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="read_7" name="read[7][15][]" value="1" id="read[7]15">
                                        <label for="read[7]15"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="edit_7" name="edit[7][15][]" value="1" id="edit[7]15">
                                        <label for="edit[7]15"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="del_7" name="delete[7][15][]" value="1" id="delete[7]15">
                                        <label for="delete[7]15"></label>
                                    </div>
                                </td>
                                <input type="hidden" name="menu_id[7][15][]" value="67">
                            </tr>
                            <tr>
                                <td>17</td>
                                <td class="text-right">RTA Office Details</td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="create_7" name="create[7][16][]" value="1" id="create[7]16">
                                        <label for="create[7]16"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="read_7" name="read[7][16][]" value="1" id="read[7]16">
                                        <label for="read[7]16"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="edit_7" name="edit[7][16][]" value="1" id="edit[7]16">
                                        <label for="edit[7]16"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="del_7" name="delete[7][16][]" value="1" id="delete[7]16">
                                        <label for="delete[7]16"></label>
                                    </div>
                                </td>
                                <input type="hidden" name="menu_id[7][16][]" value="68">
                            </tr>
                            <tr>
                                <td>18</td>
                                <td class="text-right">Manage Ownership</td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="create_7" name="create[7][17][]" value="1" id="create[7]17">
                                        <label for="create[7]17"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="read_7" name="read[7][17][]" value="1" id="read[7]17">
                                        <label for="read[7]17"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="edit_7" name="edit[7][17][]" value="1" id="edit[7]17">
                                        <label for="edit[7]17"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="del_7" name="delete[7][17][]" value="1" id="delete[7]17">
                                        <label for="delete[7]17"></label>
                                    </div>
                                </td>
                                <input type="hidden" name="menu_id[7][17][]" value="69">
                            </tr>
                        </tbody>
                    </table>
                    <input type="hidden" name="module[]" value="vehiclemgt">
                    <table class="table table-bordered table-hover" id="RoleTbl">
                        <h2>Vehicle Management</h2>
                        <thead>
                            <tr>
                                <th>Sl No.</th>
                                <th> Menu Title</th>
                                <th>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="allcheck" name="allcreate" value="1" id="allcreate_8" title="create" usemap="8">
                                        <label for="allcreate_8"><strong>Can Create</strong></label>
                                    </div>
                                </th>
                                <th>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="allcheck" name="allread" value="1" id="allread_8" title="read" usemap="8">
                                        <label for="allread_8"><strong>Can read</strong></label>
                                    </div>
                                </th>
                                <th>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="allcheck" name="alledit" value="1" id="alledit_8" title="edit" usemap="8">
                                        <label for="alledit_8"><strong>Can Edit</strong></label>
                                    </div>
                                </th>
                                <th>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="allcheck" name="alldelete" value="1" id="alldelete_8" title="del" usemap="8">
                                        <label for="alldelete_8"><strong>Can Delete</strong></label>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td class="text-">Vehicle Management</td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="create_8" name="create[8][0][]" value="1" id="create[8]0">
                                        <label for="create[8]0"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="read_8" name="read[8][0][]" value="1" id="read[8]0">
                                        <label for="read[8]0"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="edit_8" name="edit[8][0][]" value="1" id="edit[8]0">
                                        <label for="edit[8]0"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="del_8" name="delete[8][0][]" value="1" id="delete[8]0">
                                        <label for="delete[8]0"></label>
                                    </div>
                                </td>
                                <input type="hidden" name="menu_id[8][0][]" value="7">
                            </tr>
                            <tr>
                                <td>2</td>
                                <td class="text-right">Vehicle List</td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="create_8" name="create[8][1][]" value="1" id="create[8]1">
                                        <label for="create[8]1"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="read_8" name="read[8][1][]" value="1" id="read[8]1">
                                        <label for="read[8]1"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="edit_8" name="edit[8][1][]" value="1" id="edit[8]1">
                                        <label for="edit[8]1"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="del_8" name="delete[8][1][]" value="1" id="delete[8]1">
                                        <label for="delete[8]1"></label>
                                    </div>
                                </td>
                                <input type="hidden" name="menu_id[8][1][]" value="8">
                            </tr>
                            <tr>
                                <td>3</td>
                                <td class="text-right">Insurance Details</td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="create_8" name="create[8][2][]" value="1" id="create[8]2">
                                        <label for="create[8]2"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="read_8" name="read[8][2][]" value="1" id="read[8]2">
                                        <label for="read[8]2"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="edit_8" name="edit[8][2][]" value="1" id="edit[8]2">
                                        <label for="edit[8]2"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="del_8" name="delete[8][2][]" value="1" id="delete[8]2">
                                        <label for="delete[8]2"></label>
                                    </div>
                                </td>
                                <input type="hidden" name="menu_id[8][2][]" value="9">
                            </tr>
                            <tr>
                                <td>4</td>
                                <td class="text-right">Manage Legal Document</td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="create_8" name="create[8][3][]" value="1" id="create[8]3">
                                        <label for="create[8]3"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="read_8" name="read[8][3][]" value="1" id="read[8]3">
                                        <label for="read[8]3"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="edit_8" name="edit[8][3][]" value="1" id="edit[8]3">
                                        <label for="edit[8]3"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="del_8" name="delete[8][3][]" value="1" id="delete[8]3">
                                        <label for="delete[8]3"></label>
                                    </div>
                                </td>
                                <input type="hidden" name="menu_id[8][3][]" value="10">
                            </tr>
                            <tr>
                                <td>5</td>
                                <td class="text-right">Reminder Details</td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="create_8" name="create[8][4][]" value="1" id="create[8]4">
                                        <label for="create[8]4"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="read_8" name="read[8][4][]" value="1" id="read[8]4">
                                        <label for="read[8]4"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="edit_8" name="edit[8][4][]" value="1" id="edit[8]4">
                                        <label for="edit[8]4"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="del_8" name="delete[8][4][]" value="1" id="delete[8]4">
                                        <label for="delete[8]4"></label>
                                    </div>
                                </td>
                                <input type="hidden" name="menu_id[8][4][]" value="11">
                            </tr>
                        </tbody>
                    </table>
                    <input type="hidden" name="module[]" value="vehiclereq">
                    <table class="table table-bordered table-hover" id="RoleTbl">
                        <h2>Vehicle Requisition</h2>
                        <thead>
                            <tr>
                                <th>Sl No.</th>
                                <th> Menu Title</th>
                                <th>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="allcheck" name="allcreate" value="1" id="allcreate_9" title="create" usemap="9">
                                        <label for="allcreate_9"><strong>Can Create</strong></label>
                                    </div>
                                </th>
                                <th>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="allcheck" name="allread" value="1" id="allread_9" title="read" usemap="9">
                                        <label for="allread_9"><strong>Can read</strong></label>
                                    </div>
                                </th>
                                <th>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="allcheck" name="alledit" value="1" id="alledit_9" title="edit" usemap="9">
                                        <label for="alledit_9"><strong>Can Edit</strong></label>
                                    </div>
                                </th>
                                <th>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="allcheck" name="alldelete" value="1" id="alldelete_9" title="del" usemap="9">
                                        <label for="alldelete_9"><strong>Can Delete</strong></label>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td class="text-">Vehicle Requisition</td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="create_9" name="create[9][0][]" value="1" id="create[9]0">
                                        <label for="create[9]0"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="read_9" name="read[9][0][]" value="1" id="read[9]0">
                                        <label for="read[9]0"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="edit_9" name="edit[9][0][]" value="1" id="edit[9]0">
                                        <label for="edit[9]0"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="del_9" name="delete[9][0][]" value="1" id="delete[9]0">
                                        <label for="delete[9]0"></label>
                                    </div>
                                </td>
                                <input type="hidden" name="menu_id[9][0][]" value="12">
                            </tr>
                            <tr>
                                <td>2</td>
                                <td class="text-right">
                                    Manage Vehicle Requisition</td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="create_9" name="create[9][1][]" value="1" id="create[9]1">
                                        <label for="create[9]1"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="read_9" name="read[9][1][]" value="1" id="read[9]1">
                                        <label for="read[9]1"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="edit_9" name="edit[9][1][]" value="1" id="edit[9]1">
                                        <label for="edit[9]1"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="del_9" name="delete[9][1][]" value="1" id="delete[9]1">
                                        <label for="delete[9]1"></label>
                                    </div>
                                </td>
                                <input type="hidden" name="menu_id[9][1][]" value="13">
                            </tr>
                            <tr>
                                <td>3</td>
                                <td class="text-right">Vehicle Route Details</td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="create_9" name="create[9][2][]" value="1" id="create[9]2">
                                        <label for="create[9]2"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="read_9" name="read[9][2][]" value="1" id="read[9]2">
                                        <label for="read[9]2"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="edit_9" name="edit[9][2][]" value="1" id="edit[9]2">
                                        <label for="edit[9]2"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="del_9" name="delete[9][2][]" value="1" id="delete[9]2">
                                        <label for="delete[9]2"></label>
                                    </div>
                                </td>
                                <input type="hidden" name="menu_id[9][2][]" value="14">
                            </tr>
                            <tr>
                                <td>4</td>
                                <td class="text-right">Manage Approval Authority</td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="create_9" name="create[9][3][]" value="1" id="create[9]3">
                                        <label for="create[9]3"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="read_9" name="read[9][3][]" value="1" id="read[9]3">
                                        <label for="read[9]3"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="edit_9" name="edit[9][3][]" value="1" id="edit[9]3">
                                        <label for="edit[9]3"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="del_9" name="delete[9][3][]" value="1" id="delete[9]3">
                                        <label for="delete[9]3"></label>
                                    </div>
                                </td>
                                <input type="hidden" name="menu_id[9][3][]" value="15">
                            </tr>
                            <tr>
                                <td>5</td>
                                <td class="text-right">Pick & Drop Requisition List</td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="create_9" name="create[9][4][]" value="1" id="create[9]4">
                                        <label for="create[9]4"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="read_9" name="read[9][4][]" value="1" id="read[9]4">
                                        <label for="read[9]4"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="edit_9" name="edit[9][4][]" value="1" id="edit[9]4">
                                        <label for="edit[9]4"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="checkbox" class="del_9" name="delete[9][4][]" value="1" id="delete[9]4">
                                        <label for="delete[9]4"></label>
                                    </div>
                                </td>
                                <input type="hidden" name="menu_id[9][4][]" value="16">
                            </tr>
                        </tbody>
                    </table> -->
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-success w-md m-b-5">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
@section('js-content')
<script src="{{asset('dist/js/roles/role.js')}}"></script>
<script src="{{asset('dist/js/roles/create-role.js')}}"></script>
@endsection