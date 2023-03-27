<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use DB;
use App\Models\PurchasingProcess;
use Carbon\Carbon;

class ImportPo implements ToCollection, WithHeadingRow, WithStartRow
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

        foreach ($rows as $row) {

            $list_po = new PurchasingProcess;
            $list_po->po_num = strVal($row['po_num']);
            $list_po->revno = $row['revno'];
            $list_po->plant = $row['plant'];
            $list_po->id_vendor = $row['id_vendor'];
            $list_po->doc_date = !empty(Carbon::parse($row['doc_date'])->format('Y-m-d')) ? Carbon::parse($row['doc_date'])->format('Y-m-d') : string ($row['doc_date']);
            $list_po->pgr = $row['pgr'];
            $list_po->po_amount = (float)$row['po_amount'];
            $list_po->total_amount = (float)$row['total_amount'];
            $list_po->curr = $row['curr'];
            $list_po->porg = $row['porg'];
            $list_po->rel_state = $row['rel_state'];
            $list_po->creator = $row['creator'];
            //$list_po->created_by = !empty(auth()->user()->full_name) ? auth()->user()->full_name : 'user1';
            $list_po->save();

        }
    }

    }
