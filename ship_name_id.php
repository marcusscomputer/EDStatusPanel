<?php

include_once("./inc.php");
include_once("./func.php");

function ED_getShipNameID()
{
	$res1 = ED_getContentFromEvent("Loadout", "ShipName");
	$res2 = ED_getContentFromEvent("Loadout", "ShipIdent");
	$ship = ED_getContentFromEvent("Loadout", "Ship");
	
	$res3 = "";
	if ($ship == "asp") { $res3= "Asp Explorer"; }
	if ($ship == "dolphin") { $res3= "Dolphin"; }

	$res = array($res1, $res2, $res3);
	
	return $res;
}

?>
