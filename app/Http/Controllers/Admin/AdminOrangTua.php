<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrangTua;
use Illuminate\Http\Request;

class AdminOrangTua extends Controller
{
    public function index()
    {
        $orangTua = OrangTua::with(['user', 'siswa'])->get();
        return view('admin.data-master.orang-tua.index', compact('orangTua'));
    }

    public function show($id)
    {
        $orangTua = OrangTua::with(['user', 'siswa'])->findOrFail($id);
        return view('admin.data-master.orang-tua.show', compact('orangTua'));
    }
}