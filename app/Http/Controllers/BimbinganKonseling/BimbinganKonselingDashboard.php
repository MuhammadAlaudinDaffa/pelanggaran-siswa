<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BimbinganKonselingDashboard extends Controller
{
    public function index()
    {
        return view('bimbingan-konseling.index');
    }
}
