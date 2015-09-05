<?php
include("/hdd/elsanna-ssl/headers/utf8Headers.php");
include("/hdd/elsanna-ssl/scripts/sessionHandler.php");
include("/hdd/elsanna-ssl/headers/HTMLvariables.php");

// Case insensitive function to count substring occurance
function substri_count($haystack, $needle) {
	return substr_count(mb_strtoupper($haystack, 'UTF-8'), mb_strtoupper($needle, 'UTF-8'));
}

$errors = array(1 => "Username Changed!",
				2 => "Unexpected Error :(",
				3 => "Not Logged In.",
				4 => "Account deleted!",
				5 => "Story submitted!",
				6 => "User does not exist.",
				7 => "Story does not exist.",
				8 => "You did not write this review");

// Make sure we have a search variable for code later
if (!isset($_GET['search'])) {
	$_GET['search'] = "";
}
if (!isset($_GET['a'])) {
	$_GET['a'] = 0;
}
if ($_GET['a'] != 0 and $_GET['a'] != 1) {
	$_GET['a'] = 0;
}
?>
<?php echo $doctype; ?>
<html>
	<head>
		<title>Elsanna Stories</title>
		<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
	</head>
	<body>
<?php
			// Define a refer link for our 'header' so login/logout refer us back to correct page
			if ($_GET['search'] != "") {
				$headerRefer = '/?search='.$_GET['search'];
			} else {
				$headerRefer = '/';
			}
			// Include the header in our pages
			include("/hdd/elsanna-ssl/classes/header.php");
?>
<?php
			if (isset($_GET['code']) and is_numeric($_GET['code']) and isset($errors[intval($_GET['code'])])) {
				echo "\t\t".$errors[intval($_GET['code'])]."<br />\n";
			}
?>
		<form action="/submitstory/" method="get">
			<input type="submit" value="Submit a Story!">
		</form>
<?php
		if ($_GET['a'] == 0) {
			echo "\t\t<form action='/' method='get'>
				<input type='text' name='search' value='' placeholder='Summers, Queen, Princess...'>
				<input type='submit' value='Search'>
			</form>";
		} else {
			// Get current day, month and year
			date_default_timezone_set('UTC');
			$currentDay = date("d");
			$currentMonth = date("m");
			$currentYear = date("Y");
			echo "\t\t<!-- FILTER START -->
			<form action='filter.php' method='post'>
				<table style='border-collapse: collapse;'>
				<tr>
				
				
				
				<td style='border: 1px solid black'>
				Title<br />
				<input type='text' name='Title' value='' placeholder='Title'>
				</td>
				<td style='border: 1px solid black'>
				Author<br />
				<input type='text' name='Author' value='' placeholder='Author'>
				</td>
				<td style='border: 1px solid black'>
				Length (words)<br />
				<input type='number' name='Length' value='' min='1'>
				</td>
				<td style='border: 1px solid black'>
				Story Type<br />
				<input type='radio' name='StoryType' value='MC'> Multi-Chapter<br />
				<input type='radio' name='StoryType' value='OS'> One-Shot<br />
				<input type='radio' name='StoryType' value='OSS'> One-Shot Series
				</td>
				<td style='border: 1px solid black'>
				Complete<br />
				<input type='radio' name='Complete' value='Y'> Yes<br />
				<input type='radio' name='Complete' value='N'> No<br />
				<input type='radio' name='Complete' value='U'> Unknown
				</td>
				<td style='border: 1px solid black'>
				Setting<br />
				<input type='radio' name='Setting' value='C'> Canon<br />
				<input type='radio' name='Setting' value='AU'> Alternate Universe (AU)<br />
				<input type='radio' name='Setting' value='mAU'> Modern Alternate Universe (mAU)<br />
				<input type='radio' name='Setting' value='STP'> Same Time and Place (STP)<br />
				<input type='radio' name='Setting' value='U'> Unknown
				</td>
				<td style='border: 1px solid black'>
				Elsa's Character<br />
				<input type='text' name='ElsaCharacter' value='' placeholder='Queen'>
				</td>
				
				
				
				</tr>
				<tr>
				
				
				
				<td style='border: 1px solid black'>
				Anna's Character<br />
				<input type='text' name='AnnaCharacter' value='' placeholder='Princess'>
				</td>
				<td style='border: 1px solid black'>
				Elsa's Powers<br />
				<input type='radio' name='ElsaPowers' value='C'> Canon<br />
				<input type='radio' name='ElsaPowers' value='D'> Different<br />
				<input type='radio' name='ElsaPowers' value='N'> None<br />
				<input type='radio' name='ElsaPowers' value='U'> Unknown
				</td>
				<td style='border: 1px solid black'>
				Anna's Powers<br />
				<input type='radio' name='AnnaPowers' value='N'> No<br />
				<input type='radio' name='AnnaPowers' value='Y'> Yes
				</td>
				<td style='border: 1px solid black'>
				Sisters<br />
				<input type='radio' name='Sisters' value='Y'> Yes<br />
				<input type='radio' name='Sisters' value='N'> No<br />
				<input type='radio' name='Sisters' value='U'> Unknown
				</td>
				<td style='border: 1px solid black'>
				Age [<a href='https://www.fictionratings.com/'>X</a>]<br />
				<input type='radio' name='Age' value='K'> K<br />
				<input type='radio' name='Age' value='KP'> K+<br />
				<input type='radio' name='Age' value='T'> T<br />
				<input type='radio' name='Age' value='M'> M
				</td>
				<td style='border: 1px solid black'>
				Smut Prominence<br />
				<input type='radio' name='SmutLevel' value='N'> None<br />
				<input type='radio' name='SmutLevel' value='PL'> Plot Focused<br />
				<input type='radio' name='SmutLevel' value='L'> Light<br />
				<input type='radio' name='SmutLevel' value='M'> Medium<br />
				<input type='radio' name='SmutLevel' value='H'> Heavy<br />
				<input type='radio' name='SmutLevel' value='PU'> Pure
				</td>
				<td style='border: 1px solid black'>
				Date Published<br />
				<select name='DayPublished'>";
					// Print all days and select current
					for ($i = 1; $i <= 31; $i ++) {
						if ($currentDay == str_pad($i, 2, '0', STR_PAD_LEFT)) {
							echo "\t\t\t<option value='".str_pad($i, 2, '0', STR_PAD_LEFT)."' selected>".str_pad($i, 2, '0', STR_PAD_LEFT)."</option>\n";
						} else {
							echo "\t\t\t<option value='".str_pad($i, 2, '0', STR_PAD_LEFT)."'>".str_pad($i, 2, '0', STR_PAD_LEFT)."</option>\n";
						}
					}
				echo "\t\t</select>
				<select name='MonthPublished'>";
					// Print all months and select current
					for ($i = 1; $i <= 12; $i ++) {
						if ($currentMonth == str_pad($i, 2, '0', STR_PAD_LEFT)) {
							echo "\t\t\t<option value='".str_pad($i, 2, '0', STR_PAD_LEFT)."' selected>".str_pad($i, 2, '0', STR_PAD_LEFT)."</option>\n";
						} else {
							echo "\t\t\t<option value='".str_pad($i, 2, '0', STR_PAD_LEFT)."'>".str_pad($i, 2, '0', STR_PAD_LEFT)."</option>\n";
						}
					}
				echo "\t\t</select>
				<select name='YearPublished'>";
					// Print all years and select current
					for ($i = 2013; $i <= intval($currentYear); $i ++) {
						if ($currentYear == $i) {
							echo "\t\t\t<option value='".str_pad($i, 2, '0', STR_PAD_LEFT)."' selected>".str_pad($i, 2, '0', STR_PAD_LEFT)."</option>\n";
						} else {
							echo "\t\t\t<option value='".str_pad($i, 2, '0', STR_PAD_LEFT)."'>".str_pad($i, 2, '0', STR_PAD_LEFT)."</option>\n";
						}
					}
				echo "\t\t</select>
				</td>
				
				
				
				</tr>
				</table>
				<input type='submit' value='Search'>
			</form>
			<!-- FILTER END -->";
		}
		
			include("/hdd/config/config.php");
			// Connect to DB
			if(!isset($pdo)) {
				try {
					$pdo = new PDO('mysql:host='.$config['DBhost'].';dbname='.$config['DBname'], $config['DBusername'], $config['DBpassword'], $config['DBoptions']);
				} catch (PDOException $e) {
					echo 'Connection failed: ' . $e->getMessage();
					die;
				}
			}
			
			// Select all stories data
			$stmt = $pdo->prepare('SELECT Id,Title,Author,ElsaCharacter,AnnaCharacter FROM Stories;');
			$stmt->execute();
			$rows = $stmt->fetchAll();
			
			// Search Engine Start
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
						echo $row[1]."<br /><br />";
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
							echo "<br />";
							echo "Total ".$hitCounts;
							echo "<br /><br />";
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
									echo "<br />";
									echo "Total ".$hitCounts;
									echo "<br /><br />";
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
							echo "<br />";
							echo "Total ".$hitCounts;
							echo "<br /><br />";
						}
						$hitCounter += $hitCounts;
					}
				}
				if ($hitCounter != 0) {
					array_push($validStories, array(0 => $rowIndex, 1 => $hitCounter, 2 => $row['Title']));
				}
			}
			// Search Engine End
?>
		<table>
			<tr><th>Title</th></tr>
<?php
				// Sort the stories by hitcounter, then name alphabetically
				function custom_sort($a,$b) {
					if ($a[1] == $b[1]) {
						return strcmp($a[2], $b[2]);
					} else {
						return $a[1]>$b[1];
					}
				}
				
				// Call custom_sort()
				usort($validStories, "custom_sort");
				foreach ($validStories as $story) {
					// Print out the stories returned by search engine
					echo "\t\t\t<tr><td><a href='/story/?id=".$rows[$story[0]]['Id']."'>".$rows[$story[0]]['Title']."</a></td></tr>\n";
				}
?>
		</table>
	</body>
</html>