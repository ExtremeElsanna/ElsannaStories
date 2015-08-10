<?php
include("/hdd/database-config/config.php");
$pdo = new PDO('mysql:host='.$DBhost.';dbname=fiction_database', $DBusername, $DBpassword);

$stmt = $pdo->prepare('SELECT * FROM _main');
$stmt->execute();
$rows = $stmt->fetchAll();
$newStories = array();
foreach ($rows as $row) {
	$story = array();
	$story[] = $row['Title'];
	$story[] = $row['Author'];
	$story[] = $row['SiteAuthor'];
	$story[] = $row['Length'];
	switch ($row['Story Type']) {
		case "Multi-chapter":
			$story[] = "MC";
			break;
		case "One-shot":
			$story[] = "OS";
			break;
		case "One-shot Series":
			$story[] = "OSS";
			break;
	}
	
	switch ($row['Complete']) {
		case "0":
			$story[] = "N";
			break;
		case "1":
			$story[] = "Y";
			break;
		case "2":
			$story[] = "U";
			break;
	}
	
	switch ($row['Setting']) {
		case "Canon":
			$story[] = "C";
			break;
		case "AU":
			$story[] = "AU";
			break;
		case "mAU":
			$story[] = "mAU";
			break;
		case "STP":
			$story[] = "STP";
			break;
	}
	
	$story[] = $row["Elsa's Character"];
	$story[] = $row["Anna's Character"];
	
	switch ($row['Elsa Powers']) {
		case "Yes":
			$story[] = "C";
			break;
		case "No":
			$story[] = "N";
			break;
		case "Powerful":
			$story[] = "C";
			break;
		case "Different":
			$story[] = "D";
			break;
		case "Powerful/Different":
			$story[] = "D";
			break;
		case "Unknown":
			$story[] = "U";
			break;
	}
	
	$story[] = "N";
	
	switch ($row['Incest']) {
		case "0":
			$story[] = "N";
			break;
		case "1":
			$story[] = "Y";
			break;
	}
	
	switch ($row['Age Rating']) {
		case "M":
			$story[] = "M";
			break;
		case "T":
			$story[] = "T";
			break;
		case "K+":
			$story[] = "KP";
			break;
		case "K":
			$story[] = "K";
			break;
	}
	
	switch ($row['Smut Level']) {
		case "None":
			$story[] = "N";
			break;
		case "Plot Focused":
			$story[] = "PL";
			break;
		case "Plot Focused/Light":
			$story[] = "L";
			break;
		case "Light":
			$story[] = "L";
			break;
		case "Light/Medium":
			$story[] = "M";
			break;
		case "Medium":
			$story[] = "M";
			break;
		case "Medium/Heavy":
			$story[] = "H";
			break;
		case "Heavy":
			$story[] = "H";
			break;
		case "Pure":
			$story[] = "PU";
			break;
	}
	
	if ($row['Fanfiction'] != "") 
		$story[] = "FF";
		$story[] = $row['Fanfiction'];
	} elseif ($row['AO3'] != "") {
		$story[] = "AO3";
		$story[] = $row['AO3'];
	} else {
		$story[] = "O";
		$story[] = $row['Other'];
	}
	$story[] = $row['added'];
	$story[] = $row['published'];
	$story[] = 1;
	$story[] = 1;
	$newStories[] = $story;
	print_r($story);
	echo '<br>';
}

//$pdo = new PDO('mysql:host='.$DBhost.';dbname='.$DBname, $DBusername, $DBpassword);

?>