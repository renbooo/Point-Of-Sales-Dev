<?php
function spelling($number){
	$number = abs($number);
	$read = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
	$spell = "";
	if ($number< 12) {
		$spell = " " . $read[$number];
	}
	else if ($number < 20){
		$spell = spelling($number - 10) . " belas";
	}
	else if ($number < 100){
		$spell = spelling($number/10)." puluh" . spelling($number % 10);
	}
	else if ($number < 200){
		$spell = " seratus" . spelling($number - 100);
	}
	else if ($number < 1000){
		$spell = spelling($number/100) . " ratus" . spelling($number % 100);
	}
	else if ($number < 2000){
		$spell = " seribu" . spelling($number - 1000);
	}
	else if ($number < 1000000){
		$spell = spelling($number/1000) . " ribu" . spelling($number % 1000);
	}
	else if ($number < 1000000000){
		$spell = spelling($number/1000000) . " juta" . spelling($number % 1000000);
	}

	return $spell;
}