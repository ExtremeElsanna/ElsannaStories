<?php
	session_start();
	if (!isset($_SESSION['loggedIn'])) {
		$_SESSION['loggedIn'] = 0;
	}
	if (!isset($_SESSION['userId'])) {
		$_SESSION['userId'] = null;
	}
	if (!isset($_SESSION['username'])) {
		$_SESSION['userId'] = null;
	}
?>