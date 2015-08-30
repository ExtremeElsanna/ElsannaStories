﻿<?php
include("/hdd/elsanna-ssl/scripts/utf8Headers.php");
include("/hdd/elsanna-ssl/scripts/sessionHandler.php");
include("/hdd/config/config.php");

$errors = array(1 => "ReCaptcha wrong.",
				2 => "Username is shorter than 4 characters.",
				3 => "Username is longer than 25 characters.",
				4 => "Password is shorter than 7 characters.",
				5 => "Password is longer than 20 characters",
				6 => "Email is not a valid email.",
				7 => "Username cannot be 'guest'.",
				8 => "Password confirmation not equal to original password.",
				9 => "Username contains invalid characters. You may use: a-z, A-Z, 0-9.",
				10 => "Password contains invalid characters. You may use: a-z, A-Z, 0-9, [], (), {}, @, #, !, £, $, %, ^, &, *, ?, <>.",
				11 => "Username taken.",
				12 => "Email taken.",
				13 => "Unexpected Error :(");
?>
<?php include("/hdd/elsanna-ssl/headers/doctype.php") ?>
<html>
	<head>
		<title>Elsanna Stories</title>
		<script src="https://www.google.com/recaptcha/api.js" async defer></script>
		<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
	</head>
	<body>
		<?php
			// Include header in page
			$headerRefer = '/register/';
			include("/hdd/elsanna-ssl/classes/header.php");
		?>
		<?php
			if (isset($_GET['code']) and is_numeric($_GET['code'])) {
				echo $errors[intval($_GET['code'])]."<br />\n";
			}
		?>
		<form action="register.php" method="post">
			<input type="text" name="user" value="" placeholder="Username">
			<input type="password" name="password" value="" placeholder="Password">
			<input type="password" name="password_confirm" value="" placeholder="Password Confirmation">
			<input type="text" name="email" value="" placeholder="Email">
			<div class="g-recaptcha" data-sitekey="<?php echo $config['RcaptchaSiteKey'] ?>"></div>
			<input type="submit" value="Register">
		</form>
	</body>
</html>