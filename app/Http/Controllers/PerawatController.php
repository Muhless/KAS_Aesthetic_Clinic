<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Perawat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class PerawatController extends Controller
{
    public function api()
    {
        return response()->json([
            'status' => 'success',
            'data' => Perawat::all(),
        ]);
    }

    // get
    public function index()
    {
        $perawats = Perawat::with('user')->get();
        return view('pages.perawat.index', compact('perawats'));
    }

    public function detail($id)
    {
        $perawat = Perawat::findOrFail($id);

        return view('pages.perawat.detail', compact('perawat'));
    }

    // api
    public function show($id)
    {
        $perawat = Perawat::findOrFail($id);

        return response()->json([
            'data' => $perawat,
        ]);
    }

    public function create()
    {
        return view('pages.perawat.create');
    }

   public function store(Request $request)
{
    $request->validate([
        'username'      => ['required', 'unique:users,username'],
        'nama'          => ['required', 'string', 'max:255'],
        'no_telepon'    => ['nullable', 'string', 'max:20'],
        'email'         => ['nullable', 'email', 'unique:perawats,email'],
        'tanggal_lahir' => ['required', 'date'],
        'jadwal'        => ['nullable', 'string', 'max:255'],
        'password'      => ['required', 'min:8'],
        'foto'          => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
    ]);

    $fotoPath = 'dokter/foto/perawat.png'; // default
    if ($request->hasFile('foto')) {
        $fotoPath = $request->file('foto')->store('perawat/foto', 'public');
    }

    $user = User::create([
        'username' => $request->username,
        'password' => bcrypt($request->password), // ← wajib di-hash
        'role'     => 'perawat',
    ]);

    Perawat::create([
        'user_id'       => $user->id,
        'nama'          => $request->nama,
        'no_telepon'    => $request->no_telepon,
        'email'         => $request->email ? strtolower($request->email) : null,
        'tanggal_lahir' => $request->tanggal_lahir,
        'sip'           => $request->sip,
        'str'           => $request->str,
        'jadwal'        => $request->jadwal,
        'foto'          => $fotoPath,
    ]);

    return redirect()->route('perawat.index')
        ->with('success', 'Perawat berhasil ditambahkan.');
}

    public function update(Request $request, $id)
    {
        try {
            $perawat = Perawat::findOrFail($id);

            $request->validate([
                'nama' => 'sometimes|string|max:255',
                'no_telepon' => 'sometimes|string|max:20',
                'email' => 'sometimes|email|unique:perawats,email,' . $id,
                'tanggal_lahir' => 'sometimes|nullable|date|before:today',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            if ($request->hasFile('foto')) {
                if ($perawat->foto && Storage::disk('public')->exists($perawat->foto)) {
                    Storage::disk('public')->delete($perawat->foto);
                }

                $path = $request->file('foto')->store('perawat', 'public');
                $perawat->foto = $path;
            }

            $dataToUpdate = array_filter($request->only(['nama', 'no_telepon', 'email', 'tanggal_lahir']), function ($value) {
                return $value !== null && $value !== '';
            });

            $perawat->fill($dataToUpdate);
            $perawat->save();

            $perawatResponse = $perawat->toArray();
            if ($perawat->foto) {
                $perawatResponse['foto_url'] = Storage::url($perawat->foto);
            }

            return response()->json(
                [
                    'message' => 'Data perawat berhasil diperbarui.',
                    'data' => $perawatResponse,
                ],
                200,
            );
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(
                [
                    'message' => 'Validasi gagal.',
                    'errors' => $e->errors(),
                ],
                422,
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'message' => 'Terjadi kesalahan saat memperbarui data.',
                    'error' => $e->getMessage(),
                ],
                500,
            );
        }
    }

    // delete
    public function destroy($id)
    {
        $perawat = Perawat::findOrFail($id);

        if ($perawat->foto && Storage::disk('public')->exists($perawat->foto)) {
            Storage::disk('public')->delete($perawat->foto);
        }

        $perawat->user->delete(); // hapus juga user
        $perawat->delete();

        return redirect()->route('perawat.index')->with('success', 'Perawat berhasil dihapus.');
    }
}
