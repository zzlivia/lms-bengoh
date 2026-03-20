<?php

//manages login,logout, password reset requests of admin
//define folder structure of AuthController
namespace App\Http\Controllers\Admin;

//laravel classes
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

//handles admin authentication of login, logout, and reset request
class AuthController extends Controller
{
    public function showLogin(){ //display login page
        //return login view: resources/views/auth/signin.blade.php
        return view('auth.signin');}

    public function login(Request $request){ //handle login form submission
        //get login information from form input
        $credentials = [
            'adminEmail' => $request->adminEmail,
            'password' => $request->adminPass ];
        
        //verify admin's identity
        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->route('admin.dashboard'); //if login is successful, redirect to admin dashboard
        }
        return back()->with('error', 'Invalid credentials'); //if fails, error message appear
    }

    public function logout() //handle logout process
    {
        Auth::guard('admin')->logout(); //log out current admin
        return redirect()->route('admin.login'); //redirect back to login page
    }

    public function requestReset(Request $request) //handle password reset request
    {
        DB::table('user') //update user's table if the email matches
            ->where('userEmail', $request->userEmail) //find email of user
            ->update(['reset_request' => 1]);        // set request reset to 1

        return back()->with('success','Password reset request sent.');
    }
}