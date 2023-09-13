@extends('layouts.main.app')
{{-- Screen to edit permissions associated with a role --}}
@section('title', 'Edit Role')

@section('breadcrumb-content')
<li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
<li class="breadcrumb-item active" id="moduleName">Dashboard</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">Dashboard</h1>
<small id="controllerName">Edit Role</small>
@endsection

@section('content')

<div class="row">
    <div class="col-lg-12">
    </div>
</div>
<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="card">
            <h4 class="card-header"></h4>
            <form id="updateRoleForm" action="{{route('roles.update', $role['ROLE_ID'])}}" method="post" accept-charset="utf-8">
                @csrf
                @method('put')
                <div class="card-body">
                    <div class="form-group row">
                        <label for="role_name" class="col-sm-3 col-form-label">Role Name <i class="text-danger">*</i></label>
                        <div class="col-sm-9">
                            <input name="role_name" type="text" class="form-control" id="role_name" value="{{$role->ROLE_NAME}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="role_description" class="col-sm-3 col-form-label">Description </label>
                        <div class="col-sm-9">
                            <textarea class="form-control" rows="2" name="role_description" id="role_description">{{$role['DESCRIPTION']}}</textarea>
                        </div>
                    </div>
                    <input type="hidden" name="role_id" value="{{$role['ROLE_ID']}}">

                    {{-- $i - index to allow selecting all checkboxes, to number checkboxes as 2D array --}}
                    @php $i=0 @endphp
                    @foreach($menuTitles as $mainMenuItem)

                    <table class="table table-bordered table-hover" id="RoleTbl{{$i}}">
                        <h2>{!!$mainMenuItem->MENU_TITLE!!}</h2>
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
                            {{-- $j - index to display menu subtitle number --}}
                            {{-- $k - index to store data in array sent to server --}}
                            @php $j = 1; $k=0; @endphp
                            @foreach($userPermissions as $subMenuItem)
                            @if($subMenuItem->MENU_TITLE == $mainMenuItem->MENU_TITLE)
                            <tr>
                                <td>{{$j++}}</td>
                                <td class="text-">
                                    {!!$subMenuItem->MENU_SUBTITLE!!}
                                    <input type="hidden" name="role_permission[{{$k}}][permission_id]" value="{{$subMenuItem->PERMISSION_ID}}">
                                    <input type="hidden" name="role_permission[{{$k}}][title]" value="{{$subMenuItem->MENU_TITLE}}">
                                    <input type="hidden" name="role_permission[{{$k}}][subtitle]" value="{{$subMenuItem->MENU_SUBTITLE}}">
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="hidden" name="role_permission[{{$k}}][create]" value="0">
                                        <input type="checkbox" class="create_{{$i}}" name="role_permission[{{$k}}][create]" id="check_create_[{{$i}}][{{$j}}]" value="1" @if($subMenuItem->CAN_CREATE == 'Y') {{"checked"}} @endif>
                                        <label for="check_create_[{{$i}}][{{$j}}]"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="hidden" name="role_permission[{{$k}}][read]" value="0">
                                        <input type="checkbox" class="read_{{$i}}" name="role_permission[{{$k}}][read]" id="check_read_[{{$i}}][{{$j}}]" value="1" @if($subMenuItem->CAN_READ == 'Y') {{"checked"}} @endif>
                                        <label for="check_read_[{{$i}}][{{$j}}]"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="hidden" name="role_permission[{{$k}}][edit]" value="0">
                                        <input type="checkbox" class="edit_{{$i}}" name="role_permission[{{$k}}][edit]" id="check_edit_[{{$i}}][{{$j}}]" value="1" @if($subMenuItem->CAN_EDIT == 'Y') {{"checked"}} @endif>
                                        <label for="check_edit_[{{$i}}][{{$j}}]"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <input type="hidden" name="role_permission[{{$k}}][delete]" value="0">
                                        <input type="checkbox" class="del_{{$i}}" name="role_permission[{{$k}}][delete]" id="check_delete_[{{$i}}][{{$j}}]" value="1" @if($subMenuItem->CAN_DELETE == 'Y') {{"checked"}} @endif>
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

                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-success w-md m-b-5">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('js-content')
<script src="{{asset('public/dist/js/roles/role.js')}}"></script>
<script src="{{asset('public/dist/js/roles/edit-role.js')}}"></script>
@endsection