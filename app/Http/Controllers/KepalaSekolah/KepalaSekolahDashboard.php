<?php

namespace App\Http\Controllers\KepalaSekolah;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KepalaSekolahDashboard extends Controller
{
    public function index()
    {
        return view('kepala_sekolah.index');
    }
}
