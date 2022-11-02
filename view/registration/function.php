<?php
/**
 * Copyright (c) 2018. Don't copy or use the source code without author permission for comercial purpose(s)
 */

/**
 * Created by PhpStorm.
 * User: USER
 * Date: 19/07/2018
 * Time: 13:53
 */



function mailtovendordetail($name){

    //$name="hidrian.suharman@dp.dharmap.com";
    //$email="hidrian.suharman@dp.dharmap.com";
    $email = $name['email'];
    $date = date("d-m-Y H:i:s");
    $subject="PO from PT Dharma Polimetal (".$date.") [NO REPLY]";
    $to=$email;

    $id_vendor = $name['id_vendor'];
    $nm_vendor = $name['nm_vendor'];

    //$message="From:$name <br />".$message;

    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";

    $query = get_mails();
    $x = 1;
    $count = mysqli_num_rows($query);

    // More headers
    $headers .= 'From: Eproc Center <eproc.center@dac.dharmap.com>'."\r\n"; //'Reply-To: '.$name.' <'.$email.'>'."\r\n"; //silahkan diganti dengan email pengirim
    $headers .= 'Cc: ';

    while($row = mysqli_fetch_assoc($query)){
        if($count > 1) {
            if ($count > $x) {
                $separator = ',';
            } else {
                $separator = '';
            }
        } else{
            $separator = '';
        }

        $headers .= $row['mail'] . $separator.' ';
        $x++;
    }

    $headers .="\r\n"; //untuk cc lebih dari satu tinggal kasih koma
    
    $headers .= 'Bcc: eProc <eproc.center@dac.dharmap.com>'."\r\n";

    $query_exec = get_max_po_apprv_data_by_idvendor($id_vendor);

    $message = '
					
                <label>You have new Purchase Order</label><br>
                Our purchase order document now available online, just download it.<br>
                Download link will be temporary and active for <b>3 months from the document date.</b><br><br>
                Visit our website on the link below the list to get our PO document(s), here\'s the list:
                ';

    $message .= '
               
                <h3>PURCHASE ORDER From PT. DHARMA POLIMETAL</h3>
                
                <table width="100%" style="border-collapse: collapse; border: 1px; ">
                 <tr>
                    <th width="30px" align="left" style="background-color: #4CAF50; color: white;">No</th>
                    <th width="70px" align="left" style="background-color: #4CAF50; color: white;">PO Number</th>
                    <th width="70px" align="left" style="background-color: #4CAF50; color: white;">Plant</th>
                    <th width="70px" align="left" style="background-color: #4CAF50; color: white;">Doc. Date</th>
                    <th width="150px" align="left" style="background-color: #4CAF50; color: white;">Vendor Name</th>
                    <th width="40px" align="left" style="background-color: #4CAF50; color: white;">PGr</th>
                 </tr>
                  ';

    $no = 1;
    while($row_data = mysqli_fetch_assoc($query_exec)){

        if($no % 2 == 0){
            $color = "#EEEEEE";
        } else {
            $color = "white";
        }


        $dateformat = strtotime($row_data['doc_date']);
        $doc_date = date("d.m.Y", $dateformat);

        


            $message .= '
                            <tr style="background-color: '.$color.' ">
                                <td style="padding: 3px;">' . $no . '</td>
                                <td style="padding: 3px;">' . $row_data['po_num'] . '</td>
                                <td style="padding: 3px;">' . $row_data['plant'] . '</td>
                                <td style="padding: 3px;">' . $doc_date . '</td>
                                <td style="padding: 3px;">' . $row_data['nm_vendor'] . '</td>
                                <td style="padding: 3px;">' . $row_data['pgr'] . '</td>
                            </tr>';

        $no++;
    }

    $message .= '</table>';

    $message .= '<br>
                    <a href="http://eproc.dharmap.com:7777/" target="_blank" style="background-color: #4CAF50;
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
                    Click here to download the PO
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
                    <br>Web   : http://eproc.dharmap.com:7777/
    ';

    @mail($to,$subject,$message,$headers);
    if(@mail) {
        $msg = 'success';
    } else {
        $msg = 'failed';
    }

    return $msg;
}

function randomPassword() {
    //$alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789@!*&^%";
	$alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

