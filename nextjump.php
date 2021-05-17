<?php

error_reporting( 0 );

include_once("./inc.php");
include_once("./func.php");
include_once("./location.php");

header( "refresh:2;url=nextjump.php" );

?>

<html>

<head>
<link rel="stylesheet" type="text/css" href="css/edpanel.css">
</head>

<body>
<table width=600 border=0 height=50 cellspacing=0 cellpadding=0 bgcolor=#262626>
<tr>
<td valign=middle align=left>
<font class="ed_section_text_small">
<?php
$j = ED_getNextJump();
if (count($j) > 0)
{
    $s = "";
    if ($j[1] == "O" || $j[1] == "B" || $j[1] == "A" || $j[1] == "F" || $j[1] == "G" || $j[1] == "K" || $j[1] == "M")
    { $s = "<font color=#00EE33><b>[".$j[1]."]</b>"; } else { $s = "<font color=#DD1515>[".$j[1]."]"; }
    echo "Next: ".$j[0]." - ".$s;
}
?>
</font>
</td>
</tr>
</table>
</body>