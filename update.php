<?php
	session_start();
	$tableName = $_SESSION["name"];

	include('data.php');
	include('functions.php');

	$connection = connectAndSelect($host,$user,$password,$database);
	if (isset($_POST["update"]) & isset($_POST["id"])) {
		$task = $_POST["update"];
		$id = $_POST["id"];
		
		//Update task
		$query = "UPDATE $tableName SET task='$task' WHERE id='$id'";
		insert($connection,$query);

		//Get the updated task from database
		$newQuery = "SELECT task FROM $tableName WHERE id='$id'";
		$result = consult($connection,$newQuery);

		//fetch and display new Task
		$row = fetch($result);
		echo $row["task"];
	}
?>