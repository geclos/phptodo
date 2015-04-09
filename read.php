<?php
	session_start();
	$tableName = $_SESSION["name"];

	include 'data.php';
	include 'functions.php';


	if (isset($_POST["task"])) {
		$task = $_POST["task"];
		$connection = connectAndSelect($host,$user,$password,$database);

		$query = "SELECT * FROM $tableName WHERE task='$task'";
		$result = consult($connection,$query);

		$row = fetch($result);

		$id = $row['id'];
		$task = $row['task'];
		$urgent = $row['urgent'];

		if ($urgent == 1) {
			echo '<div class="clearfix"><li id="' . $id . '" class="text-error">' . $task . '</li>';
			echo '<button id="delete-' . $id . '" class="btn btn-small">Delete</button></div>';
		} else {
			echo '<div class="clearfix"><li id="' . $id . '">' . $task . '</li>';
			echo '<button id="delete-' . $id . '" class="btn btn-small">Delete</button></div>';
		}
	} else {
		die('Empty tasks are not allowed');
	}
?>