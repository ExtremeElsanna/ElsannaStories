<?php
include("/hdd/elsanna-ssl/scripts/utf8Headers.php");
include("/hdd/elsanna-ssl/scripts/sessionHandler.php");
if (!isset($_POST['user'])) {
	header("Location: /");
	die();
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Elsanna Stories</title>
		<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
	</head>
	<body>
		<table>
			<tr><th>User</th></tr>
			<?php
				include("/hdd/config/config.php");
				$pdo = new PDO('mysql:host='.$config['DBhost'].';dbname='.$config['DBname'], $config['DBusername'], $config['DBpassword'], $config['DBoptions']);
				
				$username = $_POST['user'];
				$stmt = $pdo->prepare('SELECT Username FROM Users WHERE Username LIKE "%:username%";');
				$stmt->bindParam(':username', $username, PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
				$stmt->execute();
				$rows = $stmt->fetchAll();
				
				foreach ($rows as $row) {
					echo '<tr><td><a href="/user/'.$row['Username'].'">'.$row['Username'].'</a></td></tr>';
				}
			?>

		</table>
	</body>
</html>