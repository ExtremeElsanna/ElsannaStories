<?php
// Transfer old stories to new stories

include("/hdd/config/config.php");
$pdo = new PDO('mysql:host='.$config['DBhost'].';dbname=fiction_database', $config['DBusername'], $config['DBpassword'], $config['DBoptions']);

$stmt = $pdo->prepare('SELECT Title,Summary FROM _main WHERE Summary != "";');
$stmt->execute();
$rows = $stmt->fetchAll();
$pdo = new PDO('mysql:host='.$config['DBhost'].';dbname='.$config['DBname'], $config['DBusername'], $config['DBpassword'], $config['DBoptions']);

foreach ($rows as $summary) {
	$stmt = $pdo->prepare('SELECT Id FROM Stories WHERE Title = :title;');
	$stmt->bindParam(':title', $summary['Title'], PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
	$stmt->execute();
	$idRow = $stmt->fetch();
	$storyId = $idRow['Id'];
	$userId = 0;
	$dateSubmitted = "2015-08-25";
	$moderated = 1;
	$stmt = $pdo->prepare('INSERT INTO Summaries (UserId, StoryId, Summary, DateSubmitted, Moderated) VALUES (:userId,:storyId,:summary,:dateSubmitted,:moderated);');
	$stmt->bindParam(':userId', $userId, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
	$stmt->bindParam(':storyId', $storyId, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
	$stmt->bindParam(':summary', $summary['Summary'], PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
	$stmt->bindParam(':dateSubmitted', $dateSubmitted, PDO::PARAM_STR); // <-- Automatically sanitized for SQL by PDO
	$stmt->bindParam(':moderated', $moderated, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
	$stmt->execute();
}
echo "Done";
?>