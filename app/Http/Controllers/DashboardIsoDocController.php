<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RegisIsoDoc;

class DashboardIsoDocController extends Controller
{
    public function index(Request $request)
    {
        $data['regis'] = RegisIsoDoc::with('vendor')->get();

        return view('doc_iso.master-notify.dashboard-iso', $data);
    }
}
