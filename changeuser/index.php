<?php
include("/hdd/elsanna-ssl/scripts/utf8Headers.php");
include("/hdd/elsanna-ssl/scripts/sessionHandler.php");
if ($_SESSION['loggedIn'] != 1) {
	// Not logged in
	header("Location: /?code=3");
	die();
}

$errors = array(1 => "Username taken.",
				2 => "Username contains invalid characters. You may use: a-z, A-Z, 0-9.",
				3 => "Username is shorter than 4 characters.",
				4 => "Username is longer than 25 characters.",
				5 => "Username cannot be 'guest'.",
				6 => "Unexpected Error :(");
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Elsanna Stories</title>
		<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
	</head>
	<body>
		<?php
			// Include header in page
			$headerRefer = "/";
			include("/hdd/elsanna-ssl/classes/header.php");
		?>
		<?php
			if (isset($_GET['code']) and is_numeric($_GET['code'])) {
				echo $errors[intval($_GET['code'])]."<br>\n";
			}
		?>
		<form action="changeuser.php" method="post">
			<input type="text" name="username" value="" placeholder="New Username">
			<input type="submit" value="Change Username">
		</form>
	</body>
</html>