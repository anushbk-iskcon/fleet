<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users = User::all();
        return view('users.manage-users', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('users.add-user');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Create a new user and store in DB
        $user = new User;
        $user->first_name = $request->firstname;
        $user->last_name = $request->lastname;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->about = $request->about ?? "";
        $user->active_flag = (($request->status) ? 'Y' : 'N');

        //To upload profile image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $img = time() . '-' . date('Y') . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/upload/profile/user');
            $image->move($destinationPath, $img);
            $user->PROFILE_IMAGE = $img;
        }

        $user->created_by = Auth::user()->USER_ID;
        $created = $user->save();

        if ($created) {
            return "User created successfully";
        } else {
            return "Error in creating user";
        }
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
        $user = User::find($id);
        return view('users.edit-user', compact('user'));
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
        //
        $user = User::find($id);

        //dd($request->all(), $user);
        // dd($user->first_name, $user->FIRST_NAME);
        $user->FIRST_NAME = $request->firstname;
        $user->LAST_NAME = $request->lastname;
        $user->EMAIL = $request->email;

        if ($request->password)
            $user->password = bcrypt($request->password);

        $user->ABOUT = ($request->about ?? "");
        $user->ACTIVE_FLAG = (($request->status) ? 'Y' : 'N');
        $user->MODIFIED_BY = Auth::user()->USER_ID;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $img = time() . '-' . date('Y') . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/upload/profile/users/');
            $image->move($destinationPath, $img);
            $user->PROFILE_IMAGE = $img;
        }

        $updated = $user->save();
        if ($updated) {
            return "User successfully updated";
        } else {
            return "Failed to update user";
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
     * Deactivate the specified active user
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function deactivateUser(Request $request)
    {
        $id = $request->user_id;
        $user = User::find($id);
        $user->ACTIVE_FLAG = 'N';
        $deactivated = $user->save();
        if ($deactivated) {
            return "Successfully deactivated user";
        } else {
            return "Failed to deactivate user";
        }
    }

    /**
     * Reactivate the specified inactive user
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function activateUser(Request $request)
    {
        $id = $request->user_id;
        $user = User::find($id);
        $user->ACTIVE_FLAG = 'Y';
        $activated = $user->save();
        if ($activated) {
            return "Successfully activated user";
        } else {
            return "Failed to activate user";
        }
    }
}
