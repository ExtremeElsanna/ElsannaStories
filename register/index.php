<?php
include("/hdd/elsanna-ssl/scripts/utf8Headers.php");
include("/hdd/elsanna-ssl/scripts/sessionHandler.php");
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Elsanna Stories</title>
		<script src="https://www.google.com/recaptcha/api.js" async defer></script>
		<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
	</head>
	<body>
		<form action="register.php" method="post">
			<input type="text" name="user" value="" placeholder="Username">
			<input type="password" name="password" value="" placeholder="Password">
			<input type="text" name="email" value="" placeholder="Email">
			<div class="g-recaptcha" data-sitekey="<?php echo $config['RcaptchaSiteKey'] ?>"></div>
			<input type="submit" name="submit" value="Register">
		</form>
		<br><a href="/">Home</a>
	</body>
</html>