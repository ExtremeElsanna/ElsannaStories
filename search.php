<?php
function substri_count($haystack, $needle) {
	return substr_count(mb_strtoupper($haystack, 'UTF-8'), mb_strtoupper($needle, 'UTF-8'));
}

$dummySearch = $_GET['search'];
$debug = True;
$row = array(0 => 1,
			 1 => "Test Conceal story");
$words = explode(" ",$dummySearch);
$wordcount = count($words);

if ($debug == True) {
	echo $row[1]."<br><br>";
}
for ($i = $wordcount; $i > 0; $i--) {
	$maxiterations = $wordcount-($i-1);
	$query = array();
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
		array_push($query,$split);
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
	//array_push($queries,$query);
	//array_push($query_array,$hitCounts);
	//array_push($types,0);
	
	// start non overlapping section
	if ($i > 1) {
		
		for ($y = 1; $y < $i; $y++) {
			$maxiterations = $wordcount-($i-1);
			$query = array();
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
			array_push($query,$split);
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
			array_push($query,$split);
			$hitCounts += $persplitcount;
			if ($no_results_found == True) {
				$hitCounts = 0;
			}
			
			if ($debug == True) {
				echo "<br>";
				echo "Total ".$hitCounts;
				echo "<br><br>";
			}
			//array_push($queries,$query);
			//array_push($query_array,$hitCounts);
			//array_push($types,0);
		}
	}
}
for ($i = $wordcount; $i > 0; $i--) {
	$maxiterations = $wordcount-($i-1);
	$query = array();
	$hitCounts = 0;
	for ($y = 0; $y < $maxiterations; $y++) {
		$persplitcount = 0;
		$no_results_found = False;
		$split = "";
		for ($x = 0; $x < $i; $x++) {
			$split = $split." ".$words[$y+$x];
		}
		$split = substr($split,1);
		$persplitcount = substri_count($multi_array[$counter][$infoComp],$split);
		if ($debug == True) {
			echo '"'.$split.'" - '.$persplitcount." or ";
		}
		array_push($query,$split);
		$hitCounts += $persplitcount;
	}
	if ($debug == True) {
		echo "<br>";
		echo "Total ".$hitCounts;
		echo "<br><br>";
	}
	array_push($queries,$query);
	array_push($query_array,$hitCounts);
	array_push($types,1);
}
array_push($search_array,$query_array);
if ($debug == True) {
	echo "-----------------<br><br>";
}
?>