<?php

include_once("./inc.php");
include_once("./func.php");

function ED_displayFuel()
{
	$statuscontent = file_get_contents($GLOBALS["ed_journal_folder"]."\Status.json");
	$status = json_decode($statuscontent, true);
	$fuel = $status["Fuel"]["FuelMain"];
	$value = $fuel / 32.0;
	
	$hght = 312 - (312*$value);
	
	echo "<div style='position: absolute; top: 0px; left: 0px; width: 100%; height: ".intval($hght)."px; background-color: #151515;'></div>";
}

?>
