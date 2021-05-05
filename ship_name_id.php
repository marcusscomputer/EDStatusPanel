<?php

include_once("./inc.php");
include_once("./func.php");

function ED_getShipNameID()
{
	$res1 = ED_getContentFromEvent("LoadGame", "ShipName");
	$res2 = ED_getContentFromEvent("LoadGame", "ShipIdent");
	
	$res = array($res1, $res2);
	
	return $res;
}

?>
