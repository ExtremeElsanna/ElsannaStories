﻿<?php
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
		<table>
			<?php
				if ($_SESSION['loggedIn'] == 1) {
					echo 'Hi '.$_SESSION['username'].'! <a href="/logout/">Logout</a><br>';
				} else {
					echo 'Hi Guest! <a href="/login/">Login</a><br>';
				}
			?>
			<tr><th>Title</th></tr>
			<?php
				include("/hdd/config/config.php");
				$pdo = new PDO('mysql:host='.$config['DBhost'].';dbname='.$config['DBname'], $config['DBusername'], $config['DBpassword'], $config['DBoptions']);
				
				$stmt = $pdo->prepare('SELECT Id,Title FROM Stories');
				$stmt->execute();
				$rows = $stmt->fetchAll();
				foreach ($rows as $row) {
					echo '<tr><td><a href="story/?id='.$row['Id'].'">'.$row['Title'].'</a></td></tr>\n';
				}
			?>

		</table>
	</body>
</html>