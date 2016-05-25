<?php
	include("../scripts/sessionHandler.php");
	include("../config.php");
	
	// Trigger logout procedure
	include("../scripts/logout.php");
	
	// Ensure we have a refer link
	if (!isset($_GET['refer'])) {
		$_GET['refer'] = "/";
	} else {
		set_error_handler(function() { /* ignore errors */ });
		$_GET['refer'] = mb_convert_encoding(hex2bin($_GET['refer']),'UTF-8','UCS-2');
		restore_error_handler();
	}
	// Send user back to correct page
	header("Location: ".$_GET['refer']);
	die();
?>