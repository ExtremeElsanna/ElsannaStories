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
			$headerRefer = "/";
			include("/hdd/elsanna-ssl/classes/header.php");
		?>
		
		<a href="/register/">Register</a><br>
		<form action="login.php" method="post">
			<input type="text" name="user" value="" placeholder="Username">
			<input type="password" name="password" value="" placeholder="Password">
			<?php
				echo '<input type="hidden" name="refer" value="'.$_GET['refer'].'">';
			?>
			
			<input type="submit" name="submit" value="Login">
		</form>
	</body>
</html>