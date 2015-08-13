<?php
include("/hdd/elsanna-ssl/scripts/utf8Headers.php");
include("/hdd/elsanna-ssl/scripts/sessionHandler.php");
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Elsanna Stories</title>
		<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
	</head>
	<body>
		<?php
			if ($_SESSION['loggedIn'] == 1) {
				echo 'Hi '.$_SESSION['username'].'! <a href="/logout/?refer=/">Logout</a><br>';
			} else {
				echo 'Hi Guest! <a href="/login/?refer=/">Login</a><br>';
			}
		?>
		<?php
			die;
		?>
	</body>
</html>