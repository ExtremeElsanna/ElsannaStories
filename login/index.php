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
			if (!isset($_SERVER['HTTP_REFERER'])) {
				header("Location: /?code=2");
				die();
			}
			if (!isset($_SERVER['HTTP_HOST'])) {
				header("Location: /?code=2");
				die();
			}
			$httpLength = 7;
			if (isset($_SERVER['HTTPS']) and $_SERVER['HTTPS'] == "on") {
				$httpLength = 8;
			}
			// Strip referer down to link extension
			$noProtocol = mb_substr($_SERVER['HTTP_REFERER'],$httpLength,null,"UTF-8");
			$hostLength = mb_strlen($_SERVER['HTTP_HOST'],"UTF-8");
			$referrer = str_replace("&","&amp;",mb_strtolower(mb_substr($noProtocol,$hostLength,null,"UTF-8"),"UTF-8"));
?>
		<a href="/register/">Register</a><br />
		<form action="login.php" method="post">
			<input type="text" name="user" value="" placeholder="Username">
			<input type="password" name="password" value="" placeholder="Password">
<?php
				// Pass refer link given from referer to the login.php page
				echo '<input type="hidden" name="refer" value="'.$referrer.'">';
?>
			
			<input type="submit" value="Login">
		</form>
<?php echo "<a href='/reset/?refer=".$_GET['refer']."'>Forgot Password?</a><br />" ?>
	</body>
</html>