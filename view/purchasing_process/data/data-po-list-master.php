<?php
/**
 * Copyright (c) 2018. Don't copy or use the source code without author permission for comercial purpose(s)
 */

 /*change*/
require_once "../../conn/conn.php";

//$conn = mysqli_connect("localhost", "remote", "lact0bas1lus") or die(mysql_error($conn));
$conn = get_connection();
mysqli_select_db($conn,'purch_proc');

$date_pick = "";
if (isset($_GET['date_from']) &&
    isset($_GET['date_to']) )
{
    $date_from = $_GET['date_from'];
    $date_to   = $_GET['date_to'];

    if ($date_from != "" && $date_to != "" )
    {
        $date_pick = " AND ( p.doc_date BETWEEN '".$date_from."' AND '".$date_to."' ) ";
    } 

} else {
    $date_pick = "";
}

$po_pick = "";
if (isset($_GET['po_list']))
{
    $polist = $_GET['po_list'];

    if ($polist != "" ) {

        $po_data = explode(",",$polist);

        $poarray = "";
        foreach($po_data as $i =>$key) {

            $array = "'".$key ."'";

            if (count($po_data) > 1){
                $poarray = $array.",".$poarray;
            } else {
                $poarray = $array;
            }

        }

        $po_select = rtrim($poarray, ",");

        $po_pick = " AND p.po_num IN ( ".$po_select." ) ";
    }    
    
} else {
	$po_pick = "";
   //$po_pick = " AND p.po_num = 'X' ";
}


$vend_pick = "";
if (isset($_GET['vend_list']))
{
    $vendlist = $_GET['vend_list'];

    if ($vendlist != "" ) {

        $vend_data = explode(",",$vendlist);

        $vendarray = "";
        foreach($vend_data as $i =>$key) {

            $array = "'".$key ."'";

            if (count($vend_data) > 1){
                $vendarray = $array.",".$vendarray;
            } else {
                $vendarray = $array;
            }

        }

        $vend_select = rtrim($vendarray, ",");

        $vend_pick = " AND p.id_vendor IN ( ".$vend_select." ) ";
    }    
    
} else {
	$vend_pick = "";
   //$vend_pick = " AND p.id_vendor = 'X' ";
}

$limit_query = "";
if ( $date_pick == "" && $po_pick == "" && $vend_pick == "") 
{
	$limit_query = " AND ( p.doc_date >= ( curdate() - INTERVAL 5 MONTH ) )";
}

/*
$querypo = "SELECT p.*, v.nm_vendor, u.username, u.status_user from purch_proc.po_list p 
              join dp_eproc.vendor v on p.id_vendor = v.id_vendor
              left join dp_eproc.user u on u.foreign_id = v.id_vendor
              order by p.po_num asc";
              */
              //group by p.po_num
             //where batch = (select max(batch) from po_list where po_num = p.po_num)
			 //, u.id_access_group, agl.access_group_name, mag.id_menu, mg.id_menu_group, mgl.menu_group_object
$querypo = "SELECT p.po_num, p.revno, p.plant, p.id_vendor, p.doc_date, p.pgr, p.po_val, p.tot_val, 
				p.curr, p.sent, p.downloaded, p.relind, p.last_change, p.batch,
				(SELECT file_nm FROM po_list where po_num = p.po_num order by last_change desc limit 1) as file_nm,
				(SELECT creator FROM po_list where po_num = p.po_num order by last_change desc limit 1) as creator,
				v.nm_vendor, u.username, u.status_user
				from purch_proc.po_list p 
				join dp_eproc.vendor v on p.id_vendor = v.id_vendor 
				left join dp_eproc.user u on u.foreign_id = p.id_vendor 
				left join dp_eproc.access_group_list acg on u.id_access_group = acg.id_access_group
				where v.status_vendor = 'A' AND u.role = 'vendor' AND acg.access_code = 'POL'
				#Begin of insertion by HOS 10.11.2021
				$limit_query
				#End of insertion by HOS 10.11.2021
				$date_pick
				$po_pick
				$vend_pick
				group by p.po_num
				#p.batch
				order by p.po_num asc, p.last_change desc ";

			/*
			join dp_eproc.access_group_list agl on agl.id_access_group = u.id_access_group
			join dp_eproc.menu_access_group mag on mag.id_access_group = u.id_access_group
			join dp_eproc.menu_group mg on mg.id_menu = mag.id_menu
			join dp_eproc.menu_group_list mgl on mgl.id_menu_group = mg.id_menu_group
			where mgl.menu_group_object = 'purchproc'
			*/
$query_exec = mysqli_query($conn,$querypo) or die(mysqli_error($conn));

$data = array();

if(mysqli_num_rows($query_exec) > 0 )
{
    $response = array();
    $response["data"] = array();
    while($row = mysqli_fetch_array($query_exec)){

        if($row['relind'] == '1'){
            $rel_stat = "<small><i class='fa fa-check-circle' style='color: green;' 
                                data-toggle=tooltip' data-placement='left' title='Released'>
                                </i>
                        </small>";
        } else {
            $rel_stat = "<small><i class='fa fa-exclamation-circle' style='color: red;'
                                data-toggle=tooltip' data-placement='left' title='Not Released'>
                                </i>
                        </small>";
        }

        if($row['sent'] != '0000-00-00 00:00:00'){
            $mail_stat = "<small><i class='fa fa-check-circle' style='color: green;'
                                data-toggle=tooltip' data-placement='left' title='Sent'>
                                </i>
                        </small>";
        } else {
            $mail_stat = "<small><i class='fa fa-exclamation-circle' style='color: red;'
                                data-toggle=tooltip' data-placement='left' title='Not Sent'>
                                </i>
                        </small>";
        }

        if($row['downloaded'] != '0000-00-00 00:00:00'){
            $dwld_stat = "<small><i class='fa fa-check-circle' style='color: green;'
                                    data-toggle=tooltip' data-placement='left' title='Downloaded'>
                                </i>
                          </small>";
        } else {
            $dwld_stat = "<small><i class='fa fa-exclamation-circle' style='color: red;'
                                    data-toggle=tooltip' data-placement='left' title='Not Downloaded'>
                                 </i>
                        </small>";
        }

        if(filter_var($row['username'], FILTER_VALIDATE_EMAIL) AND $row['status_user'] == "A") {
            $vendor_mail_stat = "<small><i class='fa fa-check-circle' style='color: green;'
                                        data-toggle='tooltip' data-placement='left' title='User active'>
                                        </i>
                                        </small>";
            $vendor_mail = $row['username'] . " " . $vendor_mail_stat;

        }elseif(filter_var($row['username'], FILTER_VALIDATE_EMAIL) AND $row['status_user'] != "A"){

            $vendor_mail_stat = "<small><i class='fa fa-exclamation-triangle' style='color: yellow;'
                                            data-toggle='tooltip' data-placement='left' title='User not active'>
                                        </i>
                                </small>";
            $vendor_mail = $row['username'] . " " . $vendor_mail_stat;

        }else {
            $vendor_mail_stat = "<small><i class='fa fa-exclamation-circle' style='color: red;'></i></small>";
            $vendor_mail = "No mail ".$vendor_mail_stat;
        }

        $filenm = $row['file_nm']; //.".pdf"

        //check file
        if ($filenm != "-" && $filenm != "" ) {
            //activate
            $btnlink = 'A';
            $file_exist = "<small><i class='fa fa-check-circle' style='color: green;'
                                    data-toggle='tooltip' data-placement='left' title='Exist'>
                                  </i>
                          </small>";
            $filepdf = $filenm;
        } else {
            $btnlink = 'N';
            $file_exist = "<small><i class='fa fa-exclamation-circle' style='color: red;'
                                    data-toggle='tooltip' data-placement='left' title='Not exist'>
                                </i>
                           </small>";
            $filepdf = "-";
        }

        $dateformat = strtotime($row['doc_date']);
        //$doc_date = date("d.m.Y", $dateformat);
        $doc_date = date("Y-m-d", $dateformat);

        $dateformat_upl = strtotime($row['last_change']);
        //$upload_date = date("d.m.Y H:i", $dateformat_upl);
        $upload_date = date("Y-m-d H:i:s", $dateformat_upl);
		
		$po_value = number_format($row["po_val"], 2, '.', ',');
		$po_val   = "<p class='text-right' >".$po_value."</p>";
		
        $total_value = number_format($row["tot_val"], 2, '.', ',');
		$tot_val   = "<p class='text-right' >".$total_value."</p>";

        $data['po_num'] = $row["po_num"];
        $data['revno'] = $row["revno"];
        $data['plant'] = $row["plant"];
        $data['id_vendor'] = $row["id_vendor"];
        $data['nm_vendor'] = $row["nm_vendor"];
        $data['mail'] = $vendor_mail;
        $data['doc_date'] = $doc_date;
        $data['purch_group'] = $row["pgr"];
		$data['po_val'] = $po_val;
        $data['tot_val'] = $tot_val;
        $data['curr'] = $row["curr"];
        $data['upload_date'] = $upload_date;
        $data['upload_group'] = $row["batch"];
        $data['rel_stat'] = $rel_stat;
        $data['mail_stat'] = $mail_stat;
        $data['file_exist'] = $file_exist;
        $data['download_stat'] = $dwld_stat;
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