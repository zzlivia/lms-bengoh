<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

//handles admin authentication process
class AdminAuthController extends Controller
{
    public function showLogin(){return view('admin.signin');}
    
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:admin,adminEmail',
            'password' => 'required|min:6|confirmed',
            'role' => 'required'
        ]);

        Admin::create([
            'adminName'  => $request->name,
            'adminEmail' => $request->email,
            'adminPass'  => Hash::make($request->password),
            'role'       => $request->role,
        ]);

        return redirect()->route('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = [
            'adminEmail' => $request->email,
            'password'   => $request->password,
        ];

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid admin credentials']);
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/admin/signin');
    }
}