<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
      public function api()
    {
        return response()->json([
            'status' => 'success',
            'data' => Produk::all(),
        ]);
    }

      public function index()
    {
         $produks = Produk::with('user')->get();
        return view('pages.produk.index', compact('produks'));
    }

    // POST /produks
//   public function store(Request $request)
// {
//     $request->validate([
//         'nama'   => 'required|string|max:255',
//         'harga'  => 'required|integer|min:0',
//         'stok'   => 'required|integer|min:0',
//         'status' => 'required|in:tersedia,tidak_tersedia',
//         'foto'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
//     ]);

//     $fotoPath = null;
//     if ($request->hasFile('foto')) {
//         $fotoPath = $request->file('foto')->store('produk/foto', 'public');
//     }

//     Produk::create([
//         'nama'      => $request->nama,
//         'kategori'  => $request->kategori,
//         'deskripsi' => $request->deskripsi,
//         'harga'     => $request->harga,
//         'stok'      => $request->stok,
//         'status'    => $request->status,
//         'foto'      => $fotoPath,
//     ]);

//     return redirect()->back()->with('success', 'Produk berhasil ditambahkan.');
// }

public function store(Request $request)
{
    $request->validate([
        'nama'   => 'required|string|max:255',
        'harga'  => 'required|integer|min:0',
        'stok'   => 'required|integer|min:0',
        'status' => 'required|in:tersedia,tidak_tersedia',
        'foto'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
    ]);

    $fotoPath = null;
    if ($request->hasFile('foto')) {
        $fotoPath = $request->file('foto')->store('produk/foto', 'public');
    }

    Produk::create([
        'nama'      => $request->nama,
        'kategori'  => $request->kategori,
        'deskripsi' => $request->deskripsi,
        'harga'     => $request->harga,
        'stok'      => $request->stok,
        'status'    => $request->status,
        'foto'      => $fotoPath,
    ]);

    return redirect()->back()->with('success', 'Produk berhasil ditambahkan.');
}


    // GET /produks/{id}
    public function show($id)
    {
        return response()->json(Produk::findOrFail($id));
    }

    // PUT/PATCH /produks/{id}
    public function update(Request $request, $id)
    {
        $produk = produk::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'sometimes|string',
            'kategori' => 'nullable|string',
            'deskripsi' => 'nullable|string',
            'harga' => 'sometimes|integer|min:0',
            'stok' => 'sometimes|integer|min:0',
            'foto' => 'nullable|string',
            'status' => 'in:aktif,nonaktif',
        ]);

        $produk->update($validated);

        return response()->json($produk);
    }

    // DELETE /produks/{id}
    public function destroy($id)
    {
        produk::findOrFail($id)->delete();

          return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus.');

    }
}
