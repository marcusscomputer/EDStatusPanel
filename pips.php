<?php

include_once("./inc.php");
include_once("./func.php");

function ED_pip1()
{
	$statuscontent = file_get_contents($GLOBALS["ed_journal_folder"]."\Status.json");
	$status = json_decode($statuscontent, true);
	$pips = $status["Pips"];
	$value = $pips[0] / 8.0;
	$hght = 312 - (312*$value);
	echo "<div style='position: absolute; top: 0px; left: 0px; width: 100%; height: ".intval($hght)."px; background-color: #151515;'></div>";
}

function ED_pip2()
{
	$statuscontent = file_get_contents($GLOBALS["ed_journal_folder"]."\Status.json");
	$status = json_decode($statuscontent, true);
	$pips = $status["Pips"];
	$value = $pips[1] / 8.0;
	$hght = 312 - (312*$value);
	echo "<div style='position: absolute; top: 0px; left: 0px; width: 100%; height: ".intval($hght)."px; background-color: #151515;'></div>";
}

function ED_pip3()
{
	$statuscontent = file_get_contents($GLOBALS["ed_journal_folder"]."\Status.json");
	$status = json_decode($statuscontent, true);
	$pips = $status["Pips"];
	$value = $pips[2] / 8.0;
	$hght = 312 - (312*$value);
	echo "<div style='position: absolute; top: 0px; left: 0px; width: 100%; height: ".intval($hght)."px; background-color: #151515;'></div>";
}

?>
