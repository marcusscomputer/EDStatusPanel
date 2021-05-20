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

if ($_GET["panel"] == "system") // ONLY NEEDED FOR A JAVASCRIPT CALL
{
    $p = ED_getLocation();
    echo $p[0];
    exit(0);
}

if ($_GET["panel"] == "nextjump") // ONLY NEEDED FOR A JAVASCRIPT CALL
{
    $j = ED_getNextJump();
    if (count($j) > 0)
    {
        $s = "";
        if ($j[1] == "O" || $j[1] == "B" || $j[1] == "A" || $j[1] == "F" || $j[1] == "G" || $j[1] == "K" || $j[1] == "M")
        { $s = "<font color=#00EE33><b>[".$j[1]."]</b>"; } else { $s = "<font color=#DD1515>[".$j[1]."]"; }
        echo "Next: ".$j[0]." - ".$s;
    }
    exit(0);
}


if ($_GET["panel"] != "location")
{ header( "refresh:2;url=pi.php?panel=".$_GET["panel"] ); }

?>

<html>

<head>
<link rel="stylesheet" type="text/css" href="css/edpanel.css">
<meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
<link href="http://fonts.googleapis.com/css?family=Orbitron:400" rel="stylesheet" type="text/css" />
</head>

<body>
<table width=<?php echo $GLOBALS["ed_location_panel_res"][0]; ?> height=<?php echo $GLOBALS["ed_location_panel_res"][1]; ?> cellspacing=0 cellpadding=0>
<tr>
<td valign=top align=left bgcolor=#262626>

<?php
if ($_GET["panel"] == "location") // DISPLAY PI SPECIFIC LOCATION PANEL
{
    $p = ED_getLocation();
    $cy = 0 - $p[1][1] + 1000;
    $cz = 0 + $p[1][2] * 3;

    // Before we proceed, we will check for the existence of the data.json file -
    // if it does not exist, simply put in the current system as first entry and
    // check if a route is planned, and then add the route systems too.
    // If the file does exist, simply make the adjustments for missing systems,
    // and save the file.

    if (file_exists("data/data.json") == false)
    {
        $systems = array();
        $systems["systems"] = array();
        $system["name"] = $p[0];
        $system["coords"] = array();
        $system["coords"]["x"] = $p[1][0];
        $system["coords"]["y"] = $p[1][1];
        $system["coords"]["z"] = $p[1][2];
        $systems["systems"][] = $system;

        $j = ED_getAllJumps();
        if (count($j) > 0)
        {
            for ($i=0; $i<count($j); $i++)
            {
                $t = array();
                $t["name"] = $j[$i][0];
                $t["coords"] = array();
                $t["coords"]["x"] = $j[$i][1][0];
                $t["coords"]["y"] = $j[$i][1][1];
                $t["coords"]["z"] = $j[$i][1][2];
                $systems["systems"][] = $t;
            }
        }

        $systems["routes"] = array();
        if (count($j) == 0)
        {
            $v = array();
            $v["title"] = "TravelRoute";
            $v["points"] = array();
            $t = array( "s" => $p[0] );
            $v["points"][] = $t;
            $systems["routes"][] = $v;
        }
        if (count($j) > 0)
        {
            $a = ED_getAllJumps();
            $v = array();
            $v["title"] = "TravelRoute";
            $v["points"] = array();
            $t = array( "s" => $p[0] );
            $v["points"][] = $t;
            
            for ($x=0; $x<count($j); $x++)
            {
                $u = array( "s" => $a[0] );
                $v["points"][] = $u;
            }

            $systems["routes"][] = $v;
        }

        $fp = fopen('data/data.json', 'w');
        fwrite($fp, json_encode($systems));
        fclose($fp);
    }
    else
    {
        $content = file_get_contents("data/data.json");
        $systems = json_decode($content, true);

        $exist = false;
        for ($i=0; $i<count($systems["systems"]); $i++)
        { if ($systems["systems"][$i]["name"] == $p[0]) { $exist = true; break; } }
        if ($exist == false)
        {
            $system["name"] = $p[0];
            $system["coords"] = array();
            $system["coords"]["x"] = $p[1][0];
            $system["coords"]["y"] = $p[1][1];
            $system["coords"]["z"] = $p[1][2];
            $systems["systems"][] = $system;
        }

        $j = ED_getAllJumps();
        if (count($j) > 0)
        {
            for ($i=0; $i<count($j); $i++)
            {
                $exist = false;
                for ($x=0; $x<count($systems["systems"]); $x++)
                { if ($systems["systems"][$x]["name"] == $p[0]) { $exist = true; break; } }
                if ($exist == false)
                {
                    $t = array();
                    $t["name"] = $j[$i][0];
                    $t["coords"] = array();
                    $t["coords"]["x"] = $j[$i][1][0];
                    $t["coords"]["y"] = $j[$i][1][1];
                    $t["coords"]["z"] = $j[$i][1][2];
                    $systems["systems"][] = $t;
                }
            }
        }

        $systems["routes"] = array();
        if (count($j) == 0)
        {
            $v = array();
            $v["title"] = "TravelRoute";
            $v["points"] = array();
            $t = array( "s" => $p[0] );
            $v["points"][] = $t;
            $systems["routes"][] = $v;
        }
        if (count($j) > 0)
        {
            $a = ED_getAllJumps();
            $v = array();
            $v["title"] = "TravelRoute";
            $v["points"] = array();
            $t = array( "s" => $p[0] );
            $v["points"][] = $t;
            
            for ($x=0; $x<count($j); $x++)
            {
                $u = array( "s" => $a[0][0] );
                $v["points"][] = $u;
            }

            $systems["routes"][] = $v;
        }

        unlink("data/data.json");
        $fp = fopen('data/data.json', 'w');
        fwrite($fp, json_encode($systems));
        fclose($fp);
    }
    
    $docked = ED_getDockedStation();
    echo '
<table width='.$GLOBALS["ed_location_panel_res"][0].' height='.$GLOBALS["ed_location_panel_res"][1].' cellspacing=0 cellpadding=0 align=left>
<tr height=50>
<td valign=middle align=center width='.$GLOBALS["ed_location_panel_res"][0].' height=50>

<table width=90% border=0 height=50 align=center>
<tr>
<td valign=middle align=left>
<font class="ed_section_header">'.strtoupper($p[0]).'</font> <br>
<font class="ed_section_text_small">'.$docked.'</font>
</td>
';
$id = ED_getShipNameID();
$cmdr = ED_getCommanderName();
echo '<td valign=middle align=right>
<font class="ed_section_text"><b>'.$id[0].'</b> [' . $id[1]. ']</font> <br>
<font class="ed_section_text_small">CMDR. '.$cmdr.' - ' . $id[2]. '</font> <br>
</td>
</tr>
</table>

</td>
</tr>
<tr height='.$GLOBALS["ed_location_panel_maph"].'>
<td valign=middle align=center width='.$GLOBALS["ed_location_panel_res"][0].' height='.$GLOBALS["ed_location_panel_maph"].'>
<div id="edmap" style="width: '.$GLOBALS["ed_location_panel_res"][0].'px; height: '.$GLOBALS["ed_location_panel_maph"].'px;"></div>
</td>
</tr>
<tr height=50>
<td valign=middle align=center width='.$GLOBALS["ed_location_panel_res"][0].' height=50>

<table width=90% border=0 height=50 align=center>
<tr>
<td valign=middle align=left>
<iframe src="nextjump.php" frameborder=0 width=600 height=50></iframe>
</td>
<td valign=middle align=right>
<font class="ed_section_text_small">Sol: '.round( ED_DistToSol() , 2).' LY</font>
</td>
</tr>
</table>

</td>
</tr>
</table>

<!-- jQuery -->
<link href="css/styles.css" rel="stylesheet" type="text/css" />
<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<!-- Three.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r75/three.min.js"></script>
<script src="js/ed3dmap.min.js?v=8"></script>
<script type="text/javascript">

Ed3d.init({
    container   : "edmap",
    jsonPath    : "data/data.json",
    withHudPanel : false,
    hudMultipleSelect : false,
    effectScaleSystem : [25,5000],
    startAnim: false,
    showGalaxyInfos: true,
    showNameNear: true,
    systemColor: "#ddff11",
    playerPos: ['.$p[1][0].','.$p[1][1].','.$p[1][2].'],
    cameraPos: ['.$p[1][0].','.$cy.','.$cz.']
});

</script>

<script>
// This 3-second timer loop will check if you jumped somewhere

var currentLoc = "'.$p[0].'";
var detectedLoc = "'.$p[0].'";
// Must be the same initially

function getCurrentSystem(url,params)
{
    http=new XMLHttpRequest();
    if(params!=null) {
        http.open("POST", url, true);
        http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    } else {
        http.open("GET", url, true);
    }
    http.onreadystatechange = function() {
        if(http.readyState == 4 && http.status == 200) {
            detectedLoc = http.responseText;
        }
    }
    http.send(params);
}

setInterval(jumpCheck, 3000);

function jumpCheck()
{
    getCurrentSystem("pi.php?panel=system", "");
    if (currentLoc != detectedLoc)
    { window.location.href = "pi.php?panel=location"; }
}

</script>
    ';
}



if ($_GET["panel"] == "status") // DISPLAY THE STATUS PANEL WITH PIPS AND FUEL
{
    echo '
<center><a href=pi.php?panel=status>STATUS</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=pi.php?panel=comms>COMMS</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=pi.php?panel=exp>EXPLORATION</a></center><br><br>

<table width=100% height=90% cellspacing=0 cellpadding=4 align=center>
<tr>

<td width=65% valign=top align=left>

<div style="position: relative; width: 100%; height: 100%;">
'; ED_populateStatusPanel(); echo '
</div>

</td>

<td width=9%>
<div style="width: 85px; height: 100%; position: relative; float: left;">
<center><font class="ed_section_text">FUEL</font></center>
<br>
<div style="position: absolute; z-index: 98; width: 85px; height: 89%; background-image: linear-gradient(#66FF00, red); ">';  ED_displayFuel_pi(); echo '</div>
</div>
</div>
</td>

<td width=9%>
<div style="width: 85px; height: 100%; position: relative; float: left;">
<center><font class="ed_section_text">SYS</font></center>
<br>
<div style="position: absolute; z-index: 98; width: 85px; height: 89%; background-image: linear-gradient(#5588BB, green); ">'; ED_pip1_pi(); echo '</div>
</div>
</div>
</td>

<td width=9%>
<div style="width: 85px; height: 100%; position: relative; float: left;">
<center><font class="ed_section_text">ENG</font></center>
<br>
<div style="position: absolute; z-index: 98; width: 85px; height: 89%; background-image: linear-gradient(#5588BB, green); ">'; ED_pip2_pi(); echo '</div>
</div>
</div>
</td>

<td width=9%>
<div style="width: 85px; height: 100%; position: relative; float: left;">
<center><font class="ed_section_text">WEP</font></center>
<br>
<div style="position: absolute; z-index: 98; width: 85px; height: 89%; background-image: linear-gradient(#5588BB, green); ">';  ED_pip3_pi(); echo '</div>
</div>
</div>
</td>

</tr>
</table>
    ';
}


if ($_GET["panel"] == "comms")
{
    echo '
    <center><a href=pi.php?panel=status>STATUS</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=pi.php?panel=comms>COMMS</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=pi.php?panel=exp>EXPLORATION</a><br>
    <div style="position:relative; top: 0px; width: 90%; height: 550px; background-color: #151515; text-align: left;">
<p class="ed_exploration_data_pi">
'; ED_getComms(); echo '
</p>
</div></center>
    ';
}


if ($_GET["panel"] == "exp")
{
    echo '
    <center><a href=pi.php?panel=status>STATUS</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=pi.php?panel=comms>COMMS</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=pi.php?panel=exp>EXPLORATION</a><br>
    <div style="position:relative; top: 0px; width: 90%; height: 550px; background-color: #151515; text-align: left;">
<p class="ed_exploration_data_pi">
'; ED_getExplorationData(); echo '
</p>
</div></center>
    ';
}

?>

</td>
</tr>
</table>

</body>

</html>

