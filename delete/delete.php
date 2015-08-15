<?php
	include("/hdd/elsanna-ssl/scripts/sessionHandler.php");
	include("/hdd/config/config.php");
	if ($_SESSION['loggedIn'] != 1) {
		# Not logged in
		header("Location: /");
		die();
	}
	if (!isset($_SERVER['HTTP_REFERER'])) {
		# Not referred by /delete/
		header("Location: /user/".$_SESSION['username']);
		die();
	}
	print_r($_SERVER);
	print($_SERVER['HTTP_REFERER']);
?>