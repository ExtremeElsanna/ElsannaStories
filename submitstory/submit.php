<?php
	include("/hdd/elsanna-ssl/scripts/sessionHandler.php");
	include("/hdd/config/config.php");
	if (!isset($_POST['Title'])) {
		// Title not set
		header("Location: /submitstory/");
		die();
	} else {
		$title = $_GET['Title'];
		if ($title == "") {
			// Title not valid
			header("Location: /submitstory/");
			die();
		}
	}
	if (!isset($_POST['Author'])) {
		// Author not set
		header("Location: /submitstory/");
		die();
	} else {
		$author = $_GET['Author'];
		if ($author == "") {
			// Title not valid
			header("Location: /submitstory/");
			die();
		}
	}
	if (!isset($_POST['Length'])) {
		// Length not set
		header("Location: /submitstory/");
		die();
	} else {
		$length = $_GET['Length'];
		if (!is_numeric($length)) {
			// Length not valid
			header("Location: /submitstory/");
			die();
		}
	}
	if (!isset($_POST['StoryType'])) {
		// StoryType not set
		header("Location: /submitstory/");
		die();
	} else {
		$storyType = $_GET['StoryType'];
		$valid = array("MC", "OS", "OSS");
		if (!in_array($storyType,$valid)) {
			// StoryType not valid
			header("Location: /submitstory/");
			die();
		}
	}
	if (!isset($_POST['Complete'])) {
		// Complete not set
		header("Location: /submitstory/");
		die();
	} else {
		$complete = $_GET['Complete'];
		$valid = array("Y", "N", "U");
		if (!in_array($complete,$valid)) {
			// Complete not valid
			header("Location: /submitstory/");
			die();
		}
	}
	if (!isset($_POST['Setting'])) {
		// Setting not set
		header("Location: /submitstory/");
		die();
	} else {
		$setting = $_GET['Setting'];
		$valid = array("C", "AU", "mAU", "STP", "U");
		if (!in_array($setting,$valid)) {
			// Setting not valid
			header("Location: /submitstory/");
			die();
		}
	}
	if (!isset($_POST['ElsaCharacter'])) {
		// ElsaCharacter not set
		header("Location: /submitstory/");
		die();
	} else {
		// Not required, so no checking
		$elsaCharacter = $_GET['ElsaCharacter'];
	}
	if (!isset($_POST['AnnaCharacter'])) {
		// AnnaCharacter not set
		header("Location: /submitstory/");
		die();
	} else {
		// Not required, so no checking
		$annaCharacter = $_GET['AnnaCharacter'];
	}
	if (!isset($_POST['ElsaPowers'])) {
		// ElsaPowers not set
		header("Location: /submitstory/");
		die();
	} else {
		$elsaPowers = $_GET['ElsaPowers'];
		$valid = array("C", "D", "N", "U");
		if (!in_array($elsaPowers,$valid)) {
			// ElsaPowers not valid
			header("Location: /submitstory/");
			die();
		}
	}
	if (!isset($_POST['AnnaPowers'])) {
		// AnnaPowers not set
		header("Location: /submitstory/");
		die();
	} else {
		$annaPowers = $_GET['AnnaPowers'];
		$valid = array("N","Y");
		if (!in_array($annaPowers,$valid)) {
			// AnnaPowers not valid
			header("Location: /submitstory/");
			die();
		}
	}
	if (!isset($_POST['Sisters'])) {
		// Sisters not set
		header("Location: /submitstory/");
		die();
	} else {
		$sisters = $_GET['Sisters'];
		$valid = array("Y","N","U");
		if (!in_array($sisters,$valid)) {
			// Sisters not valid
			header("Location: /submitstory/");
			die();
		}
	}
	if (!isset($_POST['Age'])) {
		// Age not set
		header("Location: /submitstory/");
		die();
	} else {
		$age = $_GET['Age'];
		$valid = array("K","KP","T","M");
		if (!in_array($age,$valid)) {
			// Age not valid
			header("Location: /submitstory/");
			die();
		}
	}
	if (!isset($_POST['SmutLevel'])) {
		// SmutLevel not set
		header("Location: /submitstory/");
		die();
	} else {
		$smutLevel = $_GET['SmutLevel'];
		$valid = array("N","PL","L","M","H","PU");
		if (!in_array($smutLevel,$valid)) {
			// SmutLevel not valid
			header("Location: /submitstory/");
			die();
		}
	}
	if (!isset($_POST['Url'])) {
		// Url not set
		header("Location: /submitstory/");
		die();
	} else {
		$url = $_GET['Url'];
		if ($title == "") {
			// Url not valid
			header("Location: /submitstory/");
			die();
		}
	}
	if (!isset($_POST['DayPublished'])) {
		// DayPublished not set
		header("Location: /submitstory/");
		die();
	} else {
		$dayPublished = $_GET['DayPublished'];
		if (!is_numeric($dayPublished)) {
			// DayPublished not valid
			header("Location: /submitstory/");
			die();
		}
	}
	if (!isset($_POST['MonthPublished'])) {
		// MonthPublished not set
		header("Location: /submitstory/");
		die();
	} else {
		$monthPublished = $_GET['MonthPublished'];
		if (!is_numeric($monthPublished)) {
			// MonthPublished not valid
			header("Location: /submitstory/");
			die();
		}
	}
	if (!isset($_POST['YearPublished'])) {
		// YearPublished not set
		header("Location: /submitstory/");
		die();
	} else {
		$yearPublished = $_GET['YearPublished'];
		if (!is_numeric($yearPublished)) {
			// YearPublished not valid
			header("Location: /submitstory/");
			die();
		}
	}
	// Construct date from individual parts
	$datePublished = $yearPublished."-".$monthPublished."-".$dayPublished;
	
	date_default_timezone_set('UTC');
	$dateAdded = date("Y-m-d");
	
	$pdo = new PDO('mysql:host='.$config['DBhost'].';dbname='.$config['DBname'], $config['DBusername'], $config['DBpassword'], $config['DBoptions']);
	$stmt = $pdo->prepare('INSERT INTO Stories (Title, Author, Length, StoryType, Complete, Setting, ElsaCharacter, AnnaCharacter, ElsaPowers, AnnaPowers, Sisters, Age, SmutLevel, Url, DateAdded, DatePublished) VALUES (:title,:author,:length,:storyType,:complete,:setting,:elsaCharacter,:annaCharacter,:elsaPowers,:annaPowers,:sisters,:age,:smutLevel,:url,:dateAdded,:datePublished);');
	$stmt->bindParam(':title', $title, PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
	$stmt->bindParam(':author', $author, PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
	$stmt->bindParam(':length', $length, PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
	$stmt->bindParam(':storyType', $storyType, PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
	$stmt->bindParam(':complete', $complete, PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
	$stmt->bindParam(':setting', $setting, PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
	$stmt->bindParam(':elsaCharacter', $elsaCharacter, PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
	$stmt->bindParam(':annaCharacter', $annaCharacter, PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
	$stmt->bindParam(':elsaPowers', $elsaPowers, PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
	$stmt->bindParam(':annaPowers', $annaPowers, PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
	$stmt->bindParam(':sisters', $sisters, PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
	$stmt->bindParam(':age', $age, PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
	$stmt->bindParam(':smutLevel', $smutLevel, PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
	$stmt->bindParam(':url', $url, PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
	$stmt->bindParam(':dateAdded', $dateAdded, PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
	$stmt->bindParam(':datePublished', $datePublished, PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
	$stmt->execute();
?>