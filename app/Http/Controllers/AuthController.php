<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // 1. tampilin form login
    // TAMPILKAN FORM LOGIN
    public function showLogin(Request $request)
    {
        if ($request->has('redirect')) {
            session(['url.intended' => $request->redirect]);
        }

        return view('auth.login');
    }

    // 2. proses login (POST)
    public function postLogin(Request $request)
    {
        // validate input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // nyoba login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // cek role kalo admin ke dashboard dan user ke home
            if (Auth::user()->role === 'admin') {
                return redirect()->intended('admin/dashboard');
            }

            return redirect()->intended('/');
        }

        // kalo misal gagal login
        return back()->withErrors([
            'email' => 'Email atau password salah bro!',
        ])->onlyInput('email');
    }

    // 3. tampilan form regis
    public function showRegister()
    {
        return view('auth.register');
    }

    // 4. proses regis (POST)
    public function postRegister(Request $request)
    {
        // validate keras sesuai dokumen nich
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        // bikin usre baru
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', // defaultnya langsung user
        ]);

        // balikin ke login dngan message pesan sukses nih bos hehehe
        return redirect()->route('login')->with('success', 'Akun berhasil dibuat! Silakan login.');
    }

    // 5. logouy
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}