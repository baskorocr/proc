<?php
/**
 * Copyright (c) 2018. Don't copy or use the source code without author permission for comercial purpose(s)
 */

if(isset($_POST['view'])) {

    include "../../lib/function.php";

    $conn=mysqli_connect("localhost","remote","lact0bas1lus") or die(mysqli_error($conn));
    mysqli_select_db('purch_proc');
    $querymf = "SELECT h.manifest, h.delivery_date, h.po_num, h.id_vendor, h.stat, h.active, v.nm_vendor, d.material, d.material_desc, sum(d.qty_pack) as qty_tot, 
              count(d.kanban) as tot_kanban, SUM(d.qty_in) as tot_qty_in, 
              (select count(dd.scan_date) from manifest_detail dd where dd.scan_date <> '0000-00-00' group by dd.manifest) as in_kanban, h.sent, h.downloaded
              from manifest_detail d 
              join manifest_header h on h.manifest = d.manifest 
              join dp_eproc.vendor v on v.id_vendor = h.id_vendor
              group by d.manifest";

    $query_exec = mysqli_query($conn,$querymf) or die(mysqli_error($conn));

    $tdata = '';

    //if (mysqli_num_rows($query_exec) > 0) {

        while ($row = mysqli_fetch_assoc($query_exec)) {

            if ($row['stat'] == "P") {
                if ($row['qty_tot'] == $row['tot_qty_in']) {
                    $scan_stat = "<small><h4><span class='badge bg-green'>Done</span></h4></small>";
                } else {
                    $scan_stat = "<small><h4><span class='badge bg-yellow'>On Progress</span></h4></small>";
                }
            } else {
                $scan_stat = "<small><h4><span class='badge bg-orange'>Waiting</span></h4></small>";
            }

            if ($row['active'] != 'A') {
                $active_stat = "<small><h4><span class='badge bg-green'>Open</span></h4></small>";
            } else {
                $active_stat = "<small><h4><span class='badge bg-red'>Closed</span></h4></small>";
            }


            $dateformat = strtotime($row['delivery_date']);
            $dlv_date = date("d.m.Y", $dateformat);


            $tdata .= '
                    <tr >
                        <td>'.$row["manifest"].'</td>
                        <td>'.$dlv_date.'</td>
                        <td>'.$row["po_num"].'</td>
                        <td>'.$row["nm_vendor"].'</td>
                        <td>'.$row["tot_kanban"].'</td>
                        <td>'.$row["in_kanban"].'</td>
                        <td>'.$scan_stat.'</td>
                        <td><small><h4><span class="badge bg-orange">Waiting</span></h4></small></td>
                        <td id="table-data">'.$active_stat.'</td>
                        <td align="center">
                             <a href="home.php?'.token().'mnu=mfmtr'.token2().'" data-toggle="" title="material" target="_blank">
                            <button class="btn-success"><i class="fa fa-sitemap"></i></button>
                        </a>

                        <a href="home.php?'.token().'mnu=mfkbn'.token2().'" data-toggle="" title="kanban" target="_blank">
                            <button class="btn-primary"><i class="fa fa-files-o"></i></button>
                        </a>
                        </td>
                    </tr>';
        }
    //}

    //$status_query = "SELECT * FROM comments WHERE comment_status=0";
    //$result_query = mysqli_query($con, $status_query);
    //$count = mysqli_num_rows($result_query);

    $data = array(
        'table_data' => $tdata
    );


    echo json_encode($data);
}

?>