<?php
include("/hdd/elsanna-ssl/headers/utf8Headers.php");
include("/hdd/elsanna-ssl/scripts/sessionHandler.php");
include("/hdd/elsanna-ssl/headers/HTMLvariables.php");

$errors = array(1 => "Summary already submitted.",
				2 => "Summary too short.",
				3 => "Summary longer than 1000 characters.",
				4 => "Summary submitted!");

				
if (!isset($_GET['id']) and !is_numeric($_GET['id'])) {
	header("Location: /?code=7");
	die();
}
$id = $_GET['id'];
?>
<?php echo $doctype; ?>
<html>
	<head>
		<title>Elsanna Stories</title>
		<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
	</head>
	<body>
<?php
			// Include header in page
			$headerRefer = '/story/?id='.$id;
			include("/hdd/elsanna-ssl/classes/header.php");
?>
<?php
			if (isset($_GET['code']) and is_numeric($_GET['code']) and isset($errors[intval($_GET['code'])])) {
				echo "\t\t".$errors[intval($_GET['code'])]."<br />\n";
			}
?>
		<table>
			<tr><th>Title</th><th>Author</th><th>Length</th><th>Story Type</th><th>Complete</th><th>Setting</th><th>Elsa Character</th><th>Anna Character</th><th>Elsa Powers</th><th>Anna Powers</th><th>Sisters</th><th>Age [<a href="https://www.fictionratings.com/">X</a>]</th><th>Smut Prominence</th><th>Url</th><th>Date Added</th><th>Date Published</th></tr>
<?php
				include("/hdd/config/config.php");
				// Connect to DB
				if(!isset($pdo)) {
					try {
						$pdo = new PDO('mysql:host='.$config['DBhost'].';dbname='.$config['DBname'], $config['DBusername'], $config['DBpassword'], $config['DBoptions']);
					} catch (PDOException $e) {
						echo 'Connection failed: ' . $e->getMessage();
						die;
					}
				}

				// Get all data about this story
				$stmt = $pdo->prepare('SELECT * FROM Stories WHERE Id = :id;');
				$stmt->bindParam(':id', $id, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
				$stmt->execute();
				$row = $stmt->fetch();
				
				if ($row["Id"] == "") {
					header("Location: /?code=7");
					die();
				}
				
				// Assign all data and format it correctly
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
						$elsaPowers = "Canon";
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
				
				// Print data
				echo "\t\t\t<tr>";
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
				echo "<td><a href='".$url."'>Link</a></td>";
				echo "<td>".$dateAdded."</td>";
				echo "<td>".$datePublished."</td>";
				echo "</tr>\n";
?>
		</table><br />
<?php
			// Get summary for this story
			$stmt = $pdo->prepare('SELECT SummaryId,Summary,Moderated FROM Summaries WHERE StoryId = :id;');
			$stmt->bindParam(':id', $id, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
			$stmt->execute();
			$row = $stmt->fetch();
			// No sumamry
			$status = 0;
			if ($row['SummaryId'] != "") {
				// Summary, not moderated
				$status = 1;
				if ($row['Moderated'] == 1) {
					// Moderated summary
					$status = 2;
				}
			}
			// Display the relevant HTML
			if ($status == 0) {
				echo "\t\tSummary:<br />\n";
				echo "\t\tNo summary exists for this story yet. Care to leave a summary for other readers?<br />\n";
				echo "\t\t<form action='submitsummary.php?id=".$id."' method='post'>\n";
				echo "\t\t\t<textarea name='summary' rows='4' cols='50' style='font-family:serif' onKeyDown='limitText(this.form.summary,1000);' onKeyUp='limitText(this.form.summary,1000);'></textarea><br />\n";
				echo "\t\t\t<label id='countdown'>Characters left: 1000</label><br />\n";
				echo "\t\t\t<input type='submit' value='Submit'><br />\n";
				echo "\t\t</form>\n";
			} else if ($status == 1) {
				echo "\t\tSummary:<br />\n";
				echo "\t\tA summary is currently in queue for moderation for this story<br />\n";
			} else if ($status == 2) {
				echo "\t\tSummary:<br />\n";
				echo "<!-- Summary Starts Here -->\n";
				echo nl2br(strip_tags($row['Summary']))."\n";
				echo "<!-- Summary Ends Here -->\n";
			}
			echo "\t\t<br />\n";
			echo "\t\t<br />\n";
			
			echo "\t\tReviews:<br />\n";
			// Select all review data
			$moderated = 1;
			$stmt = $pdo->prepare('SELECT ReviewId,UserId,Review,DateSubmitted FROM Reviews WHERE StoryId = :id AND Moderated = :moderated;');
			$stmt->bindParam(':id', $id, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
			$stmt->bindParam(':moderated', $moderated, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
			$stmt->execute();
			$rows = $stmt->fetchAll();
			
			// For each review for this story
			echo "\t\t<table>\n";
			foreach ($rows as $review) {
				// Default username to guest
				$username = "Guest";
				if ($review['UserId'] != 0) {
					// If user was not guest on submission fetch username
					$stmt = $pdo->prepare('SELECT Id,Username FROM Users WHERE Id = :userId;');
					$stmt->bindParam(':userId', $review['UserId'], PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
					$stmt->execute();
					$row = $stmt->fetch();
					if ($row['Id'] != "") {
						$username = $row['Username'];
					}
				}
				date_default_timezone_set('UTC');
				// Format a nicer date
				$newDate = date("d/m/Y", strtotime($review['DateSubmitted']));
				// Display the relevant HTML
				echo "\t\t\t<tr>";
				echo "<td style='border: 1px solid black'>".$newDate."</td>";
				echo "<td style='border: 1px solid black'>".$username."</td>";
				echo "<td style='border: 1px solid black'>".$review['Review']."</td>\n";
			}
			echo "\t\t</table><br />\n";
?>
		<script language="javascript" type="text/javascript">
			function limitText(limitField, limitNum) {
				var newValue = "Characters left: " + (limitNum - limitField.value.length).toString();
				 document.getElementById("countdown").textContent=newValue;
			}
		</script>
	</body>
</html>