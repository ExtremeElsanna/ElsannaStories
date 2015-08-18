<?php
include("/hdd/elsanna-ssl/scripts/utf8Headers.php");
include("/hdd/elsanna-ssl/scripts/sessionHandler.php");
if (!isset($_GET['refer'])) {
	$_GET['refer'] = "/";
}

$errors = array(1 => "Account Activated!",
				2 => "Password Changed!",
				3 => "Username or Password Incorrect.",
				4 => "Account not Activated.",
				5 => "",
				6 => "Activation code was sent to your email address!",
				7 => "Unexpected Error :(",
				8 => "User does not exist.",
				9 => "Account has already been activated.");
if (isset($_GET['id']) and is_numeric($_GET['id'])) {
	$errors[4] = "Account not Activated. <a href='/resend/?id=".$_GET['id']."'>Resend Activation Email</a>";
}
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
		<a href="/register/">Register</a><br>
		<form action="login.php" method="post">
			<input type="text" name="user" value="" placeholder="Username">
			<input type="password" name="password" value="" placeholder="Password">
			<?php
				// Pass refer link given from referer to the login.php page
				echo '<input type="hidden" name="refer" value="'.$_GET['refer'].'">';
			?>
			
			<input type="submit" value="Login">
		</form>
	</body>
</html>