<?php
include("/hdd/elsanna-ssl/scripts/utf8Headers.php");
include("/hdd/elsanna-ssl/scripts/sessionHandler.php");
include("/hdd/config/config.php");
if (isset($_GET['user'])) {
	$user = $_GET['user'];
	$upperUser = mb_strtoupper($user, 'UTF-8');
	
	$pdo = new PDO('mysql:host='.$config['DBhost'].';dbname='.$config['DBname'], $config['DBusername'], $config['DBpassword'], $config['DBoptions']);
	$stmt = $pdo->prepare('SELECT Id,Username FROM Users WHERE UpperUser = :upperUser;');
	$stmt->bindParam(':upperUser', $upperUser, PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
	$stmt->execute();
	$row = $stmt->fetch();
	$userId = $row['Id'];
	$user = $row['Username'];
	if ($userId == "") {
		header("Location: /");
		die;
	}
} else {
	header("Location: /");
	die;
}
if ($_SESSION['loggedIn'] == 1 and $_SESSION['userId'] == $userId) {
	$usersProfile = true;
} else {
	$usersProfile = false;
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
			$headerRefer = '/user/'.$user;
			include("/hdd/elsanna-ssl/classes/header.php");
		?>
		
		<?php			
			if ($usersProfile == true) {
				echo "Welcome to your profile!<br>\n";
				echo "\t\t<a href='/changeuser/'>Change Username</a><br>\n";
				echo "\t\t<a href='/changepass/'>Change Password</a><br>\n";
				echo "\t\t<a href='/delete/'>Delete Account</a>";
			} else {
				echo $user."'s profile!";
			}
		?>
		
	</body>
</html>