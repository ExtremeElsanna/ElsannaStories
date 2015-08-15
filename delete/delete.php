<?php
	include("/hdd/elsanna-ssl/scripts/sessionHandler.php");
	include("/hdd/config/config.php");
	if ($_SESSION['loggedIn'] != 1) {
		# Not logged in
		header("Location: /");
		die();
	}
	if (!isset($_SERVER)) {
		# SERVER data doesn't exist
		header("Location: /user/".$_SESSION['username']);
		die();
	}
	if (!isset($_SERVER['HTTP_REFERER'])) {
		# Not referred by /delete/
		header("Location: /user/".$_SESSION['username']);
		die();
	}
	print_r($_SERVER);
	$httpLength = 7;
	if (isset($_SERVER['HTTPS']) and $_SERVER['HTTPS'] == "on") {
		$httpLength = 8;
	}
	print(mb_substr($_SERVER['HTTP_REFERER'],$httpLength,null,"UTF-8"));
?>