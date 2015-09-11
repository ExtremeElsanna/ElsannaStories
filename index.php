<?phpinclude("/hdd/elsanna-ssl/headers/utf8Headers.php");include("/hdd/elsanna-ssl/scripts/sessionHandler.php");include("/hdd/elsanna-ssl/headers/HTMLvariables.php");// Case insensitive function to count substring occurancefunction substri_count($haystack, $needle) {	return substr_count(mb_strtoupper($haystack, 'UTF-8'), mb_strtoupper($needle, 'UTF-8'));}$errors = array(1 => "Username Changed!",				2 => "Unexpected Error :(",				3 => "Not Logged In.",				4 => "Account deleted!",				5 => "Story submitted!",				6 => "User does not exist.",				7 => "Story does not exist.",				8 => "You did not write this review");// Make sure we have a search variable for code laterif (!isset($_GET['search'])) {	$_GET['search'] = "";} else {	$_GET['search'] = mb_convert_encoding(hex2bin($_GET['search']),'UTF-8','UCS-2');}if (!isset($_GET['a'])) {	$_GET['a'] = 0;}if ($_GET['a'] != 0 and $_GET['a'] != 1) {	$_GET['a'] = 0;}if (!isset($_GET['code'])) {	$_GET['code'] = 0;}?><?php echo $doctype; ?><html>	<head>		<title>Elsanna Stories</title>		<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>	</head>	<body><?php			// Define a refer link for our 'header' so login/logout refer us back to correct page			$headerRefer = '/?search='.$_GET['search'].'&a='.$_GET['a'];			// Include the header in our pages			include("/hdd/elsanna-ssl/classes/header.php");?><?php			if (isset($_GET['code']) and is_numeric($_GET['code']) and isset($errors[intval($_GET['code'])])) {				echo "\t\t".$errors[intval($_GET['code'])]."<br />\n";			}?>		<form action="/submitstory/" method="get">			<input type="submit" value="Submit a Story!">		</form><?php		if ($_GET['a'] == 0) {			echo "\t\t<form action='search.php' method='post'>				<input type='text' name='search' value='' placeholder='Summers, Queen, Princess...'>				<input type='submit' value='Search'> <a href='?code=".$_GET['code']."&a=1'>Advanced Search</a>			</form>";		} else {			// Get current day, month and year			date_default_timezone_set('UTC');			$currentDay = date("d");			$currentMonth = date("m");			$currentYear = date("Y");			echo "\t\t<!-- FILTER START -->		<form action='filter.php' method='post'>			<table style='border-collapse: collapse;'>			<tr>												<td style='border: 1px solid black'>			Title<br />			<input type='text' name='Title' value='' placeholder='Title'>			</td>			<td style='border: 1px solid black'>			Author<br />			<input type='text' name='Author' value='' placeholder='Author'>			</td>			<td style='border: 1px solid black'>			Length (words)<br />			<input type='number' name='Length' value='' min='1'>			</td>			<td style='border: 1px solid black'>			Story Type<br />			<input type='checkbox' name='StoryType' value='MC'> Multi-Chapter<br />			<input type='checkbox' name='StoryType' value='OS'> One-Shot<br />			<input type='checkbox' name='StoryType' value='OSS'> One-Shot Series			</td>			<td style='border: 1px solid black'>			Complete<br />			<input type='checkbox' name='Complete' value='Y'> Yes<br />			<input type='checkbox' name='Complete' value='N'> No<br />			<input type='checkbox' name='Complete' value='U'> Unknown			</td>			<td style='border: 1px solid black'>			Setting<br />			<input type='checkbox' name='Setting' value='C'> Canon<br />			<input type='checkbox' name='Setting' value='AU'> Alternate Universe (AU)<br />			<input type='checkbox' name='Setting' value='mAU'> Modern Alternate Universe (mAU)<br />			<input type='checkbox' name='Setting' value='STP'> Same Time and Place (STP)<br />			<input type='checkbox' name='Setting' value='U'> Unknown			</td>			<td style='border: 1px solid black'>			Elsa's Character<br />			<input type='text' name='ElsaCharacter' value='' placeholder='Queen'>			</td>												</tr>			<tr>												<td style='border: 1px solid black'>			Anna's Character<br />			<input type='text' name='AnnaCharacter' value='' placeholder='Princess'>			</td>			<td style='border: 1px solid black'>			Elsa's Powers<br />			<input type='checkbox' name='ElsaPowers' value='C'> Canon<br />			<input type='checkbox' name='ElsaPowers' value='D'> Different<br />			<input type='checkbox' name='ElsaPowers' value='N'> None<br />			<input type='checkbox' name='ElsaPowers' value='U'> Unknown			</td>			<td style='border: 1px solid black'>			Anna's Powers<br />			<input type='checkbox' name='AnnaPowers' value='N'> No<br />			<input type='checkbox' name='AnnaPowers' value='Y'> Yes			</td>			<td style='border: 1px solid black'>			Sisters<br />			<input type='checkbox' name='Sisters' value='Y'> Yes<br />			<input type='checkbox' name='Sisters' value='N'> No<br />			<input type='checkbox' name='Sisters' value='U'> Unknown			</td>			<td style='border: 1px solid black'>			Age [<a href='https://www.fictionratings.com/'>X</a>]<br />			<input type='checkbox' name='Age' value='K'> K<br />			<input type='checkbox' name='Age' value='KP'> K+<br />			<input type='checkbox' name='Age' value='T'> T<br />			<input type='checkbox' name='Age' value='M'> M			</td>			<td style='border: 1px solid black'>			Smut Prominence<br />			<input type='checkbox' name='SmutLevel' value='N'> None<br />			<input type='checkbox' name='SmutLevel' value='PL'> Plot Focused<br />			<input type='checkbox' name='SmutLevel' value='L'> Light<br />			<input type='checkbox' name='SmutLevel' value='M'> Medium<br />			<input type='checkbox' name='SmutLevel' value='H'> Heavy<br />			<input type='checkbox' name='SmutLevel' value='PU'> Pure			</td>			<td style='border: 1px solid black'>			Date Published<br />			<select name='DayPublished'>\n";					// Print all days and select current					for ($i = 1; $i <= 31; $i ++) {						if ($currentDay == str_pad($i, 2, '0', STR_PAD_LEFT)) {							echo "\t\t\t\t<option value='".str_pad($i, 2, '0', STR_PAD_LEFT)."' selected>".str_pad($i, 2, '0', STR_PAD_LEFT)."</option>\n";						} else {							echo "\t\t\t\t<option value='".str_pad($i, 2, '0', STR_PAD_LEFT)."'>".str_pad($i, 2, '0', STR_PAD_LEFT)."</option>\n";						}					}				echo "\t\t\t</select>			<select name='MonthPublished'>\n";					// Print all months and select current					for ($i = 1; $i <= 12; $i ++) {						if ($currentMonth == str_pad($i, 2, '0', STR_PAD_LEFT)) {							echo "\t\t\t\t<option value='".str_pad($i, 2, '0', STR_PAD_LEFT)."' selected>".str_pad($i, 2, '0', STR_PAD_LEFT)."</option>\n";						} else {							echo "\t\t\t\t<option value='".str_pad($i, 2, '0', STR_PAD_LEFT)."'>".str_pad($i, 2, '0', STR_PAD_LEFT)."</option>\n";						}					}				echo "\t\t\t</select>			<select name='YearPublished'>\n";					// Print all years and select current					for ($i = 2013; $i <= intval($currentYear); $i ++) {						if ($currentYear == $i) {							echo "\t\t\t\t<option value='".str_pad($i, 2, '0', STR_PAD_LEFT)."' selected>".str_pad($i, 2, '0', STR_PAD_LEFT)."</option>\n";						} else {							echo "\t\t\t\t<option value='".str_pad($i, 2, '0', STR_PAD_LEFT)."'>".str_pad($i, 2, '0', STR_PAD_LEFT)."</option>\n";						}					}				echo "\t\t\t</select>			</td>												</tr>			</table>			<input type='submit' value='Search'> <a href='?code=".$_GET['code']."'>Basic Search</a>		</form>		<!-- FILTER END -->\n";		}								function search($search, $rows, $indexesToSearch) {				$debug = False;				$words = explode(" ",$search);				$wordcount = count($words);				$validStories = array();				foreach ($rows as $rowIndex => $row) {					$hitCounter = -1;					if ($search != "") {						$hitCounter = 0;						if ($debug == True) {							echo $row[1]."<br /><br />";						}						for ($i = $wordcount; $i > 0; $i--) {							$maxiterations = $wordcount-($i-1);							$hitCounts = 0;							$no_results_found = False;														// start overlapping section							for ($y = 0; $y < $maxiterations; $y++) {								$persplitcount = 0;								$split = "";								for ($x = 0; $x < $i; $x++) {									$split = $split." ".$words[$y+$x];								}								$split = substr($split,1);								foreach ($indexesToSearch as $index) {									$persplitcount += substri_count($row[$index],$split);								}								if ($debug == True) {									echo '"'.$split.'" - '.$persplitcount." and ";								}								if ($persplitcount == 0) {									$no_results_found = True;								}								$hitCounts += $persplitcount;								if ($no_results_found == True) {									$hitCounts = 0;								}							}							if ($debug == True) {								echo "<br />";								echo "Total ".$hitCounts;								echo "<br /><br />";							}							$hitCounter += $hitCounts;														// start non overlapping section							if ($i > 1) {																for ($y = 1; $y < $i; $y++) {									$maxiterations = $wordcount-($i-1);									$hitCounts = 0;									$no_results_found = False;																		//First Part									$persplitcount = 0;									$split = "";									for ($x = 0; $x < $i-$y; $x++) {										$split = $split." ".$words[$x];									}									$split = substr($split,1);									foreach ($indexesToSearch as $index) {										$persplitcount += substri_count($row[$index],$split);									}									if ($debug == True) {										echo '"'.$split.'" - '.$persplitcount." and ";									}									if ($persplitcount == 0) {										$no_results_found = True;									}									$hitCounts += $persplitcount;									if ($no_results_found == True) {										$hitCounts = 0;									}																		// Second Part									$persplitcount = 0;									$split = "";									for ($x = $i-$y; $x < $i; $x++) {										$split = $split." ".$words[$x];									}									$split = substr($split,1);									foreach ($indexesToSearch as $index) {										$persplitcount += substri_count($row[$index],$split);									}									if ($debug == True) {										echo '"'.$split.'" - '.$persplitcount." and ";									}									if ($persplitcount == 0) {										$no_results_found = True;									}									$hitCounts += $persplitcount;									if ($no_results_found == True) {										$hitCounts = 0;									}																		if ($debug == True) {										echo "<br />";										echo "Total ".$hitCounts;										echo "<br /><br />";									}									$hitCounter += $hitCounts;								}							}						}						for ($i = $wordcount; $i > 0; $i--) {							$maxiterations = $wordcount-($i-1);							$hitCounts = 0;							for ($y = 0; $y < $maxiterations; $y++) {								$persplitcount = 0;								$no_results_found = False;								$split = "";								for ($x = 0; $x < $i; $x++) {									$split = $split." ".$words[$y+$x];								}								$split = substr($split,1);								foreach ($indexesToSearch as $index) {									$persplitcount += substri_count($row[$index],$split);								}								if ($debug == True) {									echo '"'.$split.'" - '.$persplitcount." or ";								}								$hitCounts += $persplitcount;							}							if ($debug == True) {								echo "<br />";								echo "Total ".$hitCounts;								echo "<br /><br />";							}							$hitCounter += $hitCounts;						}					}					if ($hitCounter != 0) {						array_push($validStories, array(0 => $rowIndex, 1 => $hitCounter, 2 => $row['Title']));					}				}				return $validStories;			}						// Sort the stories by hitcounter, then name alphabetically			function custom_sort($a,$b) {				if ($a[1] == $b[1]) {					return strcmp($a[2], $b[2]);				} else {				// if ($a[1] == $b[1]) {					// return $a[3]<$b[3];				// } else {					return $a[1]<$b[1];				}			}						include("/hdd/config/config.php");			// Connect to DB			if(!isset($pdo)) {				try {					$pdo = new PDO('mysql:host='.$config['DBhost'].';dbname='.$config['DBname'], $config['DBusername'], $config['DBpassword'], $config['DBoptions']);				} catch (PDOException $e) {					echo 'Connection failed: ' . $e->getMessage();					die;				}			}						// Select all stories data			$stmt = $pdo->prepare('SELECT Id,Title,Author,ElsaCharacter,AnnaCharacter,Length FROM Stories;');			$stmt->execute();			$rows = $stmt->fetchAll();						// Search Engine Start			if ($_GET['a'] == 1) {				$validStories = array();				foreach ($rows as $key => $story) {					// For each detail one can filter, check if the user has filtered it, convert from numbers to letters					/* ############################################################### */					if (isset($_GET['sTitle'])) {						try {							$sTitle = mb_convert_encoding(hex2bin($_GET['sTitle']),'UTF-8','UCS-2');						} catch (Exception $e) {							$sTitle = FALSE;						}					} else {						$sTitle = FALSE;					}					if ($sTitle != FALSE) {					}					/* ############################################################### */					if (isset($_GET['sAuthor'])) {						try {							$sAuthor = mb_convert_encoding(hex2bin($_GET['sAuthor']),'UTF-8','UCS-2');						} catch (Exception $e) {							$sAuthor = FALSE;						}					} else {						$sAuthor = FALSE;					}					if ($sAuthor != FALSE) {					}					/* ############################################################### */					if (isset($_GET['sLength'])) {						try {							$sLength = mb_convert_encoding(hex2bin($_GET['sLength']),'UTF-8','UCS-2');						} catch (Exception $e) {							$sLength = FALSE;						}					} else {						$sLength = FALSE;					}					if ($sLength != FALSE) {					}					/* ############################################################### */					if (isset($_GET['sType'])) {						try {							$sType = mb_convert_encoding(hex2bin($_GET['sType']),'UTF-8','UCS-2');						} catch (Exception $e) {							$sType = FALSE;						}					} else {						$sType = FALSE;					}					if ($sType != FALSE) {					}					/* ############################################################### */					if (isset($_GET['sComplete'])) {						try {							$sComplete = mb_convert_encoding(hex2bin($_GET['sComplete']),'UTF-8','UCS-2');						} catch (Exception $e) {							$sComplete = FALSE;						}					} else {						$sComplete = FALSE;					}					if ($sComplete != FALSE) {					}					/* ############################################################### */					if (isset($_GET['sSetting'])) {						try {							$sSetting = mb_convert_encoding(hex2bin($_GET['sSetting']),'UTF-8','UCS-2');						} catch (Exception $e) {							$sSetting = FALSE;						}					} else {						$sSetting = FALSE;					}					if ($sSetting != FALSE) {					}					/* ############################################################### */					if (isset($_GET['sEChar'])) {						try {							$sEChar = mb_convert_encoding(hex2bin($_GET['sEChar']),'UTF-8','UCS-2');						} catch (Exception $e) {							$sEChar = FALSE;						}					} else {						$sEChar = FALSE;					}					if ($sEChar != FALSE) {					}					/* ############################################################### */					if (isset($_GET['sAChar'])) {						try {							$sAChar = mb_convert_encoding(hex2bin($_GET['sAChar']),'UTF-8','UCS-2');						} catch (Exception $e) {							$sAChar = FALSE;						}					} else {						$sAChar = FALSE;					}					if ($sAChar != FALSE) {					}					/* ############################################################### */					if (isset($_GET['sEPowers'])) {						try {							$sEPowers = mb_convert_encoding(hex2bin($_GET['sEPowers']),'UTF-8','UCS-2');						} catch (Exception $e) {							$sEPowers = FALSE;						}					} else {						$sEPowers = FALSE;					}					if ($sEPowers != FALSE) {					}					/* ############################################################### */					if (isset($_GET['sAPowers'])) {						try {							$sAPowers = mb_convert_encoding(hex2bin($_GET['sAPowers']),'UTF-8','UCS-2');						} catch (Exception $e) {							$sAPowers = FALSE;						}					} else {						$sAPowers = FALSE;					}					if ($sAPowers != FALSE) {					}					/* ############################################################### */					if (isset($_GET['sSisters'])) {						try {							$sSisters = mb_convert_encoding(hex2bin($_GET['sSisters']),'UTF-8','UCS-2');						} catch (Exception $e) {							$sSisters = FALSE;						}					} else {						$sSisters = FALSE;					}					if ($sSisters != FALSE) {					}					/* ############################################################### */					if (isset($_GET['sAge'])) {						try {							$sAge = mb_convert_encoding(hex2bin($_GET['sAge']),'UTF-8','UCS-2');						} catch (Exception $e) {							$sAge = FALSE;						}					} else {						$sAge = FALSE;					}					if ($sAge != FALSE) {					}					/* ############################################################### */					if (isset($_GET['sSmut'])) {						try {							$sSmut = mb_convert_encoding(hex2bin($_GET['sSmut']),'UTF-8','UCS-2');						} catch (Exception $e) {							$sSmut = FALSE;						}					} else {						$sSmut = FALSE;					}					if ($sSmut != FALSE) {					}					/* ############################################################### */					if (isset($_GET['sDate'])) {						try {							$sDate = mb_convert_encoding(hex2bin($_GET['sDate']),'UTF-8','UCS-2');						} catch (Exception $e) {							$sDate = FALSE;						}					} else {						$sDate = FALSE;					}					if ($sDate != FALSE) {					}					/* ############################################################### */					array_push($validStories, array(0 => $key, 1 => 1, 2 => $story['Title']));				}			} else {				$indexesToSearch = array(0 => "Title",										 1 => "Author",										 2 => "ElsaCharacter",										 3 => "AnnaCharacter");				$validStories = search($_GET['search'],$rows,$indexesToSearch);			}			// Search Engine End?>		<table>			<tr><th>Title</th></tr><?php				// Call custom_sort()				usort($validStories, "custom_sort");				foreach ($validStories as $story) {					// Print out the stories returned by search engine					echo "\t\t\t<tr><td><a href='/story/?id=".$rows[$story[0]]['Id']."'>".$story[2]."</a></td></tr>\n";				}?>		</table>	</body></html>