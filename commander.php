<?php

include_once("./inc.php");
include_once("./func.php");

function ED_getCommanderName()
{
	$res = ED_getContentFromEvent("LoadGame", "Commander");
	return $res;
}

?>
