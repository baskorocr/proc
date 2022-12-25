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

function numbering_format($val){
    $num = number_format($val,0, '.', ',');
    return $num;
}


function autonum( $tabel, $kolom, $lebar, $ambil, $start, $id_data)
{
    $conn=mysqli_connect("localhost","remote","lact0bas1lus") or die(mysqli_error($conn));
    mysqli_select_db("purch_proc");
    unset($hasil);
    unset($query);
    $query="select $kolom from $tabel order by $kolom desc limit 1";
    $hasil=mysqli_query($conn,$query) or die(mysqli_error($conn));
    $jumlahrecord = mysqli_num_rows($hasil);

    //$row[0] ='DN1772120181189999';
    if($jumlahrecord == 0)
        $nomor=$start;
    else
    {
        $row=mysql_fetch_array($hasil);
        $nomor=intval(substr($row[0],$ambil))+1;
    }
    if($lebar>0)
        $angka = $id_data.str_pad($nomor,$lebar,"0",STR_PAD_LEFT);
    else
        $angka = substr($nomor);
    return $angka;
}

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
    $headers .= 'From: Hidrian <hidrian.suharman@dp.dharmap.com>'."\r\n"; //'Reply-To: '.$name.' <'.$email.'>'."\r\n"; //silahkan diganti dengan email pengirim
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

    $query_exec = get_max_po_apprv_data_by_idvendor($id_vendor);

    $message = '
					
                
                <label>You have new Purchase Order</label><br>
                Our purchase order document now available online, just download it.<br>
                Download link will be temporary and active for <b>3 months from the document date.</b><br><br>
                Visit our website on the link below the list to get our PO document(s), here\'s the list:
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
                        background-color: #4CAF50;
                        color: white;
                    }

                    th, td {
                        padding: 5px;
                    }
                    
                    
                </style>
                <h3>PURCHASE ORDER From PT. DHARMA POLIMETAL</h3>
                
                <table width="100%">
                 <tr>
                    <th width="30px" align="left">No</th>
                    <th width="70px" align="left">PO Number</th>
                    <th width="70px" align="left">Plant</th>
                    <th width="70px" align="left">Doc. Date</th>
                    <th width="150px" align="left">Vendor Name</th>
                    <th width="40px" align="left">PGr</th>
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


        //if ($row_data['id_vendor'] == '211445') {
            $message .= '
                                        <tr style="background-color: '.$color.' ">
                                            <td>' . $no . '</td>
                                            <td>' . $row_data['po_num'] . '</td>
                                            <td>' . $row_data['plant'] . '</td>
                                            <td>' . $doc_date . '</td>
                                            <td>' . $row_data['nm_vendor'] . '</td>
                                            <td>' . $row_data['pgr'] . '</td>
                                        </tr>';
        //}

        $no++;
    }

    $message .= '</table>';

    $message .= '<br><a href="eproc.dharmap.com:7777/eprocurement/">Click here to download the PO </a>';
    $message .= '<br><br>Use your user access to login. If you can\'t, please contact our adminstrator to activate your account.';

    $message .= '<br><br><b>This message is sent by system, please don\'t reply.</b>';

    $message .= '   <br>
                    <br>Thanks,
                    <br>    
                    <br>Best regards,
                    <br>
                    <br><b><u>Hidrian Oma Suharman</u></b>
                    <br>IT Development
                    <br>PT. Dharma Polimetal
                    <br><label>Kawasan Delta Silikon 1, Jl. Angsana Raya Blok A9 No. 8</label>
                    <br>Lippo Cikarang, 17550
                    <br>Tlp.      : (021) 8974559
                    <br>Ext.      : 332
                    <br>Mobile : +6289 506 720 928
                    <br>Email   : sap@dp.dharmap.com
                    <br>Email   : hidrian.suharman@dp.dharmap.com
    ';

    @mail($to,$subject,$message,$headers);
    if(@mail) {
        $msg = 'success';
    } else {
        $msg = 'failed';
    }

    return $msg;
}

function mailtovendor($name){

    //$name="hidrian.suharman@dp.dharmap.com";
    //$email="hidrian.suharman@dp.dharmap.com";
    $email = $name;
    $date = date("d-m-Y H:i:s");
    $subject="New PO from PT Dharma Polimetal (".$date.") [NO REPLY]";
    $to=$email;

    //$message="From:$name <br />".$message;

    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";

    // More headers
    $headers .= 'From: Hidrian <hidrian.suharman@dp.dharmap.com>'."\r\n" . 'Reply-To: '.$name.' <'.$email.'>'."\r\n"; //silahkan diganti dengan email pengirim
    $headers .= 'Cc: hidrian.os@gmail.com, hidrian.suharman@dp.dharmap.com;' . "\r\n"; //untuk cc lebih dari satu tinggal kasih koma

    $query_exec = get_max_po_apprv_data();

    $message = '
                <h2>PURCHASE ORDER from PT. DHARMA POLIMETAL</h2>
                
                <label>You have new Purchase Order</label><br>
                Our purchase order document now available online, just download it.<br>
                Download link will be temporary and active for <b>3 months from the document date </b>.<br><br>
                Download here to get our PO document(s):
                ';

    $message .= '<br><a href="localhost/eprocurement">Click here to download the PO </a>';
    $message .= '<br><br>Use your user access to login. If you can\'t, please contact our adminstrator to active your account.';

    $message .= '<br><br><b>This message is sent by system, please don\'t reply.</b>';

    $message .= '   <br>
                    <br>Thanks,
                    <br>    
                    <br>Best regards,
                    <br>
                    <br><b><u>Hidrian Oma Suharman</u></b>
                    <br>IT Development
                    <br>PT. Dharma Polimetal
                    <br><label>Kawasan Delta Silikon 1, Jl. Angsana Raya Blok A9 No. 8</label>
                    <br>Lippo Cikarang, 17550
                    <br>Tlp.      : (021) 8974559
                    <br>Ext.      : 332
                    <br>Mobile : +6289 506 720 928
                    <br>Email   : sap@dp.dharmap.com
                    <br>Email   : hidrian.suharman@dp.dharmap.com
    ';

    @mail($to,$subject,$message,$headers);
    if(@mail) {
        $msg = 'success';
    } else {
        $msg = 'failed';
    }

    return $msg;
}


function get_pdf(){

    //$dir1 = "\\\\sysdata2\\POPDF\\PROC";
	$dir1 = "D:\\\\POPDF\\PRD-PROC";
    $file = $dir1."\\1225003684-20180716-115530.pdf";
    $filename = "1225003684-20180716-115530.pdf";
    opendir($dir1);
    fopen($file, "rw");

    header('Content-type: application/pdf');
    header('Content-Disposition: inline; filename="' . $filename . '"');
    header('Content-Transfer-Encoding: binary');
    header('Content-Length: ' . filesize($file));
    header('Accept-Ranges: bytes');

    @readfile($file);
}


function getdatapo($nopo){

    //$dir1 = "\\\\sysdata2\\POPDF\\PROC";
	$dir1 = "D:\\\\POPDF\\PRD-PROC";

    $no = 1;
    $files = array();
    $dir_iterator = new RecursiveDirectoryIterator($dir1);
    $iterator = new RecursiveIteratorIterator($dir_iterator, RecursiveIteratorIterator::SELF_FIRST);

    foreach ($iterator as $file) {

        $string = explode(".", $file);
        if(count($string) > 1) {
            $data = $string[1];
        }

        $filestr = explode("\\", $string[0]);

        //$pdffilenm = $filestr[5];
		$pdffilenm = $filestr[4];
        $pdfstring  = explode("-", $pdffilenm);
        if(count($pdfstring) > 1) {
            $pdfnamepo = $pdfstring[0];
            $pdfdatepo = $pdfstring[1];
            $pdftimepo = $pdfstring[2];
        }

        $mtime = date("d-m-Y H:i:s", filemtime($file));

        $myfile = str_replace($dir1.'\\',"",$file);

        if ($data == "pdf" and $pdfnamepo == $nopo) {

            array_push($files, $pdffilenm."_".$mtime);
            $no++;

        }//  if ($data == "pdf")

    }//foreach ($iterator as $file)

    return $files;
}


function getlatestdata($po){

    $poarr = array();

    //loop po
    $data1 = getdatapo($po);
    $count = count($data1);
    for($x =0; $x < $count; $x++){

        $stringpo = explode("_", $data1[$x]);
        if(count($stringpo) > 1) {
            $datapo = $stringpo[1];
        }

        array_push($poarr, $datapo);

    }

    //get latest
    $dates = $poarr;
    $mostRecent= 0;
    $fidx = 0;
    foreach($dates as $date){
        $curDate = strtotime($date);
        if ($curDate > $mostRecent) {
            $mostRecent = $curDate;
            $fidx++;
        }
    }

    return $fidx-1;
}


function getfileponame($po){


    $datas = getdatapo($po);
    $countdata = count($datas);

    $mostRecent = getlatestdata($po);
    $n = 1;


    for($i =0; $i < $countdata; $i++){

        $pdfstr  = explode("_", $datas[$i]);
        if(count($pdfstr) > 1) {
            $pdfponame = $pdfstr[0];
        }

        if($i == $mostRecent) {
            $filename  = $pdfponame;
        }
        $n++;
    }

    return $filename;

}

//////////////////////////////////////////////////////////////////////
//PARA: Date Should In YYYY-MM-DD Format
//RESULT FORMAT:
// '%y Year %m Month %d Day %h Hours %i Minute %s Seconds'        =>  1 Year 3 Month 14 Day 11 Hours 49 Minute 36 Seconds
// '%y Year %m Month %d Day'                                    =>  1 Year 3 Month 14 Days
// '%m Month %d Day'                                            =>  3 Month 14 Day
// '%d Day %h Hours'                                            =>  14 Day 11 Hours
// '%d Day'                                                        =>  14 Days
// '%h Hours %i Minute %s Seconds'                                =>  11 Hours 49 Minute 36 Seconds
// '%i Minute %s Seconds'                                        =>  49 Minute 36 Seconds
// '%h Hours                                                    =>  11 Hours
// '%a Days                                                        =>  468 Days
//////////////////////////////////////////////////////////////////////

function dateDifference($date_1 , $date_2 , $differenceFormat = '%m' )
{
    $datetime1 = date_create($date_1);
    $datetime2 = date_create($date_2);

    $interval = date_diff($datetime1, $datetime2);

    return $interval->format($differenceFormat);

}