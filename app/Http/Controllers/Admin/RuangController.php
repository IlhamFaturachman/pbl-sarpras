<?php

namespace App\Http\Controllers\Admin;

use App\Models\RuangModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RuangController extends Controller
{
    public function index()
    {
        $ruangs = RuangModel::with('gedung')->paginate(10);
        return view('admin.ruang.index', [
            'ruangs' => $ruangs,
        ]);
    }
}
