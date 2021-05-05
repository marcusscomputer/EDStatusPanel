<?php

include_once("./inc.php");
include_once("./func.php");

function ED_getShipImage()
{
	$res = ED_getContentFromEvent("LoadGame", "Ship");
	$img = "";
	
	if ($res == "Asp") { $img = "asp-explorer.png"; }
	
	return "img/".$img;
}

?>
