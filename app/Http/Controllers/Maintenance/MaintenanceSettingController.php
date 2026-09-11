<?php

namespace App\Http\Controllers\Maintenance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MaintenanceSetting;

class MaintenanceSettingController extends Controller
{
    public function index()
    {
        $intervalSlowMoving = MaintenanceSetting::getValue('interval_slow_moving', 6);
        $intervalStandarMoving = MaintenanceSetting::getValue('interval_standar_moving', 3);
        $intervalFastMoving = MaintenanceSetting::getValue('interval_fast_moving', 1);

        return view('maintenance.setting', compact('intervalSlowMoving', 'intervalStandarMoving', 'intervalFastMoving'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'interval_slow_moving' => 'required|integer|min:1|max:24',
            'interval_standar_moving' => 'required|integer|min:1|max:24',
            'interval_fast_moving' => 'required|integer|min:1|max:24',
        ]);

        MaintenanceSetting::updateOrCreate(
            ['key' => 'interval_slow_moving'],
            ['value' => $request->interval_slow_moving]
        );

        MaintenanceSetting::updateOrCreate(
            ['key' => 'interval_standar_moving'],
            ['value' => $request->interval_standar_moving]
        );

        MaintenanceSetting::updateOrCreate(
            ['key' => 'interval_fast_moving'],
            ['value' => $request->interval_fast_moving]
        );

        return redirect()->back()->with('success', 'Setting maintenance berhasil disimpan!');
    }
}
