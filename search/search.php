<?php
	include("scripts/sessionHandler.php");
	include_once("scripts/functions.php");

	if (!isset($_POST['user'])) {
		$_POST['user'] = "";
	} else {
		$_POST['user'] = Encode($_POST['user']);
	}
	header("Location: /search/?user=".$_POST['user']);
	
?>
