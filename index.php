<?php
include("/hdd/elsanna-ssl/scripts/utf8Headers.php");
include("/hdd/elsanna-ssl/scripts/sessionHandler.php");

function substri_count($haystack, $needle) {
	return substr_count(mb_strtoupper($haystack, 'UTF-8'), mb_strtoupper($needle, 'UTF-8'));
}
if (!isset($_GET['search'])) {
	$_GET['search'] = "";
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Elsanna Stories</title>
		<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
	</head>
	<body>
		<?php
			if ($_GET['search'] != "") {
				$headerRefer = '/?search='.$_GET['search'];
			} else {
				$headerRefer = '/';
			}
			include("/hdd/elsanna-ssl/classes/header.php");
		?>
		
		<form action="/" method="get">
			<input type="text" name="search" value="" placeholder="Summers, Queen, Princess...">
			<input type="submit" value="Search">
		</form>
		<?php
			include("/hdd/config/config.php");
			$pdo = new PDO('mysql:host='.$config['DBhost'].';dbname='.$config['DBname'], $config['DBusername'], $config['DBpassword'], $config['DBoptions']);
			
			$stmt = $pdo->prepare('SELECT Id,Title,Author,ElsaCharacter,AnnaCharacter FROM Stories');
			$stmt->execute();
			$rows = $stmt->fetchAll();
			$debug = False;
			$words = explode(" ",$_GET['search']);
			$wordcount = count($words);
			$validStories = array();
			$indexesToSearch = array(0 => "Title",
									 1 => "Author",
									 2 => "ElsaCharacter",
									 3 => "AnnaCharacter");
			foreach ($rows as $rowIndex => $row) {
				$hitCounter = -1;
				if ($_GET['search'] != "") {
					$hitCounter = 0;
					if ($debug == True) {
						echo $row[1]."<br><br>";
					}
					for ($i = $wordcount; $i > 0; $i--) {
						$maxiterations = $wordcount-($i-1);
						$hitCounts = 0;
						$no_results_found = False;
						
						// start overlapping section
						for ($y = 0; $y < $maxiterations; $y++) {
							$persplitcount = 0;
							$split = "";
							for ($x = 0; $x < $i; $x++) {
								$split = $split." ".$words[$y+$x];
							}
							$split = substr($split,1);
							foreach ($indexesToSearch as $index) {
								$persplitcount += substri_count($row[$index],$split);
							}
							if ($debug == True) {
								echo '"'.$split.'" - '.$persplitcount." and ";
							}
							if ($persplitcount == 0) {
								$no_results_found = True;
							}
							$hitCounts += $persplitcount;
							if ($no_results_found == True) {
								$hitCounts = 0;
							}
						}
						if ($debug == True) {
							echo "<br>";
							echo "Total ".$hitCounts;
							echo "<br><br>";
						}
						$hitCounter += $hitCounts;
						
						// start non overlapping section
						if ($i > 1) {
							
							for ($y = 1; $y < $i; $y++) {
								$maxiterations = $wordcount-($i-1);
								$hitCounts = 0;
								$no_results_found = False;
								
								//First Part
								$persplitcount = 0;
								$split = "";
								for ($x = 0; $x < $i-$y; $x++) {
									$split = $split." ".$words[$x];
								}
								$split = substr($split,1);
								foreach ($indexesToSearch as $index) {
									$persplitcount += substri_count($row[$index],$split);
								}
								if ($debug == True) {
									echo '"'.$split.'" - '.$persplitcount." and ";
								}
								if ($persplitcount == 0) {
									$no_results_found = True;
								}
								$hitCounts += $persplitcount;
								if ($no_results_found == True) {
									$hitCounts = 0;
								}
								
								// Second Part
								$persplitcount = 0;
								$split = "";
								for ($x = $i-$y; $x < $i; $x++) {
									$split = $split." ".$words[$x];
								}
								$split = substr($split,1);
								foreach ($indexesToSearch as $index) {
									$persplitcount += substri_count($row[$index],$split);
								}
								if ($debug == True) {
									echo '"'.$split.'" - '.$persplitcount." and ";
								}
								if ($persplitcount == 0) {
									$no_results_found = True;
								}
								$hitCounts += $persplitcount;
								if ($no_results_found == True) {
									$hitCounts = 0;
								}
								
								if ($debug == True) {
									echo "<br>";
									echo "Total ".$hitCounts;
									echo "<br><br>";
								}
								$hitCounter += $hitCounts;
							}
						}
					}
					for ($i = $wordcount; $i > 0; $i--) {
						$maxiterations = $wordcount-($i-1);
						$hitCounts = 0;
						for ($y = 0; $y < $maxiterations; $y++) {
							$persplitcount = 0;
							$no_results_found = False;
							$split = "";
							for ($x = 0; $x < $i; $x++) {
								$split = $split." ".$words[$y+$x];
							}
							$split = substr($split,1);
							foreach ($indexesToSearch as $index) {
								$persplitcount += substri_count($row[$index],$split);
							}
							if ($debug == True) {
								echo '"'.$split.'" - '.$persplitcount." or ";
							}
							$hitCounts += $persplitcount;
						}
						if ($debug == True) {
							echo "<br>";
							echo "Total ".$hitCounts;
							echo "<br><br>";
						}
						$hitCounter += $hitCounts;
					}
				}
				if ($hitCounter != 0) {
					array_push($validStories, array(0 => $rowIndex, 1 => $hitCounter, 2 => $row['Title']));
				}
			}
		?>
		
		<table>
			<tr><th>Title</th></tr>
			<?php
				function custom_sort($a,$b) {
					if ($a[1] == $b[1]) {
						return strcmp($a[2], $b[2]);
					} else {
						return $a[1]>$b[1];
					}
				}
				
				$rowIds = array();
				$hitCounter = array();
				foreach ($validStories as $key => $row) {
					$rowIds[$key]  = $row[0];
					$hitCounter[$key] = $row[1];
				}
				usort($validStories, "custom_sort");
				foreach ($validStories as $story) {
					echo "<tr><td><a href='/story/?id=".$rows[$story[0]]['Id']."'>".$rows[$story[0]]['Title']."</a></td></tr>\n\t\t\t";
				}
			?>
			
		</table>
	</body>
</html>