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
            'username' => 'required|username',
            'password' => 'required'
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'username' => 'username atau password salah.',
        ]);
    }

    public function showRegister()
{
    return view('pages.auth.register');
}

public function register(Request $request)
{
    $request->validate([
        'nama'       => 'required|string|max:255',
        'username'   => 'required|string|max:50|unique:users,username',
        'email'      => 'nullable|email|unique:users,email',
        'phone'      => 'nullable|string|max:20',
        'birth_date' => 'nullable|date',
        'role'       => 'required|in:admin,dokter,resepsionis,terapis',
        'password'   => 'required|string|min:5',
    ]);

    User::create([
        'nama'       => $request->nama,
        'username'   => $request->username,
        'email'      => $request->email,
        'phone'      => $request->phone,
        'birth_date' => $request->birth_date,
        'role'       => $request->role,
        'password'   => $request->password, // otomatis hashed oleh cast()
    ]);

    return redirect('/login')->with('success', 'Registrasi berhasil! Silakan login.');
}


}
