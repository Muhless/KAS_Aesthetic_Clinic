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
    public function api()
    {
        return response()->json([
            'status' => 'success',
            'data' => Dokter::all(),
        ]);
    }

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

  // Menampilkan form (GET)
public function create()
{
    return view('pages.dokter.create');
}

// Menyimpan data (POST)
public function store(Request $request)
{
    $request->validate([
        'username'     => 'required|unique:users,username',
        'nama'         => 'required|string|max:255',
        'email'        => 'required|email|unique:dokter,email',
        'password'     => 'required|min:8',
        'tanggal_lahir'=> 'required|date',
        'spesialisasi' => 'required|string|max:255',
        'no_telepon'   => 'nullable|string|max:20',
        'foto'         => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
    ]);

 $fotoPath = 'dokter/foto/default.png'; // default
if ($request->hasFile('foto')) {
    $fotoPath = $request->file('foto')->store('dokter/foto', 'public');
}

    // Insert ke tabel users (data login saja)
    $user = User::create([
        'username' => $request->username,
        'password' => bcrypt($request->password),
        'role'     => 'dokter',
    ]);

    // Insert ke tabel dokter (data profil)
    Dokter::create([
        'user_id'       => $user->id,
        'nama'          => $request->nama,
        'email'         => $request->email,
        'no_telepon'    => $request->no_telepon,
        'tanggal_lahir' => $request->tanggal_lahir,
        'spesialis'     => $request->spesialisasi,
        'foto'          => $fotoPath,
    ]);

    return redirect()->route('dokter.index')
        ->with('success', 'Dokter berhasil ditambahkan.');
}

public function update(Request $request, $id)
    {
        try {
            $dokter = Dokter::findOrFail($id);

            $request->validate([
                'nama' => 'sometimes|string|max:255',
                'no_telepon' => 'sometimes|string|max:20',
                'email' => 'sometimes|email|unique:dokters,email,' . $id,
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

            $dataToUpdate = array_filter($request->only(['nama', 'no_telepon', 'email', 'tanggal_lahir', 'spesialis']), function ($value) {
                return $value !== null && $value !== '';
            });

            $dokter->fill($dataToUpdate);
            $dokter->save();

            $dokterResponse = $dokter->toArray();
            if ($dokter->foto) {
                $dokterResponse['foto_url'] = Storage::url($dokter->foto);
            }

            return response()->json(
                [
                    'message' => 'Data dokter berhasil diperbarui.',
                    'data' => $dokterResponse,
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
        $dokter = Dokter::findOrFail($id);

        if ($dokter->foto && Storage::disk('public')->exists($dokter->foto)) {
            Storage::disk('public')->delete($dokter->foto);
        }

        $dokter->user->delete(); // hapus juga user
        $dokter->delete();

        return redirect()->route('dokter.index')->with('success', 'Dokter berhasil dihapus.');
    }
}
