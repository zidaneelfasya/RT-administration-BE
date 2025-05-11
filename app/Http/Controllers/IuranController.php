<?php

namespace App\Http\Controllers;

use App\Models\Iuran;
use Illuminate\Http\Request;

class IuranController extends Controller
{
    public function index(){
        $iuran = Iuran::all();
        return response()->json($iuran);
    }
}
