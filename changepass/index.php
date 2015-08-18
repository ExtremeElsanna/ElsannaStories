<?php
include("/hdd/elsanna-ssl/scripts/utf8Headers.php");
include("/hdd/elsanna-ssl/scripts/sessionHandler.php");
if ($_SESSION['loggedIn'] != 1 and $_SESSION['changePassId'] == null) {
	// Not logged in
	header("Location: /?code=3");
	die();
}

$errors = array(1 => "Old Password is incorrect.",
				2 => "Password confirmation not equal to original password.",
				3 => "Password is shorter than 7 characters.",
				4 => "Password is longer than 20 characters",
				5 => "Password contains invalid characters. You may use: a-z, A-Z, 0-9, [], (), {}, @, #, !, £, $, %, ^, &, *, ?, <>",
				6 => "New Password same as Old Password.",
				7 => "You need to change your password.");
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Elsanna Stories</title>
		<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
	</head>
	<body>
		<?php
			// Include header on page
			$headerRefer = "/";
			include("/hdd/elsanna-ssl/classes/header.php");
		?>
		<?php
			if (isset($_GET['code']) and is_numeric($_GET['code'])) {
				echo $errors[intval($_GET['code'])]."<br>\n";
			}
		?>
		<form action="changepass.php" method="post">
			<input type="password" name="old_password" value="" placeholder="Old Password">
			<input type="password" name="new_password" value="" placeholder="New Password">
			<input type="password" name="new_password_confirm" value="" placeholder="New Password Confirmation">
			<input type="submit" value="Change Password">
		</form>
	</body>
</html>