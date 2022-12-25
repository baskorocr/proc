<?php

    //include "dociso-query.php";
    include "purchasing_process/purch-proc-query.php";

    //function mail_iso_notify($name){
    //function mail_iso_expired($name){

    function mail_iso_once($name){

        //$name="hidrian.suharman@dp.dharmap.com";
        //$email="hidrian.suharman@dp.dharmap.com";
        $email     = $name['email'];
        $trn_id    = $name['trn_id'];
        $doc_year  = $name['doc_year'];
        $id_vendor = $name['id_vendor'];
        $nm_vendor = $name['nm_vendor'];
        $trn_type  = $name['trn_type'];

        $query_exec2    = get_transaction_type_id($trn_type);
        $row2           = mysqli_fetch_assoc($query_exec2);
        $count_row2     = mysqli_num_rows($query_exec2);

        $date = date("d-m-Y H:i:s");
        $subject="DOC ISO Notification [".$row2['trn_name']."] from PT Dharma Polimetal (".$date.") [NO REPLY]";
        //$to=$email;
        //make email to is list

        $to = "";
        $mnu_obj      = "dociso";
        $query_to     = get_user_iso_mail($id_vendor, $mnu_obj);
        $count        = mysqli_num_rows($query_to);
        //$rowiso     = mysqli_fetch_assoc($query_iso);

        $x = 1;
        while($row_to = mysqli_fetch_assoc($query_to)){
            if($count > 1) {
                if ($count > $x) {
                    $separator = ',';
                } else {
                    $separator = '';
                }
            } else{
                $separator = '';
            }

            $to .= $row_to['username'] . $separator.' ';
            $x++;
        }
            
        $query_cc   = get_all_user_iso_mail($id_vendor, $mnu_obj);
        $count      = mysqli_num_rows($query_cc);
        //$row_cc     = mysqli_fetch_assoc($query_cc);

        //$message="From:$name <br />".$message;

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";

        // More headers
        $headers .= 'From: Eproc Center <eproc.center@dac.dharmap.com>'."\r\n"; //'Reply-To: '.$name.' <'.$email.'>'."\r\n"; //silahkan diganti dengan email pengirim
        $headers .= 'Cc: ';

        $x = 1;
        while($row_cc = mysqli_fetch_assoc($query_cc)){
            if($count > 1) {
                if ($count > $x) {
                    $separator = ',';
                } else {
                    $separator = '';
                }
            } else{
                $separator = '';
            }

            $headers .= $row_cc['username'] . $separator.' ';
            $x++;
        }

        $headers .="\r\n"; //untuk cc lebih dari satu tinggal kasih koma

        $headers .= 'Bcc: eProc <eproc.center@dac.dharmap.com>'."\r\n";

        $message = 'Dear <b>'.$nm_vendor.'</b>, <br><br>
    
                    <label>There is information about your ISO Document</label><br>
                    Your ISO Document now available online, please register and update your information.<br>
                    You will informed once your <b>ISO Document expire date upcoming or if any updates.</b><br><br>
                    Visit our website on the link below to get more information(s), here\'s the list:
                    ';

        $message .= '
                        <style>
                                    
                        table {
                            border-collapse: collapse;
                        }
                        
                        table, td, th {
                            border: 1px solid black;
                        }
                        
                        th {
                            background-color: #a89d1d;
                            color: white;
                        }

                        th, td {
                            padding: 5px;
                        }
                        
                        </style>

                    <h3>DOC ISO for PT. DHARMA POLIMETAL</h3>
                    
                    <table width="100%" style="border-collapse: collapse; border: 1; ">
                     <tr>
                        <th width="30px" align="left" style="background-color: #a89d1d; color: white;">No</th>
                        <th width="150px" align="left" style="background-color: #a89d1d; color: white;">Vendor Name</th>
                        <th width="70px" align="left" style="background-color: #a89d1d; color: white;">Simplikasi</th>
                        <th width="100px" align="left" style="background-color: #a89d1d; color: white;">Material Supply</th>
                        <th width="100px" align="left" style="background-color: #a89d1d; color: white;">Cert. Num</th>
                        <th width="100px" align="left" style="background-color: #a89d1d; color: white;">Cert. Date</th>
                        <th width="70px" align="left" style="background-color: #a89d1d; color: white;">Certified</th>
                        <th width="100px" align="left" style="background-color: #a89d1d; color: white;">ISO Type</th>
                        <th width="150px" align="left" style="background-color: #a89d1d; color: white;">Expired Date</th>
                        <th width="70px" align="left" style="background-color: #a89d1d; color: white;">Doc Status</th>
                        <th width="70px" align="left" style="background-color: #a89d1d; color: white;">Doc Process</th>
                     </tr>
                      ';
                
            $query_exec = get_all_iso_data_by_vendor_trn_id($id_vendor, $trn_id, $doc_year);

            $no = 1;
            while($row_data = mysqli_fetch_assoc($query_exec)){
               
                if($no % 2 == 0){
                    $color = "#EEEEEE";
                } else {
                    $color = "white";
                }

                
                $query_exec2 = get_transaction_type_id($row_data['stat']);
                $row2 = mysqli_fetch_assoc($query_exec2);
                $count = mysqli_num_rows($query_exec2);
                if ($count == 1) {
                    $color = 'label label-'.$row2['color'];
                    $stat = '<span class="'.$color.'">'.$row2['trn_name'].'</span>';
                    //$stat = '<span class="label label-success">Valid</span>';
                } else {
                    $stat = '<span class="label label-primary">'.$row2['trn_name'].'</span>';
                }

                $query_exec2    = get_transaction_type_id($trn_type);
                $row2           = mysqli_fetch_assoc($query_exec2);
                $count_row2     = mysqli_num_rows($query_exec2);
                if ($count_row2 == 1) {
                    $color = 'label label-'.$row2['color'];
                    $doc_proccess = '<span class="'.$color.'">'.$row2['trn_name'].'</span>';
                } else {
                    $doc_proccess = '<span class="label label-primary">'.$row2['trn_name'].'</span>';
                }
                

                $message .= '
                                <tr style="background-color: '.$color.' ">
                                    <td style="padding: 3px; ">' . $no . '</td>
                                    <td style="padding: 3px; ">' . $row_data['nm_vendor'] . '</td>
                                    <td style="padding: 3px; ">' . $row_data['simply'] . '</td>
                                    <td style="padding: 3px; ">' . $row_data['mat_supply'] . '</td>
                                    <td style="padding: 3px; ">' . $row_data['cert_num'] . '</td>
                                    <td style="padding: 3px; ">' . $row_data['cert_date'] . '</td>
                                    <td style="padding: 3px; ">' . $row_data['cert_name'] . '</td>
                                    <td style="padding: 3px; ">' . $row_data['iso_type_name'] . '</td>
                                    <td style="padding: 3px; ">' . $row_data['exp_date'] . '</td>
                                    <td style="padding: 3px; ">' . $stat . '</td>
                                    <td style="padding: 3px; ">' . $doc_proccess . '</td>
                                </tr>';  
                $no++;
            }

        $message .= '</table>';

        $message .= '<br>
                        <a href="http://eproc.dharmap.com:7777/eprocurement/" target="_blank" style="background-color: #a89d1d;
                            border: none;
                            color: white;
                            padding: 13px 30px;
                            text-align: center;
                            text-decoration: none;
                            display: inline-block;
                            font-size: 14px;
                            margin: 4px 2px;
                            cursor: pointer;"
                        >
                        Click here to download the Doc ISO
                        </a>
    				';
        $message .= '<br><br>Use your user access to login. If you can\'t, please contact our adminstrator to activate your account.';

        $message .= '<br><br><b>This message is sent by system, please don\'t reply.</b>';

        $message .= '   <br>
                        <br>Thanks,
                        <br>    
                        <br>Best regards,
                        <br>
                        <br><b><u>eProc Center</u></b>
                        <br>Procurement Division
                        <br>PT. Dharma Polimetal
                        <br><label>Kawasan Delta Silikon 1, Jalan Angsana Raya Blok A9 No 8</label>
                        <br>Lippo Cikarang, 17550
                        <br>Tlp.  : (021) 8974559
                        <br>Ext.  : 811/812
                        <br>Email : eproc.center@dac.dharmap.com
                        <br>Web   : http://eproc.dharmap.com:7777/eprocurement/
        ';

        @mail($to,$subject,$message,$headers);
        if(@mail) {
            $msg = 'success';
        } else {
            $msg = 'failed';
        }

        return $msg;
    }


    function mkdir_r($dirName, $rights=0777){

            $dirs = explode('/', $dirName);
            $dir='';
            foreach ($dirs as $part) {
                $dir.=$part.'/';
                if (!is_dir($dir) && strlen($dir)>0)
                mkdir($dir, $rights);
            }
    }

    function new_format_date($format, $date){
        $newdate= date($format, strtotime($date));

    return $newdate;
    }
    
?>