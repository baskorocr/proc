<?php
namespace App\Helpers;

use App\Models\Transaction;
use App\Models\NumberRange;
use DB;

class IsoHelper {

	function get_transaction_type_id($trn_id){

		$tr = Transaction::where('trn_id',$trn_id)->get();
		return $tr;
	}

	function get_transaction_type_id_first($trn_id){

		$tr = Transaction::where('trn_id',$trn_id)->first();
		return $tr;
	}

	//NUMBER RANGE
	function get_number_range($doc_type, $doc_year){
		$n = NumberRange::where('doc_type',$doc_type)->where('doc_year',intval($doc_year))->first();
		// dd($n);
		if(!empty($n))
		{
			return $n->current_num + 1;
		} 

		return 0;
	}

	function update_number_range($doc_type, $doc_year){
		$n = NumberRange::where('doc_type',$doc_type)->where('doc_year',intval($doc_year))->first();


		NumberRange::where('doc_type',$doc_type)->where('doc_year',intval($doc_year))->update(['current_num' => ($n->current_num + 1)]);
		
	}


	function get_number_range_data($doc_type, $doc_year){
		$n = NumberRange::where('doc_type',$doc_type)->where('doc_year',intval($doc_year))->first();
 		
 		return $n;
		
	}


}
