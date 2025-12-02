<?php

namespace App\Http\Controllers;

use App\Models\User;

class AdminController extends Controller
{
    public function adminIndex()
    {
        $admins = User::where('role', 'admin')->get();
        // dd($admins->toArray());

        return view('pages.perawat.index', compact('admins'));
    }
}
