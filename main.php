<?php
session_start();
if(!$_SESSION['access']) {
	header("Location: index.php");
}
require_once $_SERVER['DOCUMENT_ROOT'] . "/dao.php";

$user = $_SESSION['user'];
$dao = new Dao();
$lists = $dao->getAllLists($user);
$_SESSION['lists'] = $lists;

if(!isset($_SESSION['currentList'])) {
	$_SESSION['currentList'] = $lists ? $lists[0] : false;
}
$currentList = $_SESSION['currentList'];
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
        <p>Welcome <?= $user ?>!</p>
			<div id="list_menu">
				<div id="list_title">
					<p><?php echo $currentList['title'] ?></p>
				</div>
				<div id="share_options">
                    <?php $shareButtons = $currentList ? "" : "disabled"; ?>
					<button id="add_person" type="button" onclick=share(<?php echo $currentList['list_id'] ?>) <?php echo $shareButtons ?>>Share</button>
				</div>
			</div>
			<div id="list_content">
				<div id="list_tabs">
					<ul id="list_ul">
                        <?php
							foreach($lists as $list) {
								if ($currentList['list_id'] == $list['list_id']) {
									echo "<li><button id=\"". $list['title'] ."\" class=\"list_button current_list\" onclick=\"switchToList(". $list['list_id'] .")\">".$list['title']."</button></li>";
								}
								else {
									echo "<li><button id=\"". $list['title'] ."\" class=\"list_button\" onclick=\"switchToList(". $list['list_id'] .")\">".$list['title']."</button></li>";
								}
							}
						?>
						<li><button id="new_list" class="list_button" onclick="newList()">Create List</button></li>
					</ul>
				</div>
				<div id="list_container">
					<form id="items">
					<?php
					if(!$currentList) {
						echo "You have not made any checklists.";
					} else { ?>
                        <ul id="item_ul">
						<?php
                        	$items = $dao->getListItems($currentList['list_id']);
							$i = 1;
							foreach($items as $item) {
								$checked = $item["checked"] ? "checked" : "";
								$status = $checked ? 1:0;
								echo "<li><input id=\"item".$i."\" onclick=toggleChecked(". $item['li_id'] .",". $status .") type=\"checkbox\" name=\"item\" ". $checked ."><label for=\"item".$i."\">". $item["content"] ."</label></li>";
								$i++;
							}
						?>
							<li><button onclick="newItem(<?php echo $currentList['list_id'] ?>)">Create Item</button></li>
						</ul>
					<?php } ?>
					</form>
				</div>
			</div>
		</div>

		<?php include_once('templates/footer.php')?>
</html>