<?php
	require_once('config.php');
	
	// 连接dB
	$conn = mysql_connect($_hostname, $_username, $_password);
	mysql_select_db($_dbname, $conn);
	mysql_query("set names utf8");

?>