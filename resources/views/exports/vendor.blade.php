<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Eproc Dharma Polimetal</title>
</head>
<body>
<table border="1">
	<tr><td colspan="19" align="center">eProc Dharma Polimetal</tr>
	<tr>
		<td>#</td>
		<td >ID Vendor</td>
		<td >Purch Org</td>
		<td >Vendor Name</td>
		<td >Email</td>
		<td >Alias</td>
		<td >Street</td>
		<td >District</td>
		<td >Post Code</td>
		<td >City</td>
		<td >Country</td>
		<td >Region</td>
		<td >Phone 1</td>
		<td >Vat Reg</td>
		<td >Order Curr</td>
		<td >Pay Term</td>
		<td >Sales Person</td>
		<td >Phone 2</td>
		<td >Status</td>
	</tr>
@foreach($vendors as $key => $data)
<?php  
	if($data->status_vendor == "A")
	{
	   
	    $status = "Active";
	} elseif($data->status_vendor=='N') {
	    $status = "Non-Active";
	} else{
	    $status = "N/A";
	}
	?>
	<tr>
		<td>{{$key+=1}}</td>
		<td>{{$data->id_vendor}}</td>
		<td>{{$data->purch_org}}</td>
		<td>{{$data->nm_vendor}}</td>
		<td>{{$data->vend_email}}</td>
		<td>{{$data->allias}}</td>
		<td>{{$data->street}}</td>
		<td>{{$data->district}}</td>
		<td>{{$data->postal_code}}</td>
		<td>{{$data->city}}</td>
		<td>{{$data->country}}</td>
		<td>{{$data->region}}</td>
		<td>{{$data->phone_1}}</td>
		<td>{{$data->vat_reg}}</td>
		<td>{{$data->order_curr}}</td>
		<td>{{$data->pay_term}}</td>
		<td>{{$data->sales_person}}</td>
		<td>{{$data->phone_2}}</td>
		<td>{{$status}}</td>
	</tr>
@endforeach
</table>
</body>
</html>