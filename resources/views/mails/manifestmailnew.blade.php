<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>MF</title>
    </head>
    <body>
        Dear <b>{{$vendor->nm_vendor}}</b>, <br><br>
        
       You have new Manifest Order.<br>
       Out Manifest Instruction document now available online, just download it.<br>
       Visit our website on the link below the list to get our Manifest Order, here's the list:
        
        <br>
        <h3>Manifest Order from PT. DHARMA POLIMETAL</h3>
        
        <table width="100%" style=" ">
            <tr>
                <th width="30px" align="left" style="background-color: #00008b; color: white;">No</th>
                <th width="70px" align="left" style="background-color: #00008b; color: white;">MI Date</th>
                <th width="70px" align="left" style="background-color: #00008b; color: white;">MI Number</th>
                <th width="70px" align="left" style="background-color: #00008b; color: white;">Delivery Date</th>
                <th width="70px" align="left" style="background-color: #00008b; color: white;">Vendor Name</th>
                <th width="70px" align="left" style="background-color: #00008b; color: white;">PO Number</th>
                <th width="150px" align="left" style="background-color: #00008b; color: white;">Plant</th>
            </tr>
            <?php $i=1; ?>
            <tr>
                <td>1</td>
                <td>{{date("d.m.Y",strtotime($manifest->release_date))}}</td>
                <td>{{$manifest->manifest}}</td>
                <td>{{date("d.m.Y",strtotime($manifest->delivery_date))}}</td>
                <td>{{@$manifest->vendors->nm_vendor}}</td>
                <td>{{$manifest->po_num}}</td>
                <td>{{@$manifest->po->plant}}</td>
            </tr>
        </table>
            <br>
            <a href="{{url('/')}}" target="_blank" style="background-color: #00008b;
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
                Click here to download the Manifest Order
            </a>
            <br><br>Use your user access to login. If you can't, please contact our adminstrator to activate your account.
            <br><br><b>This message is sent by system, please don't reply.</b>
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
            <br>Email : eproc.center@dac.dharmap.com
          <br>Web   : <a href="{{url('/')}}">{{url('/')}}</a>
    
    </body>
</html>