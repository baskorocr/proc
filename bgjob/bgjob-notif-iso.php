<?php

require "bgjob-query.php";
require "bgjob-func.php";
include "../view/lib/ip-detect.php";

$today      = date('Y-m-d');
$time       = date('H:i:s');
$datetime   = date('Y-m-d H:i:s');
$ip_addr    = ip_detect();
$query_exec = get_all_iso_data();
$my_trn_id = "";
$my_doc_year = "";

while ($row = mysqli_fetch_assoc($query_exec)) {

    $trn_id         = $row['trn_id'];
    $doc_year       = $row['doc_year'];
    $id_user        = 'bgjob';
    $id_vendor      = $row['id_vendor'];
    $trn_date       = $today;
    $trn_time       = $time;
    $trn_detail     = $row['notif_id'];
    $notify_date    = $row['notify_date'];
	$trn_type		= $row['trn_type'];
	
	//echo $trn_id     ."<br>";
	//echo $doc_year   ."<br>";
	//echo $id_user    ."<br>";
	//echo $id_vendor  ."<br>";
	//echo $trn_date   ."<br>";
	//echo $trn_time   ."<br>";
	//echo $trn_detail ."<br>";
	//echo "notify date: ", $notify_date."<br>";
    //echo $trn_type	 ."<br>";
	
    //get emailing data
    $email_list_stat    = array();
    $mnu_obj            = "dociso";
    $query_iso          = get_user_iso_mail($id_vendor, $mnu_obj);
    //$rowiso     = mysqli_fetch_assoc($query_iso);

    while ($rowiso = mysqli_fetch_assoc($query_iso)) {

        $email['email']     = $rowiso['username'];
        $email['name']      = $rowiso['nm_user'];
        $email['role']      = $rowiso['role'];
        $email['id_vendor'] = $rowiso['id_vendor'];
        $email['nm_vendor'] = $rowiso['nm_vendor'];
        $email['trn_id']    = $trn_id;
        $email['doc_year']  = $doc_year;
        $email['trn_type']  = $trn_type;
        $email['mailing']   = 'To';
		
		//echo $email['email']    ."<br>";
		//echo $email['name']     ."<br>";
		//echo $email['role']     ."<br>";
		//echo $email['id_vendor']."<br>";
		//echo $email['nm_vendor']."<br>";
		//echo $email['trn_id']   ."<br>";
		//echo $email['doc_year'] ."<br>";
		//echo $email['trn_type'] ."<br>";
		//echo $email['mailing']  ."<br>";
		
		$exp_date_sp   = explode(".", $row['exp_date']);
        $exp_date_fm   = $exp_date_sp[2]."-".$exp_date_sp[1]."-".$exp_date_sp[0];
        $exp_date      = $exp_date_fm; //check expire date with d-date
		
		//echo "today :", $today  ."<br>";
		//echo "exp date : ", $exp_date."<br>";

        if (filter_var($email['email'], FILTER_VALIDATE_EMAIL)){
            $email['valid'] = 'Valid';
        } else {
            $email['valid'] = 'Invalid';
        }

        $email_list_stat[] = $email;
    }
	
	//print_r ($email_list_stat[0]);
	
    if ( ($notify_date == $today || $exp_date == $today) && isset($email_list_stat[0]) ) {
        echo $row['trn_id'].$row['doc_year'].$row['notif_id']."  ".$row['exp_date']." ".$row['notify_date']."<br>";

        if ($exp_date == $today) {
            $stat   = 'E';
            $notif_id = $stat;

            if ($row['trn_type'] == 'N') {
                update_stat_reg_iso($trn_id, $doc_year, $stat);
            } else {
				
				if (($my_trn_id != $trn_id) AND ($my_doc_year != $doc_year) ) {
					
					$my_trn_id 		= $trn_id;
					$my_doc_year 	= $doc_year;
					
					update_stat_reg_iso($trn_id, $doc_year, $stat);

					$msg = mail_iso_once($email_list_stat[0], $notif_id);
					//$msg = 'success';
					
					if($msg == 'success'){
						insert_iso_log($trn_id, $doc_year, $id_user, $trn_type, $trn_date, $trn_time, $ip_addr, $trn_detail);
						echo "success";
					}
				}

            }
            
        } else {
            $trn_type   = 'I';
            update_trn_reg_iso($trn_id, $doc_year, $trn_type);
            update_trn_iso_notif($trn_id, $doc_year, $row['notif_id'], $datetime, '', '');

            $notif_id = $row['notif_id'];

            $msg = mail_iso_once($email_list_stat[0], $notif_id);
            //$msg = 'success';
                        
            if($msg == 'success'){
                insert_iso_log($trn_id, $doc_year, $id_user, $trn_type, $trn_date, $trn_time, $ip_addr, $trn_detail);
				echo "success";
            }
        }
        
       
    }
    
}

?>