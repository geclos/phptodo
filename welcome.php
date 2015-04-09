<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>To do - Welcome</title>
		<link rel="stylesheet" href="/css/bootstrap.min.css" type="text/css" media="screen">
		<link rel="stylesheet" type="text/css" href="/css/bootstrap-responsive.min.css" media="screen">
		<link  rel="stylesheet" href="/css/main.css" type="text/css" media="screen">
	</head>
	<body>
		
		<header id="loginHeader">
			<h1>Welcome!</h1>
			<h2>Write your name to start a session</h2>
			<p>Please note that this is a simple personal project to test my abilities with PHP, MySQL and Javascript/AJAX. This web app is not intended for commercial use. However, feel free to play with it :)</p>
		</header>
		
		<?php 
			if(isset($_GET["exist"]) & $_GET["exist"] == 1){
				$alert = '<section id="alertSection" class="alertSection"><article class="alertArticle"><p><span class="negrita">Please re-enter your password</span></p><p>Either the password you entered was incorrect or your user name has already been chosen. Please, fix it.</p></article></section>';
				echo $alert;
			}
		?>	

		<section id="loginSection">
			<form id="loginForm" method="POST" action="index.php" class="form-horizontal">
				<div class="control-group">
					<label class="control-label">Name</label>
					<div class="controls">	
						<input type="text" name="name" id="name" autofocus required placeholder="Your name"/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Password</label>
					<div class="controls">
						<input type="password" name="password" id="password" required placeholder="Your password">
					</div>
				</div>
				<div class="control-group">
					<div class="controls"><button type="submit" id="submitLogin	" class="btn btn-primary">Enter</button></div>
				</div>
			</form>
		</section>
	</body>
</html>
