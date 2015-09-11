<?php
	include("/hdd/elsanna-ssl/scripts/sessionHandler.php");

	foreach ($_POST as $param) {
		echo $param;
	}
	die;
	header("Location: /?search=".$_POST['search']);
?>