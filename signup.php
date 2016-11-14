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
			<form id="signup_form" name="signup_form" action="handlers/new_user.php" method="POST">
				<label for="email">Email Address:</label><br />
				<input id="email" type="text" name="signup-email" placeholder="your@email.com"
					<?php
						if(isset($_SESSION['presets']['email'])) {
							echo "value=\"" . $_SESSION['presets']['email'] . "\"";
						}
					?>
				>
				<?= get_error("email") ?>

				<br />
				<label for="password">Password: </label><br />
				<input id="password"type="password" name="signup-password" placeholder="password">
				<?= get_error("password") ?>
				<br />
				<small>Must contain at least 6 characters</small>
				<br />
				<label for="conf_password">Confirm Password:</label><br />
				<input id="conf_password"type="password" name="confirm-signup-password" placeholder="password">
				
				<br />
				
				<input type="submit" name="create-account" value="Create">
				
			</form>
		</div>

		<?php include_once('templates/footer.php')?>
    </body>
</html>


<?php
/*
 * Template for validation errors
 */
function get_error($error_name) {
	if(isset($_SESSION['errors'][$error_name])) { ?>
		<span class="error"><?= $_SESSION['errors'][$error_name] ?></span>
		<?php
	}
}
?>