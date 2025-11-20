<?php

namespace App\Http\Controllers\OrangTua;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrangTuaDashboard extends Controller
{
    public function index()
    {
        return view('orang_tua.index');
    }
}