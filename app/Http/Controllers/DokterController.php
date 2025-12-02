<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Dokter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DokterController extends Controller
{
    // ===========================
    // LIST DOKTER
    // ===========================
    public function index()
    {
        $dokters = Dokter::with('user')->get();
        return view('pages.dokter.index', compact('dokters'));
    }



    public function create()
    {
        return view('pages.dokter.create');
    }


    
    public function store(Request $request)
    {
        $request->validate([
            'nama' => ['required'],
            'no_telepon' => ['required'],
            'email' => ['required', 'email'],
            'tanggal_lahir' => ['required', 'date'],
            'password' => ['required', 'min:6'],
            'str' => ['nullable'],
            'sip' => ['nullable'],
            'spesialis' => ['nullable'],
            'jadwal_praktik' => ['nullable'],
            'foto' => ['nullable', 'image', 'max:2048'],
        ]);

        // ---- Create User ----
        $user = User::create([
            'akun' => $request->email,        // login pakai email
            'password' => $request->password,
            'role' => 'dokter',
        ]);

        // ---- Upload foto ----
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('dokter', 'public');
        }

        // ---- Create Dokter Detail ----
        Dokter::create([
            'user_id' => $user->id,
            'nama' => $request->nama,
            'no_telepon' => $request->no_telepon,
            'email' => strtolower($request->email),
            'tanggal_lahir' => $request->tanggal_lahir,
            'str' => $request->str,
            'sip' => $request->sip,
            'spesialis' => $request->spesialis,
            'jadwal_praktik' => $request->jadwal_praktik,
            'foto' => $fotoPath,
        ]);

        return redirect()->route('dokter.index')->with('success', 'Dokter berhasil ditambahkan.');
    }


    // ===========================
    // FORM EDIT
    // ===========================
    public function edit($id)
    {
        $dokter = Dokter::findOrFail($id);
        return view('pages.dokter.edit', compact('dokter'));
    }


    // ===========================
    // UPDATE DATA
    // ===========================
    public function update(Request $request, $id)
    {
        $dokter = Dokter::findOrFail($id);

        $request->validate([
            'nama' => ['required'],
            'no_telepon' => ['required'],
            'email' => ['required', 'email'],
            'tanggal_lahir' => ['required', 'date'],
            'str' => ['nullable'],
            'sip' => ['nullable'],
            'spesialis' => ['nullable'],
            'jadwal_praktik' => ['nullable'],
            'foto' => ['nullable', 'image', 'max:2048'],
        ]);

        // ---- Update Foto ----
        if ($request->hasFile('foto')) {
            if ($dokter->foto && Storage::disk('public')->exists($dokter->foto)) {
                Storage::disk('public')->delete($dokter->foto);
            }
            $dokter->foto = $request->file('foto')->store('dokter', 'public');
        }

        $dokter->update($request->except('foto'));

        return redirect()->route('dokter.index')->with('success', 'Data dokter berhasil diperbarui.');
    }


    // ===========================
    // HAPUS DOKTER + USER
    // ===========================
    public function destroy($id)
    {
        $dokter = Dokter::findOrFail($id);

        if ($dokter->foto && Storage::disk('public')->exists($dokter->foto)) {
            Storage::disk('public')->delete($dokter->foto);
        }

        $dokter->user->delete(); // hapus juga user
        $dokter->delete();

        return redirect()->route('dokter.index')->with('success', 'Dokter berhasil dihapus.');
    }
}
