<?php include("/hdd/elsanna-ssl/scripts/utf8Headers.php"); ?>
<!DOCTYPE html>
<html>
	<head>
		<title>Elsanna Stories</title>
		<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
	</head>
	<body>
		<table>
			<tr><th>Title</th></tr>
			<?php
				include("/hdd/database-config/config.php");
				$pdo = new PDO('mysql:host='.$DBhost.';dbname='.$DBname, $DBusername, $DBpassword);
				$stmt = $pdo->prepare("SET NAMES 'utf8'");
				$stmt->execute();
				
				$stmt = $pdo->prepare('SELECT Id,Title FROM Stories WHERE Id = 131');
				$stmt->execute();
				$rows = $stmt->fetchAll();
				foreach ($rows as $row) {
					echo '<tr><td><a href="story/?id='.$row['Id'].'">'.$row['Title'].'</a></td></tr>';
				}
			?>

		</table>
	</body>
</html>