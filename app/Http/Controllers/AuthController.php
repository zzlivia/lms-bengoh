<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

//handles learners authentication process
class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.signin');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,userEmail',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'userName' => $request->name,
            'userEmail' => $request->email,
            'userPass' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect()->route('learner.homepage');
    }

    public function login(Request $request)
    {
        $credentials = [
            'userEmail' => $request->email,
            'password'  => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('learner.homepage');
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}