<?php
	session_start();
	$tableName = $_SESSION["name"];
	
	include('data.php');
	include('functions.php');

	$connection = connectAndSelect($host,$user,$password,$database);
	if (isset($_POST['task'])) {
		$task = $_POST['task'];
		if (isset($_POST['urgent'])) {
			$query = "INSERT INTO $tableName (id,task,urgent) VALUES (0,'$task',1)";
		} else if (!isset($_POST['urgent'])) {
			$query = "INSERT INTO $tableName (id,task,urgent) VALUES (0,'$task',0)";
		}
		insert($connection,$query);
	} else {
		die("Empty tasks are not allowed");
	}

?>