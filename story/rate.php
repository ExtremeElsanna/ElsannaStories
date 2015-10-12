<?php
	include("/hdd/elsanna-ssl/scripts/sessionHandler.php");
	include("/hdd/config/config.php");
				
	if (!isset($_GET['id']) or !is_numeric($_GET['id'])) {
		header("Location: /?code=2");
		die();
	}
	if (!isset($_GET['rating']) or !is_numeric($_GET['rating'])) {
		header("Location: /?code=2");
		die();
	}
	if ($_GET['rating'] < 0 and $_GET['rating'] > 5) {
		header("Location: /?code=2");
		die();
	}
	if ($_SESSION['loggedIn'] != 1) {
		// Not logged in
		header("Location: /story/?id=".$_GET['id']."&code=3");
		die();
	}
	
	// Get (non)existing rating data
	$userId = $_SESSION['userId'];
	$storyId = $_GET['id'];
	$rating = $_GET['rating'];
	$stmt = $pdo->prepare('SELECT RatingId,Rating FROM Ratings WHERE UserId = :userId AND StoryId = :storyId;');
	$stmt->bindParam(':userId', $userId, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
	$stmt->bindParam(':storyId', $storyId, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
	$stmt->execute();
	$row = $stmt->fetch();
	if ($row['RatingId'] == "") {
		// Rate Story
		$stmt = $pdo->prepare('INSERT INTO Ratings (UserId, StoryId, Rating) VALUES (:userId,:storyId,:rating);');
		$stmt->bindParam(':userId', $userId, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
		$stmt->bindParam(':storyId', $storyId, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
		$stmt->bindParam(':rating', $rating, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
		$stmt->execute();
		header("Location: /story/?id=".$storyId."&code=13");
	} else {
		if ($_GET['rating'] == 0) {
			// Delete Rating
			$stmt = $pdo->prepare('DELETE FROM Ratings WHERE UserId = :userId AND StoryId = :storyId;');
			$stmt->bindParam(':userId', $userId, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
			$stmt->bindParam(':storyId', $storyId, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
			$stmt->execute();
			header("Location: /story/?id=".$storyId."&code=15");
		} else if ($row['Rating'] != $rating) {
			// Update Rating
			$stmt = $pdo->prepare('UPDATE Ratings SET Rating = :rating WHERE UserId = :userId AND StoryId = :storyId;');
			$stmt->bindParam(':userId', $userId, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
			$stmt->bindParam(':storyId', $storyId, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
			$stmt->bindParam(':rating', $rating, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
			$stmt->execute();
			header("Location: /story/?id=".$storyId."&code=14");
		}
	}
?>