<?php
	include("/hdd/elsanna-ssl/scripts/sessionHandler.php");
	include("/hdd/config/config.php");
	
	// Trigger logout procedure
	include("/hdd/elsanna-ssl/scripts/logout.php");
	
	// Ensure we have a refer link
	if (!isset($_GET['refer'])) {
		$_GET['refer'] = "/";
	}
	// Send user back to correct page
	header("Location: ".$_GET['refer']);
	die();
?>