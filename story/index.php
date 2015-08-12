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
		<table>
			<tr><th>Title</th><th>Author</th><th>Length</th><th>Story Type</th><th>Complete</th><th>Setting</th><th>Elsa Character</th><th>Anna Character</th><th>Elsa Powers</th><th>Anna Powers</th><th>Sisters</th><th>Age</th><th>Smut Level</th><th>Url</th><th>Date Added</th><th>Date Published</th></tr>
			<?php
				include("/hdd/config/config.php");
				$pdo = new PDO('mysql:host='.$config['DBhost'].';dbname='.$config['DBname'], $config['DBusername'], $config['DBpassword'], $config['DBoptions']);

				$id = $_GET['id'];
				$stmt = $pdo->prepare('SELECT * FROM Stories WHERE Id = :id');
				$stmt->bindParam(':id', $id, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
				$stmt->execute();
				$row = $stmt->fetch();
				
				echo "<tr>";
				echo "<td>".$row['Title']."</td>";
				echo "<td>".$row['Author']."</td>";
				echo "<td>".$row['Length']."</td>";
				echo "<td>".$row['StoryType']."</td>";
				echo "<td>".$row['Complete']."</td>";
				echo "<td>".$row['Setting']."</td>";
				echo "<td>".$row['ElsaCharacter']."</td>";
				echo "<td>".$row['AnnaCharacter']."</td>";
				echo "<td>".$row['ElsaPowers']."</td>";
				echo "<td>".$row['AnnaPowers']."</td>";
				echo "<td>".$row['Incest']."</td>";
				echo "<td>".$row['Age']."</td>";
				echo "<td>".$row['SmutLevel']."</td>";
				echo "<td>".$row['Url']."</td>";
				echo "<td>".$row['DateAdded']."</td>";
				echo "<td>".$row['DatePublished']."</td>";
				echo "</tr>";
			?>
		
		</table>
	</body>
</html>