<?php

include_once("./inc.php");
include_once("./func.php");

function ED_getComms()
{
	$events = array("ReceiveText");
	$data = ED_getContentFromSpecifiedEvents($events);
	for ($i=count($data); $i>0; $i--)
	{
		if ($data[$i]["event"] == $events[0])
		{
			if (
				str_contains($data[$i]["Message"], "COMMS_entered") == true ||
				str_contains($data[$i]["Message"], "STATION_NoFireZone_entered") == true ||
				str_contains($data[$i]["Message"], "DockingChatter_Neutral") == true ||
				str_contains($data[$i]["Message"], "STATION_docking_granted") == true ||
				str_contains($data[$i]["Message"], "STATION_NoFireZone_exited") == true
			)
			{ echo "<font color=#5383de>[ ".$data[$i]["From"]." ] </b><font color=#00EE77>".$data[$i]["Message_Localised"]."</font></b><br>"; }
			else
			{ echo "<font color=#cf6f0c>[ ".$data[$i]["From"]." ] : </b><font color=#00EE77>".$data[$i]["Message"]."</font></b><br>"; }
		}
	}
}

?>
