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



function mailresetpwd($name){

    //$name="hidrian.suharman@dp.dharmap.com";
    //$email="hidrian.suharman@dp.dharmap.com";
    $email = $name['email'];
    $date = date("d-m-Y H:i:s");
    $subject="User Password Reset - eProc PT Dharma Polimetal (".$date.") [NO REPLY]";
    $to=$email;

    //$id_vendor = $name['id_vendor'];
    $nm_vendor = $name['nm_vendor'];
    $passwd    = $name['passwd'];

    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";

    // More headers
    $headers .= 'From: Eproc Center <eproc.center@dac.dharmap.com>'."\r\n"; //'Reply-To: '.$name.' <'.$email.'>'."\r\n"; //silahkan diganti dengan email pengirim
    $headers .= 'Bcc: eProc <eproc.center@dac.dharmap.com>'."\r\n";

    $message = ' Dear <b>'.$nm_vendor.'</b>, <br><br>
					
                Your credential to eProc Dharma Polimetal portal
                has been changed with following detail:
                <br>
				
				Username : <b>'.$email.'</b>
                Password : <b>'.$passwd.'</b>
                <br><br>

                Please change password as soon as you reach our website. <br>
            
                ';


    $message .= '<br>
                <a href="http://eproc.dharmap.com:7777/eprocurement/" target="_blank" style="background-color: #4CAF50;
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
                Click here to Login
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