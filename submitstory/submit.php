<?php
	date_default_timezone_set('UTC');
	include("../scripts/sessionHandler.php");
	include("../config.php");	
	
	if (!isset($_POST['Title'])) {
		// Title not set
		header("Location: /submitstory/?code=1");
		die();
	} else {
		$title = $_POST['Title'];
		if ($title == "") {
			// Title not valid
			header("Location: /submitstory/?code=2");
			die();
		}
	}
	
	if (!isset($_POST['Author'])) {
		// Author not set
		header("Location: /submitstory/?code=1");
		die();
	} else {
		$author = $_POST['Author'];
		if ($author == "") {
			// Author not valid
			header("Location: /submitstory/?code=3");
			die();
		}
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

	// Get all stories with that title and author
	$stmt = $pdo->prepare('SELECT StoryId,Visible FROM Stories WHERE Title = :title AND Author = :author;');
	$stmt->bindParam(':title', $title, PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
	$stmt->bindParam(':author', $author, PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
	$stmt->execute();
	$row = $stmt->fetch();
	if ($row['StoryId'] != "") {
		if ($row['Visible'] == 1) {
			// Story already exists
			header("Location: /submitstory/?code=4");
			die();
		} else {
			// Story already exists and deleted from site
			header("Location: /submitstory/?code=16");
			die();
		}
	}
	
	if (!isset($_POST['Chapters'])) {
		// Chapters not set
		header("Location: /submitstory/?code=1");
		die();
	} else {
		$chapters = $_POST['Chapters'];
		if (!is_numeric($chapters)) {
			// Chapters not valid
			header("Location: /submitstory/?code=17");
			die();
		}
	}
	
	if (!isset($_POST['WordsRadio'])) {
		// WordsRadio not set
		header("Location: /submitstory/?code=1");
		die();
	} else {
		$wordsRadio = $_POST['WordsRadio'];
		if ($wordsRadio == "Y")
		{
			if (!isset($_POST['Words'])) {
				// Words not set
				header("Location: /submitstory/?code=1");
				die();
			} else {
				$words = $_POST['Words'];
				if (!is_numeric($words)) {
					// Words not valid
					header("Location: /submitstory/?code=5");
					die();
				}
			}
		} else {
			$words = -1;
		}
	}
	
	if (!isset($_POST['StoryType'])) {
		// StoryType not set
		header("Location: /submitstory/?code=1");
		die();
	} else {
		$storyType = $_POST['StoryType'];
		$valid = array("MC", "OS", "OSS");
		if (!in_array($storyType,$valid)) {
			// StoryType not valid
			header("Location: /submitstory/?code=6");
			die();
		}
	}
	
	if (!isset($_POST['Complete'])) {
		// Complete not set
		header("Location: /submitstory/?code=1");
		die();
	} else {
		$complete = $_POST['Complete'];
		$valid = array("Y", "N", "U");
		if (!in_array($complete,$valid)) {
			// Complete not valid
			header("Location: /submitstory/?code=7");
			die();
		}
	}
	
	if (!isset($_POST['Setting'])) {
		// Setting not set
		header("Location: /submitstory/?code=1");
		die();
	} else {
		$setting = $_POST['Setting'];
		$valid = array("C", "AU", "mAU", "STP", "U");
		if (!in_array($setting,$valid)) {
			// Setting not valid
			header("Location: /submitstory/?code=8");
			die();
		}
	}
	
	if (!isset($_POST['ElsaCharacterRadio'])) {
		// ElsaCharacterRadio not set
		header("Location: /submitstory/?code=1");
		die();
	} else {
		$elsaCharacterRadio = $_POST['ElsaCharacterRadio'];
		if ($elsaCharacterRadio == "Y")
		{
			if (!isset($_POST['ElsaCharacter'])) {
				// ElsaCharacter not set
				header("Location: /submitstory/?code=1");
				die();
			} else {
				// Not required, so no checking
				$elsaCharacter = $_POST['ElsaCharacter'];
			}
		} else {
			$elsaCharacter = "";
		}
	}
	
	if (!isset($_POST['AnnaCharacterRadio'])) {
		// AnnaCharacterRadio not set
		header("Location: /submitstory/?code=1");
		die();
	} else {
		$annaCharacterRadio = $_POST['AnnaCharacterRadio'];
		if ($annaCharacterRadio == "Y")
		{
			if (!isset($_POST['AnnaCharacter'])) {
				// AnnaCharacter not set
				header("Location: /submitstory/?code=1");
				die();
			} else {
				// Not required, so no checking
				$annaCharacter = $_POST['AnnaCharacter'];
			}
		} else {
			$annaCharacter = "";
		}
	}
	
	if (!isset($_POST['ElsaPowers'])) {
		// ElsaPowers not set
		header("Location: /submitstory/?code=1");
		die();
	} else {
		$elsaPowers = $_POST['ElsaPowers'];
		$valid = array("C", "D", "N", "U");
		if (!in_array($elsaPowers,$valid)) {
			// ElsaPowers not valid
			header("Location: /submitstory/?code=9");
			die();
		}
	}
	
	if (!isset($_POST['AnnaPowers'])) {
		// AnnaPowers not set
		header("Location: /submitstory/?code=1");
		die();
	} else {
		$annaPowers = $_POST['AnnaPowers'];
		$valid = array("N","Y","U");
		if (!in_array($annaPowers,$valid)) {
			// AnnaPowers not valid
			header("Location: /submitstory/?code=10");
			die();
		}
	}
	
	if (!isset($_POST['Sisters'])) {
		// Sisters not set
		header("Location: /submitstory/?code=1");
		die();
	} else {
		$sisters = $_POST['Sisters'];
		$valid = array("Y","C","N","U");
		if (!in_array($sisters,$valid)) {
			// Sisters not valid
			header("Location: /submitstory/?code=11");
			die();
		}
	}
	
	if (!isset($_POST['Age'])) {
		// Age not set
		header("Location: /submitstory/?code=1");
		die();
	} else {
		$age = $_POST['Age'];
		$valid = array("K","KP","T","M");
		if (!in_array($age,$valid)) {
			// Age not valid
			header("Location: /submitstory/?code=12");
			die();
		}
	}
	
	if (!isset($_POST['SmutLevel'])) {
		// SmutLevel not set
		header("Location: /submitstory/?code=1");
		die();
	} else {
		$smutLevel = $_POST['SmutLevel'];
		$valid = array("N","PL","L","M","H","PU","U");
		if (!in_array($smutLevel,$valid)) {
			// SmutLevel not valid
			header("Location: /submitstory/?code=13");
			die();
		}
	}
	
	if (!isset($_POST['Url'])) {
		// Url not set
		header("Location: /submitstory/?code=1");
		die();
	} else {
		$url = $_POST['Url'];
		if ($title == "") {
			// Url not valid
			header("Location: /submitstory/?code=14");
			die();
		}
	}
	
	if (!isset($_POST['DayPublished'])) {
		// DayPublished not set
		header("Location: /submitstory/?code=1");
		die();
	} else {
		$dayPublished = $_POST['DayPublished'];
		if (!is_numeric($dayPublished)) {
			// DayPublished not valid
			header("Location: /submitstory/?code=15");
			die();
		}
	}
	
	if (!isset($_POST['MonthPublished'])) {
		// MonthPublished not set
		header("Location: /submitstory/?code=1");
		die();
	} else {
		$monthPublished = $_POST['MonthPublished'];
		if (!is_numeric($monthPublished)) {
			// MonthPublished not valid
			header("Location: /submitstory/?code=15");
			die();
		}
	}
	
	if (!isset($_POST['YearPublished'])) {
		// YearPublished not set
		header("Location: /submitstory/?code=1");
		die();
	} else {
		$yearPublished = $_POST['YearPublished'];
		if (!is_numeric($yearPublished)) {
			// YearPublished not valid
			header("Location: /submitstory/?code=15");
			die();
		}
	}
	
	// Construct date from individual parts
	$datePublished = $yearPublished."-".$monthPublished."-".$dayPublished;
	$timePublished = strtotime($datePublished);
	
	// Get current date
	$timeAdded = time();
	
	// Insert story into DB for moderation
	$stmt = $pdo->prepare('INSERT INTO Stories (Title, Author, Chapters, Words, StoryType, Complete, Setting, ElsaCharacter, AnnaCharacter, ElsaPowers, AnnaPowers, Sisters, Age, SmutLevel, Url, TimeAdded, TimePublished) VALUES (:title,:author,:chapters,:words,:storyType,:complete,:setting,:elsaCharacter,:annaCharacter,:elsaPowers,:annaPowers,:sisters,:age,:smutLevel,:url,:timeAdded,:timePublished);');
	$stmt->bindParam(':title', $title, PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
	$stmt->bindParam(':author', $author, PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
	$stmt->bindParam(':chapters', $chapters, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
	$stmt->bindParam(':words', $words, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
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
	$stmt->bindParam(':timeAdded', $timeAdded, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
	$stmt->bindParam(':timePublished', $timePublished, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
	$stmt->execute();
	
	// Story submitted
	header("Location: /?code=5");
	die();
?>
