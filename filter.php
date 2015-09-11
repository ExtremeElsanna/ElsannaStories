<?php
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
		$encParam = bin2hex(mb_convert_encoding($param, 'UCS-2', 'UTF-8'));
		switch ($key) {
			case "Title":
				$getParams = $getParams."sTitle=".$encParam."&";
				break;
			case "Author":
				$getParams = $getParams."sAuthor=".$encParam."&";
				break;
			case "Length":
				$getParams = $getParams."sLength=".$encParam."&";
				break;
			case "ElsaCharcter":
				$getParams = $getParams."sEChar=".$encParam."&";
				break;
			case "AnnaCharcter":
				$getParams = $getParams."sAChar=".$encParam."&";
				break;
			case "DayPublished":
				if (isset($_POST['MonthPublished']) and isset($_POST['YearPublished'])) {
					$encParam = bin2hex(mb_convert_encoding(strtotime ( $_POST['DayPublished']."/".$_POST['MonthPublished']."/".$_POST['YearPublished']), 'UCS-2', 'UTF-8'));
					$getParams = $getParams."sDate=".$encParam."&";
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
	$getParams .= mb_substr($storyType, 0, -1, "UTF-8")."&";
	$getParams .= mb_substr($complete, 0, -1, "UTF-8")."&";
	$getParams .= mb_substr($setting, 0, -1, "UTF-8")."&";
	$getParams .= mb_substr($elsaPowers, 0, -1, "UTF-8")."&";
	$getParams .= mb_substr($annaPowers, 0, -1, "UTF-8")."&";
	$getParams .= mb_substr($sisters, 0, -1, "UTF-8")."&";
	$getParams .= mb_substr($age, 0, -1, "UTF-8")."&";
	$getParams .= mb_substr($smutLevel, 0, -1, "UTF-8");
	echo $getParams;
	die;
	header("Location: /?search=".$_POST['search']);
?>