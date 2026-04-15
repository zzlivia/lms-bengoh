<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthenticationController extends Controller
{
    public function showLogin()
    { return view('authentication.signin'); }

    public function showRegister()
    { return view('authentication.register'); }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,userEmail|unique:admin,adminEmail',
            'phone' => 'required|string|max:20|unique:users,phone', // 👈 ADD THIS
            'password' => 'required|min:6|confirmed',
            'role' => 'required_if:is_admin,1'
        ]);

        if ($request->boolean('is_admin')) {
            \App\Models\Admin::create([
                'adminName' => $request->name,'adminEmail' => $request->email,'adminPass' => bcrypt($request->password),'adminRole' => $request->role
            ]);
            return redirect()->route('login')->with('success', 'Admin account created!');
        } else {

            \App\Models\Users::create([
                'userName'  => $request->name,'userEmail' => $request->email,'phone' => $request->phone,'userPass' => bcrypt($request->password),'authenticated' => 1
            ]);
            return redirect()->route('login')->with('success', 'Learner account created!');
        }
    }

    public function login(Request $request)
    {
        $request->validate(['email' => 'required','password' => 'required']);
        //get remember value
        $remember = $request->filled('remember');

        //admin login
        if (Auth::guard('admin')->attempt(['adminEmail' => $request->email,'password' => $request->password
        ], $remember)) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        //determine if input is email or phone
        $loginField = filter_var($request->email, FILTER_VALIDATE_EMAIL) 
            ? 'userEmail' 
            : 'phone';

        // user login
        if (Auth::attempt([
            $loginField => $request->email,'password' => $request->password
        ], $remember)) {
            $request->session()->regenerate();
            $user = Auth::user();
            // record remember state
            $user->update([
                'authenticated' => $remember ? 1 : 0
            ]);
            if ($user->must_change_password) {
                return redirect()->route('password.change');
            }
            return redirect()->route('homepage');
        }
        return back()->withErrors(['email' => 'Invalid email or password.']);
    }

    public function logout(Request $request)
    {
        // Logout both guards safely
        Auth::guard('admin')->logout();
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    // moved from AuthController
    public function requestReset(Request $request)
    {
        $request->validate([
            'login' => 'required'
        ]);
        $login = $request->login;
        // detect email or phone
        if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            $user = DB::table('users')->where('userEmail', $login)->first();
        } else {
            $user = DB::table('users')->where('phone', $login)->first();
        }

        if (!$user) {
            return back()->withErrors(['login' => 'User not found']);
        }

        // generate temp password
        $tempPassword = Str::random(8);

        // update password
        DB::table('users')
            ->where('userID', $user->userID)
            ->update([
                'userPass' => Hash::make($tempPassword),
                'must_change_password' => 1,
                'updated_at' => now()
            ]);

        // send email
        Mail::raw("Your temporary password is: $tempPassword", function ($message) use ($user) {
            $message->to($user->userEmail)
                    ->subject('Temporary Password of Bengoh Academy Account');
        });

        return back()->with('success', 'Temporary password sent to your email.');
    }

    public function showForgotPassword()
    {
        return view('authentication.forgot_password');
    }

    public function showChangePassword()
    {
        return view('authentication.change_password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed'
        ]);

        $user = Auth::user();
        $user->userPass = Hash::make($request->password);
        $user->must_change_password = 0;
        $user->save();
        return redirect()->route('homepage')->with('success', 'Password updated successfully.');
    }

}