		<a href="/">Home</a><br />
<?php
	include(dirname(__FILE__)."/../scripts/sessionHandler.php");
?>
		<form action="/search/" method="get">
			<input type="text" name="user" value="" placeholder="Username...">
			<input type="submit" value="Search">
		</form>
<?php
	if (!isset($headerRefer)) {
		$headerRefer = "/";
	}
	set_error_handler(function() { /* ignore errors */ });
	$headerRefer = bin2hex(mb_convert_encoding($headerRefer, 'UCS-2', 'UTF-8'));
	restore_error_handler();
	// Print either Hi %User% or Hi Guest, with logout and login respectively which will refer back to given link when visited
	if ($_SESSION['loggedIn'] == 1) {
		echo "\t\tHi ".$_SESSION['username']."! <a href='/logout/?refer=".$headerRefer."'>Logout</a> - <a href='/user/".$_SESSION['username']."'>Profile</a><br />\n";
	} else {
		echo "\t\tHi Guest! <a href='/login/?refer=".$headerRefer."'>Login</a><br />\n";
	}
?>