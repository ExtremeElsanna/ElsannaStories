﻿<?php
include("/hdd/elsanna-ssl/scripts/utf8Headers.php");
include("/hdd/elsanna-ssl/scripts/sessionHandler.php");
if (!isset($_GET['id'])) {
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
		<?php
			$headerRefer = '/story/?id='.$_GET['id'];
			include("/hdd/elsanna-ssl/classes/header.php");
		?>
		
		<table>
			<tr><th>Title</th><th>Author</th><th>Length</th><th>Story Type</th><th>Complete</th><th>Setting</th><th>Elsa Character</th><th>Anna Character</th><th>Elsa Powers</th><th>Anna Powers</th><th>Sisters</th><th>Age [<a href="https://www.fictionratings.com/">X</a>]</th><th>Smut Prominence</th><th>Url</th><th>Date Added</th><th>Date Published</th></tr>
			<?php
				include("/hdd/config/config.php");
				$pdo = new PDO('mysql:host='.$config['DBhost'].';dbname='.$config['DBname'], $config['DBusername'], $config['DBpassword'], $config['DBoptions']);

				$id = $_GET['id'];
				$stmt = $pdo->prepare('SELECT * FROM Stories WHERE Id = :id;');
				$stmt->bindParam(':id', $id, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
				$stmt->execute();
				$row = $stmt->fetch();
				
				$title = $row['Title'];
				$author = $row['Author'];
				$length = $row['Length'];
				switch ($row['StoryType']) {
					case "MC":
						$storyType = "Multi-Chapter";
						break;
					case "OS":
						$storyType = "One-Shot";
						break;
					case "OSS":
						$storyType = "One-Shot Series";
						break;
				}
				switch ($row['Complete']) {
					case "Y":
						$complete = "Yes";
						break;
					case "N":
						$complete = "No";
						break;
					case "U":
						$complete = "Unknown";
						break;
				}
				switch ($row['Setting']) {
					case "C":
						$setting = "Canon";
						break;
					case "AU":
						$setting = "Alternate Universe (AU)";
						break;
					case "mAU":
						$setting = "Mordern Alternate Universe (mAU)";
						break;
					case "STP":
						$setting = "Same Time and Place (STP)";
						break;
					case "U":
						$setting = "Unknown";
						break;
				}
				$elsaCharacter = $row['ElsaCharacter'];
				$annaCharacter = $row['AnnaCharacter'];
				switch ($row['ElsaPowers']) {
					case "C":
						$elsaPowers = "Canom";
						break;
					case "D":
						$elsaPowers = "Different";
						break;
					case "N":
						$elsaPowers = "None";
						break;
					case "U":
						$elsaPowers = "Unknown";
						break;
				}
				switch ($row['AnnaPowers']) {
					case "Y":
						$annaPowers = "Yes";
						break;
					case "N":
						$annaPowers = "No";
						break;
				}
				switch ($row['Sisters']) {
					case "Y":
						$sisters = "Yes";
						break;
					case "N":
						$sisters = "No";
						break;
					case "U":
						$sisters = "Unknown";
						break;
				}
				switch ($row['Age']) {
					case "K":
						$age = "K";
						break;
					case "KP":
						$age = "K+";
						break;
					case "T":
						$age = "T";
						break;
					case "M":
						$age = "M";
						break;
				}
				switch ($row['SmutLevel']) {
					case "N":
						$smutLevel = "None";
						break;
					case "PL":
						$smutLevel = "Plot Focused";
						break;
					case "L":
						$smutLevel = "Light";
						break;
					case "M":
						$smutLevel = "Medium";
						break;
					case "H":
						$smutLevel = "Heavy";
						break;
					case "PU":
						$smutLevel = "Pure";
						break;
				}
				$url = $row['Url'];
				$dateAdded = $row['DateAdded'];
				$datePublished = $row['DatePublished'];
				
				echo "<tr>";
				echo "<td>".$title."</td>";
				echo "<td>".$author."</td>";
				echo "<td>".$length."</td>";
				echo "<td>".$storyType."</td>";
				echo "<td>".$complete."</td>";
				echo "<td>".$setting."</td>";
				echo "<td>".$elsaCharacter."</td>";
				echo "<td>".$annaCharacter."</td>";
				echo "<td>".$elsaPowers."</td>";
				echo "<td>".$annaPowers."</td>";
				echo "<td>".$sisters."</td>";
				echo "<td>".$age."</td>";
				echo "<td>".$smutLevel."</td>";
				echo "<td>".$url."</td>";
				echo "<td>".$dateAdded."</td>";
				echo "<td>".$datePublished."</td>";
				echo "</tr>";
			?>
		
		</table>
	</body>
</html>