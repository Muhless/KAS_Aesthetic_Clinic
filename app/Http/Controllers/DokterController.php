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

    public function detail(Dokter $dokter)
    {
        $totalPelayanan = $dokter->pelayanan()->count();
        $pelayananBulanIni = $dokter->pelayanan()->whereMonth('tanggal', now()->month)->count();
        $pelayananHariIni = $dokter->pelayanan()->whereDate('tanggal', today())->count();
        $pelayananTerakhir = $dokter->pelayanan()->with('pasien')->latest('tanggal')->limit(10)->get();

        return view('pages.dokter.detail', compact('dokter', 'totalPelayanan', 'pelayananBulanIni', 'pelayananHariIni', 'pelayananTerakhir'));
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
        'username' => 'required|unique:users,username',
        'password' => 'required|min:8',
        'nama' => 'required|string|max:255',
        'no_telepon' => 'nullable|string|max:20',
        'email' => 'required|email|unique:dokters,email',
        'tanggal_lahir' => 'required|date',
        'spesialisasi' => 'required|string|max:255',
        'biaya_konsultasi' => 'nullable|numeric|min:0',
        'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
    ]);

    $fotoPath = 'dokter/foto/dokter.png';
    if ($request->hasFile('foto')) {
        $fotoPath = $request->file('foto')->store('dokter/foto', 'public');
    }

    $user = User::create([
        'username' => $request->username,
        'password' => bcrypt($request->password),
        'role' => 'dokter',
    ]);

    Dokter::create([
        'user_id' => $user->id,
        'nama' => $request->nama,
        'email' => $request->email,
        'no_telepon' => $request->no_telepon,
        'tanggal_lahir' => $request->tanggal_lahir,
        'spesialis' => $request->spesialisasi,
        'biaya_konsultasi' => $request->biaya_konsultasi ?? 0,
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
            'email' => 'sometimes|email|unique:dokters,email,' . $id,
            'tanggal_lahir' => 'sometimes|nullable|date|before:today',
            'spesialis' => 'nullable|string|max:255',
            'biaya_konsultasi' => 'nullable|numeric|min:0',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            if ($dokter->foto && Storage::disk('public')->exists($dokter->foto)) {
                Storage::disk('public')->delete($dokter->foto);
            }
            $dokter->foto = $request->file('foto')->store('dokter', 'public');
        }

        $dataToUpdate = array_filter(
            $request->only(['nama', 'no_telepon', 'email', 'tanggal_lahir', 'spesialis', 'biaya_konsultasi']),
            fn($value) => $value !== null && $value !== ''
        );

        $dokter->fill($dataToUpdate);
        $dokter->save();

        $dokterResponse = $dokter->toArray();
        if ($dokter->foto) {
            $dokterResponse['foto_url'] = Storage::url($dokter->foto);
        }

       return redirect()->route('dokter.index')->with('success', 'Data dokter berhasil diperbarui.');

    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'message' => 'Validasi gagal.',
            'errors' => $e->errors(),
        ], 422);

    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Terjadi kesalahan saat memperbarui data.',
            'error' => $e->getMessage(),
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
