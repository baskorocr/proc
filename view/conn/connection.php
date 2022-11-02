<?php
	function get_connection()
	{
		$conn=mysqli_connect("localhost","remote","lact0bas1lus") or die(mysqli_error($conn));
		mysqli_select_db($conn,"eproc");
		return $conn;
	}
?>