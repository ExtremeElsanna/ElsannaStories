<?php
	include("/hdd/elsanna-ssl/scripts/sessionHandler.php");
	include("/hdd/config/config.php");
	
	// Trigger logout procedure
	include("/hdd/elsanna-ssl/scripts/logout.php");
	
	if (!isset($_SERVER['HTTP_REFERER'])) {
		header("Location: /?code=2");
		die();
	}
	if (!isset($_SERVER['HTTP_HOST'])) {
		header("Location: /?code=2");
		die();
	}
	$httpLength = 7;
	if (isset($_SERVER['HTTPS']) and $_SERVER['HTTPS'] == "on") {
		$httpLength = 8;
	}
	// Strip referer down to link extension
	$noProtocol = mb_substr($_SERVER['HTTP_REFERER'],$httpLength,null,"UTF-8");
	$hostLength = mb_strlen($_SERVER['HTTP_HOST'],"UTF-8");
	$referrer = mb_strtolower(mb_substr($noProtocol,$hostLength,null,"UTF-8"),"UTF-8");
	// Send user back to correct page
	header("Location: ".$referrer);
	die();
?>