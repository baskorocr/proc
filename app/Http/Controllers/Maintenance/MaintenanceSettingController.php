<?php

namespace App\Http\Controllers\Maintenance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MaintenanceSetting;

class MaintenanceSettingController extends Controller
{
    public function index()
    {
        $intervalDefault = MaintenanceSetting::getValue('interval_default', 2);
        $intervalCF = MaintenanceSetting::getValue('interval_cf', 6);

        return view('maintenance.setting', compact('intervalDefault', 'intervalCF'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'interval_default' => 'required|integer|min:1|max:24',
            'interval_cf' => 'required|integer|min:1|max:24',
        ]);

        MaintenanceSetting::updateOrCreate(
            ['key' => 'interval_default'],
            ['value' => $request->interval_default]
        );

        MaintenanceSetting::updateOrCreate(
            ['key' => 'interval_cf'],
            ['value' => $request->interval_cf]
        );

        return redirect()->back()->with('success', 'Setting maintenance berhasil disimpan!');
    }
}
