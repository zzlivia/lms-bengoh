<?php

namespace App\Http\Controllers; //base controller

//import classes
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class SettingsController extends Controller
{
    //profile setting section
    public function profile()   //show the profile settings page
    {   
        $user = Auth::user(); //get current authenticated user
        return view('settings.profile', compact('user')); //allow the profile settings
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email'
        ]);

        $user->userName = $request->name;
        $user->userEmail = $request->email;

        if ($request->filled('new_password')) {
            $user->userPass = bcrypt($request->new_password);
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully');
    }

    //notification section
    public function notifications()
    {
        return view('settings.notifications'); //show notification
    }
    public function saveNotifications(Request $request) //save notification preferences
    {
        session([
            'notify_mcq' => $request->has('notify_mcq'),
            'notify_grades' => $request->has('notify_grades')
        ]);
        return back()->with('success','Notification settings saved');
    }

    //preference section
    public function preferences() //show preferences
    {
        return view('settings.preferences');
    }

    public function savePreferences(Request $request) //save preferences
    {
        session([
            'listening_mode' => $request->has('listening_mode'),
            'sound_effects' => $request->has('sound_effects')
        ]);
        return back()->with('success','Preferences saved');
    }
}