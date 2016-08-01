<?php
include("headers/utf8Headers.php");
include("scripts/sessionHandler.php");
include_once("scripts/functions.php");
include("headers/HTMLvariables.php");

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
				8 => "You did not write this review.",
				9 => "Password reset link has expired.");

// Make sure we have a search variable for code later
if (!isset($_GET['search'])) {
	$_GET['search'] = "";
} else {
	$_GET['search'] = Decode($_GET['search']);
}
if (!isset($_GET['a'])) {
	$_GET['a'] = 0;
}
if ($_GET['a'] != 0 and $_GET['a'] != 1) {
	$_GET['a'] = 0;
}
if (!isset($_GET['code'])) {
	$_GET['code'] = 0;
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
			$headerRefer = '/?search='.$_GET['search'].'&a='.$_GET['a'];
			// Include the header in our pages
			include("classes/header.php");
?>
<?php
			if (isset($_GET['code']) and is_numeric($_GET['code']) and isset($errors[intval($_GET['code'])])) {
				echo "\t\t".$errors[intval($_GET['code'])]."<br />\n";
			}
		if ($_GET['a'] == 0) {
			$search = $_GET['search'];
			echo "\t\t<form action='search.php' method='post'>
				<input type='text' name='search' value='".$search."' placeholder='Summers, Queen, Princess...'>
				<input type='submit' value='Search'> <a href='?code=".$_GET['code']."&a=1'>Advanced Search</a>
			</form>";
		} else {
			// Get current day, month and year
			date_default_timezone_set('UTC');
			$currentDay = date("d");
			$currentMonth = date("m");
			$currentYear = date("Y");
			
			// Set the default values of the HTML forms to any data we already hold for each potential search query parameter
			/* ############################################## */
			if (isset($_GET['sTitle'])) {
				$dTitle = Decode($_GET['sTitle']);
			} else {
				$dTitle = FALSE;
			}
			if ($dTitle != FALSE) {
				$titleDefault = $dTitle;
			} else {
				$titleDefault = "";
			}
			/* ############################################## */
			if (isset($_GET['sAuthor'])) {
				$dAuthor = Decode($_GET['sAuthor']);
			} else {
				$dAuthor = FALSE;
			}
			if ($dAuthor != FALSE) {
				$authorDefault = $dAuthor;
			} else {
				$authorDefault = "";
			}
			/* ############################################## */
			if (isset($_GET['sEChar'])) {
				$dEChar = Decode($_GET['sEChar']);
			} else {
				$dEChar = FALSE;
			}
			if ($dEChar != FALSE) {
				$eCharDefault = $dEChar;
			} else {
				$eCharDefault = "";
			}
			/* ############################################## */
			if (isset($_GET['sAChar'])) {
				$dAChar = Decode($_GET['sAChar']);
			} else {
				$dAChar = FALSE;
			}
			if ($dAChar != FALSE) {
				$aCharDefault = $dAChar;
			} else {
				$aCharDefault = "";
			}
			/* ############################################# */
			$sT = array(0 => "", 1 => "", 2 => "");
			if (isset($_GET['sType'])) {
				$dType = Decode($_GET['sType']);
			} else {
				$dType = FALSE;
			}
			if ($dType != FALSE) {
				$types = explode(",",$dType);
				if (in_array("MC",$types)) {
					$sT[0] = " checked";
				}
				if (in_array("OS",$types)) {
					$sT[1] = " checked";
				}
				if (in_array("OSS",$types)) {
					$sT[2] = " checked";
				}
			}
			/* ############################################# */
			$com = array(0 => "", 1 => "", 2 => "");
			if (isset($_GET['sComplete'])) {
				$dComplete = Decode($_GET['sComplete']);
			} else {
				$dComplete = FALSE;
			}
			if ($dComplete != FALSE) {
				$types = explode(",",$dComplete);
				if (in_array("Y",$types)) {
					$com[0] = " checked";
				}
				if (in_array("N",$types)) {
					$com[1] = " checked";
				}
				if (in_array("U",$types)) {
					$com[2] = " checked";
				}
			}
			/* ############################################# */
			$setting = array(0 => "", 1 => "", 2 => "", 3 => "", 4 => "");
			if (isset($_GET['sSetting'])) {
				$dSetting = Decode($_GET['sSetting']);
			} else {
				$dSetting = FALSE;
			}
			if ($dSetting != FALSE) {
				$types = explode(",",$dSetting);
				if (in_array("C",$types)) {
					$setting[0] = " checked";
				}
				if (in_array("AU",$types)) {
					$setting[1] = " checked";
				}
				if (in_array("mAU",$types)) {
					$setting[2] = " checked";
				}
				if (in_array("STP",$types)) {
					$setting[3] = " checked";
				}
				if (in_array("U",$types)) {
					$setting[4] = " checked";
				}
			}
			/* ############################################# */
			$ePowers = array(0 => "", 1 => "", 2 => "", 3 => "");
			if (isset($_GET['sEPowers'])) {
				$dEPowers = Decode($_GET['sEPowers']);
			} else {
				$dEPowers = FALSE;
			}
			if ($dEPowers != FALSE) {
				$types = explode(",",$dEPowers);
				if (in_array("C",$types)) {
					$ePowers[0] = " checked";
				}
				if (in_array("D",$types)) {
					$ePowers[1] = " checked";
				}
				if (in_array("N",$types)) {
					$ePowers[2] = " checked";
				}
				if (in_array("U",$types)) {
					$ePowers[3] = " checked";
				}
			}
			/* ############################################# */
			$aPowers = array(0 => "", 1 => "");
			if (isset($_GET['sAPowers'])) {
				$dAPowers = Decode($_GET['sAPowers']);
			} else {
				$dAPowers = FALSE;
			}
			if ($dAPowers != FALSE) {
				$types = explode(",",$dAPowers);
				if (in_array("N",$types)) {
					$aPowers[0] = " checked";
				}
				if (in_array("Y",$types)) {
					$aPowers[1] = " checked";
				}
			}
			/* ############################################# */
			$sisters = array(0 => "", 1 => "", 2 => "");
			if (isset($_GET['sSisters'])) {
				$dSisters = Decode($_GET['sSisters']);
			} else {
				$dSisters = FALSE;
			}
			if ($dSisters != FALSE) {
				$types = explode(",",$dSisters);
				if (in_array("Y",$types)) {
					$sisters[0] = " checked";
				}
				if (in_array("N",$types)) {
					$sisters[1] = " checked";
				}
				if (in_array("U",$types)) {
					$sisters[2] = " checked";
				}
			}
			/* ############################################# */
			$age = array(0 => "", 1 => "", 2 => "", 3 => "");
			if (isset($_GET['sAge'])) {
				$dAge = Decode($_GET['sAge']);
			} else {
				$dAge = FALSE;
			}
			if ($dAge != FALSE) {
				$types = explode(",",$dAge);
				if (in_array("K",$types)) {
					$age[0] = " checked";
				}
				if (in_array("KP",$types)) {
					$age[1] = " checked";
				}
				if (in_array("T",$types)) {
					$age[2] = " checked";
				}
				if (in_array("M",$types)) {
					$age[3] = " checked";
				}
			}
			/* ############################################# */
			$smut = array(0 => "", 1 => "", 2 => "", 3 => "", 4 => "", 5 => "");
			if (isset($_GET['sSmut'])) {
				$dSmut = Decode($_GET['sSmut']);
			} else {
				$dSmut = FALSE;
			}
			if ($dSmut != FALSE) {
				$types = explode(",",$dSmut);
				if (in_array("N",$types)) {
					$smut[0] = " checked";
				}
				if (in_array("PL",$types)) {
					$smut[1] = " checked";
				}
				if (in_array("L",$types)) {
					$smut[2] = " checked";
				}
				if (in_array("M",$types)) {
					$smut[3] = " checked";
				}
				if (in_array("H",$types)) {
					$smut[4] = " checked";
				}
				if (in_array("PU",$types)) {
					$smut[5] = " checked";
				}
			}
			/* ############################################# */
			$more = "";
			$less = "";
			$between = "";
			$len = "";
			$len1 = "";
			$len2 = "";
			if (isset($_GET['sWords'])) {
				$sWords = Decode($_GET['sWords']);
				if (isset($_GET['sWords2'])) {
					$sWords2 = Decode($_GET['sWords2']);
				}
			} else {
				$sWords = FALSE;
			}
			if ($sWords != FALSE) {
				if (mb_substr($sWords,0,1,'UTF-8') == "M" and is_numeric(mb_substr($sWords,1,null,'UTF-8'))) {
					$more = " checked";
					$less = "";
					$between = "";
					$len = mb_substr($sWords,1,null,'UTF-8');
					$len1 = "";
					$len2 = "";
				} else if (mb_substr($sWords,0,1,'UTF-8') == "L" and is_numeric(mb_substr($sWords,1,null,'UTF-8'))) {
					$more = "";
					$less = " checked";
					$between = "";
					$len = mb_substr($sWords,1,null,'UTF-8');
					$len1 = "";
					$len2 = "";
				} else if (mb_substr($sWords,0,1,'UTF-8') == "B" and is_numeric(mb_substr($sWords,1,null,'UTF-8')) and isset($_GET['sWords2'])and is_numeric($sWords2)) {
					$more = "";
					$less = "";
					$between = " checked";
					$len = "";
					$len1 = mb_substr($sWords,1,null,'UTF-8');
					$len2 = $sWords2;
				} else {
					$found = False;
				}
			}
			/* ############################################# */
			$beforePublished = "";
			$sincePublished = "";
			$dayPublished = null;
			$monthPublished = null;
			$yearPublished = null;
			if (isset($_GET['sDatePublished'])) {
				$sDatePublished = Decode($_GET['sDatePublished']);
			} else {
				$sDatePublished = FALSE;
			}
			if ($sDatePublished != FALSE) {
				date_default_timezone_set('UTC');
				try {
					$dayPublished = date("d",mb_substr($sDatePublished,1,null,'UTF-8'));
					$monthPublished = date("m",mb_substr($sDatePublished,1,null,'UTF-8'));
					$yearPublished = date("Y",mb_substr($sDatePublished,1,null,'UTF-8'));
				} catch (Exception $e) {
					// Invalid Time
				}
				if (mb_substr($sDatePublished,0,1,'UTF-8') == "B" and is_numeric(mb_substr($sDatePublished,1,null,'UTF-8'))) {
					$beforePublished = " checked";
					$sincePublished = "";
				} else if (mb_substr($sDatePublished,0,1,'UTF-8') == "S" and is_numeric(mb_substr($sDatePublished,1,null,'UTF-8'))) {
					$beforePublished = "";
					$sincePublished = " checked";
				}
			}
			/* ############################################# */
			$beforeUpdated = "";
			$sinceUpdated = "";
			$dayUpdated = null;
			$monthUpdated = null;
			$yearUpdated = null;
			if (isset($_GET['sDateUpdated'])) {
				$sDateUpdated = Decode($_GET['sDateUpdated']);
			} else {
				$sDateUpdated = FALSE;
			}
			if ($sDateUpdated != FALSE) {
				date_default_timezone_set('UTC');
				try {
					$dayUpdated = date("d",mb_substr($sDateUpdated,1,null,'UTF-8'));
					$monthUpdated = date("m",mb_substr($sDateUpdated,1,null,'UTF-8'));
					$yearUpdated = date("Y",mb_substr($sDateUpdated,1,null,'UTF-8'));
				} catch (Exception $e) {
					// Invalid Time
				}
				if (mb_substr($sDateUpdated,0,1,'UTF-8') == "B" and is_numeric(mb_substr($sDateUpdated,1,null,'UTF-8'))) {
					$beforeUpdated = " checked";
					$sinceUpdated = "";
				} else if (mb_substr($sDateUpdated,0,1,'UTF-8') == "S" and is_numeric(mb_substr($sDateUpdated,1,null,'UTF-8'))) {
					$beforeUpdated = "";
					$sinceUpdated = " checked";
				}
			}
			/* ############################################# */
			$beforeAdded = "";
			$sinceAdded = "";
			$dayAdded = null;
			$monthAdded = null;
			$yearAdded = null;
			if (isset($_GET['sDateAdded'])) {
				$sDateAdded = Decode($_GET['sDateAdded']);
			} else {
				$sDateAdded = FALSE;
			}
			if ($sDateAdded != FALSE) {
				date_default_timezone_set('UTC');
				try {
					$dayAdded = date("d",mb_substr($sDateAdded,1,null,'UTF-8'));
					$monthAdded = date("m",mb_substr($sDateAdded,1,null,'UTF-8'));
					$yearAdded = date("Y",mb_substr($sDateAdded,1,null,'UTF-8'));
				} catch (Exception $e) {
					// Invalid Time
				}
				if (mb_substr($sDateAdded,0,1,'UTF-8') == "B" and is_numeric(mb_substr($sDateAdded,1,null,'UTF-8'))) {
					$beforeAdded = " checked";
					$sinceAdded = "";
				} else if (mb_substr($sDateAdded,0,1,'UTF-8') == "S" and is_numeric(mb_substr($sDateAdded,1,null,'UTF-8'))) {
					$beforeAdded = "";
					$sinceAdded = " checked";
				}
			}
			/* ############################################# */
			
			echo "\t\t<!-- FILTER START -->
		<form action='filter.php' method='post'>
			<table style='border-collapse: collapse;'>
			<tr>
			
			
			
			<td style='border: 1px solid black'>
			Title<br />
			<input type='text' name='Title' value='".$titleDefault."' placeholder='Title'>
			</td>
			<td style='border: 1px solid black'>
			Author<br />
			<input type='text' name='Author' value='".$authorDefault."' placeholder='Author'>
			</td>
			<td style='border: 1px solid black'>
			Words<br />
			<input type='radio' name='WordsType' value='M'".$more."> More Than<br />
			<input type='radio' name='WordsType' value='L'".$less."> Less Than<br />
			<input type='number' name='Words' value='".$len."' min='1'> words<br />
			<input type='radio' name='WordsType' value='B'".$between."> Between<br />
			<input type='number' name='WordsB1' value='".$len1."' min='1'> and
			<input type='number' name='WordsB2' value='".$len2."' min='1'> words
			</td>
			<td style='border: 1px solid black'>
			Story Type<br />
			<input type='checkbox' name='StoryType1' value='MC'".$sT[0]."> Multi-Chapter<br />
			<input type='checkbox' name='StoryType2' value='OS'".$sT[1]."> One-Shot<br />
			<input type='checkbox' name='StoryType3' value='OSS'".$sT[2]."> One-Shot Series
			</td>
			<td style='border: 1px solid black'>
			Complete<br />
			<input type='checkbox' name='Complete1' value='Y'".$com[0]."> Yes<br />
			<input type='checkbox' name='Complete2' value='N'".$com[1]."> No<br />
			<input type='checkbox' name='Complete3' value='U'".$com[2]."> Unknown
			</td>
			<td style='border: 1px solid black'>
			Setting<br />
			<input type='checkbox' name='Setting1' value='C'".$setting[0]."> Canon<br />
			<input type='checkbox' name='Setting2' value='AU'".$setting[1]."> Alternate Universe (AU)<br />
			<input type='checkbox' name='Setting3' value='mAU'".$setting[2]."> Modern Alternate Universe (mAU)<br />
			<input type='checkbox' name='Setting4' value='STP'".$setting[3]."> Same Time and Place (STP)<br />
			<input type='checkbox' name='Setting5' value='U'".$setting[4]."> Unknown
			</td>
			<td style='border: 1px solid black'>
			Elsa's Character<br />
			<input type='text' name='ElsaCharacter' value='".$eCharDefault."' placeholder='Queen'>
			</td>
			<td style='border: 1px solid black'>
			Anna's Character<br />
			<input type='text' name='AnnaCharacter' value='".$aCharDefault."' placeholder='Princess'>
			</td>
			<td style='border: 1px solid black'>
			Elsa's Powers<br />
			<input type='checkbox' name='ElsaPowers1' value='C'".$ePowers[0]."> Canon<br />
			<input type='checkbox' name='ElsaPowers2' value='D'".$ePowers[1]."> Different<br />
			<input type='checkbox' name='ElsaPowers3' value='N'".$ePowers[2]."> None<br />
			<input type='checkbox' name='ElsaPowers4' value='U'".$ePowers[3]."> Unknown
			</td>
			<td style='border: 1px solid black'>
			Anna's Powers<br />
			<input type='checkbox' name='AnnaPowers1' value='N'".$aPowers[0]."> No<br />
			<input type='checkbox' name='AnnaPowers2' value='Y'".$aPowers[1]."> Yes
			</td>
			<td style='border: 1px solid black'>
			Sisters<br />
			<input type='checkbox' name='Sisters1' value='Y'".$sisters[0]."> Yes<br />
			<input type='checkbox' name='Sisters2' value='N'".$sisters[1]."> No<br />
			<input type='checkbox' name='Sisters3' value='U'".$sisters[2]."> Unknown
			</td>
			<td style='border: 1px solid black'>
			Age [<a href='https://www.fictionratings.com/'>X</a>]<br />
			<input type='checkbox' name='Age1' value='K'".$age[0]."> K<br />
			<input type='checkbox' name='Age2' value='KP'".$age[1]."> K+<br />
			<input type='checkbox' name='Age3' value='T'".$age[2]."> T<br />
			<input type='checkbox' name='Age4' value='M'".$age[3]."> M
			</td>
			<td style='border: 1px solid black'>
			Smut Prominence<br />
			<input type='checkbox' name='SmutLevel1' value='N'".$smut[0]."> None<br />
			<input type='checkbox' name='SmutLevel2' value='PL'".$smut[1]."> Plot Focused<br />
			<input type='checkbox' name='SmutLevel3' value='L'".$smut[2]."> Light<br />
			<input type='checkbox' name='SmutLevel4' value='M'".$smut[3]."> Medium<br />
			<input type='checkbox' name='SmutLevel5' value='H'".$smut[4]."> Heavy<br />
			<input type='checkbox' name='SmutLevel6' value='PU'".$smut[5]."> Pure
			</td>
			<td style='border: 1px solid black'>
			Date Updated<br />
			<input type='radio' name='DateUpdatedType' value='B'".$before."> Before<br />
			<input type='radio' name='DateUpdatedType' value='S'".$since."> Since<br />
			<select name='DayUpdated'>\n";
					// Print all days and select current
					for ($i = 1; $i <= 31; $i ++) {
						if (($currentDay == str_pad($i, 2, '0', STR_PAD_LEFT) and $dayUpdated == null) or ($dayUpdated == $i)) {
							echo "\t\t\t\t<option value='".str_pad($i, 2, '0', STR_PAD_LEFT)."' selected>".str_pad($i, 2, '0', STR_PAD_LEFT)."</option>\n";
						} else {
							echo "\t\t\t\t<option value='".str_pad($i, 2, '0', STR_PAD_LEFT)."'>".str_pad($i, 2, '0', STR_PAD_LEFT)."</option>\n";
						}
					}
				echo "\t\t\t</select>
			<select name='MonthUpdated'>\n";
					// Print all months and select current
					for ($i = 1; $i <= 12; $i ++) {
						if (($currentMonth == str_pad($i, 2, '0', STR_PAD_LEFT) and $monthUpdated == null) or ($monthUpdated == $i)) {
							echo "\t\t\t\t<option value='".str_pad($i, 2, '0', STR_PAD_LEFT)."' selected>".str_pad($i, 2, '0', STR_PAD_LEFT)."</option>\n";
						} else {
							echo "\t\t\t\t<option value='".str_pad($i, 2, '0', STR_PAD_LEFT)."'>".str_pad($i, 2, '0', STR_PAD_LEFT)."</option>\n";
						}
					}
				echo "\t\t\t</select>
			<select name='YearUpdated'>\n";
					// Print all years and select current
					for ($i = 2013; $i <= intval($currentYear); $i ++) {
						if (($currentYear == $i and $yearUpdated == null) or ($yearUpdated == $i)) {
							echo "\t\t\t\t<option value='".str_pad($i, 2, '0', STR_PAD_LEFT)."' selected>".str_pad($i, 2, '0', STR_PAD_LEFT)."</option>\n";
						} else {
							echo "\t\t\t\t<option value='".str_pad($i, 2, '0', STR_PAD_LEFT)."'>".str_pad($i, 2, '0', STR_PAD_LEFT)."</option>\n";
						}
					}
				echo "\t\t\t</select>
			</td>
			<td style='border: 1px solid black'>
			Date Published<br />
			<input type='radio' name='DatePublishedType' value='B'".$before."> Before<br />
			<input type='radio' name='DatePublishedType' value='S'".$since."> Since<br />
			<select name='DayPublished'>\n";
					// Print all days and select current
					for ($i = 1; $i <= 31; $i ++) {
						if (($currentDay == str_pad($i, 2, '0', STR_PAD_LEFT) and $dayPublished == null) or ($dayPublished == $i)) {
							echo "\t\t\t\t<option value='".str_pad($i, 2, '0', STR_PAD_LEFT)."' selected>".str_pad($i, 2, '0', STR_PAD_LEFT)."</option>\n";
						} else {
							echo "\t\t\t\t<option value='".str_pad($i, 2, '0', STR_PAD_LEFT)."'>".str_pad($i, 2, '0', STR_PAD_LEFT)."</option>\n";
						}
					}
				echo "\t\t\t</select>
			<select name='MonthPublished'>\n";
					// Print all months and select current
					for ($i = 1; $i <= 12; $i ++) {
						if (($currentMonth == str_pad($i, 2, '0', STR_PAD_LEFT) and $monthPublished == null) or ($monthPublished == $i)) {
							echo "\t\t\t\t<option value='".str_pad($i, 2, '0', STR_PAD_LEFT)."' selected>".str_pad($i, 2, '0', STR_PAD_LEFT)."</option>\n";
						} else {
							echo "\t\t\t\t<option value='".str_pad($i, 2, '0', STR_PAD_LEFT)."'>".str_pad($i, 2, '0', STR_PAD_LEFT)."</option>\n";
						}
					}
				echo "\t\t\t</select>
			<select name='YearPublished'>\n";
					// Print all years and select current
					for ($i = 2013; $i <= intval($currentYear); $i ++) {
						if (($currentYear == $i and $yearPublished == null) or ($yearPublished == $i)) {
							echo "\t\t\t\t<option value='".str_pad($i, 2, '0', STR_PAD_LEFT)."' selected>".str_pad($i, 2, '0', STR_PAD_LEFT)."</option>\n";
						} else {
							echo "\t\t\t\t<option value='".str_pad($i, 2, '0', STR_PAD_LEFT)."'>".str_pad($i, 2, '0', STR_PAD_LEFT)."</option>\n";
						}
					}
				echo "\t\t\t</select>
			</td>
			<td style='border: 1px solid black'>
			Date Added<br />
			<input type='radio' name='DateAddedType' value='B'".$before."> Before<br />
			<input type='radio' name='DateAddedType' value='S'".$since."> Since<br />
			<select name='DayAdded'>\n";
					// Print all days and select current
					for ($i = 1; $i <= 31; $i ++) {
						if (($currentDay == str_pad($i, 2, '0', STR_PAD_LEFT) and $dayAdded == null) or ($dayAdded == $i)) {
							echo "\t\t\t\t<option value='".str_pad($i, 2, '0', STR_PAD_LEFT)."' selected>".str_pad($i, 2, '0', STR_PAD_LEFT)."</option>\n";
						} else {
							echo "\t\t\t\t<option value='".str_pad($i, 2, '0', STR_PAD_LEFT)."'>".str_pad($i, 2, '0', STR_PAD_LEFT)."</option>\n";
						}
					}
				echo "\t\t\t</select>
			<select name='MonthAdded'>\n";
					// Print all months and select current
					for ($i = 1; $i <= 12; $i ++) {
						if (($currentMonth == str_pad($i, 2, '0', STR_PAD_LEFT) and $monthAdded == null) or ($monthAdded == $i)) {
							echo "\t\t\t\t<option value='".str_pad($i, 2, '0', STR_PAD_LEFT)."' selected>".str_pad($i, 2, '0', STR_PAD_LEFT)."</option>\n";
						} else {
							echo "\t\t\t\t<option value='".str_pad($i, 2, '0', STR_PAD_LEFT)."'>".str_pad($i, 2, '0', STR_PAD_LEFT)."</option>\n";
						}
					}
				echo "\t\t\t</select>
			<select name='YearAdded'>\n";
					// Print all years and select current
					for ($i = 2013; $i <= intval($currentYear); $i ++) {
						if (($currentYear == $i and $yearAdded == null) or ($yearAdded == $i)) {
							echo "\t\t\t\t<option value='".str_pad($i, 2, '0', STR_PAD_LEFT)."' selected>".str_pad($i, 2, '0', STR_PAD_LEFT)."</option>\n";
						} else {
							echo "\t\t\t\t<option value='".str_pad($i, 2, '0', STR_PAD_LEFT)."'>".str_pad($i, 2, '0', STR_PAD_LEFT)."</option>\n";
						}
					}
				echo "\t\t\t</select>
			</td>
			
			
			
			</tr>
			</table>
			<input type='submit' value='Search'> <a href='?code=".$_GET['code']."'>Basic Search</a>
		</form>
		<!-- FILTER END -->\n";
		}
		
			
			function search($search, $rows, $indexesToSearch) {
				$debug = False;
				$words = explode(" ",$search);
				$wordcount = count($words);
				$validStories = array();
				foreach ($rows as $rowIndex => $row) {
					$hitCounter = -1;
					if ($search != "") {
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
					if ($hitCounter != 0 and $row['Moderated'] == 1) {
						array_push($validStories, array(0 => $rowIndex, 1 => $hitCounter, 2 => $row['Title']));
					}
				}
				return $validStories;
			}
			
			// Sort the stories by hitcounter, then name alphabetically
			function custom_sort($a,$b) {
				if ($a[1] == $b[1]) {
					return strcmp($a[2], $b[2]);
				} else {
				// if ($a[1] == $b[1]) {
					// return $a[3]<$b[3];
				// } else {
					return $a[1]<$b[1];
				}
			}
			
			include("config.php");
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
			$stmt = $pdo->prepare('SELECT StoryId,Title,Author,Chapters,Words,StoryType,Complete,Setting,ElsaCharacter,AnnaCharacter,ElsaPowers,AnnaPowers,Sisters,Age,SmutLevel,TimeAdded,TimeUpdated,TimePublished,Moderated FROM Stories;');
			$stmt->execute();
			$rows = $stmt->fetchAll();			
					
			function intdiv($a, $b){
				return ($a - $a % $b) / $b;
			}
					
			// Search Engine Start
			if ($_GET['a'] == 1) {
				$validStories = array();
				foreach ($rows as $key => $story) {
					$found = True;
					// For each detail one can filter, check if the user has filtered it, convert from numbers to letters and remove story if doesn't match filters
					/* ############################################################### */
					if (isset($_GET['sTitle']) and $found == True) {
						$sTitle = Decode($_GET['sTitle']);
					} else {
						$sTitle = FALSE;
					}
					if ($sTitle != FALSE and $story['Title'] != "") {
						if (mb_stripos($story['Title'], $sTitle, 0, 'UTF-8') === false) {
							$found = False;
						}
					}
					/* ############################################################### */
					if (isset($_GET['sAuthor']) and $found == True) {
						$sAuthor = Decode($_GET['sAuthor']);
					} else {
						$sAuthor = FALSE;
					}
					if ($sAuthor != FALSE and $story['Author'] != "") {
						if (mb_stripos($story['Author'], $sAuthor, 0, 'UTF-8') === false) {
							$found = False;
						}
					}
					/* ############################################################### */
					if (isset($_GET['sWords']) and $found == True) {
						$sWords = Decode($_GET['sWords']);
						if (isset($_GET['sWords2'])) {
							$sWords2 = Decode($_GET['sWords2']);
						}
					} else {
						$sWords = FALSE;
					}
					if ($sWords != FALSE) {
						if (mb_substr($sWords,0,1,'UTF-8') == "M" and is_numeric(mb_substr($sWords,1,null,'UTF-8'))) {
							if ($story['Words'] <= mb_substr($sWords,1,null,'UTF-8')) {
								$found = False;
							}
						} else if (mb_substr($sWords,0,1,'UTF-8') == "L" and is_numeric(mb_substr($sWords,1,null,'UTF-8'))) {
							if ($story['Words'] >= mb_substr($sWords,1,null,'UTF-8')) {
								$found = False;
							}
						} else if (mb_substr($sWords,0,1,'UTF-8') == "B" and isset($_GET['sWords2']) and is_numeric(mb_substr($sWords,1,null,'UTF-8')) and is_numeric($sWords2)) {
							if ($story['Words'] < mb_substr($sWords,1,null,'UTF-8')) {
								$found = False;
							} else if ($story['Words'] > $sWords2) {
								$found = False;
							}
						} else {
							$found = False;
						}
					}
					/* ############################################################### */
					if (isset($_GET['sType']) and $found == True) {
						$sType = Decode($_GET['sType']);
					} else {
						$sType = FALSE;
					}
					if ($sType != FALSE) {
						$types = explode(",",$sType);
						if (!in_array($story['StoryType'],$types)) {
							$found = False;
						}
					}
					/* ############################################################### */
					if (isset($_GET['sComplete']) and $found == True) {
						$sComplete = Decode($_GET['sComplete']);
					} else {
						$sComplete = FALSE;
					}
					if ($sComplete != FALSE) {
						$states = explode(",",$sComplete);
						if (!in_array($story['Complete'],$states)) {
							$found = False;
						}
					}
					/* ############################################################### */
					if (isset($_GET['sSetting']) and $found == True) {
						$sSetting = Decode($_GET['sSetting']);
					} else {
						$sSetting = FALSE;
					}
					if ($sSetting != FALSE) {
						$states = explode(",",$sSetting);
						if (!in_array($story['Setting'],$states)) {
							$found = False;
						}
					}
					/* ############################################################### */
					if (isset($_GET['sEChar']) and $found == True) {
						$sEChar = Decode($_GET['sEChar']);
					} else {
						$sEChar = FALSE;
					}
					if ($sEChar != FALSE and $story['ElsaCharacter'] != "") {
						if (mb_stripos($story['ElsaCharacter'], $sEChar, 0, 'UTF-8') === false) {
							$found = False;
						}
					}
					/* ############################################################### */
					if (isset($_GET['sAChar']) and $found == True) {
						$sAChar = Decode($_GET['sAChar']);
					} else {
						$sAChar = FALSE;
					}
					if ($sAChar != FALSE and $story['AnnaCharacter'] != "") {
						if (mb_stripos($story['AnnaCharacter'], $sAChar, 0, 'UTF-8') === false) {
							$found = False;
						}
					}
					/* ############################################################### */
					if (isset($_GET['sEPowers']) and $found == True) {
						$sEPowers = Decode($_GET['sEPowers']);
					} else {
						$sEPowers = FALSE;
					}
					if ($sEPowers != FALSE) {
						$states = explode(",",$sEPowers);
						if (!in_array($story['ElsaPowers'],$states)) {
							$found = False;
						}
					}
					/* ############################################################### */
					if (isset($_GET['sAPowers']) and $found == True) {
						$sAPowers = Decode($_GET['sAPowers']);
					} else {
						$sAPowers = FALSE;
					}
					if ($sAPowers != FALSE) {
						$states = explode(",",$sAPowers);
						if (!in_array($story['AnnaPowers'],$states)) {
							$found = False;
						}
					}
					/* ############################################################### */
					if (isset($_GET['sSisters']) and $found == True) {
						$sSisters = Decode($_GET['sSisters']);
					} else {
						$sSisters = FALSE;
					}
					if ($sSisters != FALSE) {
						$states = explode(",",$sSisters);
						if (!in_array($story['Sisters'],$states)) {
							$found = False;
						}
					}
					/* ############################################################### */
					if (isset($_GET['sAge']) and $found == True) {
						$sAge = Decode($_GET['sAge']);
					} else {
						$sAge = FALSE;
					}
					if ($sAge != FALSE) {
						$states = explode(",",$sAge);
						if (!in_array($story['Age'],$states)) {
							$found = False;
						}
					}
					/* ############################################################### */
					if (isset($_GET['sSmut']) and $found == True) {
						$sSmut = Decode($_GET['sSmut']);
					} else {
						$sSmut = FALSE;
					}
					if ($sSmut != FALSE) {
						$states = explode(",",$sSmut);
						if (!in_array($story['SmutLevel'],$states)) {
							$found = False;
						}
					}
					/* ############################################################### */
					if (isset($_GET['sDatePublished']) and $found == True) {
						$sDatePublished = Decode($_GET['sDatePublished']);
					} else {
						$sDatePublished = FALSE;
					}

					if ($sDatePublished != FALSE) {
						if (mb_substr($sDatePublished,0,1,'UTF-8') == "B" and is_numeric(mb_substr($sDatePublished,1,null,'UTF-8'))) {
							try {
								$timePublished = $story['TimePublished'];
								$filterTime = intdiv(mb_substr($sDatePublished,1,null,'UTF-8'),86400) * 86400;
								if ($timePublished > $filterTime) {
									$found = False;
								}
							} catch (Exception $e) {
								// Invalid Date
								$found = False;
							}
						} else if (mb_substr($sDatePublished,0,1,'UTF-8') == "S" and is_numeric(mb_substr($sDatePublished,1,null,'UTF-8'))) {
							try {
								$timePublished = $story['TimePublished'];
								$filterTime = intdiv(mb_substr($sDatePublished,1,null,'UTF-8'),86400) * 86400;
								if ($timePublished < $filterTime) {
									$found = False;
								}
							} catch (Exception $e) {
								// Invalid Date
								$found = False;
							}
						} else {
							$found = False;
						}
					}
					/* ############################################################### */
					if (isset($_GET['sDateUpdated']) and $found == True) {
						$sDateUpdated = Decode($_GET['sDateUpdated']);
					} else {
						$sDateUpdated = FALSE;
					}

					if ($sDateUpdated != FALSE) {
						if (mb_substr($sDateUpdated,0,1,'UTF-8') == "B" and is_numeric(mb_substr($sDateUpdated,1,null,'UTF-8'))) {
							try {
								$timeUpdated = $story['TimeUpdated'];
								$filterTime = intdiv(mb_substr($sDateUpdated,1,null,'UTF-8'),86400) * 86400;
								if ($timeUpdated > $filterTime) {
									$found = False;
								}
							} catch (Exception $e) {
								// Invalid Date
								$found = False;
							}
						} else if (mb_substr($sDateUpdated,0,1,'UTF-8') == "S" and is_numeric(mb_substr($sDateUpdated,1,null,'UTF-8'))) {
							try {
								$timeUpdated = $story['TimeUpdated'];
								$filterTime = intdiv(mb_substr($sDateUpdated,1,null,'UTF-8'),86400) * 86400;
								if ($timeUpdated < $filterTime) {
									$found = False;
								}
							} catch (Exception $e) {
								// Invalid Date
								$found = False;
							}
						} else {
							$found = False;
						}
					}
					/* ############################################################### */
					if (isset($_GET['sDateAdded']) and $found == True) {
						$sDateAdded = Decode($_GET['sDateAdded']);
					} else {
						$sDateAdded = FALSE;
					}

					if ($sDateAdded != FALSE) {
						if (mb_substr($sDateAdded,0,1,'UTF-8') == "B" and is_numeric(mb_substr($sDateAdded,1,null,'UTF-8'))) {
							try {
								$timeAdded = $story['TimeAdded'];
								$filterTime = intdiv(mb_substr($sDateAdded,1,null,'UTF-8'),86400) * 86400;
								if ($timeAdded > $filterTime) {
									$found = False;
								}
							} catch (Exception $e) {
								// Invalid Date
								$found = False;
							}
						} else if (mb_substr($sDateAdded,0,1,'UTF-8') == "S" and is_numeric(mb_substr($sDateAdded,1,null,'UTF-8'))) {
							try {
								$timeAdded = $story['TimeAdded'];
								$filterTime = intdiv(mb_substr($sDateAdded,1,null,'UTF-8'),86400) * 86400;
								if ($timeAdded < $filterTime) {
									$found = False;
								}
							} catch (Exception $e) {
								// Invalid Date
								$found = False;
							}
						} else {
							$found = False;
						}
					}
					/* ############################################################### */
					if ($found == True and $story['Moderated'] == 1) {
						array_push($validStories, array(0 => $key, 1 => 1, 2 => $story['Title']));
					}
				}
			} else {
				$indexesToSearch = array(0 => "Title",
										 1 => "Author",
										 2 => "ElsaCharacter",
										 3 => "AnnaCharacter");
				$validStories = search($_GET['search'],$rows,$indexesToSearch);
			}
			// Search Engine End
?>
		<table>
			<tr><th>Title</th></tr>
<?php
				// Call custom_sort()
				usort($validStories, "custom_sort");
				foreach ($validStories as $story) {
					// Print out the stories returned by search engine
					echo "\t\t\t<tr><td><a href='/story/?id=".$rows[$story[0]]['StoryId']."'>".$story[2]."</a></td></tr>\n";
				}
?>
		</table>
	</body>
</html>
