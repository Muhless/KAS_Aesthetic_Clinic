<?php

namespace App\Http\Controllers;

use App\Models\Keuangan;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class KeuanganController extends Controller
{
    public function api()
    {
        return response()->json(['status' > 'success', 'data' => Keuangan::all()]);
    }

    public function index()
    {
        // $pembayarans = Pembayaran::all();
        return view('pages.keuangan.index');
    }
}
