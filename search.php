<?php
function mb_substri_count($haystack, $needle) {
	return mb_substr_count(mb_strtoupper($haystack, 'UTF-8'), mb_strtoupper($needle, 'UTF-8'), 'UTF-8');
}

$dummySearch = $_GET['search'];
$row = array(0 => 1,
			 1 => $_GET['story']);

# Array containing each word of the query
$queryWords = explode(" ", $dummySearch);

# For each 'split size' e.g. not splitting the query at all is 0 while splitting it once is 1. See search engine algorithm.txt
for ($splitCount = 0; $i <= count($queryWords)-1; $i++) {
	echo 'Making '.$splitCount.' splits!<br>';
}
?>