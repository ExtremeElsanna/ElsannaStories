<?php
	if (!isset($_SESSION)) {
		session_start();
	}
	if (!isset($_SESSION['loggedIn'])) {
		$_SESSION['loggedIn'] = 0;
	}
	if (!isset($_SESSION['userId'])) {
		$_SESSION['userId'] = null;
	}
	if (!isset($_SESSION['username'])) {
		$_SESSION['userId'] = null;
	}
	if (!isset($_SESSION['lastActive'])) {
		$_SESSION['userId'] = null;
	}
	
	if ($_SESSION['loggedIn'] == 1) {
		date_default_timezone_set('UTC');
		$currentTime = time();
		$difference = $currentTime - $_SESSION['lastActive'];
		if ($difference > 1) {
			include("/hdd/elsanna-ssl/scripts/logout.php");
		} else {
			$_SESSION['lastActive'] = $currentTime;
		}
	}
?>