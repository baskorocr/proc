<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use DB;
use App\Models\PurchasingProcess;
use App\Models\MasterVendor;
use App\Models\MasterUser;
use Carbon\Carbon;

class ImportVendorEmail implements ToCollection, WithHeadingRow, WithStartRow
{
    /**
    * @return int
    */
    public function startRow(): int

    {
        return 2;
    }

    /**
    * @param array $row
    * @param Collection $collection
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {

        //\Log::info($rows);

        // Validator::make($rows->toArray(), [
        //     '*.item_code' => 'required|exists:m_items,item_code',
        //     '*.currency_name' => 'required|exists:m_currencies,currency_name',
        // ])->validate();
        dd($rows);
        foreach ($rows as $row) {

            $list_po = new MasterVendor;
            $list_po->id_user = \Numbering::generateAuto(new \App\Models\MasterUser(),"id_user", 5, 1, 1, "");
            $list_po->nm_user = $row[0];
            $list_po->username =  $row[1];
            $list_po->password = bcrypt($row[2]);
            $list_po->id_tipe_user = '04';
            $list_po->status_user = "A";
            $list_po->role = "vendor";

            $list_po->foreign_id = MasterVendor::where('id',$row[2]);

            //$list_po->created_by = !empty(auth()->user()->full_name) ? auth()->user()->full_name : 'user1';
            $list_po->save();

        }
    }

    }
