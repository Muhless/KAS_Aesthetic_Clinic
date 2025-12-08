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
   public function store(Request $request)
{
    $validated = $request->validate([
        'nama'        => 'required|string|max:255',
        'kategori'    => 'nullable|string|max:255',
        'deskripsi'   => 'nullable|string',
        'harga'       => 'required|numeric|min:0',
        'stok'        => 'required|integer|min:0',
        'foto'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'status'      => 'nullable|in:tersedia,tidak_tersedia',
    ]);

    if ($request->hasFile('foto')) {
        $validated['foto'] = $request->file('foto')->store('produk', 'public');
    }

    $produk = Produk::create($validated);

    return redirect()->route('produk.index')
                     ->with('success', 'Produk berhasil ditambahkan!');
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
