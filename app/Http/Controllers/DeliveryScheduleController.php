<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeliveryScheduleController extends Controller
{
    public function index()
    {
        return view('eproc/deliveryschedule/index');
    }
}
