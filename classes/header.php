<a href="/">Home</a><br>
<?php
	include("/hdd/elsanna-ssl/scripts/sessionHandler.php");
	if (!isset($headerRefer)) {
		$headerRefer = "/";
	}
	if ($_SESSION['loggedIn'] == 1) {
		echo 'Hi '.$_SESSION['username'].'! <a href="/logout/?refer='.$headerRefer.'">Logout</a><br>';
	} else {
		echo 'Hi Guest! <a href="/login/?refer='.$headerRefer.'">Login</a><br>';
	}
?>