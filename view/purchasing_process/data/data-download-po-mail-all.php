<?php

include "../function.php";

$conn = mysqli_connect("localhost", "remote", "lact0bas1lus") or die(mysqli_error($conn));
mysqli_select_db('purch_proc');
$querypo = "SELECT p.*, d.nm_vendor, d.status_vendor, u.status_user, u.role from purch_proc.po_list p 
			  join dp_eproc.vendor d on p.id_vendor = d.id_vendor
			  join dp_eproc.user u on u.foreign_id = d.id_vendor
              where d.status_vendor = 'A'
              #and p.sent <> '00-00-0000 00:00:00' 
              group by p.po_num
              order by p.sent desc";

$query_exec = mysqli_query($conn,$querypo) or die(mysqli_error($conn));

$tdata = '';

if(mysqli_num_rows($query_exec) > 0 ){
    $response = array();
    $response["data"] = array();
    while($row = mysqli_fetch_array($query_exec)){

        if($row['sent'] != '0000-00-00 00:00:00'){
            $mail_stat = "<small><i class='fa fa-check-circle' style='color: green;'></i></small>";
        } else {
            $mail_stat = "<small><i class='fa fa-exclamation-circle' style='color: red;'></i></small>";
        }

        if($row['downloaded'] != '0000-00-00 00:00:00'){
            $dwld_stat = "<small><i class='fa fa-check-circle' style='color: green;'></i></small>";
        } else {
            $dwld_stat = "<small><i class='fa fa-exclamation-circle' style='color: red;'></i></small>";
        }

        $filenm = $row['file_nm']; //.".pdf"

        $diff = dateDifference($row['doc_date'] , date("Y-m-d"),'%m' );

        //check file
        if ($filenm != "") {
            //activate
            $btnlink = 'A';
            $stat = '';
            $file_exist = "<small><i class='fa fa-check-circle' style='color: green;'></i></small>";
            $filepdf = $filenm;

            //3 months

            if($diff >= 3){
                $stat = 'disabled';
            } else {
                $stat = '';
            }


        } else {
            $btnlink = 'N';
            $stat = 'disabled';
            $file_exist = "<small><i class='fa fa-exclamation-circle' style='color: red;'></i></small>";
            $filepdf = "-";

        }

        if($stat == 'disabled'){

            $active = "<small><i class='fa fa-exclamation-circle' style='color: red;'></i></small>";

        } else {
            $active = "<small><i class='fa fa-check-circle' style='color: green;'></i></small>";
        }

        $list = "<input type='checkbox' name='selectpo[]' value=".$filepdf." ".$stat." >";


        $data['list'] = $list;
        $data['po_num'] = $row["po_num"];
        $data['plant'] = $row["plant"];
        $data['id_vendor'] = $row["id_vendor"];
        $data['nm_vendor'] = $row["nm_vendor"];
        $data['mail_stat'] = $mail_stat;
        $data['file_exist'] = $file_exist;
        $data['download_stat'] = $dwld_stat;
        $data['active'] = $active;
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