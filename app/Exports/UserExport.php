<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\MasterUserExport;
 use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class UserExport implements FromView,ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('exports.user', [
            'users' => MasterUserExport::all()
        ]);
    }
}
