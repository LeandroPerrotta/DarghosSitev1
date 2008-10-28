<?
echo '<tr><td class=newbar><center><b>:: '.$lang['houses_title'].' ::</td></tr>
<tr><td class=newtext>';
$servername = 'tenerian';
if ($servername)
{
if (file_exists($cfg['dirdata'].$cfg['house_file'])){
		$serverId = 'tenerian_houses';
$HousesXML = simplexml_load_file($cfg['dirdata'].$cfg['house_file']);
		$result = mysql_query("SELECT players.name, houses.id FROM players, houses WHERE houses.owner = players.id") or die(mysql_error());
while ($row = mysql_fetch_array($result)){
	$houses[(int)$row['id']] = $row['name'];
}

foreach ($HousesXML->house as $house)
{
	if($house['townid'] == 1)
	{
		$t++;
		$style = rotateStyle($t);	
		
		$name = $houses[(int)$house['houseid']];
		if ($name == "" or NULL)
		{
			$player = ''.$lang['houses_nobody'].'';
		}
		else
		{
			$player = '<a href="?page=character.details&char='.($name).'">'.$name.'</a>';
		}
		$quendor.= '<tr class='.$style.'><td>'.htmlspecialchars($house['name']).'</td><td>'.htmlspecialchars($house['rent']).' gps</td><td>'.htmlspecialchars($house['size']).' sqm</td><td>'.$player.'</td></tr>'."\r\n";		
	}	
}

foreach ($HousesXML->house as $house)
{
	if($house['townid'] == 4)
	{
		$t++;
		$style = rotateStyle($t);	
		
		$name = $houses[(int)$house['houseid']];
		if ($name == "" or NULL)
		{
			$player = ''.$lang['houses_nobody'].'';
		}
		else
		{
			$player = '<a href="?page=character.details&char='.($name).'">'.$name.'</a>';
		}
		$thorn.= '<tr class='.$style.'><td>'.htmlspecialchars($house['name']).'</td><td>'.htmlspecialchars($house['rent']).' gps</td><td>'.htmlspecialchars($house['size']).' sqm</td><td>'.$player.'</td></tr>'."\r\n";		
	}	
}

foreach ($HousesXML->house as $house)
{	
	if($house['townid'] == 2)
	{
		$t++;
		$style = rotateStyle($t);	
		
		$name = $houses[(int)$house['houseid']];
		if ($name == "" or NULL)
		{
			$player = ''.$lang['houses_nobody'].'';
		}
		else
		{
			$player = '<a href="?page=character.details&char='.($name).'">'.$name.'</a>';
		}
		$aracura.= '<tr class='.$style.'><td>'.htmlspecialchars($house['name']).'</td><td>'.htmlspecialchars($house['rent']).' gps</td><td>'.htmlspecialchars($house['size']).' sqm</td><td>'.$player.'</td></tr>'."\r\n";		
	}	
}

foreach ($HousesXML->house as $house)
{	
	if($house['townid'] == 5)
	{
		$t++;
		$style = rotateStyle($t);	
		
		$name = $houses[(int)$house['houseid']];
		if ($name == "" or NULL)
		{
			$player = ''.$lang['houses_nobody'].'';
		}
		else
		{
			$player = '<a href="?page=character.details&char='.($name).'">'.$name.'</a>';
		}
		$salazart.= '<tr class='.$style.'><td>'.htmlspecialchars($house['name']).'</td><td>'.htmlspecialchars($house['rent']).' gps</td><td>'.htmlspecialchars($house['size']).' sqm</td><td>'.$player.'</td></tr>'."\r\n";		
	}	
}

echo '<br><center><table width=95% border=0 cellspacing="1" cellpadding="4">';
echo '<tr class=rank2><td colspan="4">'.$lang['houses_on'].' Quendor City</B></td></tr>';
echo '<tr class=rank1><td width=30%><b>'.$lang['name'].'</td><td width=15%><b>'.$lang['rent'].'</td><td width=15%><b>'.$lang['size'].'</td><td width=40%><b>'.$lang['owner'].'</td></tr>';
echo $quendor;
echo '</table><br>';

echo '<table width=95% border=0 cellspacing="1" cellpadding="4">';
echo '<tr class=rank2><td colspan="4">'.$lang['houses_on'].' Thorn City</B></td></tr>';
echo '<tr class=rank1><td width=30%><b>'.$lang['name'].'</td><td width=15%><b>'.$lang['rent'].'</td><td width=15%><b>'.$lang['size'].'</td><td width=40%><b>'.$lang['owner'].'</td></tr>';
echo $thorn;
echo '</table><br>';

echo '<table width=95% border=0 cellspacing="1" cellpadding="4">';
echo '<tr class=rank2><td colspan="4">'.$lang['houses_on'].' Aracura City</B></td></tr>';
echo '<tr class=rank1><td width=30%><b>'.$lang['name'].'</td><td width=15%><b>'.$lang['rent'].'</td><td width=15%><b>'.$lang['size'].'</td><td width=40%><b>'.$lang['owner'].'</td></tr>';
echo $aracura;
echo '</table><br>';

echo '<table width=95% border=0 cellspacing="1" cellpadding="4">';
echo '<tr class=rank2><td colspan="4">'.$lang['houses_on'].' Salazart City</B></td></tr>';
echo '<tr class=rank1><td width=30%><b>'.$lang['name'].'</td><td width=15%><b>'.$lang['rent'].'</td><td width=15%><b>'.$lang['size'].'</td><td width=40%><b>'.$lang['owner'].'</td></tr>';
echo $salazart;
echo '</table><br>';
}else $error = "House file not found";


echo '<br><center><table border="0" width="95%" CELLSPACING="0" CELLPADDING="4">';
echo 'O aluguel das casas são cobrados SEMANALMENTE e ele é retirado do depot da cidade correspondente a casa adquirida, portanto sempre reserve o valor semanal de seu aluguel no depot da cidade de sua casa.<br><br>';
echo 'O valor do aluguel, assim como a data de cobrança (semanal, mensal e etc.) podem ser modificados SEM PREVIO AVISO, portanto sempre verifique esta pagina para evitar problemas.<br><br>';
echo 'Para comprar uma casa fique de frente para a porta da casa desejada e digite a palavra magica !buyhouse, primeiro certifique que contem a quantidade de GPs para adquirir a casa (você pode saber o valor para adquirir a house dando use na porta da house desejada).<br><br>';
echo 'Caso queira vender sua casa para outro jogador ultilize o Trade House digitando a palavra magica !sellhouse nickdojogador (exemplo: !sellhouse CM Slash) estando dentro de sua house.<br><br>';
echo 'Caso queira se desfazer de sua house apenas digite !leavehouse dentro de sua house. (note que ao se desfazer de sua house você não é reembolsado em nada).<br><br>';
echo '</table>';
echo '</div>';
echo '</div>';
echo '<div class="bot"></div>';
echo '</div>';

}
else
{
	echo '<form method="post" action="?page=community.houses">';
	echo '<br><center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
	echo '<tr><td class=rank2 width="75%">'.$lang['world_selection'].':</td></tr>';
	echo '<tr class=rank3><td width="75%">'.$lang['world'].': <select name="server"><OPTION VALUE="" SELECTED>(choose world)</OPTION><option value="uniterian">Uniterian</option><option value="tenerian">Tenerian</option></select> <input type="image" value="submit" src="images/submit.gif"/></td></tr>';
	echo '</table><br>';
	echo '</form>';	
}
?>