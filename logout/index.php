<?php
	include("/hdd/elsanna-ssl/scripts/sessionHandler.php");
	include("/hdd/config/config.php");
	
	// Trigger logout procedure
	include("/hdd/elsanna-ssl/scripts/logout.php");
	
	// Send user back to correct page
	header("Location: ".$_SESSION['refer']);
	die();
?>