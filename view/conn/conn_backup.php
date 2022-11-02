<?php
	function get_connection()
	{
        $config = parse_ini_file('config.ini');
        //$conn=mysql_connect("localhost","root","") or die(mysql_error());
		//mysql_select_db("dp_eproc");
        $conn=mysql_connect($config['server'],$config['username'],$config['password']) or die(mysql_error());
        mysql_select_db($config['dbname']);
		return $conn;
	}
?>