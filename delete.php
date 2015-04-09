<?php
	session_start();
	$tableName = $_SESSION["name"];

	include 'data.php';
	include 'functions.php';

	$connection = connectAndSelect($host,$user,$password,$database);
	$id = $_POST["id"];
	$query = "DELETE FROM $tableName WHERE id='$id'";
	consult($connection,$query);
?>