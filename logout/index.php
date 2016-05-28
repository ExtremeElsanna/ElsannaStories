<?php
	include("../scripts/sessionHandler.php");
	include_once("../scripts/functions.php");
	include("../config.php");
	
	// Trigger logout procedure
	include("../scripts/logout.php");
	
	// Ensure we have a refer link
	if (!isset($_GET['refer'])) {
		$_GET['refer'] = "/";
	} else {
		$_GET['refer'] = Decode($_GET['refer']);
	}
	// Send user back to correct page
	header("Location: ".$_GET['refer']);
	die();
?>
