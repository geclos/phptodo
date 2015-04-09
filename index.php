<?php
	include 'data.php';
	include 'functions.php';
	$connection = connectAndSelect($host,$user,$password,$database);

	// The browser has a session cookie stored. So we grab data from that cookie and restore the previous session.
	if (isset($_COOKIE["PHPSESSID"]) & !isset($_POST["name"]) & !isset($_POST["password"])) {
		session_id($_COOKIE["PHPSESSID"]);
		session_start();

	// The browser comes from welcome.php with a valid form
	} elseif (isset($_POST["name"]) & isset($_POST["password"])) {
		
		$userName = $_POST["name"];
		$userPsswd = $_POST["password"];

		//Look for a username that matches into the database
		$checkUser = "SELECT * FROM users WHERE name='$userName'";
		$userResult = consult($connection,$checkUser);
		$user = fetch($userResult);

		// Everything matches so we create a new session with data given.
		if ($user & ($user["password"] == $userPsswd)) {
			session_start();
			$_SESSION["name"] = $userName;
			$_SESSION["password"] = $userPsswd;

		// The user exist but the password is incorrect.
		} elseif ($user & ($user["password"] != $userPsswd)) {
			header("location: welcome.php?exist=1");

		// User don't exist, so we add it to the database and start a new session.
		} elseif (!$user) {
			session_start();
			$_SESSION["name"] = $userName;
			$_SESSION["password"] = $userPsswd;

			$insertQuery = "INSERT INTO users (id,name,password) VALUES (0,'$userName','$userPsswd')";
			insert($connection,$insertQuery);
		}
	//The browser come from anywhere with an invalid config
	} else {
		header("location:welcome.php");
	}

	//Check if session name is set in case PHPSESSID exist but without session's variables required
	if (isset($_SESSION["name"])) {
		$tableName = $_SESSION["name"];
		//Change to list's database
		select($connection,$database);
	}
?>	
<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<title>To do - <?php echo $tableName;?></title>
		<link rel="stylesheet" href="/css/bootstrap.min.css" type="text/css" media="screen">
		<link rel="stylesheet" type="text/css" href="/css/bootstrap-responsive.min.css">
		<link  rel="stylesheet" href="/css/main.css" type="text/css" media="screen">
	</head>
	
	<body>

		<header id="appHeader" class="clearfix">
				<h1 class="dropdown">Hola, <?php echo '<a href="app.php" class="dropdown-toggle" data-toggle="dropdown" data-target="#">' . $tableName . '</a>';?>
					<ul class="dropdown-menu pull-right" role="menu" aria-labelledby="drop3">
						<li><a id="logOut" tabindex="-1" href="close.php">Log Out</a></li>
					</ul>
			</nav>
		</header>

		<form method="POST" action="insert.php" id="the-form" class="form-inline">
			<div class="input-append">
				<input type="text" name="task" id="task" placeholder="Your task" autofocus />
				<button type="submit" name="submit" class="btn btn-primary" id="submit">Send</button>
			</div>
			<span class="help-block">Type a task to start your list.</span>
					<label class="checkbox">
					<input type="checkbox" name="urgent" id="urgent"> <span class="label label-info">Urgent</span>
					</label>
		</form>

		<ul id="my-list" class="clearfix">
			<?php

			//Check if table exist

			$checkTable = tableExist($connection,$database,$tableName);
			$itExist = fetch($checkTable);

			//Creates table if it doesn't exist
			
			if(!$itExist) {
				$createTable = "CREATE TABLE {$tableName} (
					id smallint(6) NOT NULL AUTO_INCREMENT PRIMARY KEY,
					task varchar(140) NOT NULL,
					urgent boolean NOT NULL
					) CHARACTER SET utf8 COLLATE utf8_spanish_ci";

				$created = mysql_query($createTable,$connection);

				if (!$created) {
					die("Database query failed: " . mysql_error());
				}

				$clickMe = "Click over this text to update it";
				$insertClickMe = "INSERT INTO $tableName (id,task,urgent) VALUES (0,'$clickMe',0)";
				insert($connection,$insertClickMe);
			}

			//Retrieves and displays table's results.

			$query = "SELECT * FROM {$tableName} ORDER BY id DESC";
			$result = consult($connection,$query);
			
			if ($result) {
				$array = fetch($result);
				while ($array) {
					if ($array["urgent"] == 1) {
						echo '<div class="clearfix"><li id="' . $array["id"] . '" class="text-error">' . $array["task"] . '</li>';
						echo '<button id="delete-' . $array["id"] . '" class="btn btn-small">Delete</button></div>';
					}else {
						echo '<div class="clearfix"><li id="' . $array["id"] . '">' . $array["task"] . '</li>';
						echo '<button id="delete-' . $array["id"] . '" class="btn btn-small">Delete</button></div>';
					}
					$array = fetch($result);
				}
			}
			?>
		</ul>

	</body>

	<script type="text/javascript" src="/js/jquery-1.8.2.min.js"></script>
	<script type="text/javascript" src="/js/main.js"></script>
	<script type="text/javascript" src="/js/bootstrap.min.js"></script>

</html>
