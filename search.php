<?php
function mb_substri_count($haystack, $needle) {
	return mb_substr_count(mb_strtoupper($haystack, 'UTF-8'), mb_strtoupper($needle, 'UTF-8'), 'UTF-8');
}

$dummySearch = $_GET['search'];
$row = array(0 => 1,
			 1 => $_GET['story']);
?>