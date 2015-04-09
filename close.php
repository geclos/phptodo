<?php
	session_start();
	
	if (ini_get("session.use_cookies") == true) {
		$params = session_get_cookie_params();
		setcookie(session_name(), '', time() -99999, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
	}
	
	session_destroy();
	header("location: welcome.php");
?>
