<!DOCTYPE html>
<html>
	<head>
		<title>Elsanna Stories</title>
		<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
	</head>
	<body>
		<table>
			<tr><th>Title</th><th>Author</th><th>Site Author</th><th>Length</th><th>Story Type</th><th>Complete</th><th>Setting</th><th>Elsa Character</th><th>Anna Character</th><th>Elsa Powers</th><th>Anna Powers</th><th>Incest</th><th>Age</th><th>Smut Level</th><th>Host</th><th>Url</th><th>Date Added</th><th>Date Published</th><th>Visible</th><th>Moderated</th></tr>
			<?php
				include("/hdd/database-config/config.php");
				$pdo = new PDO('mysql:host='.$DBhost.';dbname='.$DBname, $DBusername, $DBpassword);

				$id = $_GET['id'];
				$stmt = $pdo->prepare('SELECT * FROM Stories WHERE Id = :id');
				$stmt->bindParam(':id', $id, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
				$stmt->execute();
				$row = $stmt->fetch();
				
				echo "<tr>";
				echo "<td>".$row['Title']."</td>";
				echo "<td>".$row['Author']."</td>";
				echo "<td>".$row['SiteAuthor']."</td>";
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
				echo "<td>".$row['Host']."</td>";
				echo "<td>".$row['Url']."</td>";
				echo "<td>".$row['DateAdded']."</td>";
				echo "<td>".$row['DatePublished']."</td>";
				echo "<td>".$row['Visible']."</td>";
				echo "<td>".$row['Moderated']."</td>";
				echo "</tr>";
			?>
		
		</table>
	</body>
</html>