<?php
function substri_count($haystack, $needle) {
	return substr_count(mb_strtoupper($haystack, 'UTF-8'), mb_strtoupper($needle, 'UTF-8'));
}

$dummySearch = $_GET['search'];
$debug = True;
$row = array(0 => 1,
			 1 => $_GET['story']);
$words = explode(" ",$dummySearch);
$wordcount = count($words);

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
		$persplitcount = substri_count($row[1],$split);
		if ($debug == True) {
			echo '"'.$split.'" - '.$persplitcount;
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
			$persplitcount = substri_count($row[1],$split);
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
			$persplitcount = substri_count($row[1],$split);
			echo "I'm here!";
			if ($debug == True) {
				echo '"'.$split.'" - '.$persplitcount." and ";
			}
			echo "I'm here!";
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
		$persplitcount = substri_count($row[1],$split);
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
}
if ($debug == True) {
	echo "-----------------<br><br>";
}
?>