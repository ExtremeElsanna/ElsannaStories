		<a href="/">Home</a><br />
<?php
	include(dirname(__FILE__)."/../scripts/sessionHandler.php");
	include_once(dirname(__FILE__)."/../scripts/functions.php");
	if (!isset($_GET['user']))
	{
		$_GET['user'] = "";
	}
	else
	{
		$_GET['user'] = Decode($_GET['user']);
	}
	echo '<form action="/search/search.php" method="post">';
	echo '<input type="text" name="user" value="'.$_GET['user'].'" placeholder="Username...">';
	echo '<input type="submit" value="Search">';
	echo '</form>';
	if (!isset($headerRefer)) {
		$headerRefer = "/";
	}
	$headerRefer = Encode($headerRefer);
	// Print either Hi %User% or Hi Guest, with logout and login respectively which will refer back to given link when visited
	if ($_SESSION['loggedIn'] == 1) {
		echo "\t\tHi ".$_SESSION['username']."! <a href='/logout/?refer=".$headerRefer."'>Logout</a> - <a href='/user/".$_SESSION['username']."'>Profile</a><br />\n";
	} else {
		echo "\t\tHi Guest! <a href='/login/?refer=".$headerRefer."'>Login</a><br />\n";
	}
?>
		<form action="/submitstory/" method="get">
			<input type="submit" value="Submit a Story!">
		</form>
