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
    {
        return view('authentication.signin');
    }

    public function showRegister()
    {
        return view('authentication.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,userEmail|unique:admin,adminEmail',
            'password' => 'required|min:6|confirmed',
            'role' => 'required_if:is_admin,1'
        ]);

        if ($request->boolean('is_admin')) {
            \App\Models\Admin::create([
                'adminName'  => $request->name,
                'adminEmail' => $request->email,
                'adminPass' => bcrypt($request->password),
                'adminRole'  => $request->role
            ]);

            return redirect()->route('login')->with('success', 'Admin account created!');
        } else {
            \App\Models\Users::create([
                'userName'      => $request->name,
                'userEmail'     => $request->email,
                'userPass'      => bcrypt($request->password),
                'authenticated' => 1
            ]);

            return redirect()->route('login')->with('success', 'Learner account created!');
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        // Try admin login
        if (Auth::guard('admin')->attempt([
            'adminEmail' => $request->email,
            'password' => $request->password
        ])) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        // Try user login
        if (Auth::attempt([
            'userEmail' => $request->email,
            'password' => $request->password
        ])) {
            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->must_change_password) {
                return redirect()->route('password.change');
            }

            return redirect()->route('homepage');
        }

        return back()->with('error', 'Invalid credentials');
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
            $user = DB::table('users')
                ->where('userEmail', $login)
                ->orWhere('phone', $login)
                ->first();
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
                    ->subject('Temporary Password');
        });

        return back()->with('success', 'Temporary password sent to your email.');
    }

    public function showForgotPassword()
    {
        return view('authentication.forgot_password');
    }
}