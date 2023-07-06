<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // Show the Profile Page of logged in user
    public function viewProfile()
    {
        $userId = Auth::user()->USER_ID;
        $user = User::find($userId);
        return view('profile.view', compact('user'));
    }

    // Show the Profile Edit Page
    public function editProfile()
    {
        $userId = Auth::user()->USER_ID;
        $user = User::find($userId);
        return view('profile.edit', compact('user'));
    }

    // Update User Profile Details
    public function updateProfile(Request $request)
    {
        $userId = Auth::user()->USER_ID;
        $user = User::find($userId);

        $user->FIRST_NAME = $request->firstname;
        $user->LAST_NAME = $request->lastname;
        $user->EMAIL = $request->email;
        $user->ABOUT = ($request->about ?? "");

        // If password is updated
        if ($request->password)
            $user->password = bcrypt($request->password);

        // for new image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $img = time() . '-' . date('Y') . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/upload/profile/users/');
            $image->move($destinationPath, $img);
            $user->PROFILE_IMAGE = $img;
        }

        $user->MODIFIED_BY = $userId;
        $updated = $user->save();

        if ($updated) {
            return "Your profile was updated successfully";
        } else {
            return "Error updating profile";
        }
    }
}
