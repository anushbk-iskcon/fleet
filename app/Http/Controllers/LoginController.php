<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Session;

class LoginController extends Controller
{
    //
    public function loginPage()
    {
        return view('login');
    }

    public function doLogin(Request $request)
    {
        // Login actions
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $userCredentials = $request->only('email', 'password');

        if (Auth::attempt($userCredentials)) {
            $userRoleId = DB::table('user_roles')->where('USER_ID', Auth::user()->USER_ID)->value('ROLE_ID');
            $userRole = Role::find($userRoleId);
            $userRoleName = $userRole->ROLE_NAME;

            $userPermissions = DB::table('role_permissions')->where('ROLE_ID', $userRoleId)->get();

            $userMenu = DB::table('permissions')
                ->selectRaw('permissions.PARENT_ID, permissions.MENU_TITLE, group_concat(permissions.MENU_SUBTITLE) as subtitles, group_concat(permissions.SLUG) as urls')
                ->groupBy('permissions.PARENT_ID')->groupBy('permissions.MENU_TITLE')
                ->orderBy('permissions.PARENT_ID')
                ->get();

            $menuPermissions = DB::table('permissions')
                ->join('role_permissions', function ($join) use ($userRoleId) {
                    $join->on('permissions.PERMISSION_ID', '=', 'role_permissions.PERMISSION_ID')
                        ->where('role_permissions.ROLE_ID', '=', $userRoleId);
                })
                ->selectRaw('permissions.PERMISSION_ID as permissionID, permissions.SLUG as url, role_permissions.CAN_CREATE as CAN_CREATE, role_permissions.CAN_READ as CAN_READ, role_permissions.CAN_EDIT as CAN_EDIT, role_permissions.CAN_DELETE as CAN_DELETE')
                ->get();

            $userMenuPermissions = array();
            foreach ($menuPermissions as $menuPermission) {
                $userMenuPermissions[$menuPermission->url] = array();
                $userMenuPermissions[$menuPermission->url]['CAN_CREATE'] = $menuPermission->CAN_CREATE;
                $userMenuPermissions[$menuPermission->url]['CAN_READ'] = $menuPermission->CAN_READ;
                $userMenuPermissions[$menuPermission->url]['CAN_EDIT'] = $menuPermission->CAN_EDIT;
                $userMenuPermissions[$menuPermission->url]['CAN_DELETE'] = $menuPermission->CAN_DELETE;
            }

            // dd($userMenuPermissions);

            // Load Role data and Permissions by module data to session
            session(['userRoleId' => $userRoleId, 'userRole' => $userRoleName, 'permissions' => $userPermissions, 'userMenu' => $userMenu, 'userMenuPermissions' => $userMenuPermissions]);
            //dd(session('permissions'), session('userMenu'), $userMenuPermissions);
            $request->session()->flash('success', 'Welcome back');
            return redirect()->intended('dashboard');
        }

        return redirect("login")->withInput($request->only('email'))->withSuccess('Please check your login credentials and try again');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
