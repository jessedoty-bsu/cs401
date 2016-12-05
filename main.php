<?php
session_start();
if(!$_SESSION['access']) {
	header("Location: index.php");
}
require_once $_SERVER['DOCUMENT_ROOT'] . "/handlers/list.php";

$listObj = new CheckList($_SESSION['user']);
$lists = $listObj->getAllLists();
$currentList = $lists ? $lists[0] : false;
?>

<html>
	<title>Jot Record: A Collaborative Checklist Platform</title>
	
	<head>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js" type="text/javascript"></script>
		<script src="scripts/ajax.js" type="text/javascript"></script>
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
					<p><?php $currentList['title'] ?></p>
				</div>
				<div id="share_options">
                    <?php $shareButtons = $currentList ? "" : "disabled"; ?>
					<button id="add_person" type="button" <?php echo $shareButtons ?>>Add Person</button>
					<button id="remove_person type="button" <?php echo $shareButtons ?>>Remove Person</button>
				</div>
			</div>
			<div id="list_content">
				<div id="list_tabs">
					<ul id="list_ul">
                        <?php
							foreach($lists as $list) {
								echo "<li><button id=\"". $list['title'] ."\" onclick=\"switchToList(this.id)\">".$list['title']."</button></li>";
							}
						?>
						<li><button id="new_list" onclick="newList()">Create List</button></li>
					</ul>
				</div>
				<div id="list_container">
					<form id="items">
					<?php
					if(!$currentList) {
						echo "You have not made any checklists.";
					} else { ?>
                        <ul id="item_ul">
						<li><input id="list_id" type="hidden" value=<?php echo "\"".$currentList['list_id']."\"" ?>></li>
						<?php
                        	$items = $listObj->getListItems($currentList['list_id']);
							$i = 1;
							foreach($items as $item) {
								$checked = $item["checked"] ? "checked" : "";
								echo "<li><input id=\"item".$i."\" type=\"checkbox\" name=\"item\" ". $checked ."><label for=\"item".$i."\">". $item["content"] ."</label></li>";
								$i++;
							}
						?>
							<li><button onclick="newItem()">Create Item</button></li>
						</ul>
					<?php } ?>
					</form>
				</div>
			</div>
		</div>

		<?php include_once('templates/footer.php')?>
</html>