<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Eproc Dharma Polimetal</title>
</head>
<body>
<table border="1">
	<tr><td colspan="7" align="center">eProc Dharma Polimetal</tr>
	<tr>
		<td>#</td>
		<td>ID User</td>
		<td>Nama  User</td>
		<td>Tipe User</td>
		<td>Login Username</td>
		<td>Role</td>
		<td>Status</td>
	</tr>
@foreach($users as $key => $data)
	<?php  
	if($data->status_user == "A")
	{
	   
	    $status = "Active";
	} elseif($data->status_user=='N') {
	    $status = "Non-Active";
	} else{
	    $status = "N/A";
	}
	?>
	<tr>
		<td>{{$key+=1}}</td>
		<td>{{$data->id_user}}</td>
		<td>{{ @$data->nm_user."".(!$data->is_vendor?'|Internal User':'|External User')}}</td>
		<td>{{@$data->tipeUser->nm_tipe_user."|".(empty($data->roles)?@$data->access_group->access_group_name:$data->roles->name).""}}</td>
		<td>{{$data->username}}</td>
		<td>{{$data->role}}</td>
		<td>{{$status}}</td>
	</tr>
@endforeach
</table>
</body>
</html>