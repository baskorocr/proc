<?php
/**
 * Copyright (c) 2018. Don't copy or use the source code without author permission for comercial purpose(s)
 */

    function get_connection_proc()
	{
        $config = parse_ini_file('config.ini');

        $conn=mysqli_connect($config['server'],$config['username'],$config['password']) or die(mysqli_error($conn));
        mysqli_select_db($conn,'purch_proc');
		return $conn;
	}
?>