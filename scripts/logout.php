<?php
	# Null session data
	$_SESSION['loggedIn'] = 0;
	$_SESSION['userId'] = null;
	$_SESSION['username'] = null;
	
	if (!isset($_GET['refer'])) {
		$_GET['refer'] = "/";
	}
	header("Location: ".$_GET['refer']);
	die();
?>