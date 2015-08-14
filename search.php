<?php
function substri_count($haystack, $needle) {
	return substr_count(mb_strtoupper($haystack, 'UTF-8'), mb_strtoupper($needle, 'UTF-8'));
}

$dummySearch = $_GET['search'];
$debug = False;
$row = array(0 => 1,
			 1 => $_GET['story']);
$row2 = array(0 => 1,
			 1 => $_GET['story2']);
$rows = array(0 => $row,
			  1 => $row2);
$words = explode(" ",$dummySearch);
$wordcount = count($words);
foreach ($rows as $row) {
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
		$hitCounter += $hitCounts;
	}
	echo $hitCounter.'<br>';
}
?>