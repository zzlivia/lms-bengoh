<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //registration process
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users,userEmail',
            'password' => 'required|string|min:8|confirmed',
        ]);

        //create the user 
        $user = Users::create([
            'userName'      => $request->name,
            'userEmail'     => $request->email,
            'userPass'      => Hash::make($request->password),
            'authenticated' => true, // setting the flag
        ]);

        Auth::login($user);
        //return redirect()->route('courses.index')->with('success', 'Registration successful!');
    }

    //sign in process
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // map to recognize the userEmail and password
        $authAttempt = [
            'userEmail' => $credentials['email'],
            'password'  => $credentials['password'], // looks for the hashed 'userPass' automatically through getAuthPassword()
        ];

        if (Auth::attempt($authAttempt, $request->remember)) {
            $request->session()->regenerate();
            return redirect()->intended('/homepage');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    //logout process
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Logged out successfully.');
    }
}