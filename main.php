<?php
session_start();
if(!$_SESSION['access']) {
	header("Location: index.php");
}
?>

<html>
	<title>Jot Record: A Collaborative Checklist Platform</title>
	
	<head>
		<link href="styles/style.css" type="text/css" rel="stylesheet">
		<link href="styles/main.css" type="text/css" rel="stylesheet">
		<link rel="icon" type="image/png" href="favicon.ico">
	</head>

	<body>
		<?php include_once('templates/header.php')?>
		
		<div id="content">
        <p>Welcome <?= $_SESSION['user'] ?>!</p>
			<div id="list_menu">
				<div id="list_title">
					<p>List Title (Permissions)</p>
				</div>
				<div id="share_options">
					<button id="add_person" type="button">Add Person</button>
					<button id="remove_person type="button">Remove Person</button>
				</div>
			</div>
			<div id="list_content">
				<div id="tabs">
					<ul>
						<li><form><input type="submit" name="list_tab" value="List 1"></form></li>
						<li><form><input type="submit" name="list_tab" value="List 2"></form></li>
						<li><form><input type="submit" name="new_list" value="New List"></form></li>
					</ul>
				</div>
				<div id="list_container">
					<form id="items">
						<input type="checkbox" name="item" value="Item 1"><p>Item 1</p>
						<input type="checkbox" name="item" value="Item 2"><p>Item 2</p>
						<input type="submit" name="new_item" value="New Item">
					</form>
				</div>
			</div>
		</div>

		<?php include_once('templates/footer.php')?>
</html>