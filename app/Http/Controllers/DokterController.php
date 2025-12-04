<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Dokter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class DokterController extends Controller
{
    // get
    public function index()
    {
        $dokters = Dokter::with('user')->get();
        return view('pages.dokter.index', compact('dokters'));
    }

    public function detail($id)
{
    $dokter = Dokter::with('jadwalPraktek')->findOrFail($id);

    return view('pages.dokter.detail', compact('dokter'));
}

    // api
    public function show($id)
    {
        $dokter = Dokter::findOrFail($id);

        return response()->json([
            'data' => $dokter,
        ]);
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
            'spesialis' => ['nullable'],
            'jadwal_praktik' => ['nullable'],
            'foto' => ['nullable', 'image', 'max:2048'],
        ]);

        $user = User::create([
            'akun' => $request->email,
            'password' => $request->password,
            'role' => 'dokter',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('dokter', 'public');
        }

        Dokter::create([
            'user_id' => $user->id,
            'nama' => $request->nama,
            'no_telepon' => $request->no_telepon,
            'email' => strtolower($request->email),
            'tanggal_lahir' => $request->tanggal_lahir,
            'spesialis' => $request->spesialis,
            'jadwal_praktik' => $request->jadwal_praktik,
            'foto' => $fotoPath,
        ]);

        return redirect()->route('dokter.index')->with('success', 'Dokter berhasil ditambahkan.');
    }

 public function update(Request $request, $id)
{
    try {
        $dokter = Dokter::findOrFail($id);

        $request->validate([
            'nama' => 'sometimes|string|max:255',
            'no_telepon' => 'sometimes|string|max:20',
            'email' => 'sometimes|email|unique:dokter,email,' . $id,
            'tanggal_lahir' => 'sometimes|nullable|date|before:today',
            'spesialis' => 'nullable|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            if ($dokter->foto && Storage::disk('public')->exists($dokter->foto)) {
                Storage::disk('public')->delete($dokter->foto);
            }

            $path = $request->file('foto')->store('dokter', 'public');
            $dokter->foto = $path;
        }

       $dataToUpdate = array_filter($request->only([
            'nama',
            'no_telepon',
            'email',
            'tanggal_lahir',
            'spesialis'
        ]), function($value) {
            return $value !== null && $value !== '';
        });

        $dokter->fill($dataToUpdate);
        $dokter->save();

        $dokterResponse = $dokter->toArray();
        if ($dokter->foto) {
            $dokterResponse['foto_url'] = Storage::url($dokter->foto);
        }

        return response()->json([
            'message' => 'Data dokter berhasil diperbarui.',
            'data' => $dokterResponse
        ], 200);

    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'message' => 'Validasi gagal.',
            'errors' => $e->errors()
        ], 422);

    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Terjadi kesalahan saat memperbarui data.',
            'error' => $e->getMessage()
        ], 500);
    }
}


    // delete
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
