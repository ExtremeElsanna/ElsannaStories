<?php
	function toNumbers($param) {
		set_error_handler(function() { /* ignore errors */ });
		$encParam = bin2hex(mb_convert_encoding($param, 'UCS-2', 'UTF-8'));
		//$encParam = $param;
		restore_error_handler();
		return $encParam;
	}
	
	include("/hdd/elsanna-ssl/scripts/sessionHandler.php");
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
		$encParam = toNumbers($param);
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
			case "LengthType":
				if ($_POST['LengthType'] == "M" and isset($_POST['Length']) and is_numeric($_POST['Length'])) {
					$getParams = $getParams."sLength=".toNumbers("M".$_POST['Length'])."&";
				} else if ($_POST['LengthType'] == "L" and isset($_POST['Length']) and is_numeric($_POST['Length'])) {
					$getParams = $getParams."sLength=".toNumbers("L".$_POST['Length'])."&";
				} else if ($_POST['LengthType'] == "B" and isset($_POST['LengthB1']) and is_numeric($_POST['LengthB1']) and isset($_POST['LengthB2']) and is_numeric($_POST['LengthB2'])) {
					if ($_POST['LengthB1'] <= $_POST['LengthB2']) {
						$num1 = $_POST['LengthB1'];
						$num2 = $_POST['LengthB2'];
					} else {
						$num1 = $_POST['LengthB2'];
						$num2 = $_POST['LengthB1'];
					}
					$getParams = $getParams."sLength=".toNumbers("B".$num1)."&sLength2=".toNumbers($num2)."&";
				}
				break;
			case "ElsaCharcter":
				if ($_POST['ElsaCharcter'] != "") {
					$getParams = $getParams."sEChar=".$encParam."&";
				}
				break;
			case "AnnaCharcter":
				if ($_POST['AnnaCharcter'] != "") {
					$getParams = $getParams."sAChar=".$encParam."&";
				}
				break;
			case "DayPublished":
				if (isset($_POST['MonthPublished']) and isset($_POST['YearPublished']) and is_numeric($_POST['DayPublished']) and is_numeric($_POST['MonthPublished']) and is_numeric($_POST['YearPublished']) and isset($_POST['DateType']) and ($_POST['DateType'] == "B" or $_POST['DateType'] == "S")) {
					try {
						$encParam = toNumbers($_POST['DateType'].strtotime ( $_POST['DayPublished']."/".$_POST['MonthPublished']."/".$_POST['YearPublished']));
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
		$getParams .= "sType=".toNumbers(mb_substr($storyType, 0, -1, "UTF-8"))."&";
	}
	if ($complete != "") {
		$getParams .= "sComplete=".toNumbers(mb_substr($complete, 0, -1, "UTF-8"))."&";
	}
	if ($setting != "") {
		$getParams .= "sSetting=".toNumbers(mb_substr($setting, 0, -1, "UTF-8"))."&";
	}
	if ($elsaPowers != "") {
		$getParams .= "sEPowers=".toNumbers(mb_substr($elsaPowers, 0, -1, "UTF-8"))."&";
	}
	if ($annaPowers != "") {
		$getParams .= "sAPowers=".toNumbers(mb_substr($annaPowers, 0, -1, "UTF-8"))."&";
	}
	if ($sisters != "") {
		$getParams .= "sSisters=".toNumbers(mb_substr($sisters, 0, -1, "UTF-8"))."&";
	}
	if ($age != "") {
		$getParams .= "sAge=".toNumbers(mb_substr($age, 0, -1, "UTF-8"))."&";
	}
	if ($smutLevel != "") {
		$getParams .= "sSmut=".toNumbers(mb_substr($smutLevel, 0, -1, "UTF-8"));
	}
	$getParams = mb_substr($getParams, 0, -1, "UTF-8");
	header("Location: /?a=1&".$getParams);
?>