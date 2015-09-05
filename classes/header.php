		<a href="/">Home</a><br />
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
	$_SESSION['refer'] = $headerRefer;
	// Print either Hi %User% or Hi Guest, with logout and login respectively which will refer back to given link when visited
	if ($_SESSION['loggedIn'] == 1) {
		//echo "\t\tHi ".$_SESSION['username']."! <a href='/logout/?refer=".$headerRefer."'>Logout</a> - <a href='/user/".$_SESSION['username']."'>Profile</a><br />\n";
		echo "\t\tHi ".$_SESSION['username']."! <a href='/logout/'>Logout</a> - <a href='/user/".$_SESSION['username']."'>Profile</a><br />\n";
	} else {
		//echo "\t\tHi Guest! <a href='/login/?refer=".$headerRefer."'>Login</a><br />\n";
		echo "\t\tHi Guest! <a href='/login/'>Login</a><br />\n";
	}
	print_r($_SESSION);
?>