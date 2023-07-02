<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Vendor;
 use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class VendorExport implements FromView,ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('exports.vendor', [
            'vendors' => Vendor::all()
        ]);
    }
}
