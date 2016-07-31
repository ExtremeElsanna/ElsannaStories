<?php
include("../headers/utf8Headers.php");
include("../scripts/sessionHandler.php");
include("../headers/HTMLvariables.php");

$errors = array(1 => "Summary already submitted.",
				2 => "Summary too short.",
				3 => "Summary longer than 1000 characters.",
				4 => "Summary submitted!",
				5 => "Unexpected Error :(",
				6 => "Review Deleted",
				7 => "Review Updated",
				8 => "Review too short.",
				9 => "Review longer than 300 characters.",
				10 => "Favourited!",
				11 => "Unfavourited!",
				12 => "Review submitted!",
				13 => "Rating submitted!",
				14 => "Rating updated!",
				15 => "Rating removed!");

				
if (!isset($_GET['id']) or !is_numeric($_GET['id'])) {
	header("Location: /?code=7");
	die();
}
if (!isset($_GET['code'])) {
	$_GET['code'] = 0;
}
$id = $_GET['id'];

include("../config.php");
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
$stmt = $pdo->prepare('SELECT * FROM Stories WHERE StoryId = :storyId;');
$stmt->bindParam(':storyId', $id, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
$stmt->execute();
$story = $stmt->fetch();

if ($story["StoryId"] == "") {
	header("Location: /?code=7");
	die();
}
?>
<?php echo $doctype; ?>
<html>
	<head>
		<title>Elsanna Stories</title>
		<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
	</head>
	<body>
<?php
// Get all data about this story
			// Include header in page
			$headerRefer = '/story/?id='.$id;
			include("../classes/header.php");
?>
<?php
			if (isset($_GET['code']) and is_numeric($_GET['code']) and isset($errors[intval($_GET['code'])])) {
				echo "\t\t".$errors[intval($_GET['code'])]."<br />\n";
			}
			
			// Get all data about this story
			$stmt = $pdo->prepare('SELECT * FROM Ratings WHERE StoryId = :storyId;');
			$stmt->bindParam(':storyId', $id, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
			$stmt->execute();
			$ratingRows = $stmt->fetchAll();
			$totalRating = 0;
			$counter = 0;
			foreach ($ratingRows as $rateRow) {
				$totalRating += $rateRow['Rating'] * 10 * 2;
				$counter ++;
			}
			if ($totalRating == 0) {
				$totalRating = "No Rating";
			} else {
				$totalRating = $totalRating / $counter;
			}
?>
		<table>
			<tr><th>Title</th><th>Author</th><th>Chapters</th><th>Words</th><th>Story Type</th><th>Complete</th><th>Setting</th><th>Elsa Character</th><th>Anna Character</th><th>Elsa Powers</th><th>Anna Powers</th><th>Sisters</th><th>Age [<a href="https://www.fictionratings.com/">X</a>]</th><th>Smut Prominence</th><th>Rating</th><th>Date Updated</th><th>Date Published</th><th>Date Added</th></tr>
<?php

				
				// Assign all data and format it correctly
				$title = $story['Title'];
				$author = $story['Author'];
				$chapters = $story['Chapters'];
				if ($chapters == -1)
				{
					$chapters = "Unknown";
				}
				$words = $story['Words'];
				if ($words == -1)
				{
					$words = "Unknown";
				}
				switch ($story['StoryType']) {
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
				switch ($story['Complete']) {
					case "Y":
						$complete = "Yes";
						break;
					case "N":
						$complete = "No";
						break;
				}
				switch ($story['Setting']) {
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
				$elsaCharacter = $story['ElsaCharacter'];
				$annaCharacter = $story['AnnaCharacter'];
				switch ($story['ElsaPowers']) {
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
				switch ($story['AnnaPowers']) {
					case "Y":
						$annaPowers = "Yes";
						break;
					case "N":
						$annaPowers = "None";
						break;
					case "U":
						$annaPowers = "Unknown";
						break;
				}
				switch ($story['Sisters']) {
					case "Y":
						$sisters = "Yes";
						break;
					case "C":
						$sisters = "It's Complicated";
						break;
					case "N":
						$sisters = "No";
						break;
					case "U":
						$sisters = "Unknown";
						break;
				}
				switch ($story['Age']) {
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
				switch ($story['SmutLevel']) {
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
					case "U":
						$smutLevel = "Unknown";
						break;
				}
				$url = $story['Url'];
				
				$timeUpdated = $story['TimeUpdated'];
				if ($timeUpdated == 0)
				{
					$dateUpdated = "Unknown";
				} else {
					$dateUpdated = date("d/m/Y", $timeUpdated);
				}
				$datePublished = date("d/m/Y", $story['TimePublished']);
				$dateAdded = date("d/m/Y", $story['TimeAdded']);
				
				// Print data
				echo "\t\t\t<tr>";
				echo "<td>".$title."</td>";
				echo "<td>".$author."</td>";
				echo "<td>".$chapters."</td>";
				echo "<td>".$words."</td>";
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
				echo "<td>".$totalRating."</td>";
				echo "<td>".$dateUpdated."</td>";
				echo "<td>".$datePublished."</td>";
				echo "<td>".$dateAdded."</td>";
				echo "</tr>\n";
?>
		</table><br />
<?php
		if ($_SESSION['loggedIn'] == 1) {
			$stmt = $pdo->prepare('SELECT FavouriteId FROM Favourites WHERE UserId = :userId AND StoryId = :storyId;');
			$stmt->bindParam(':userId', $_SESSION['userId'], PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
			$stmt->bindParam(':storyId', $id, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
			$stmt->execute();
			$row = $stmt->fetch();
			if ($row['FavouriteId'] == "") {
				echo "\t\t<a href='favourite.php?id=".$id."'>Favourite</a><br />\n";
			} else {
				echo "\t\t<a href='favourite.php?id=".$id."'>UnFavourite</a><br />\n";
			}
			
			
			$stmt = $pdo->prepare('SELECT RatingId,Rating FROM Ratings WHERE UserId = :userId AND StoryId = :storyId;');
			$stmt->bindParam(':userId', $_SESSION['userId'], PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
			$stmt->bindParam(':storyId', $id, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
			$stmt->execute();
			$row = $stmt->fetch();
			if ($row['RatingId'] != "") {
				// Rated, set a default
				$rating = $row['Rating'];
			} else {
				$rating = null;
			}
			echo "\t\tRating<br>\n";
			if ($rating != null) {
				echo "\t\t<a href='rate.php?id=".$id."&rating=0'>Delete</a> ";
			}
			if ($rating == 1) {
				echo "\t\t1 ";
			} else {
				echo "\t\t<a href='rate.php?id=".$id."&rating=1'>1</a> ";
			}
			if ($rating == 2) {
				echo "\t\t2 ";
			} else {
				echo "\t\t<a href='rate.php?id=".$id."&rating=2'>2</a> ";
			}
			if ($rating == 3) {
				echo "\t\t3 ";
			} else {
				echo "\t\t<a href='rate.php?id=".$id."&rating=3'>3</a> ";
			}
			if ($rating == 4) {
				echo "\t\t4 ";
			} else {
				echo "\t\t<a href='rate.php?id=".$id."&rating=4'>4</a> ";
			}
			if ($rating == 5) {
				echo "\t\t5<br />\n";
			} else {
				echo "\t\t<a href='rate.php?id=".$id."&rating=5'>5</a><br />\n";
			}
			
		}
		
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
			echo "\t\t\t<textarea name='summary' rows='4' cols='50' style='font-family:serif' onKeyDown='limitText(this.form.summary,1000,\"summaryCountdown\");' onKeyUp='limitText(this.form.summary,1000,\"summaryCountdown\");'></textarea><br />\n";
			echo "\t\t\t<label id='summaryCountdown'>Characters left: 1000</label><br />\n";
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
		$stmt = $pdo->prepare('SELECT ReviewId,UserId,Review,TimeSubmitted FROM Reviews WHERE StoryId = :id AND Moderated = :moderated ORDER BY TimeSubmitted DESC;');
		$stmt->bindParam(':id', $id, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
		$stmt->bindParam(':moderated', $moderated, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
		$stmt->execute();
		$rows = $stmt->fetchAll();
		
		$hasReview = false;
		if ($_SESSION['loggedIn'] == 1) {
			// If logged in
			$stmt = $pdo->prepare('SELECT ReviewId FROM Reviews WHERE UserId = :userId and StoryId = :storyId;');
			$stmt->bindParam(':userId', $_SESSION['userId'], PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
			$stmt->bindParam(':storyId', $id, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
			$stmt->execute();
			$row = $stmt->fetch();
			if ($row['ReviewId'] != "") {
				$hasReview = true;
			}
		} else {
			if (isset($_GET['code']) and $_GET['code'] == 10) {
				$hasReview = true;
			}
		}
		
		if ($_SESSION['loggedIn'] == 1) {
			if (!$hasReview) {
				echo "\t\tYou have not yet written a review for this story.<br />\n";
			} else {
				echo "\t\tYou have already written a review for this story, a new one will overwrite the old one.<br />\n";
			}
			echo "\t\tYou are reviewing as: ".$_SESSION['username']."<br />\n";
		} else {
			echo "\t\tYou are reviewing as: Guest<br />\n";
		}
		echo "\t\t<form action='submitreview.php?id=".$id."' method='post'>\n";
		echo "\t\t\t<textarea name='review' rows='4' cols='50' style='font-family:serif' onKeyDown='limitText(this.form.review,300,\"reviewCountdown\");' onKeyUp='limitText(this.form.review,300,\"reviewCountdown\");'></textarea><br />\n";
		echo "\t\t\t<label id='reviewCountdown'>Characters left: 300</label><br />\n";
		echo "\t\t\t<input type='submit' value='Submit'><br />\n";
		echo "\t\t</form><br />\n";
		
		$pageSize = 5;
		if (!isset($_GET['page']) or !is_numeric($_GET['page'])) {
			$page = 1;
		} else {
			$page = $_GET['page'];
		}
		
		$reviews = count($rows);
		$pages = ceil($reviews/$pageSize);
		if ($page > $pages) {
			$page = $pages;
		}
		if ($page < 1) {
			$page = 1;
		}
		
		// For each review for this story
		echo "\t\t<table style='border-collapse: collapse;'>\n";
		$hasReviews = false;
		foreach ($rows as $key => $review) {
			$hasReviews = true;
			if ($key >= (($page-1)*$pageSize) and $key < ($page*$pageSize)) {
				// Default username to guest
				$username = "Guest";
				if ($review['UserId'] != 0) {
					// If user was not guest on submission fetch username
					$stmt = $pdo->prepare('SELECT UserId,Username FROM Users WHERE UserId = :userId;');
					$stmt->bindParam(':userId', $review['UserId'], PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
					$stmt->execute();
					$row = $stmt->fetch();
					if ($row['UserId'] != "") {
						$username = $row['Username'];
					}
				}
				// Check if review belongs to logged in user
				if ($_SESSION['loggedIn'] == 1 and $_SESSION['userId'] == $review['UserId']) {
					$usersReview = true;
				} else {
					$usersReview = false;
				}
				date_default_timezone_set('UTC');
				// Format a nicer date
				$newDate = date("d/m/Y H:i", $review['TimeSubmitted']);
				// Display the relevant HTML
				echo "\t\t\t<tr>";
				echo "<td style='border: 1px solid black'>".$newDate."</td>";
				echo "<td style='border: 1px solid black'>".$username."</td>";
				if ($usersReview) {
					echo "<td style='border: 1px solid black'>".$review['Review']."</td>";
					echo "<td style='border: 1px solid black'><a href='deletereview.php?review=".$review['ReviewId']."&amp;story=".$id."'>Delete</a></td>";
				} else {
					echo "<td style='border: 1px solid black' colspan=2>".nl2br(strip_tags($review['Review']))."</td>";
				}
				echo "</tr>\n";
			}
		}
		if ($hasReviews) {
			$codeExtension = "";
			if (isset($_GET['code'])) {
				$codeExtension = "&amp;code=".$_GET['code'];
			}
			$pageHTML = "\t\t\t<tr><td style='border: 1px solid black' colspan=4>Page: ";
			if ($page > 3) {
				$pageHTML = $pageHTML."<a href='?id=".$id."&amp;page=".(1).$codeExtension."'>".(1)."</a> ... ";
			}
			if ($page > 2) {
				$pageHTML = $pageHTML."<a href='?id=".$id."&amp;page=".($page-2).$codeExtension."'>".($page-2)."</a> ";
			}
			if ($page > 1) {
				$pageHTML = $pageHTML."<a href='?id=".$id."&amp;page=".($page-1).$codeExtension."'>".($page-1)."</a> ";
			}
			$pageHTML = $pageHTML.$page;
			if ($page < $pages) {
				$pageHTML = $pageHTML." <a href='?id=".$id."&amp;page=".($page+1).$codeExtension."'>".($page+1)."</a>";
			}
			if ($page < $pages-1) {
				$pageHTML = $pageHTML." <a href='?id=".$id."&amp;page=".($page+2).$codeExtension."'>".($page+2)."</a>";
			}
			if ($page < $pages-2) {
				$pageHTML = $pageHTML." ... <a href='?id=".$id."&amp;page=".($pages).$codeExtension."'>".($pages)."</a>";
			}
			$pageHTML = $pageHTML."</td></tr>\n";
			echo $pageHTML;
		}
		echo "\t\t</table><br />\n";
?>
		<script language="javascript" type="text/javascript">
			function limitText(limitField, limitNum, countdown) {
				var newValue = "Characters left: " + (limitNum - limitField.value.length).toString();
				 document.getElementById(countdown).textContent=newValue;
			}
		</script>
	</body>
</html>
