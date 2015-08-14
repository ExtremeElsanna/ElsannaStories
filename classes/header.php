<a href="/">Home</a><br>
<?php
	include("/hdd/elsanna-ssl/scripts/sessionHandler.php");
?>
<form action="/search/" method="get">
	<input type="text" name="user" value="" placeholder="Username...">
	<input type="submit" value="Search">
</form>
<?php
	if (!isset($headerRefer)) {
		$headerRefer = "/";
	}
	if ($_SESSION['loggedIn'] == 1) {
		echo 'Hi '.$_SESSION['username'].'! <a href="/logout/?refer='.$headerRefer.'">Logout</a><br>';
	} else {
		echo 'Hi Guest! <a href="/login/?refer='.$headerRefer.'">Login</a><br>';
	}
?>