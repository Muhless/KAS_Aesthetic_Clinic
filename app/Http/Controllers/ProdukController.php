<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ProdukController extends Controller
{
    public function api($id)
    {
        $produk = Produk::findOrFail($id);
        return response()->json(['data' => $produk]);
    }

    public function index(Request $request)
    {
        $produks = Produk::with('user')
            ->when($request->nama, fn($q) => $q->where('nama', 'like', '%' . $request->nama . '%'))
            ->when($request->kategori, fn($q) => $q->where('kategori', $request->kategori))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->stok_menipis, fn($q) => $q->where('stok', '<=', 5))
            ->get();

        // Untuk dropdown filter kategori
        $kategoris = Produk::select('kategori')->whereNotNull('kategori')->distinct()->pluck('kategori');

        return view('pages.produk.index', compact('produks', 'kategoris'));
    }

    public function cetakPdf(Request $request)
    {
        $produks = Produk::with('user')
            ->when($request->nama, fn($q) => $q->where('nama', 'like', '%' . $request->nama . '%'))
            ->when($request->kategori, fn($q) => $q->where('kategori', $request->kategori))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->stok_menipis, fn($q) => $q->where('stok', '<=', 5))
            ->get();

        $filterInfo = [
            'nama'         => $request->nama,
            'kategori'     => $request->kategori,
            'status'       => $request->status ? ($request->status == 'tersedia' ? 'Tersedia' : 'Tidak Tersedia') : null,
            'stok_menipis' => $request->stok_menipis ? 'Ya (stok ≤ 5)' : null,
        ];

        $pdf = Pdf::loadView('pages.produk.laporan-pdf', compact('produks', 'filterInfo'))
            ->setPaper('a4', 'landscape');

        return $pdf->stream('laporan-produk-' . now()->format('Ymd-His') . '.pdf');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|integer|min:0',
            'stok' => 'required|integer|min:0',
            'status' => 'required|in:tersedia,tidak_tersedia',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('produk/foto', 'public');
        }

        Produk::create([
            'nama' => $request->nama,
            'kategori' => $request->kategori,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'status' => $request->status,
            'foto' => $fotoPath,
        ]);

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan.');
    }

    public function show($id)
    {
        return response()->json(Produk::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        $validated = $request->validate([
            'nama'      => 'sometimes|string|max:255',
            'kategori'  => 'nullable|string',
            'deskripsi' => 'nullable|string',
            'harga'     => 'sometimes|integer|min:0',
            'stok'      => 'sometimes|integer|min:0',
            'status'    => 'in:tersedia,tidak_tersedia',
            'foto'      => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('produk/foto', 'public');
        } else {
            unset($validated['foto']);
        }

        $produk->update($validated);

        return redirect()->back()->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Produk::findOrFail($id)->delete();

        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus.');
    }
}   
