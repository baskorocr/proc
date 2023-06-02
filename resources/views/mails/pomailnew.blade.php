<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>PO</title>
         <style type="text/css">

        th {        
                 white-space:nowrap;
            }
        </style>
    </head>
    <body>
        Dear <b>{{@IsoHelper::get_vendor($po->id_vendor)->nm_vendor}}</b>, <br><br>
        
        <label>You have new Purchase Order</label><br>
        Our purchase order document now available online, just download it.<br>
        Download link will be temporary and active for <b>3 months from the document date.</b><br><br>
        Visit our website on the link below the list to get our PO document(s), here's the list:
        
        <br>
        <h3>PURCHASE ORDER From PT. DHARMA POLIMETAL</h3>
        
        <table width="100%"  class="table table-bordered"  style="border: 1; ">
            <tr>
                <th width="30px" align="left" style="background-color: #4CAF50; color: white;">No</th>
                <th width="70px" align="left" style="background-color: #4CAF50; color: white;">PO Number</th>
                <th width="70px" align="left" style="background-color: #4CAF50; color: white;">Plant</th>
                <th width="70px" align="left" style="background-color: #4CAF50; color: white;">Doc. Date</th>
                <th width="70px" align="left" style="background-color: #4CAF50; color: white;">Rev.</th>
                <th width="70px" align="left" style="background-color: #4CAF50; color: white;">File Ver.</th>
                <th width="150px" align="left" style="background-color: #4CAF50; color: white;">Vendor Name</th>
                <th width="40px" align="left" style="background-color: #4CAF50; color: white;">PGr</th>
                <th width="40px" align="left" style="background-color: #4CAF50; color: white;">Total Ammount with Tax</th>
                <th width="40px" align="left" style="background-color: #4CAF50; color: white;">Curr</th>
            </tr>
            <?php $i=1; ?>
            
            <tr>
                <td>{{$i}}</td>
                <td>{{$po->po_num}}</td>
                <td>{{$po->plant}}</td>
                <td>{{date('d.m.Y',strtotime($po->doc_date))}}</td>
                <td>{{$po->revno}}</td>
                <td>{{empty($po->file_nm) ? "-":$po->file_nm}}</td>
                <td>{{@IsoHelper::get_vendor($po->id_vendor)->nm_vendor}}</td>
                <td>{{$po->pgr}}</td>
                <td>{{number_format($po->tot_val,2)}}</td>
                <td>{{strtoupper($po->curr)}}</td>
            </tr>
  
        </table>
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
                Click here to download the PO
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