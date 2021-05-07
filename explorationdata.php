<?php

include_once("./inc.php");
include_once("./func.php");

function ED_getExplorationData()
{
	$events = array("FSSDiscoveryScan", "FSSSignalDiscovered", "FSSAllBodiesFound", "DiscoveryScan", "Scan", "SAASignalsFound", "SAAScanComplete");
	$data = ED_getContentFromSpecifiedEvents($events);
	for ($i=count($data); $i>0; $i--)
	{
	
		if ($data[$i]["event"] == $events[0])
		{
			echo "<b><font color=#009999>FSS RESULT FOR</font></b>: <u>" . $data[$i]["SystemName"] . "</u>, Bodies - " . $data[$i]["BodyCount"] . ", Non bodies - " . $data[$i]["NonBodyCount"] . "<br>";
		}
		
		if ($data[$i]["event"] == $events[1])
		{
			if ($data[$i]["SignalName_Localised"] != "")
			{ echo "<b><font color=#990099>SIGNAL DISCOVERED</font></b>: " . $data[$i]["SignalName_Localised"] . " "; }
			else
			{ echo "<b><font color=#990099>SIGNAL DISCOVERED</font></b>: " . $data[$i]["SignalName"] . " "; }
			if ($data[$i]["IsStation"] == true) { echo "<u><b><font color=#FFFF00>[S]</font></b></u> "; }
			echo "<br>";
		}
		
		if ($data[$i]["event"] == $events[2])
		{
			echo "<b><font color=#DDDD00>[SYSTEM SCAN COMPLETE]</font></b>: " . $data[$i]["SystemName"] . " - " . $data[$i]["Count"] . "<br>";
		}
		
		if ($data[$i]["event"] == $events[3])
		{
			echo "<b><font color=#00DDDD>DISCOVERY SCAN</font></b>: " . $data[$i]["Bodies"] . "<br>";
		}
		
		if ($data[$i]["event"] == $events[4])
		{
			echo "<b><font color=#4477AA>SCAN RESULT</font></b>: " . $data[$i]["BodyName"] . " - Distance: " . round($data[$i]["DistanceFromArrivalLS"], 2) . " LS - ";
			echo $data[$i]["PlanetClass"] . " - ";
			if ($data[$i]["WasDiscovered"] == false)
			{ echo "<b><font color=#FF0000>[D]</font></b> "; } else { echo "<b><font color=#00FF00>[D]</font></b> "; }
			echo " ";
			if ($data[$i]["WasMapped"] == false)
			{ echo "<b><font color=#FF0000>[M]</font></b> "; } else { echo "<b><font color=#00FF00>[M]</font></b> "; }
			if ($data[$i]["Landable"] == true)
			{ echo "<b><font color=#FFFF00>[L]</font></b> "; }
			echo "<br>"; 
		}
		
		if ($data[$i]["event"] == $events[5])
		{
			for ($j=0; $j<count($data[$i]["Signals"]); $j++)
			{
				echo "<b><font color=#FF5511>POI FOUND</font></b>: " . $data[$i]["BodyName"] . " - " . $data[$i]["Signals"][$j]["Type_Localised"] . " - Count: " . $data[$i]["Signals"][$j]["Count"] . "<br>";
			}
		}
	}
}

?>
