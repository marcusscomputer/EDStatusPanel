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
			echo "<font color=#009999>[ ".$data[$i]["From"]." ] : </b><font color=#00EE77>".$data[$i]["Message"]."</font></b><br>";
		}
		
	}
}

?>
