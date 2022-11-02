<?php
	//require_once '../vendor/autoload.php';
	
	function get_connectionxxx()
	{
        $client = new MongoDB\Client("mongodb://localhost:27017");
		//$collection = $client->demo->beers;
		return $client;
	}
	
	function get_connection()
	{
        $config = parse_ini_file('config.ini');
        //$conn=mysql_connect("localhost","root","") or die(mysql_error());
		//mysql_select_db("dp_eproc");
        $conn=mysqli_connect($config['server'],$config['username'],$config['password']) or die(mysqli_error($conn));
        mysqli_select_db($conn,$config['dbname']);
		return $conn;
	}
?>