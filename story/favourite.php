<?php
	include("../scripts/sessionHandler.php");
	include("../config.php");
				
	if (!isset($_GET['id']) or !is_numeric($_GET['id'])) {
		header("Location: /?code=2");
		die();
	}
	if ($_SESSION['loggedIn'] != 1) {
		// Not logged in
		header("Location: /story/?id=".$_GET['id']."&code=3");
		die();
	}
	
	// Get (non)existing favourite data
	$userId = $_SESSION['userId'];
	$storyId = $_GET['id'];
	$stmt = $pdo->prepare('SELECT FavouriteId FROM Favourites WHERE UserId = :userId AND StoryId = :storyId;');
	$stmt->bindParam(':userId', $userId, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
	$stmt->bindParam(':storyId', $storyId, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
	$stmt->execute();
	$row = $stmt->fetch();
	if ($row['FavouriteId'] == "") {
		// Favourite Story
		$stmt = $pdo->prepare('INSERT INTO Favourites (UserId, StoryId) VALUES (:userId,:storyId);');
		$stmt->bindParam(':userId', $userId, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
		$stmt->bindParam(':storyId', $storyId, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
		$stmt->execute();
		header("Location: /story/?id=".$storyId."&code=10");
	} else {
		// Un-Favourite Story
		$stmt = $pdo->prepare('DELETE FROM Favourites WHERE UserId = :userId AND StoryId = :storyId;');
		$stmt->bindParam(':userId', $userId, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
		$stmt->bindParam(':storyId', $storyId, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
		$stmt->execute();
		header("Location: /story/?id=".$storyId."&code=11");
	}
?>
