<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Reset Password</title>
    </head>
    <body>
        Dear <b>{{$nm_vendor}}</b>, <br><br>
        Your credential to eProc Dharma Polimetal portal
        has been changed with following detail:
        <br>
        <br>
        Username : <b>{{$email}}</b><br>
        Password : <b>{{$password}}</b>
        <br><br>
        Please change password as soon as you reach our website. <br>
        <br>
        <a href="{{url('/')}}" target="_blank" style="background-color: #4CAF50;
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
        <br><br>Use your user access to login. If you can\'t, please contact our adminstrator to activate your account.
        <br><br><b>This message is sent by system, please don\'t reply.</b>
        <br>
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
        <br>Email : <a href="mail:eproc.center@dac.dharmap.com">eproc.center@dac.dharmap.com</a>
        <br>Web   : <a href="{{url('/')}}">{{url('/')}}</a>
    </body>
</html>