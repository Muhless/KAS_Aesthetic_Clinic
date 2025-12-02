<?php

namespace App\Http\Controllers;

use App\Models\Perawat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PerawatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function perawatIndex()
    {
        $response = Http::get(env('API_URL') . '/perawat');

        $perawats = $response->json()['data']; // Sesuaikan struktur JSON API

        return view('pages.perawat.index', compact('perawats'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Perawat $perawat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Perawat $perawat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Perawat $perawat)
    {
        //
    }
}
