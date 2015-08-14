<a href="/">Home</a><br>
<?php
	if ($_SESSION['loggedIn'] == 1) {
		echo 'Hi '.$_SESSION['username'].'! <a href="/logout/?refer=/story/?id='.$_GET['id'].'">Logout</a><br>';
	} else {
		echo 'Hi Guest! <a href="/login/?refer=/story/?id='.$_GET['id'].'">Login</a><br>';
	}
?>