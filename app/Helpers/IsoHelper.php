<?php
namespace App\Helpers;

use App\Models\Transaction;
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


}
