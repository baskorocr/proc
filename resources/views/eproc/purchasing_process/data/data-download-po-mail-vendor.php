<?php

$conn = mysqli_connect("localhost", "remote", "lact0bas1lus") or die(mysqli_error($conn));
mysqli_select_db('purch_proc');
$querypo = "SELECT p.*, v.nm_vendor, u.id_user, u.username, u.status_user from purch_proc.po_list p 
              join dp_eproc.vendor v on p.id_vendor = v.id_vendor 
              join dp_eproc.user u on u.foreign_id = v.id_vendor
              where p.batch = (select max(p.batch) from purch_proc.po_list) 
			  #and p.sent = '0000-00-00 00:00:00'
              group by p.po_num";

$query_exec = mysqli_query($conn,$querypo) or die(mysqli_error($conn));

$tdata = '';

if(mysqli_num_rows($query_exec) > 0 ){
    $response = array();
    $response["data"] = array();
    while($row = mysqli_fetch_array($query_exec)){

        if($row['relind'] == '1'){
            $rel_stat = "<small><i class='fa fa-check-circle' style='color: green;'></i></small>";
        } else {
            $rel_stat = "<small><i class='fa fa-exclamation-circle' style='color: red;'></i></small>";
        }

        if(filter_var($row['username'], FILTER_VALIDATE_EMAIL) AND $row['status_user'] == "A") {
            $vendor_mail_stat = "<small><i class='fa fa-check-circle' style='color: green;'></i></small>";
            $vendor_mail = $row['username'] . " " . $vendor_mail_stat;

        }elseif(filter_var($row['username'], FILTER_VALIDATE_EMAIL) AND $row['status_user'] != "A"){

            $vendor_mail_stat = "<small><i class='fa fa-exclamation-circle' style='color: red;'></i></small>";
            $vendor_mail = $row['username'] . " " . $vendor_mail_stat;

        }else {
            $vendor_mail_stat = "<small><i class='fa fa-exclamation-circle' style='color: red;'></i></small>";
            $vendor_mail = "No mail ".$vendor_mail_stat;
        }

        $filenm = $row['file_nm']; //.".pdf"

        //check file
        if ($filenm != "") {
            //activate
            $btnlink = 'A';
            $file_exist = "<small><i class='fa fa-check-circle' style='color: green;'></i></small>";
            $filepdf = $filenm;
        } else {
            $btnlink = 'N';
            $file_exist = "<small><i class='fa fa-exclamation-circle' style='color: red;'></i></small>";
            $filepdf = "-";
        }

        $dateformat = strtotime($row['doc_date']);
        $doc_date = date("d.m.Y", $dateformat);

        $data['po_num'] = $row["po_num"];
        $data['plant'] = $row["plant"];
        $data['id_vendor'] = $row["id_vendor"];
        $data['nm_vendor'] = $row["nm_vendor"];
        $data['doc_date'] = $doc_date;
        $data['mail'] = $vendor_mail;
        $data['rel_stat'] = $rel_stat;
        $data['file_exist'] = $file_exist;
        $data['filepdf'] = $filepdf;
        array_push($response["data"], $data);
    }
    echo json_encode($response);
}else {
    //$response["message"]="no data";
    //echo json_encode($response);
    echo '{ "data": [] }';
}

//echo $data;