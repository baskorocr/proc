<?php

namespace App\Http\Controllers\Maintenance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\masterData\Riwayat;

class MovementAssetsController extends Controller
{
    //
    public function history(){
        $riwayats = Riwayat::with(['user', 'statusAwalVendor', 'statusAkhirVendor'])->get();

        return view('riwayat.index', compact('riwayats'));
    }
}