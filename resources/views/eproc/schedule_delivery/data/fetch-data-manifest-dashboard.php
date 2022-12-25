
<?php

    include "../../lib/function.php";
    include "../../schedule_delivery/schedule-delivery-query.php";

    $query_exec = get_all_manifest_group_2();
    $tdata = '';

    //if (mysql_num_rows($query_exec) > 0) {

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


            $tot_kanban = $row["tot_kanban"];
            if($row["in_kanban"] >= 1){
                $kanban_in = $row["in_kanban"];
            } else {
                $kanban_in = "0";
            }

            if ($tot_kanban == $kanban_in) {
                $kanban_stat = "<small><h4><span class='badge bg-green'>".$kanban_in."/".$tot_kanban."</span></h4></small>";
            } else {
                $kanban_stat = "<small><h4><span class='badge bg-orange'>".$kanban_in."/".$tot_kanban."</span></h4></small>";
            }


            $dateformat = strtotime($row['delivery_date']);
            $dlv_date = date("d.m.Y", $dateformat);


            $tdata .= '
                    <tr >
                        <td>'.$row["manifest"].'</td>
                        <td>'.$dlv_date.'</td>
                        <td>'.$row["po_num"].'</td>
                        <td>'.$row["nm_vendor"].'</td>
                        <td id="kanban-stat">'.$kanban_stat.'</td>
                        <td id="scan-stat">'.$scan_stat.'</td>
                        <td id="receive-stat"><small><h4><span class="badge bg-orange">Waiting</span></h4></small></td>
                        <td id="open-stat">'.$active_stat.'</td>
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


        echo $tdata;


?>