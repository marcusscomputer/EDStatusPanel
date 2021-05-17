<?php

error_reporting( 0 );

include_once("./inc.php");
include_once("./func.php");
include_once("./ship_name_id.php");
include_once("./commander.php");
include_once("./location.php");
include_once("./explorationdata.php");
include_once("./fuel.php");
include_once("./pips.php");
include_once("./comms.php");

header( "refresh:2;url=panel.php" );

?>

<html>

<head>
<link rel="stylesheet" type="text/css" href="css/edpanel.css">
</head>

<body>
<br>
<div class="ed_header"><center>
<font size=7>
<?php
$id = ED_getShipNameID();
echo "<b>".$id[0] . "</b> [" . $id[1]. "]";
?>
</font><br>
<font size=4>CMDR. <?php echo ED_getCommanderName(); ?> - <?php echo $id[2]; ?></font>
</center>
</div>

<br><br>
<table width=95% height=87% cellspacing=3 cellpadding=0 align=center>
<tr>
<td valign=middle align=left bgcolor=#262626 style='border-radius: 10px;'>

<div style="position:relative; top: 0px; width: 100%; height: 400px;">
<table width=100% height=100% cellspacing=0 cellpadding=0>
<tr>
<td valign=middle align=left width=50%>
<br>
<center><font class="ed_section_header">CURRENT LOCATION</font><br><br>
<font class="ed_section_text"> <?php $p = ED_getLocation(); echo $p[0]; ?> </font><br>
<font class="ed_section_text_small">
<?php
echo ED_getDockedStation(); echo "<br>";
$j = ED_getNextJump();
if (count($j) > 0)
{
    $s = "";
    if ($j[1] == "O" || $j[1] == "B" || $j[1] == "A" || $j[1] == "F" || $j[1] == "G" || $j[1] == "K" || $j[1] == "M")
    { $s = "<font color=#00EE33><b>[".$j[1]."]</b>"; } else { $s = "<font color=#DD1515>[".$j[1]."]"; }
    echo "Next: ".$j[0]." ".$s;
}
?></font><br><br>
<font class="ed_section_text_small"> <b>COORDINATES</b><br> <?php echo $p[1][0]." : ".$p[1][1]." : ".$p[1][2]; ?> </font><br><br>
<font class="ed_section_text_small"> <b>LAST JUMP DISTANCE</b><br> <?php echo $p[2]; ?> LY</font><br><br>
<font class="ed_section_text_small"> <b>DISTANCE TO SOL:</b><br> <?php echo round( ED_DistToSol() , 2); ?> LY</font><br><br>
</center>
</td>
<td valign=middle align=left width=50%>
<div id="glxmap" style="z-index: 98; position: relative; solid; width: 400px; background-color: #151515; border-radius: 10px;"><img src="img/galaxyBackgroundV3.png" style="width:400px; height:400px;">
<div class="ed_sol_pointer" style="position: absolute; left: 197px; top: 301px;">
</div>
<?php $loc = count($p) - 1; ?>
<div class="ed_galmap_pointer" style="position: absolute; left: <?php echo intval($p[$loc][0]);?>px; top: <?php echo intval($p[$loc][1]);?>px;"></div>
</div>
</td>
</tr>
</table>
</div>

</td>

<td valign=top align=left width=50% bgcolor=#262626 style='border-radius: 10px;'>
<br>
<center><font class="ed_section_header">STATUS</font></center>

<table width=100% height=87% cellspacing=0 cellpadding=4 align=center>
<tr>

<td width=65% valign=top align=left>

<div style="position: relative; width: 100%; height: 100%;">
<?php ED_populateStatusPanel(); ?>
</div>

</td>

<td width=8%>
<div style="width: 85px; height: 100%; position: relative; float: left;">
<center><font class="ed_section_text">FUEL</font></center>
<br>
<div style="position: absolute; z-index: 98; width: 85px; height: 85%; background-image: linear-gradient(#66FF00, red); "><?php ED_displayFuel(); ?></div>
</div>
</div>
</td>

<td width=8%>
<div style="width: 85px; height: 100%; position: relative; float: left;">
<center><font class="ed_section_text">SYS</font></center>
<br>
<div style="position: absolute; z-index: 98; width: 85px; height: 85%; background-image: linear-gradient(#5588BB, green); "><?php ED_pip1(); ?></div>
</div>
</div>
</td>

<td width=8%>
<div style="width: 85px; height: 100%; position: relative; float: left;">
<center><font class="ed_section_text">ENG</font></center>
<br>
<div style="position: absolute; z-index: 98; width: 85px; height: 85%; background-image: linear-gradient(#5588BB, green); "><?php ED_pip2(); ?></div>
</div>
</div>
</td>

<td width=8%>
<div style="width: 85px; height: 100%; position: relative; float: left;">
<center><font class="ed_section_text">WEP</font></center>
<br>
<div style="position: absolute; z-index: 98; width: 85px; height: 85%; background-image: linear-gradient(#5588BB, green); "><?php ED_pip3(); ?></div>
</div>
</div>
</td>

</tr>
</table>

</td>

</tr>

<tr>
<td valign=top align=left bgcolor=#262626 style='border-radius: 10px;'><br>
<center><font class="ed_section_header">COMMS</font>
<div style="position:relative; top: 0px; width: 90%; height: 400px; background-color: #151515; text-align: left;">
<p class="ed_exploration_data">
<?php ED_getComms(); ?>
</p>
</div></center>
</td>
<td valign=top align=left bgcolor=#262626 style='border-radius: 10px;'><br>
<center><font class="ed_section_header">EXPLORATION</font>
<div style="position:relative; top: 0px; width: 90%; height: 400px; background-color: #151515; text-align: left;">
<p class="ed_exploration_data">
<?php ED_getExplorationData(); ?>
</p>
</div></center>
</td>
</tr>

</table>


</body>

</html>

