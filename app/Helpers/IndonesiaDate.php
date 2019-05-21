<?php
function indo_date($dt, $appear_day = true){
	$day_name = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jum'at", "Sabtu");
	$month_name = array(1=>"Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "Nopember", "Desember");

	$year = substr($dt, 0, 4);
	$month = $month_name[(int)substr($dt, 5, 2)];
	$date = substr($dt, 8, 2);

	$text = "";
	if ($appear_day) {
	 	$day_sort = date('w', mktime(0, 0, 0, substr($dt, 5, 2), $date, $year));
	 	$day = $day_name[$day_sort];
	 	$text .= $day . ", ";
	 }
	 $text .= $date ." ". $month ." ". $year;

	 return $text; 
}