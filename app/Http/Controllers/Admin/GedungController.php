<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GedungModel;
use Illuminate\Http\Request;

class GedungController extends Controller
{
    public function index() {
        $gedungs = GedungModel::paginate(10); 
    
        return view('admin.gedung.index', [
            'gedungs' => $gedungs,
        ]);
    }
}
