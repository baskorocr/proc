<?php
/**
 * Copyright (c) 2018. Don't copy or use the source code without author permission for comercial purpose(s)
 */

include "../../lib/function.php";

$conn = mysqli_connect("localhost", "remote", "lact0bas1lus") or die(mysqli_error($conn));
mysqli_select_db('purch_proc');

$querymf = "SELECT h.manifest, h.delivery_date, h.po_num, h.id_vendor, h.stat, h.active, v.nm_vendor, d.material, 
            d.material_desc, sum(d.qty_pack) as qty_tot, count(d.kanban) as tot_kanban, SUM(d.qty_in) as tot_qty_in, 
            (select count(dd.scan_date) from manifest_detail dd where dd.manifest = h.manifest and dd.scan_date <> '0000-00-00' 
            group by dd.manifest) as in_kanban, 
            (select count(dd.issued_date) from manifest_detail dd where dd.manifest = h.manifest and dd.issued_date <> '0000-00-00' 
            group by dd.manifest) as received_kanban,
            h.sent, h.downloaded from manifest_detail d 
            join manifest_header h on h.manifest = d.manifest 
            join dp_eproc.vendor v on v.id_vendor = h.id_vendor 
            group by d.manifest 
            order by h.delivery_date desc";

$query_exec = mysqli_query($conn,$querymf) or die(mysqli_error($conn));

$tdata = '';

if(mysqli_num_rows($query_exec) > 0 ){
    $response = array();
    $response["data"] = array();
    while($row = mysqli_fetch_array($query_exec)){

        if ($row['stat'] == "P") {
            if ($row['qty_tot'] == $row['tot_qty_in']) {
                $scan_stat = "<small><h4><span class=\"badge bg-green\">Done</span></h4></small>";
            } else {
                $scan_stat = "<small><h4><span class=\"badge bg-blue\">On Progress</span></h4></small>";
            }
        }elseif ($row['stat'] == "H"){
            $scan_stat = "<small><h4><span class=\"badge bg-red\">Outstanding</span></h4></small>";

        }elseif ($row['stat'] == "D"){
            $scan_stat = "<small><h4><span class=\"badge bg-green\">Done</span></h4></small>";
        } else {
            $scan_stat = "<small><h4><span class=\"badge bg-orange\">Waiting</span></h4></small>";
        }

        if ($row['active'] == 'O') {
            $active_stat = "<small><h4><span class=\"badge bg-orange\">Open</span></h4></small>";
        } else {
            $active_stat = "<small><h4><span class=\"badge bg-green\">Closed</span></h4></small>";
        }

        $tot_kanban = $row["tot_kanban"];
        if ($row["in_kanban"] >= 1) {
            $kanban_in = $row["in_kanban"];
        } else {
            $kanban_in = "0";
        }

        if ($tot_kanban == $kanban_in) {
            $kanban_stat = "<small><h4><span class=\"badge bg-green\">" . $kanban_in . "/" . $tot_kanban . "</span></h4></small>";
        } else {
            $kanban_stat = "<small><h4><span class=\"badge bg-orange\">" . $kanban_in . "/" . $tot_kanban . "</span></h4></small>";
        }

        if ($row["received_kanban"] >= 1) {
            $kanban_received = $row["received_kanban"];
        } else {
            $kanban_received = "0";
        }

        if ($tot_kanban == $kanban_received) {
            $receive_stat = "<small><h4><span class=\"badge bg-green\">" .$kanban_received. "/" . $tot_kanban . "</span></h4></small>";
        } else {
            $receive_stat = "<small><h4><span class=\"badge bg-orange\">" .$kanban_received. "/" . $tot_kanban . "</span></h4></small>";
        }

        //$receive_stat ="<small><h4><span class=\"badge bg-orange\">Waiting</span></h4></small></td>";

        $dateformat = strtotime($row['delivery_date']);
        //$dlv_date = date("d.m.Y", $dateformat);
		$dlv_date = date("Y-m-d", $dateformat);

        $buttons ="
                   <form name=\"myForm\" action=\"home.php?".token()."mnu=mfmtr".token2()."\" method=\"post\" enctype=\"multipart/form-data\" target=\"_blank\">
                        <input type=\"hidden\" name=\"mf\" value=\"".$row['manifest']."\" readonly='true'>
                        <button type=\"submit\" name=\"mfmat\" class=\"btn-success\"  data-toggle=\"\" title=\"material\"><i class=\"fa fa-sitemap\"></i></button>
                   </form>
                   <form name=\"myForm1\" action=\"home.php?".token()."mnu=mfkbn".token2()."\" method=\"post\" enctype=\"multipart/form-data\" target=\"_blank\">
                        <input type=\"hidden\" name=\"mf\" value=\"".$row['manifest']."\" readonly='true'>
                        <button type=\"submit\" name=\"mfkan\" class=\"btn-primary\" data-toggle=\"\" title=\"kanban\"><i class=\"fa fa-files-o\"></i></button>
                   </form>
                   ";

        $data['manifest'] = $row["manifest"];
        $data['delivery_date'] = $dlv_date;
        $data['po_num'] = $row["po_num"];
        $data['nm_vendor'] = $row["nm_vendor"];
        $data['stat_kanban'] = $kanban_stat;
        $data['scan_stat'] = $scan_stat;
        $data['receive_stat'] = $receive_stat;
        $data['active_stat'] = $active_stat;
        $data['buttons'] = $buttons;
        array_push($response["data"], $data);
    }
    echo json_encode($response);
}else {
    //$response["message"]="no data";
    //echo json_encode($response);
    echo '{ "data": [] }';
}

//echo $data;