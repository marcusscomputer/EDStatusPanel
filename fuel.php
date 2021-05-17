<?php

include_once("./inc.php");
include_once("./func.php");

function ED_displayFuel()
{
	$fuelcap = ED_getContentFromEvent("Loadout", "FuelCapacity");
	$statuscontent = file_get_contents($GLOBALS["ed_journal_folder"]."\Status.json");
	$status = json_decode($statuscontent, true);
	$fuel = $status["Fuel"]["FuelMain"];
	$value = $fuel / $fuelcap["Main"];
	
	$v = 312;
	$hght = $v - ($v*$value);
	
	echo "<div style='position: absolute; top: 0px; left: 0px; width: 100%; height: ".intval($hght)."px; background-color: #151515;'></div>";
}

function ED_displayFuel_pi()
{
	$fuelcap = ED_getContentFromEvent("Loadout", "FuelCapacity");
	$statuscontent = file_get_contents($GLOBALS["ed_journal_folder"]."\Status.json");
	$status = json_decode($statuscontent, true);
	$fuel = $status["Fuel"]["FuelMain"];
	$value = $fuel / $fuelcap["Main"];
	
	$v = 473;
	$hght = $v - ($v*$value);
	
	echo "<div style='position: absolute; top: 0px; left: 0px; width: 100%; height: ".intval($hght)."px; background-color: #151515;'></div>";
}

?>
