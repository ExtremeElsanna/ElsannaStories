<?php
include("/hdd/elsanna-ssl/scripts/utf8Headers.php");
include("/hdd/elsanna-ssl/scripts/sessionHandler.php");
// Require username to search by
if (!isset($_GET['user'])) {
	header("Location: /?code=2");
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
		<?php
			// Include header in page
			$headerRefer = '/';
			include("/hdd/elsanna-ssl/classes/header.php");
		?>
		
		<table>
			<tr><th>User</th></tr>
			<?php
				include("/hdd/config/config.php");
				// Connect to DB
				if(!isset($pdo)) {
					$pdo = new PDO('mysql:host='.$config['DBhost'].';dbname='.$config['DBname'], $config['DBusername'], $config['DBpassword'], $config['DBoptions']);
				}
				
				$username = "%".$_GET['user']."%";
				// Get all users with search query as a substring
				$stmt = $pdo->prepare('SELECT Username FROM Users WHERE Username LIKE :username;');
				$stmt->bindParam(':username', $username, PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
				$stmt->execute();
				$rows = $stmt->fetchAll();
				foreach ($rows as $row) {
					// Print user
					echo '<tr><td><a href="/user/'.$row['Username'].'">'.$row['Username'].'</a></td></tr>';
				}
			?>

		</table>
	</body>
</html>