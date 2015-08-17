<?php
include("/hdd/elsanna-ssl/scripts/utf8Headers.php");
include("/hdd/elsanna-ssl/scripts/sessionHandler.php");

$errors = array(1 => "Old password wrong",
				2 => "Pass conf not same",
				3 => "Password < 7 chars",
				4 => "Password > 20 chars",
				5 => "Password contains invalid characters a=>z,A=>Z,0=>9,[,],(,),{,},@,#,!,£,$,%,^,&,*,?,<,>",
				6 => "New Password same as old password");
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
				echo $errors[intval($_GET['code'])]."<br>";
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