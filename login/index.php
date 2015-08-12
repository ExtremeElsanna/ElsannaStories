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
			print_r($_SERVER);
			echo '<br>';
			print_r($_SERVER['HTTP_HOST']);
			echo '<br>';
			print_r($_SERVER['HTTP_REFERER']);
			echo '<br>';
		?>
		
		<a href="/">Home</a> <a href="/register/">Register</a><br>
		<form action="login.php" method="post">
			<input type="text" name="user" value="" placeholder="Username">
			<input type="password" name="password" value="" placeholder="Password">
			<input type="submit" name="submit" value="Login">
		</form>
	</body>
</html>