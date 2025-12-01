<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('pages.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'akun' => 'required|string',
            'password' => 'required',
        ]);

        $credentials = $request->only('akun', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'akun' => 'Akun atau password salah.',
        ]);
    }

    public function showRegisterStep1()
    {
        return view('pages.auth.register.step1');
    }

    public function registerStep1(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'nullable|email|unique:users,email',
            'no_telepon' => 'nullable|string|max:20',
            'tanggal_lahir' => 'nullable|date',
            'role' => 'required|in:admin,dokter,terapis,kasir',
        ]);

        session(['reg_data_step1' => $validated]);

        return redirect('/register/account');
    }

    public function showRegisterStep2()
    {
        if (!session()->has('reg_data_step1')) {
            return redirect('/register');
        }

        return view('pages.auth.register.step2');
    }

    public function registerStep2(Request $request)
    {
        $request->validate([
            'akun' => 'required|string|max:50|unique:users,akun',
            'password' => 'required|string|min:5',
        ]);

        $step1 = session('reg_data_step1');

        User::create([
            ...$step1,
            'akun' => $request->akun,
            'password' => $request->password,
        ]);

        session()->forget('reg_data_step1');

        return redirect('/login')->with('success', 'Registrasi berhasil! Silakan login.');
    }
}
