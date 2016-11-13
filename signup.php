<?php
	session_start();
?>

<html>
	<title>Jot Record: A Collaborative Checklist Platform</title>
	
	<head>
		<link href="styles/style.css" type="text/css" rel="stylesheet">
		<link rel="icon" type="image/png" href="favicon.ico">
	</head>

	<body>
		<?php include_once('templates/header.php')?>
		
		<div id="content">
			<form id="signup_form" name="signup_form" action="handlers/user_handler.php" method="POST">
				<label for="email">Email Address:</label><br />
				<input id="email" type="text" name="signup-email" placeholder="your@email.com">
				<?= get_error("email") ?>

				<br />
				<label for="password">Password: </label><br />
				<input id="password"type="password" name="signup-password" placeholder="password">
				<br />
				<small>Must contain at least 6 characters</small>
				<br />
				<label for="conf_password">Confirm Password:</label><br />
				<input id="conf_password"type="password" name="confirm-signup-password" placeholder="password">
				
				<br />
				
				<input type="submit" name="create-account" value="Create">
				
			</form>
		</div>
		<footer>
			<p>Copyright &copy; 2016 Jesse Doty. All Rights Reserved.</p>
		</footer>
    </body>
</html>

<?php
function get_error($error_name) {
	if(isset($_SESSION['errors'][$error_name])) { ?>
		return "<span class="error"><?= $_SESSION['errors'][$error_name] ?></span>";
		<?php
	}
}
?>