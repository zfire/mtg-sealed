<?php
require_once("connection.php");

$num = 10000;
$selesnya = array('2','3','4','7','8','9','10','11','12','13','15','16','17','18','19','20','21','22','23','24','25','26','27','28','113','114','115','116','117','118','119','121','123','124','125','126','128','130','131','132','133','134','135','137','138','139','146','148','150','151','154','168','178','190','194','206','209','217','214','223');
$azorius = array('2','3','4','5','6','7','8','9','11','12','13','14','15','16','17','18','20','22','23','24','25','26','27','29','31','32','33','34','36','37','39','40','41','42','43','46','47','48','49','50','51','52','53','54','55','56','142','145','155','156','161','169','171','179','181','189','193','196','201','210','218','224');
$golgari = array('57','58','59','60','61','63','64','66','67','69','70','72','73','74','75','76','77','78','79','80','82','83','113','114','115','116','117','118','119','120','121','122','124','125','126','127','129','130','131','132','133','134','135','136','137','138','139','141','152','158','164','165','174','175','176','177','191','198','204','205','213','216','222');
$rakdos = array('57','58','59','60','61','62','63','64','65','66','67','68','69','70','72','73','74','76','77','78','79','81','82','83','85','86','87','88','89','90','91','94','95','96','97','98','99','100','102','103','104','105','107','108','109','112','144','147','157','166','167','184','185','186','187','192','195','197','199','212','220','221');
$izzet = array('29','30','31','32','33','34','35','36','37','38','39','40','42','45','46','47','48','49','50','52','53','54','56','85','86','87','88','91','92','93','94','95','97','98','99','100','101','102','103','104','106','107','108','109','111','112','149','153','160','162','163','170','172','173','180','182','183','202','203','211','215','219');

$numcommon = $num*10;
$numuncommon = $num*3;
$numrare = $num-($num/8);
$numfoils = $num/4;
$nummythic = $num/8;

#Commons
$resultcommon = mysql_query("SELECT number FROM cards WHERE rarity = 'C' AND number IN (".implode(',',$izzet).")");
$numcommonsset = mysql_num_rows($resultcommon);
$wholesetscommon = floor($numcommon/$numcommonsset);
$randomcommons = $numcommon%$numcommonsset;

$arraycommons = array($numcommonsset);
$i = 0;
while ($row = mysql_fetch_array($resultcommon,MYSQL_NUM))
{
	$arraycommons[$i] = $row[0];
	$i++;
}
$commons = array($numcommon);
$lastcommon = $numcommon-1;
$i = 0;
for ($k=0; $k < $wholesetscommon; $k++) { 
	for ($j=0; $j < $numcommonsset; $j++) { 
		$commons[$i] = $arraycommons[$j];
		$i++;
	}
}
for ($l=0; $l < $randomcommons; $l++) { 
	$commons[$i] = $arraycommons[rand(0,$numcommonsset-1)];
	$i++;
}

#Uncommons
$resultuncommon = mysql_query("SELECT number FROM cards WHERE rarity = 'U' AND number IN (".implode(',',$izzet).")");
$numuncommonsset = mysql_num_rows($resultuncommon);
$wholesetsuncommon = floor($numuncommon/$numuncommonsset);
$randomuncommons = $numuncommon%$numuncommonsset;

$i = 0;
while ($row = mysql_fetch_array($resultuncommon,MYSQL_NUM))
{
	$arrayuncommons[$i] = $row[0];
	$i++;
}
$uncommons = array($numuncommon);
$lastuncommon = $numuncommon-1;
$i = 0;
for ($k=0; $k < $wholesetsuncommon; $k++) { 
	for ($j=0; $j < $numuncommonsset; $j++) { 
		$uncommons[$i] = $arrayuncommons[$j];
		$i++;
	}
}
for ($l=0; $l < $randomuncommons; $l++) { 
	$uncommons[$i] = $arrayuncommons[rand(0,$numuncommonsset-1)];
	$i++;
}

#rares
$resultrare = mysql_query("SELECT number FROM cards WHERE rarity = 'R' AND number IN (".implode(',',$izzet).")");
$numraresset = mysql_num_rows($resultrare);
$wholesetsrare = floor($numrare/$numraresset);
$randomrares = $numrare%$numraresset;

$i = 0;
while ($row = mysql_fetch_array($resultrare,MYSQL_NUM))
{
	$arrayrares[$i] = $row[0];
	$i++;
}
$rares = array($numrare);
$lastrare = $numrare-1;
$i = 0;
for ($k=0; $k < $wholesetsrare; $k++) { 
	for ($j=0; $j < $numraresset; $j++) { 
		$rares[$i] = $arrayrares[$j];
		$i++;
	}
}
for ($l=0; $l < $randomrares; $l++) { 
	$rares[$i] = $arrayrares[rand(0,$numraresset-1)];
	$i++;
}

#mythics
$resultmythic = mysql_query("SELECT number FROM cards WHERE rarity = 'M' AND number IN (".implode(',',$izzet).")");
$nummythicsset = mysql_num_rows($resultmythic);
$wholesetsmythic = floor($nummythic/$nummythicsset);
$randommythics = $nummythic%$nummythicsset;

$i = 0;
while ($row = mysql_fetch_array($resultmythic,MYSQL_NUM))
{
	$arraymythics[$i] = $row[0];
	$i++;
}
$mythics = array($nummythic);
$lastmythic = $nummythic-1;
$i = 0;
for ($k=0; $k < $wholesetsmythic; $k++) { 
	for ($j=0; $j < $nummythicsset; $j++) { 
		$mythics[$i] = $arraymythics[$j];
		$i++;
	}
}
for ($l=0; $l < $randommythics; $l++) { 
	$mythics[$i] = $arraymythics[rand(0,$nummythicsset-1)];
	$i++;
}

$q = 0;
for ($i=0; $i < $num; $i++) { 
	$boosterarray = array(14);
	for ($j=0; $j < 10; $j++) { 
		$commoninbooster = true;
		while ($commoninbooster)
		{
			$p = rand(0,$lastcommon);
			$commoninbooster = cardisinbooster($commons[$p],$boosterarray);
			if (!$commoninbooster)
			{
				$boosterarray[$j] = $commons[$p];
				$commons[$p] = $commons[$lastcommon];
				$lastcommon--;
			}
		}
	}
	for ($j=10; $j < 13; $j++) { 
		$uncommoninbooster = true;
		while ($uncommoninbooster)
		{
			$p = rand(0,$lastuncommon);
			$uncommoninbooster = cardisinbooster($uncommons[$p],$boosterarray);
			if (!$uncommoninbooster)
			{
				$boosterarray[$j] = $uncommons[$p];
				$uncommons[$p] = $uncommons[$lastuncommon];
				$lastuncommon--;
			}
		}
	}
	if ($i % 8 == 0) #mythic
	{
		$p = rand(0,$lastmythic);
		$boosterarray[13] = $mythics[$p];
		$mythics[$p] = $mythics[$lastmythic];
		$lastmythic--;
	}
	else #rare
	{
		$p = rand(0,$lastrare);
		$boosterarray[13] = $rares[$p];
		$rares[$p] = $rares[$lastrare];
		$lastrare--;
	}

	$booster = implode(',',array_values($boosterarray));
	$result = mysql_query("INSERT INTO boosters_guild (cards,guild) VALUES ('".$booster."','izzet')");
	$q = $i;
}
function cardisinbooster($number,$a)
{
	return in_array($number,$a);
}
?>