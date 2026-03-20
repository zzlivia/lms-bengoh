<?php

//handles login and registration with two roles
namespace App\Http\Controllers; //base controllers

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    public function showLogin() //displays login page
    {
        return view('auth.signin'); // since file is signin.blade.php
    }

    // add registration functions
    public function showRegister() //displays registration page
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([ //validate user input
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:user,userEmail|unique:admin,adminEmail',
            'password' => 'required|min:6|confirmed',
            'role' => 'required_if:is_admin,on'
        ]);

        if ($request->boolean('is_admin')) { //check if the user is admin
            //if admin checkbox ticked, save into admin table
            \App\Models\Admin::create([
                'adminName'  => $request->name,
                'adminEmail' => $request->email,
                'adminPass'  => bcrypt($request->password),
                'role'       => $request->role
            ]);
            //redirect to login page
            return redirect()->route('login')->with('success', 'Admin account created!');

        } else {
            // or else save to user table
            \App\Models\User::create([
                'userName'      => $request->name,
                'userEmail'     => $request->email,
                'userPass'      => bcrypt($request->password),
                'authenticated' => 1
            ]);
            //redirect to login page
            return redirect()->route('login')->with('success', 'Learner account created!');
        }
    }

    public function login(Request $request)
    {
        $request->validate([ //validate input
            'email' => 'required',
            'password' => 'required'
        ]);

        ///try to login as admin
        if (Auth::guard('admin')->attempt([
            'adminEmail' => $request->email,
            'password' => $request->password
        ])) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        //try to login as learner
        if (Auth::attempt([
            'userEmail' => $request->email,
            'password' => $request->password
        ])) {
            $request->session()->regenerate();
            return redirect()->route('learner.homepage');
        }

        return back()->with('error', 'Invalid credentials');
    }

    public function logout(Request $request)
    {
        Auth::logout(); //log user out
        //destroy session
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        //redirect to login page
        return redirect('/login');
    }
}