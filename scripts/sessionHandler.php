<?php
	// Make sure session data exists for access
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
	if (!isset($_SESSION['changePassId'])) {
		$_SESSION['userId'] = null;
	}
	
	// Check user logged in
	if ($_SESSION['loggedIn'] == 1) {
		date_default_timezone_set('UTC');
		$currentTime = time();
		$difference = $currentTime - $_SESSION['lastActive'];
		// Check if not active for 15 minutes
		if ($difference > 900) {
			// Log the user out
			include("/hdd/elsanna-ssl/scripts/logout.php");
		} else {
			// Update the last active time
			$_SESSION['lastActive'] = $currentTime;
		}
	}
	echo "-----"."<br>";
	echo $_SESSION['loggedIn']."<br>";
	echo $_SESSION['userId']."<br>";
	echo $_SESSION['username']."<br>";
	echo "-----"."<br>";
?>