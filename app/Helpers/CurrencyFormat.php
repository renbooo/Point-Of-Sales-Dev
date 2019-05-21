<?php
function currency_format($number){
	$result = number_format($number, 0, ',','.');
	return $result;
}