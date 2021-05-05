<?php

include_once("./inc.php");
include_once("./func.php");

function ED_getLocation()
{
	$r = array();
	
	$r[] = ED_getContentFromEvent("Location", "StarSystem");
	$r[] = ED_getContentFromEvent("Location", "StarPos");
	
	if (ED_doesEventParameterExist("FSDJump", "StarSystem") == true)
	{
		$r[0] = ED_getContentFromEvent("FSDJump", "StarSystem");
		$r[1] = ED_getContentFromEvent("FSDJump", "StarPos");
		$r[] = ED_getContentFromEvent("FSDJump", "JumpDist");
	}
	
	if (ED_doesEventParameterExist("ApproachBody", "Body") == true)
	{ $r[] = ED_getContentFromEvent("ApproachBody", "Body"); }
	
	$sol_x = 200;
	$sol_y = 335;
	
	$xp = $r[1][0] / 400; $yp = $r[1][2] / 400; 
	$posptr_x = $sol_x + $xp;
	$posptr_y = $sol_y + $yp;
	$r[] = array($posptr_x, $posptr_y);
	
	return $r;
}

?>
