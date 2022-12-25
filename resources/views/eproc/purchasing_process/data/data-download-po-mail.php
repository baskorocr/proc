<?php

require_once "../../conn/conn.php";
include "../function.php";

//$conn = mysqli_connect("localhost", "remote", "lact0bas1lus") or die(mysqli_error($conn));
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

    if ( isset( $_GET['id_vendor']) )
    {} 
    else
    {
        $date_pick = "";
    }
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

    if ( isset( $_GET['id_vendor']) )
    {} 
    else 
    {
		$po_pick = "";
        //$po_pick = "AND p.po_num = 'X' ";
    }
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
    
    if ( isset( $_GET['id_vendor']) )
    {} 
    else 
    {	
		$vend_pick = "";
        //$vend_pick = " AND p.id_vendor = 'X' ";
    }
   
}

$limit_query = "";
if ( $date_pick == "" && $po_pick == "" && $vend_pick == "") 
{
	$limit_query = " AND ( p.doc_date >= ( curdate() - INTERVAL 3 MONTH ) 
                        #OR p.downloaded = '00-00-0000 00:00:00' 
                  )";
}

if ( isset( $_GET['id_vendor']) )
{
    $querypo = "SELECT p.po_num, p.revno, p.plant, p.id_vendor, p.doc_date, p.pgr, p.po_val, p.tot_val, 
					p.curr, p.sent, p.downloaded, p.relind, p.last_change, p.batch,
					(SELECT file_nm FROM po_list where po_num = p.po_num AND id_vendor = '$_GET[id_vendor]' order by last_change desc limit 1) as file_nm,
					(SELECT creator FROM po_list where po_num = p.po_num AND id_vendor = '$_GET[id_vendor]' order by last_change desc limit 1) as creator, 
					d.nm_vendor, d.status_vendor, u.status_user, u.role from purch_proc.po_list p 
                    join dp_eproc.vendor d on p.id_vendor = d.id_vendor
                    join dp_eproc.user u on u.foreign_id = d.id_vendor
                    where p.id_vendor = '$_GET[id_vendor]' 
					#AND p.sent <> '00-00-0000 00:00:00' 
                    and d.status_vendor = 'A' and u.status_user = 'A'
                    #Begin of insertion by HOS 10.11.2021
					$limit_query
                    #End of insertion by HOS 10.11.2021
                    $date_pick
                    $po_pick
                    group by p.po_num
					#p.batch
                    order by p.sent desc";
}
else
{
    $querypo = "SELECT p.po_num, p.revno, p.plant, p.id_vendor, p.doc_date, p.pgr, p.po_val, p.tot_val, 
				p.curr, p.sent, p.downloaded, p.relind, p.last_change, p.batch,
			    (SELECT file_nm FROM po_list where po_num = p.po_num order by last_change desc limit 1) as file_nm,
				(SELECT creator FROM po_list where po_num = p.po_num order by last_change desc limit 1) as creator, 
				d.nm_vendor, d.status_vendor, u.status_user, u.role 
				from purch_proc.po_list p 
                join dp_eproc.vendor d on p.id_vendor = d.id_vendor
                left join dp_eproc.user u on u.foreign_id = d.id_vendor
                where  d.status_vendor = 'A'
                #AND p.sent <> '00-00-0000 00:00:00' 
                #OR (p.downloaded <> '00-00-0000 00:00:00' AND curdate() < p.downloaded + INTERVAL 30 DAY )
                #Begin of insertion by HOS 10.11.2021
				$limit_query
                #End of insertion by HOS 10.11.2021
                $date_pick
                $po_pick
                $vend_pick
                group by p.po_num
				#p.batch
                order by p.sent desc";
}

$query_exec = mysqli_query($conn,$querypo) or die(mysqli_error($conn));

$data = array();
$po_exist = array();

if(mysqli_num_rows($query_exec) > 0 ){
    $response = array();
    $response["data"] = array();
    while($row = mysqli_fetch_array($query_exec)){

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

		$file_ver = $row['file_nm'];
        $filenm = $row['file_nm'];
		if ($filenm != "")
		{
			$filenm = $row['file_nm']."|".$row['creator'];
		}

        $diff = dateDifference($row['doc_date'] , date("Y-m-d"),'%m' );

       //check file
       $cb_check = '';
       if ($filenm != "-" || $filenm != "" ) {
            //activate
            $btnlink = 'A';
            $stat = '';
            $file_exist = "<small><i class='fa fa-check-circle' style='color: green;'
                                     data-toggle=tooltip' data-placement='left' title='Exist'>
                                  </i>
                          </small>";

            //$filepdf = $filenm.".pdf";
            $filepdf = $filenm;
            $cb_check = '';

            //3 months
            if($diff >= 3){
                $stat = 'disabled';
            } else {
                $stat = '';

                if (isset($_GET['check']))
                {
                    if ($_GET['check'] == "X")
                    {
                        $cb_check = 'checked';
                    }
                }
            }


        } else {
            $btnlink = 'N';
            $stat = 'disabled';
            $file_exist = "<small><i class='fa fa-exclamation-circle' style='color: red;'
                                    data-toggle=tooltip' data-placement='left' title='Not exist'>
                                </i>
                           </small>";
            $filepdf = "-";

        }

        if($stat == 'disabled'){

            $active = "<small><i class='fa fa-exclamation-circle' style='color: red;'
                                data-toggle=tooltip' data-placement='left' title='Not Active'>
                              </i>
                       </small>";

        } else {
            $active = "<small><i class='fa fa-check-circle' style='color: green;'
                                data-toggle=tooltip' data-placement='left' title='Active'>
                             </i>
                        </small>";
        }

        $dateformat = strtotime($row['doc_date']);
        //$doc_date = date("d.m.Y", $dateformat);
        $doc_date = date("Y-m-d", $dateformat);

        $dateformat_sent = strtotime($row['sent']);
        //$mail_sent = date("d.m.Y H:i", $dateformat_sent);
        $mail_sent = date("Y-m-d H:i:s", $dateformat_sent);
		
		$po_value = number_format($row["po_val"], 2, '.', ',');
		$po_val   = "<p class='text-right' >".$po_value."</p>";

        $total_value = number_format($row["tot_val"], 2, '.', ',');
		$tot_val   = "<p class='text-right' >".$total_value."</p>";

        if($filenm != '') {
            array_push($po_exist,  $row['po_num']);
        }
        
        $list = "<tr><td><input type='checkbox' class='call-checkbox' name='selectpo[]' id='selectpo' value='$filepdf' $stat $cb_check ></td>";
        $ponum = "<td>
                    <a href='' data-toggle='modal' data-target='#poDetail'
                    data-ponum='".$row['po_num']."'>
                        ".$row['po_num']."
                    </a>
                 </td>";

        $data["list"]           = $list;
        $data['po_num']         = "<td>".$row["po_num"]."</td>";
        $data['revno']          = "<td>".$row["revno"]."</td>";
        $data['plant']          = "<td>".$row["plant"]."</td>";
        $data['id_vendor']      = "<td>".$row["id_vendor"]."</td>";
        $data['nm_vendor']      = "<td>".$row["nm_vendor"]."</td>";
        $data['doc_date']       = "<td>".$doc_date."</td>";
        $data['purch_gr']       = "<td>".$row['pgr']."</td>";
		$data['po_val'] 		= "<td>".$po_val."</td>";
        $data['tot_val']        = "<td>".$tot_val."</td>";
        $data['curr']           = "<td>".$row["curr"]."</td>";
        $data['send_date']      = "<td>".$mail_sent."</td>";
        $data['mail_stat']      = "<td>".$mail_stat."</td>";
        $data['file_exist']     = "<td>".$file_exist."</td>";
        $data['download_stat']  = "<td>".$dwld_stat."</td>";
        $data['active']         = "<td>".$active."</td>";
        $data['filepdf']        = "<td>".$file_ver."</td></tr>";
        array_push($response["data"], $data);
    }

    $count_data = count($po_exist);
    
    echo json_encode($response);
}
else 
{
    //$response["message"]="no data";
    //echo json_encode($response);
    echo '{ "data": [] }';
}

//echo $data;