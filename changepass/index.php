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
			$headerRefer = "/";
			include("/hdd/elsanna-ssl/classes/header.php");
		?>
		
		<form action="changepass.php" method="post">
			<input type="password" name="old_password" value="" placeholder="Old Password">
			<input type="password" name="new_password" value="" placeholder="New Password">
			<input type="password" name="new_password_confirm" value="" placeholder="New Password Confirmation">
			<input type="submit" value="Change Password">
		</form>
	</body>
</html>