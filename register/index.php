﻿<?php
include("/hdd/elsanna-ssl/scripts/utf8Headers.php");
include("/hdd/elsanna-ssl/scripts/sessionHandler.php");
include("/hdd/config/config.php");
?>
<!DOCTYPE html>
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