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
                     -->
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
<script src="{{asset('public/dist/js/roles/role.js')}}"></script>
<script src="{{asset('public/dist/js/roles/create-role.js')}}"></script>
@endsection