<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function api()
    {
        return response()->json(['status' > 'success', 'data' => Pembayaran::all()]);
    }

    public function index()
    {
        // $pembayarans = Pembayaran::all();
        return view('pages.pembayaran.index');
    }
}
