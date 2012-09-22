<?php
require_once("connection.php");
if (isset($_GET['format']))
{
	$format = $_GET['format'];
	if (isset($_GET['guild']))
	{
		$guild = $_GET['guild'];
	}
	else
	{
		$guild = "sealed";
	}
}
else 
{
	$format = "";
}
?>
<html>
<head>

</head>

<body>
<a href="http://zfire.dk/mtg/">Single Booster</a> <a href="?format=sealed&guild=4pack">Sealed 4xRTR</a>	<a href="?format=sealed">Sealed 6xRTR</a> <a href="?format=sealed&guild=teamsealed"> Team Sealed 12xRTR</a>	<a href="?format=sealed&guild=azorius">Sealed 5xRTR+Azorius</a>	<a href="?format=sealed&guild=selesnya">Sealed 5xRTR+Selesnya</a>	<a href="?format=sealed&guild=golgari">Sealed 5xRTR+Golgari</a> <a href="?format=sealed&guild=izzet">Sealed 5xRTR+Izzet</a> <a href="?format=sealed&guild=rakdos">Sealed 5xRTR+Rakdos</a><br>
<?php
$sortcards = array();
if ($format == "sealed")
{
	if ($guild == "sealed")
	{
		$q = 6;
	}
	elseif ($guild == "teamsealed") {
		$q = 12;
	}
	elseif ($guild == "4pack")
	{
		$q = 4;
	}
	else
	{
		$q = 5;
	}
	$num = array();
	for ($i=0; $i < $q; $i++) { 
		$num[$i] = rand(0,149000);
	}
	$resultcard = mysql_query("SELECT cards FROM boosters WHERE id IN (".implode(',',$num).")");
	if ($guild == "sealed" || $guild == "teamsealed" || $guild == "4pack")
	{
		$cards = array();
	}
	else
	{
		$numguild = rand(0,9998);
		$guild = mysql_real_escape_string($guild);
		$resultguild = mysql_query("SELECT cards FROM boosters_guild WHERE guild ='".$guild."' LIMIT 1 OFFSET ".$numguild."");
		$rowguild = mysql_fetch_row($resultguild);
		$guildpromo = guildpromo($guild);
		$final = $guildpromo.','.$rowguild[0];
		$cards = explode(',',$final);
	}
	while ($result = mysql_fetch_row($resultcard))
	{
		$cards = array_merge($cards,explode(',',$result[0]));
		
	}
	$sort = "";
	if (isset($_GET['sort']))
	{
		if ($_GET['sort'] == 1)
		{
			sort($cards,SORT_REGULAR);
		}
		else if ($_GET['sort'] == 2)
		{
			$sort = "rarity";
		}
	}
	if ($sort == "rarity")
	{
		global $sortcards;
		$sortedresult = mysql_query("SELECT number FROM cards WHERE number IN (".implode(',',$cards).") ORDER BY case rarity when 'M' then 1 when 'R' then 2 when 'U' then 3 when 'C' then 4 else 99 end");
		$i = 0;
		while ($row = mysql_fetch_row($sortedresult))
		{
			$sortcards[$i] = $row[0];
			$i++;
		}
		usort($cards, function($a,$b)
		{
			global $sortcards;
			return array_search($a, $sortcards) > array_search($b, $sortcards);

		});
	}
	$finalresult = mysql_query("SELECT number,name FROM cards WHERE number IN (".implode(',',$cards).")");
	$textcardsnum = array();
	$textcards = array();
	$x = 0;
	while ($row = mysql_fetch_row($finalresult))
	{
		if (!in_array($row[1], $textcards))
		{
			$textcards[$x] = $row[1];
			$textcardsnum[$x] = numberofcards($cards,$row[0]);
			$x++;
		}
	}
	foreach ($cards as $card) {
			echo '<span><img style="height:370;width:265;" src="pictures/'.$card.'.jpg" title="'.$card.'" /> </span>';
	}
	if ($guild == "sealed")
	{
		echo '<br>Booster 1 ID:'.$num[0].'<br>Booster 2 ID:'.$num[1].'<br>Booster 3 ID:'.$num[2].'<br>Booster 4 ID:'.$num[3].'<br>Booster 5 ID:'.$num[4].'<br>Booster 6 ID:'.$num[5];
	}
	elseif ($guild == "teamsealed") {
		echo '<br>Booster 1 ID:'.$num[0].'<br>Booster 2 ID:'.$num[1].'<br>Booster 3 ID:'.$num[2].'<br>Booster 4 ID:'.$num[3].'<br>Booster 5 ID:'.$num[4].'<br>Booster 6 ID:'.$num[5].'<br>Booster 7 ID:'.$num[6].'<br>Booster 8 ID:'.$num[7].'<br>Booster 9 ID:'.$num[8].'<br>Booster 10 ID:'.$num[9].'<br>Booster 11 ID:'.$num[10].'<br>Booster 12 ID:'.$num[11];
	}
	elseif ($guild == "4pack"){
		echo '<br>Booster 1 ID:'.$num[0].'<br>Booster 2 ID:'.$num[1].'<br>Booster 3 ID:'.$num[2].'<br>Booster 4 ID:'.$num[3];
	}
	else
	{
		echo '<br>Guild Booster ID:'.$numguild.'';
		echo '<br>Booster 1 ID:'.$num[0].'<br>Booster 2 ID:'.$num[1].'<br>Booster 3 ID:'.$num[2].'<br>Booster 4 ID:'.$num[3].'<br>Booster 5 ID:'.$num[4];
	}
	echo '<br><br><b>List of cards (.MWD format):</b>';
	for ($i=0; $i < $x; $i++) { 
		echo '<br>'.$textcardsnum[$i].' [RTR] '.$textcards[$i];
	}
}
else
{
	$num = rand(0,149000);
	$resultcard = mysql_query("SELECT cards FROM boosters WHERE id='".$num."'");
	$result = mysql_fetch_row($resultcard);
	$cards = explode(',',$result[0]);
	$textcards = array();
	$x = 0;
	$finalresult = mysql_query("SELECT name FROM cards WHERE number IN (".implode(',',$cards).")");
	while ($row = mysql_fetch_row($finalresult))
	{
		$textcards[$x] = $row[0];
		$x++;
	}
	foreach ($cards as $card) {
		echo '<span><img style="height:370;width:265;" src="pictures/'.$card.'.jpg" title="'.$card.'" /> </span>';
	}
	echo '<br>Booster ID: '.$num;
	echo '<br><br><b>List of cards (.MWD format):</b>';
	for ($i=0; $i < $x; $i++) { 
		echo '<br>1 [RTR] '.$textcards[$i];
	}
}
function guildpromo($guild)
{
	switch ($guild) {
		case 'azorius':
			return 142;
			break;
		case 'selesnya':
			return 240;
			break;
		case 'golgari':
			return 152;
			break;
		case 'izzet':
			return 170;
			break;
		case 'rakdos':
			return 147;
			break;
		default:
			# code...
			break;
	}
}
function numberofcards($array,$card)
{
	$i = 0;
	foreach ($array as $a) {
		if ($a == $card)
		{
			$i++;
		}
	}
	return $i;
}
?>
</body>
</html>