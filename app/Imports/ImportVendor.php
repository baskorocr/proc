<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use DB;
use App\Models\PurchasingProcess;
use App\Models\MasterVendor;
use Carbon\Carbon;

class ImportVendor implements ToCollection, WithHeadingRow, WithStartRow
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
        // dd($rows);
        foreach ($rows as $row) {

            $list_po = new MasterVendor;
            $list_po->id_vendor = \Numbering::generateAuto(new \App\Models\MasterVendor(),"id_vendor", 4, 4, 1, "10");
            $list_po->purch_org = $row[0];
            $list_po->nm_vendor = $row[1];
            $list_po->alias = $row[3];
            $list_po->street = $row[4];
            $list_po->district = $row[5];
            $list_po->postal_code = $row[6];
            $list_po->city = $row[7];
            $list_po->country = $row[8];
            $list_po->region = $row[9];
            $list_po->phone_1 = $row[10];
            $list_po->vat_reg = $row[11];
            $list_po->order_curr = $row[12];
            $list_po->pay_term = $row[13];
            $list_po->sales_person = $row[14];
            $list_po->phone_2 = $row[15];
            if(strlen($row[16])>1):
                if(strtolower($row[16]) == "active")
                {
                    $status = "A";
                } else{
                    $status = "N";
                }
            else:
                if(strtolower($row[16]) == "a")
                {
                    $status = "A";
                } else{
                    $status = "N";
                }
            endif;
            $list_po->status_vendor =  $status ;
            //$list_po->created_by = !empty(auth()->user()->full_name) ? auth()->user()->full_name : 'user1';
            $list_po->save();

        }
    }

    }
