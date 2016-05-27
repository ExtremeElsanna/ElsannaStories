<?php
function Decode($enc)
{
	set_error_handler(function() { /* ignore errors */ });
	$dec = mb_convert_encoding(hex2bin($enc),'UTF-8','UCS-2');
	restore_error_handler();
	return $dec;
}

function Encode($dec)
{
	set_error_handler(function() { /* ignore errors */ });
	$enc = bin2hex(mb_convert_encoding($dec, 'UCS-2', 'UTF-8'));
	restore_error_handler();
	return $enc;
}
?>