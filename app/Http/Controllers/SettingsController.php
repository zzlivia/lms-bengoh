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
    {   //check if user is not log in yet
        if(!Auth::check()){ 
            return redirect('/login');  //redirect to login if not authenticated
        }
        $user = Auth::user(); //get current authenticated user
        return view('settings.profile', compact('user')); //allow the profile settings
    }

    public function updateProfile(Request $request) //handle profile update form submission
    {
        $user = Auth::user();   //get current authenticated user
        $request->validate([ //validate incoming request data
            'name' => 'required|string|max:255',
            'email' => 'required|email'
        ]);
        $user->name = $request->name; //update userName 
        $user->email = $request->email; //update userEmails
        if($request->filled('new_password')){ //check if user entered a new password
            $user->password = bcrypt($request->new_password); //hash and update entered password
        }
        $user->save(); //save update user data to db
        return back()->with('success','Profile updated successfully');
    }

    //notification section
    public function notifications()
    {
        return view('settings.notifications'); //show notification
    }
    public function saveNotifications(Request $request) //save notification preferences
    {
        session([ //store by session
            'notify_mcq' => $request->notify_mcq,
            'notify_grades' => $request->notify_grades
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
        session([ //store by session
            'listening_mode' => $request->listening_mode,
            'sound_effects' => $request->sound_effects
        ]);
        return back()->with('success','Preferences saved');
    }
}