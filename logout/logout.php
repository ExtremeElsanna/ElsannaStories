<?php
	include("/hdd/elsanna-ssl/scripts/sessionHandler.php");
	include("/hdd/config/config.php");
	
	$_SESSION['loggedIn'] = 0;
	$_SESSION['userId'] = null;
	$_SESSION['username'] = null;
	header("Location: /");
	die();
?>