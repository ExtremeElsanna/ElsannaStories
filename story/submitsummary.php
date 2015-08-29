<?php
	include("/hdd/elsanna-ssl/scripts/sessionHandler.php");
	include("/hdd/config/config.php");
				
	if (!isset($_GET['id']) and !is_numeric($_GET['id'])) {
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
	
	// Get all data about this story
	$stmt = $pdo->prepare('SELECT Id FROM Stories WHERE Id = :id;');
	$stmt->bindParam(':id', $id, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
	$stmt->execute();
	$row = $stmt->fetch();
	
	if ($row["Id"] == "") {
		header("Location: /?code=7");
		die();
	}
	$id = $_GET['id'];
	
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
	
	if ($status == 2) {
		// Summary doesn't exist yet
		if (isset($_POST['summary']) and strlen($_POST['summary']) > 0) {
			// Summary > 0 chars
			if (strlen($_POST['summary']) <= 1000) {
				// Summary <= 1000 chars
				$userId = 0;
				if ($_SESSION['loggedIn'] == 1) {
					$userId = $_SESSION['userId'];
				}
				date_default_timezone_set('UTC');
				$submitDate = date("Y-m-d");
				$moderated = 0;
				$summary = $_POST['summary'];
				
				$stmt = $pdo->prepare('INSERT INTO Summaries (UserId, StoryId, Summary, DateSubmitted, Moderated) VALUES (:userId,:id,:summary,:submitDate,:moderated);');
				$stmt->bindParam(':userId', $userId, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
				$stmt->bindParam(':id', $id, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
				$stmt->bindParam(':summary', $summary, PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
				$stmt->bindParam(':submitDate', $submitDate, PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
				$stmt->bindParam(':moderated', $moderated, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
				$stmt->execute();
				header("Location: /story/?id=".$id."&code=4");
				die();
			} else {
				// Summary longer than 1000 chars
				header("Location: /story/?id=".$id."&code=3");
				die();
			}
		} else {
			// Summary shorter than or equal to 0 chars
			header("Location: /story/?id=".$id."&code=2");
			die();
		}
	} else {
		// Summary exists already
		header("Location: /story/?id=".$id."&code=1");
		die();
	}
?>