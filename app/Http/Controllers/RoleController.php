<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Display all roles in manage-roles page with options to edit/deactivate
        $roles = Role::all();
        return view('roles-permissions.manage-roles', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $menuTitles = DB::select('select distinct MENU_TITLE from permissions where IS_ACTIVE = "Y"');
        $menupermissions = DB::select('select * from permissions where IS_ACTIVE = "Y"');
        return view('roles-permissions.create-role', compact('menuTitles', 'menupermissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // echo $request->role_name;
        // echo "<br>";

        //Store newly created Role in 'roles' table
        $role = Role::create([
            'ROLE_NAME' => $request->role_name,
            'DESCRIPTION' => $request->role_description,
            'CREATED_BY' => Auth::id()
        ]);

        $roleId = $role->ROLE_ID;

        // Store permissions attached to newly created role in 'role_permissions' table

        // echo '<pre>';
        // print_r($request['role_permission']);
        // echo '</pre>';
        $i = 0;
        foreach ($request['role_permission'] as $rp) {
            $canCreate = $rp['create'] ? 'Y' : 'N';  // If value is 1, Y else when value is 0, N
            $canRead = $rp['read'] ? 'Y' : 'N';
            $canEdit = $rp['edit'] ? 'Y' : 'N';
            $canDelete = $rp['delete'] ? 'Y' : 'N';

            // echo $canCreate . "<br>" . $canRead . "<br>" . $canEdit . "<br>" . $canDelete . "<br>";
            DB::table('role_permissions')->insert([
                'ROLE_ID' => $roleId,
                'PERMISSION_ID' => $rp['permission_id'],
                'MENU_TITLE' => $rp['title'],
                'MENU_SUBTITLE' => $rp['subtitle'],
                'CAN_CREATE' => $canCreate,
                'CAN_READ' => $canRead,
                'CAN_EDIT' => $canEdit,
                'CAN_DELETE' => $canDelete,
                'CREATED_BY' => Auth::id(),
                'CREATED_ON' => date('Y-m-d H:i:s')
            ]);
        }

        return "New role added successfully";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $menuTitles = DB::select('select distinct MENU_TITLE from permissions where IS_ACTIVE = "Y"');
        $menupermissions = DB::select('select * from permissions');

        $role = Role::find($id);
        $userPermissions = DB::select('select p.PERMISSION_ID, p.MENU_TITLE, p.MENU_SUBTITLE, 
        rp.USER_PERMISSION_ID, rp.CAN_CREATE, rp.CAN_READ, rp.CAN_EDIT, rp.CAN_DELETE
        from permissions p left join role_permissions rp on p.PERMISSION_ID = rp.PERMISSION_ID AND rp.ROLE_ID = ? 
        AND rp.IS_ACTIVE = ? WHERE p.IS_ACTIVE = ?', [$id, 'Y', 'Y']);

        // $res = DB::table('role_permissions')->where('ROLE_ID', $id)->where('PERMISSION_ID', 700)->get();
        // $s = "";
        // if (count($res)) $s = "True";
        // else $s = "False";
        // dd($res, $s);
        // dd($userPermissions);
        return view('roles-permissions.edit-role', compact('menuTitles', 'menupermissions', 'role', 'userPermissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Update role if name or description were changed
        $role = Role::find($id);
        $role->ROLE_NAME = $request->role_name;
        $role->DESCRIPTION = $request->role_description;
        $role->MODIFIED_BY = Auth::id();
        $updated = $role->save();

        // Update individual permissions if any changes made
        foreach ($request['role_permission'] as $rp) {
            $canCreate = $rp['create'] ? 'Y' : 'N';
            $canRead = $rp['read'] ? 'Y' : 'N';
            $canEdit = $rp['edit'] ? 'Y' : 'N';
            $canDelete = $rp['delete'] ? 'Y' : 'N';

            $checkPermission = DB::table('role_permissions')->where('ROLE_ID', $id)->where('PERMISSION_ID', $rp['permission_id'])->get();
            $permissionExists = count($checkPermission);
            if ($permissionExists) {
                # There is an entry for the existing menu item in role_permissions table, update it

                DB::table('role_permissions')->where('ROLE_ID', $id)->where('PERMISSION_ID', $rp['permission_id'])->update([
                    'CAN_CREATE' => $canCreate,
                    'CAN_READ' => $canRead,
                    'CAN_EDIT' => $canEdit,
                    'CAN_DELETE' => $canDelete,
                    'MODIFIED_BY' => Auth::id(),
                    'MODIFIED_ON' => date('Y-m-d H:i:s')
                ]);
            } else {
                # Create entry with new Create/Read/Edit/Delete permissions for the given menu item
                DB::table('role_permissions')->insert([
                    'ROLE_ID' => $id,
                    'PERMISSION_ID' => $rp['permission_id'],
                    'MENU_TITLE' => $rp['title'],
                    'MENU_SUBTITLE' => $rp['subtitle'],
                    'CAN_CREATE' => $canCreate,
                    'CAN_READ' => $canRead,
                    'CAN_EDIT' => $canEdit,
                    'CAN_DELETE' => $canDelete,
                    'CREATED_BY' => Auth::id(),
                    'CREATED_ON' => date('Y-m-d H:i:s')
                ]);
            }

            // echo $canCreate . "<br>" . $canRead . "<br>" . $canEdit . "<br>" . $canDelete . "<br>";

        }
        if ($updated) {
            return "Role has been successfully updated";
        } else {
            return "Could not update role";
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Deactivate the specified role
     */
    public function deactivateRole(Request $request)
    {
        $id = $request->role_id;
        $role = Role::find($id);
        $role->IS_ACTIVE = 'N';
        $role->MODIFIED_BY = Auth::id();
        $deactivated = $role->save();
        if ($deactivated) {
            return "Successfully deactivated role";
        } else {
            return "Failed to deactivate role";
        }
    }

    /**
     * Activate / re-eactivate the specified role
     */
    public function activateRole(Request $request)
    {
        $id = $request->role_id;
        $role = Role::find($id);
        $role->IS_ACTIVE = 'Y';
        $role->MODIFIED_BY = Auth::id();
        $deactivated = $role->save();
        if ($deactivated) {
            return "Successfully activated role";
        } else {
            return "Failed to activate role";
        }
    }

    /**
     * Assign Role to User
     */
    public function assignRoleToUser(Request $request)
    {
        if ($request->isMethod('post')) {
            // Insert newly assigned role to user to DB
            $user_id = $request->user_id;
            $assigned_role = $request->assigned_role;

            DB::table('user_roles')->insert([
                'USER_ID' => $user_id,
                'ROLE_ID' => $assigned_role
            ]);

            return "Successfully assigned selected role to user";
        } else {
            // Show screen to assign role to user
            $users = User::all();
            $roles = Role::all();
            return view('roles-permissions.assign-role-to-user', compact('users', 'roles'));
        }
    }

    /**
     * Get and list the roles assigned to existing users
     */
    public function getUserAccessRoles(Request $request)
    {
        $userRoles = DB::table('user_roles')
            ->join('roles', 'user_roles.ROLE_ID', '=', 'roles.ROLE_ID')
            ->join('users', 'user_roles.USER_ID', '=', 'users.USER_ID')
            ->select('user_roles.USER_ID', 'user_ROLES.ROLE_ID', 'users.FIRST_NAME', 'users.LAST_NAME', 'roles.ROLE_NAME')
            ->get();

        return view('roles-permissions.user-access', compact('userRoles'));
    }

    /**
     * Show Screen to Edit Role assigned to a User
     */
    public function getUserAccessRole($user_id)
    {
        $user = User::find($user_id);
        $currentRole = DB::table('user_roles')->where('USER_ID', $user_id)->get();
        $roles = Role::all();

        return view('roles-permissions.edit-user-access-role', compact('user', 'currentRole', 'roles'));
    }

    /**
     * Update role assigned to a user
     */
    public function updateUserAccessRole(Request $request)
    {
        $user_id = $request->user_id;
        $new_role_id = $request->assigned_role;

        $affected = DB::table('user_roles')->where('USER_ID', $user_id)->update([
            'ROLE_ID' => $new_role_id
        ]);
        if ($affected) {
            // Number of rows updated is not zero, i.e. is 1
            return "Successfully assigned new role to user";
        } else {
            return "Failed to assign new role to user";
        }
    }
}
