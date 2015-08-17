<?php
include("/hdd/elsanna-ssl/scripts/utf8Headers.php");
include("/hdd/elsanna-ssl/scripts/sessionHandler.php");
include("/hdd/config/config.php");

$errors = array(1 => "ReCaptcha wrong",
				2 => "Username < 4 chars",
				3 => "Username > 25 chars",
				4 => "Password < 7 chars",
				5 => "Password > 20 chars",
				6 => "Email not valid",
				7 => "Username is Guest or guest",
				8 => "Pass conf not same",
				9 => "Username contains invalid characters a=>z,A=>Z,0=>9",
				10 => "Password contains invalid characters a=>z,A=>Z,0=>9,[,],(,),{,},@,#,!,£,$,%,^,&,*,?,<,>",
				11 => "Username already exists",
				12 => "Email already exists");
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
		
		<?php
			if (isset($_GET['code']) and is_numeric($_GET['code'])) {
				echo $errors[intval($_GET['code'])]."<br>";
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