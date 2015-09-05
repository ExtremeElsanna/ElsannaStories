<?php
include("/hdd/elsanna-ssl/headers/utf8Headers.php");
if (!isset($_GET['refer'])) {
	$_GET['refer'] = "/";
}
include("/hdd/elsanna-ssl/scripts/sessionHandler.php");
include("/hdd/elsanna-ssl/headers/HTMLvariables.php");

$errors = array(1 => "Account Activated!",
				2 => "Password Changed!",
				3 => "Username or Password Incorrect.",
				4 => "Account not Activated.",
				5 => "Activation code was sent to your email address! Please check your junk folder if nothing arrives in the next 15 minutes.",
				6 => "Unexpected Error :(",
				7 => "User does not exist.",
				8 => "Account has already been activated.",
				9 => "Reset password link was sent to your email address if it was valid! Please check your junk folder if nothing arrives in the next 15 minutes.",
				10 => "Your account has been disabled. Please contact the support staff to find out why.",
				11 => "New password was sent to your email address! Please check your junk folder if nothing arrives in the next 15 minutes.");
if (isset($_GET['id']) and is_numeric($_GET['id'])) {
	$errors[4] = "Account not Activated. <a href='resend.php?id=".$_GET['id']."'>Resend Activation Email</a>";
}
?>
<?php echo $doctype; ?>
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
			if (isset($_GET['code']) and is_numeric($_GET['code']) and isset($errors[intval($_GET['code'])])) {
				echo "\t\t".$errors[intval($_GET['code'])]."<br />\n";
			}
?>
		<a href="/register/">Register</a><br />
		<form action="login.php" method="post">
			<input type="text" name="user" value="" placeholder="Username">
			<input type="password" name="password" value="" placeholder="Password">
			<input type="submit" value="Login">
		</form>
<?php
		echo "\t\t<a href='/reset/?refer=".$_GET['refer']."'>Forgot Password?</a><br />\n"
?>
	</body>
</html>