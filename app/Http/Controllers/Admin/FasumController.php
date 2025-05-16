<?php

namespace App\Http\Controllers\Admin;

use App\Models\FasumModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FasumController extends Controller
{
    public function index() {
        $fasums = FasumModel::paginate(10); 
    
        return view('admin.fasum.index', [
            'fasums' => $fasums,
        ]);
    }
}
