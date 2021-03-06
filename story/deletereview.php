<?php
	include("../scripts/sessionHandler.php");
	include("../config.php");
	if ($_SESSION['loggedIn'] != 1) {
		// Not logged in
		header("Location: /?code=3");
		die();
	}
	if (!isset($_GET['review']) or !is_numeric($_GET['review'])) {
		// Not logged in
		header("Location: /?code=5");
		die();
	}
	if (!isset($_GET['story']) or !is_numeric($_GET['story'])) {
		// Not logged in
		header("Location: /?code=5");
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

	$stmt = $pdo->prepare('SELECT ReviewId,UserId,StoryId FROM Reviews WHERE ReviewId = :reviewId;');
	$reviewId = $_GET['review'];
	$stmt->bindParam(':reviewId', $reviewId, PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
	$stmt->execute();
	$row = $stmt->fetch();
	if ($row['ReviewId'] == "" or $_GET['story'] != $row['StoryId']) {
		// Review doesn't exist or
		// StoryId incorrect
		header("Location: /?code=2");
		die();
	}
	if ($row['UserId'] != $_SESSION['userId']) {
		// Review not written by user
		header("Location: /?code=8");
		die();
	}
	
	// Delete user
	$stmt = $pdo->prepare("DELETE FROM Reviews WHERE ReviewId = :reviewId;");
	$stmt->bindParam(':reviewId', $reviewId, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
	$stmt->execute();
	// ReDirect to homepage
	header("Location: /story/?id=".$_GET['story']."&code=6");
	die();
?>
