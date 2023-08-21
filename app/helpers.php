<?php

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Models\Role;
use DB;

if (!function_exists('getMenuPermission')) {

    function getMenuPermission()
    {
        $userRoleId = DB::table('user_roles')->where('USER_ID', Auth::user()->USER_ID)->value('ROLE_ID');
        $userRole = Role::find($userRoleId);
        $userRoleName = $userRole->ROLE_NAME;

        $userPermissions = DB::table('role_permissions')->where('ROLE_ID', $userRoleId)->get();
        $menuPermissions = DB::table('permissions')
            ->join('role_permissions', function ($join) use ($userRoleId) {
                $join->on('permissions.PERMISSION_ID', '=', 'role_permissions.PERMISSION_ID')
                    ->where('role_permissions.ROLE_ID', '=', $userRoleId);
            })
            ->selectRaw('permissions.PERMISSION_ID as permissionID, permissions.SLUG as url, role_permissions.CAN_CREATE as CAN_CREATE, role_permissions.CAN_READ as CAN_READ, role_permissions.CAN_EDIT as CAN_EDIT, role_permissions.CAN_DELETE as CAN_DELETE')
            ->where(['permissions.IS_ACTIVE' => 'Y'])
            ->get();

        $userMenuPermissions = array();
        foreach ($menuPermissions as $menuPermission) {
            $userMenuPermissions[$menuPermission->url] = array();
            $userMenuPermissions[$menuPermission->url]['CAN_CREATE'] = $menuPermission->CAN_CREATE;
            $userMenuPermissions[$menuPermission->url]['CAN_READ'] = $menuPermission->CAN_READ;
            $userMenuPermissions[$menuPermission->url]['CAN_EDIT'] = $menuPermission->CAN_EDIT;
            $userMenuPermissions[$menuPermission->url]['CAN_DELETE'] = $menuPermission->CAN_DELETE;
        }

        return $userMenuPermissions;
    }
}
if (!function_exists('getuserMenu')) {

    function getuserMenu()
    {
        $userMenu = DB::table('permissions')
            ->selectRaw('permissions.PARENT_ID, permissions.MENU_TITLE, group_concat(permissions.MENU_SUBTITLE) as subtitles, group_concat(permissions.SLUG) as urls')
            ->groupBy('permissions.PARENT_ID')->groupBy('permissions.MENU_TITLE')
            ->where(['permissions.IS_ACTIVE' => 'Y'])
            ->orderBy('permissions.PARENT_ID')
            ->get();

        return $userMenu;
    }
}



if (!function_exists('getErrors')) {

    function getErrors($validator)
    {

        $errors = [];

        foreach ($validator->errors()->getMessages() as $key => $msg) {

            $errors[$key] = $msg[0];
        }

        return $errors;
    }
}
