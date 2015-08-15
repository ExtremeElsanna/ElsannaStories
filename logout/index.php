<?php
	include("/hdd/elsanna-ssl/scripts/sessionHandler.php");
	include("/hdd/config/config.php");
	
	include("/hdd/elsanna-ssl/scripts/logout.php");
	
	if (!isset($_GET['refer'])) {
		$_GET['refer'] = "/";
	}
	header("Location: ".$_GET['refer']);
	die();
?>