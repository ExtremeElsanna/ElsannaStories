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
	if (!isset($_SERVER['HTTP_HOST'])) {
		# HTTP_HOST data not present for some reason
		header("Location: /user/".$_SESSION['username']);
		die();
	}
	print_r($_SERVER);
	$httpLength = 7;
	if (isset($_SERVER['HTTPS']) and $_SERVER['HTTPS'] == "on") {
		$httpLength = 8;
	}
	$noProtocol = mb_substr($_SERVER['HTTP_REFERER'],$httpLength,null,"UTF-8");
	$hostLength = mb_strlen($_SERVER['HTTP_HOST'],"UTF-8");
	$noHost = mb_strtolower(mb_substr($noProtocol,$hostLength,null,"UTF-8"),"UTF-8");
	if (mb_substr($noHost,-9,null,"UTF-8") == "index.php") {
		$noHost = mb_substr($noHost,0,-9,"UTF-8");
	}
	print($noHost);
?>