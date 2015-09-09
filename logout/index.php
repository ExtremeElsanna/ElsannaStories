<?php
	include("/hdd/elsanna-ssl/scripts/sessionHandler.php");
	include("/hdd/config/config.php");
	
	// Trigger logout procedure
	include("/hdd/elsanna-ssl/scripts/logout.php");
	
	// Ensure we have a refer link
	if (!isset($_GET['refer'])) {
		$_GET['refer'] = "/";
	} else {
		$_GET['refer'] = iconv('UCS-2','UTF-8', hex2bin($_GET['refer']));
	}
	// Send user back to correct page
	header("Location: ".$_GET['refer']);
	die();
?>