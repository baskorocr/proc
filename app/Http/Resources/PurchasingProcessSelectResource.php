<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Storage;
use Exception;

class PurchasingProcessSelectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
          // if($this->revno != 0)
               //  {
               //      $pdf_nm = $this->po_num."-".date('Ymd',strtotime($this->revdt))."-".date('His',strtotime($this->revtm)).".pdf";
               //  } else{
             $pdf_nm = $this->file_nm;
                // }
                

            if($this->file_nm=="-"  || empty($this->file_nm)){

                $selected= false;

            }
            $file = Storage::disk('po_directory')->path(""). $pdf_nm;
            $file_qas = Storage::disk('po_qas_directory')->path(""). $pdf_nm;
            $relativeName = basename($file);
            if(file_exists($file))
            {
              $selected= true;
            } elseif(file_exists($file_qas)){

                 $selected= true;
            }else{
               $selected= false;
            }

         return [
                    '_id' =>  $this->_id,
                    'po_num' =>  $this->po_num,
                    'file_nm' =>  $this->file_nm,
                    'selected' =>  $selected,
            ];
    }
}
