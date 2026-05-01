<?php

namespace App\Http\Controllers;

use App\Models\Kunjungan;
use Illuminate\Http\Request;

class KunjunganController extends Controller
{
    // KunjunganController.php
public function store(Request $request)
{
    $request->validate([
        'pasien_id' => 'required|exists:pasien,id',
        'dokter_id' => 'required|exists:dokter,id',
        'tanggal'   => 'required|date',
        'keluhan'   => 'nullable|string',
    ]);

    Kunjungan::create($request->only(['pasien_id', 'dokter_id', 'tanggal', 'keluhan']));

    return redirect()->back()->with('success', 'Kunjungan berhasil ditambahkan.');
}
}
