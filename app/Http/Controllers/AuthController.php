<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login'); 
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            session()->flash('success', 'Login berhasil! Selamat datang di dashboard.');
            return redirect()->route('dashboard');
        } else {
            session()->flash('error', 'Login gagal! Email atau password salah.');
            return redirect()->back();
        }
    }

    public function logout()
    {
        Auth::logout();
        session()->flash('success', 'Logout berhasil! Sampai jumpa lagi.');
        return redirect()->route('login');
    }

}
