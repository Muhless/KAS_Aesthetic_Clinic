<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Dokter;
use App\Models\Perawat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('pages.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required',
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'username' => 'username atau password salah.',
        ]);
    }

    public function showRegisterUser()
    {
        return view('pages.auth.register.user');
    }

    public function registerUser(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:50|unique:users,username',
            'password' => 'required|string|min:5',
            'role' => 'required|in:admin,dokter,perawat',
        ]);

        session(['reg_data_user' => $validated]);

        return match ($validated['role']) {
            'admin' => redirect('/register/admin'),
            'dokter' => redirect('/register/dokter'),
            'perawat' => redirect('/register/perawat'),
        };
    }

    public function showRegisterAdmin()
    {
        if (!session()->has('reg_data_user')) {
            return redirect('/register');
        }

        return view('pages.auth.register.admin');
    }

    public function registerAdmin(Request $request)
    {
        $userSession = session('reg_data_user');

        if (!$userSession) {
            return redirect('/register');
        }

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'nullable|email',
        ]);

        $user = User::create([
            'username' => $userSession['username'],
            'password' => bcrypt($userSession['password']),
            'role' => $userSession['role'],
        ]);

        Admin::create([
            'user_id' => $user->id,
            'nama' => $validated['nama'],
            'email' => $validated['email'],
        ]);

        session()->forget('reg_data_user');

        return redirect('/login')->with('success', 'Registrasi admin berhasil.');
    }

    public function showRegisterDokter()
    {
        if (!session()->has('reg_data_user')) {
            return redirect('/register');
        }

        return view('pages.auth.register.dokter');
    }

    public function registerDokter(Request $request)
    {
        $userSession = session('reg_data_user');

        if (!$userSession) {
            return redirect('/register');
        }

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'no_telepon' => 'nullable|string',
            'email' => 'nullable|email',
            'tanggal_lahir' => 'nullable|date',
        ]);

        $user = User::create([
            'username' => $userSession['username'],
            'password' => bcrypt($userSession['password']),
            'role' => $userSession['role'],
        ]);

        Dokter::create([
            'user_id' => $user->id,
            'nama' => $validated['nama'],
            'no_telepon' => $validated['no_telepon'],
            'email' => $validated['email'],
            'tanggal_lahir' => $validated['tanggal_lahir'],
        ]);

        session()->forget('reg_data_user');

        return redirect('/login')->with('success', 'Registrasi dokter berhasil.');
    }

    public function showRegisterPerawat()
    {
        if (!session()->has('reg_data_user')) {
            return redirect('/register');
        }

        return view('pages.auth.register.perawat');
    }

    public function registerPerawat(Request $request)
    {
        try {
            $userSession = session('reg_data_user');

            if (!$userSession) {
                return redirect('/register')->with('error', 'Data user tidak ditemukan. Silakan ulangi pendaftaran.');
            }

            $validated = $request->validate([
                'nama' => 'required|string|max:255',
                'no_telepon' => 'nullable|string',
                'email' => 'nullable|email',
                'tanggal_lahir' => 'nullable|date',
            ]);

            $user = User::create([
                'username' => $userSession['username'],
                'password' => bcrypt($userSession['password']),
                'role' => $userSession['role'],
            ]);

            Perawat::create([
                'user_id' => $user->id,
                'nama' => $validated['nama'],
                'no_telepon' => $validated['no_telepon'],
                'email' => $validated['email'],
                'tanggal_lahir' => $validated['tanggal_lahir'],
            ]);

            session()->forget('reg_data_user');

            return redirect('/login')->with('success', 'Registrasi perawat berhasil.');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
