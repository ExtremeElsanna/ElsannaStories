<?php
	include("scripts/sessionHandler.php");
	include_once("scripts/functions.php");
	$getParams = "";
	$storyType = "";
	$complete = "";
	$setting = "";
	$elsaPowers = "";
	$annaPowers = "";
	$sisters = "";
	$age = "";
	$smutLevel = "";
	foreach ($_POST as $key => $param) {
		echo $key." : ".$param."<br>";
		set_error_handler(function() { /* ignore errors */ });
		$encParam = Encode($param);
		switch ($key) {
			case "Title":
				if ($_POST['Title'] != "") {
					$getParams = $getParams."sTitle=".$encParam."&";
				}
				break;
			case "Author":
				if ($_POST['Author'] != "") {
					$getParams = $getParams."sAuthor=".$encParam."&";
				}
				break;
			case "WordsType":
				if ($_POST['WordsType'] == "M" and isset($_POST['Words']) and is_numeric($_POST['Words'])) {
					$getParams = $getParams."sWords=".Encode("M".$_POST['Words'])."&";
				} else if ($_POST['WordsType'] == "L" and isset($_POST['Words']) and is_numeric($_POST['Words'])) {
					$getParams = $getParams."sWords=".Encode("L".$_POST['Words'])."&";
				} else if ($_POST['WordsType'] == "B" and isset($_POST['WordsB1']) and is_numeric($_POST['WordsB1']) and isset($_POST['WordsB2']) and is_numeric($_POST['WordsB2'])) {
					if ($_POST['WordsB1'] <= $_POST['WordsB2']) {
						$num1 = $_POST['WordsB1'];
						$num2 = $_POST['WordsB2'];
					} else {
						$num1 = $_POST['WordsB2'];
						$num2 = $_POST['WordsB1'];
					}
					$getParams = $getParams."sWords=".Encode("B".$num1)."&sWords2=".Encode($num2)."&";
				}
				break;
			case "ElsaCharacter":
				if ($_POST['ElsaCharacter'] != "") {
					$getParams = $getParams."sEChar=".$encParam."&";
				}
				break;
			case "AnnaCharacter":
				if ($_POST['AnnaCharacter'] != "") {
					$getParams = $getParams."sAChar=".$encParam."&";
				}
				break;
			case "DayPublished":
				if (isset($_POST['MonthPublished']) and isset($_POST['YearPublished']) and is_numeric($_POST['DayPublished']) and is_numeric($_POST['MonthPublished']) and is_numeric($_POST['YearPublished']) and isset($_POST['DateType']) and ($_POST['DateType'] == "B" or $_POST['DateType'] == "S")) {
					try {
						$encParam = Encode($_POST['DateType'].strtotime ( $_POST['YearPublished']."-".$_POST['MonthPublished']."-".$_POST['DayPublished']));
						$getParams = $getParams."sDate=".$encParam."&";
					} catch (Exception $e) {
						// Not a valid date
					}
				}
				break;
			/* START OF THE CHECK BOX OPTIONS */
			case "StoryType1":
				$storyType = $storyType."MC,";
				break;
			case "StoryType2":
				$storyType = $storyType."OS,";
				break;
			case "StoryType3":
				$storyType = $storyType."OSS,";
				break;
				
			case "Complete1":
				$complete = $complete."Y,";
				break;
			case "Complete2":
				$complete = $complete."N,";
				break;
			case "Complete3":
				$complete = $complete."U,";
				break;
				
			case "Setting1":
				$setting = $setting."C,";
				break;
			case "Setting2":
				$setting = $setting."AU,";
				break;
			case "Setting3":
				$setting = $setting."mAU,";
				break;
			case "Setting4":
				$setting = $setting."STP,";
				break;
			case "Setting5":
				$setting = $setting."U,";
				break;
				
			case "ElsaPowers1":
				$elsaPowers = $elsaPowers."C,";
				break;
			case "ElsaPowers2":
				$elsaPowers = $elsaPowers."D,";
				break;
			case "ElsaPowers3":
				$elsaPowers = $elsaPowers."N,";
				break;
			case "ElsaPowers4":
				$elsaPowers = $elsaPowers."U,";
				break;
				
			case "AnnaPowers1":
				$annaPowers = $annaPowers."N,";
				break;
			case "AnnaPowers2":
				$annaPowers = $annaPowers."Y,";
				break;
				
			case "Sisters1":
				$sisters = $sisters."Y,";
				break;
			case "Sisters2":
				$sisters = $sisters."N,";
				break;
			case "Sisters3":
				$sisters = $sisters."U,";
				break;
				
			case "Age1":
				$age = $age."K,";
				break;
			case "Age2":
				$age = $age."KP,";
				break;
			case "Age3":
				$age = $age."T,";
				break;
			case "Age4":
				$age = $age."M,";
				break;
				
			case "SmutLevel1":
				$smutLevel = $smutLevel."N,";
				break;
			case "SmutLevel2":
				$smutLevel = $smutLevel."PL,";
				break;
			case "SmutLevel3":
				$smutLevel = $smutLevel."L,";
				break;
			case "SmutLevel4":
				$smutLevel = $smutLevel."M,";
				break;
			case "SmutLevel5":
				$smutLevel = $smutLevel."H,";
				break;
			case "SmutLevel6":
				$smutLevel = $smutLevel."PU,";
				break;
		}
	}
	if ($storyType != "") {
		$getParams .= "sType=".Encode(mb_substr($storyType, 0, -1, "UTF-8"))."&";
	}
	if ($complete != "") {
		$getParams .= "sComplete=".Encode(mb_substr($complete, 0, -1, "UTF-8"))."&";
	}
	if ($setting != "") {
		$getParams .= "sSetting=".Encode(mb_substr($setting, 0, -1, "UTF-8"))."&";
	}
	if ($elsaPowers != "") {
		$getParams .= "sEPowers=".Encode(mb_substr($elsaPowers, 0, -1, "UTF-8"))."&";
	}
	if ($annaPowers != "") {
		$getParams .= "sAPowers=".Encode(mb_substr($annaPowers, 0, -1, "UTF-8"))."&";
	}
	if ($sisters != "") {
		$getParams .= "sSisters=".Encode(mb_substr($sisters, 0, -1, "UTF-8"))."&";
	}
	if ($age != "") {
		$getParams .= "sAge=".Encode(mb_substr($age, 0, -1, "UTF-8"))."&";
	}
	if ($smutLevel != "") {
		$getParams .= "sSmut=".Encode(mb_substr($smutLevel, 0, -1, "UTF-8"))."&";
	}
	$getParams = mb_substr($getParams, 0, -1, "UTF-8");
	if ($getParams != "")
	{
		header("Location: /?a=1&".$getParams);
	}
	else
	{
		header("Location: /?a=1");
	}
?>
