<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect('/dashboard'); // or wherever
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'organization_name' => 'required|string|max:255',
        ]);

        $organization = Organization::create([
            'name' => $request->organization_name,
        ]);

        User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'organization_id' => $organization->id,
        ]);

        return redirect('/login')->with('success', 'Registration successful. Please login.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/');
    }
}