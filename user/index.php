<?php
include("/hdd/elsanna-ssl/scripts/utf8Headers.php");
include("/hdd/elsanna-ssl/scripts/sessionHandler.php");
include("/hdd/config/config.php");
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Elsanna Stories</title>
		<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
	</head>
	<body>
		<a href="/">Home</a><br>
		<?php
			if ($_SESSION['loggedIn'] == 1) {
				echo 'Hi '.$_SESSION['username'].'! <a href="/logout/">Logout</a><br>';
			} else {
				echo 'Hi Guest! <a href="/login/">Login</a><br>';
			}
		?>
		
		<?php
			if (isset($_GET['user'])) {
				$user = $_GET['user'];
				$upperUser = mb_strtoupper($user, 'UTF-8');
				
				$pdo = new PDO('mysql:host='.$config['DBhost'].';dbname='.$config['DBname'], $config['DBusername'], $config['DBpassword'], $config['DBoptions']);
				$stmt = $pdo->prepare('SELECT Username FROM Users WHERE UpperUser = :upperUser');
				$stmt->bindParam(':upperUser', $upperUser, PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
				$stmt->execute();
				$row = $stmt->fetch();
				$user = $row['Username'];
				if ($user != "") {
					echo $user."'s profile!";
				} else {
					header("Location: /");
					die;
				}
			} else {
				header("Location: /");
				die;
			}
		?>
	</body>
</html>