<?php
include("/hdd/elsanna-ssl/scripts/utf8Headers.php");
include("/hdd/elsanna-ssl/scripts/sessionHandler.php");
if (!isset($_GET['refer'])) {
	$_GET['refer'] = "/";
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
		<form action="reset.php" method="post">
			<input type="text" name="user" value="" placeholder="Username">
			<input type="password" name="password" value="" placeholder="Password">
			<?php
				// Pass refer link given from referer to the login.php page
				echo '<input type="hidden" name="refer" value="'.$_GET['refer'].'">';
			?>
			
			<input type="submit" value="Login">
		</form>
		<a href="/reset/">Forgot Password?</a><br>
	</body>
</html>