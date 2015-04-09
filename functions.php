<?php

//Functions used within other functions to get the job done. Skip it.

function connect($host,$user,$password) {
		
	$connection = mysql_connect($host,$user,$password);
	if (!$connection) {
		die("database connection error " . mysql_error());
	};
	
	return $connection;
};

function select($connection,$database) {
	
	$db_select = mysql_select_db($database,$connection);
	if (!$db_select) {
		die("database selection failed: " . mysql_error());
	};
	
	return $db_select;
};

//Here's where the fun happens.

//Connects to host and selects the database.
	
function connectAndSelect($host,$user,$password,$database) {
	$connection = connect($host,$user,$password);
	select($connection,$database);
	
	return $connection;
}

//Query to retrieve content from a table

function consult($connection,$query) {

	$result = mysql_query($query,$connection);
	if (!$result) {
		die("Database query failed: " . mysql_error());
	};
	
	return $result;
};

//Query to insert content to a table.

function insert($connection,$query) {
	
		mysql_query("SET NAMES 'utf8_spanish_ci'", $connection);
		mysql_query($query,$connection);
}

//Creates one single row with a row from the table retrieved in $result. 
//It works only one row at a time and row ids are the ones on the table from the database.

function fetch($result) {
	
	$row = mysql_fetch_array($result);
	
	return $row;
}

//Check if a table exist within a database given

function tableExist($connection,$database,$tableName) {
	
	$query = "SELECT table_name
	FROM information_schema.tables
	WHERE table_schema = '$database'
	AND table_name = '$tableName'";

	$result = consult($connection,$query);
	
	return $result;
}
?>