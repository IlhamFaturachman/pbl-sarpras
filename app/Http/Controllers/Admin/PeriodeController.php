<?php

namespace App\Http\Controllers\Admin;

use App\Models\PeriodeModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PeriodeController extends Controller
{
    public function index() {
        $periodes = PeriodeModel::paginate(10); 
    
        return view('admin.periode.index', [
            'periodes' => $periodes,
        ]);
    }
}
