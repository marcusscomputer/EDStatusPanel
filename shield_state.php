<?php

include_once("./inc.php");
include_once("./func.php");

function ED_getShieldState()
{
	$res = ED_getContentFromEvent("ShieldState", "ShieldsUp");
	
	if ($res == true)
	{ echo "<font color=#FFFF00 class='ed_shield_text'> SHIELDS </font>"; }
	else
	{ echo "<font color=#FF0000 class='ed_shield_text'> SHIELDS </font>"; }
}

?>
