<?php
	include("../scripts/sessionHandler.php");
	include("../config.php");
				
	if (!isset($_GET['id']) or !is_numeric($_GET['id'])) {
		header("Location: /?code=2");
		die();
	}
	
	// Connect to DB
	if(!isset($pdo)) {
		try {
			$pdo = new PDO('mysql:host='.$config['DBhost'].';dbname='.$config['DBname'], $config['DBusername'], $config['DBpassword'], $config['DBoptions']);
		} catch (PDOException $e) {
			echo 'Connection failed: ' . $e->getMessage();
			die;
		}
	}
	
	$id = $_GET['id'];
	
	// Get all data about this story
	$stmt = $pdo->prepare('SELECT StoryId FROM Stories WHERE StoryId = :storyId;');
	$stmt->bindParam(':storyId', $id, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
	$stmt->execute();
	$row = $stmt->fetch();
	
	if ($row["StoryId"] == "") {
		header("Location: /?code=7");
		die();
	}
	
	$hasReview = false;
	
	if ($_SESSION['loggedIn'] == 1) {
		// If logged in
		$stmt = $pdo->prepare('SELECT ReviewId FROM Reviews WHERE UserId = :userId and StoryId = :storyId;');
		$stmt->bindParam(':userId', $_SESSION['userId'], PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
		$stmt->bindParam(':storyId', $id, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
		$stmt->execute();
		$row = $stmt->fetch();
		if ($row['ReviewId'] != "") {
			$hasReview = $row['ReviewId'];
		}
	}
	
	// Review doesn't exist yet
	if (isset($_POST['review']) and strlen($_POST['review']) > 0) {
		// Review > 0 chars
		if (strlen($_POST['review']) <= 300) {
			// Review <= 300 chars
			$userId = 0;
			if ($_SESSION['loggedIn'] == 1) {
				$userId = $_SESSION['userId'];
			}
			date_default_timezone_set('UTC');
			$submitTime = time();
			$moderated = 0;
			$review = $_POST['review'];
			
			if ($hasReview != false)
			{
				$stmt = $pdo->prepare('UPDATE Reviews SET Review = :review, TimeSubmitted = :submitTime, Moderated = :moderated WHERE ReviewId = :reviewId;');
				$stmt->bindParam(':review', $review, PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
				$stmt->bindParam(':submitTime', $submitTime, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
				$stmt->bindParam(':moderated', $moderated, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
				$stmt->bindParam(':reviewId', $hasReview, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
				$stmt->execute();
				header("Location: /story/?id=".$id."&code=7");
			} else {
				$stmt = $pdo->prepare('INSERT INTO Reviews (UserId, StoryId, Review, TimeSubmitted, Moderated) VALUES (:userId,:id,:review,:submitTime,:moderated);');
				$stmt->bindParam(':userId', $userId, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
				$stmt->bindParam(':id', $id, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
				$stmt->bindParam(':review', $review, PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
				$stmt->bindParam(':submitTime', $submitTime, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
				$stmt->bindParam(':moderated', $moderated, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
				$stmt->execute();
				header("Location: /story/?id=".$id."&code=12");
			}
			
			die();
		} else {
			header("Location: /story/?id=".$id."&code=9");
			die();
		}
	} else {
		header("Location: /story/?id=".$id."&code=8");
		die();
	}
?>
