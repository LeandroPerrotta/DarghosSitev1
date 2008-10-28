<?
echo '<tr><td class=newbar><center><b>:: Status ::</td></tr>
<tr><td class=newtext><br><center>';	

echo '<center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
echo '<tr class=rank2><td colspan="2"><b>Darghos Status</td></tr>';

$DB->query("SELECT status, players, uptime, monsters, record, recordIn, max, lastUpdate FROM site.servers_status WHERE server_id = 1");	
while($fetch = $DB->fetch())
{
	if($fetch->status == 1)
	{
		echo '<TR class=rank1><td width="30%">Jogadores</td><td>'.$fetch->players.'/'.$fetch->max.'</td></tr>';
		echo '<TR class=rank1><td>Recorde de jogadores</td><td>'.$fetch->record.' em '.date('M d Y, H:i:s',$fetch->recordIn).'</td></tr>';
		echo '<TR class=rank1><td>Tempo ligado</td><td>'.$fetch->uptime.'</td></tr>';
		echo '<TR class=rank1><td>Monstros</td><td>'.$fetch->monsters.'</td></tr>';
		echo '<TR class=rank1><td>Localização</td><td><img src="images/br.png"></td></tr>';
	}
	else
	{
		echo '<TR class=rank1><td><font color="red"><b>Offline</td></tr>';
	}
}	
echo '</table><br>
';

$whoisonline = '	
<table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">
	<tr class=rank2>
		<td colspan=5>Players Online</td>
	</tr>	
	<tr class=rank1>
		<td width=6%></td>
		<td width=50%><b>Nome</td>
		<td><b>Level</td>
		<td><b>Vocação</td>
	</tr>';

$whoisQuery = mysql_query("SELECT vocation, group_id, name, level, account_id FROM `players` WHERE online = '1' ORDER by name ASC") or die(mysql_error());			
while($fetch2 = mysql_fetch_object($whoisQuery))
{
	$playerCounter++;
	$vocation = Tolls::getVocation($fetch2->vocation);
	
	if($fetch2->group_id <= 1)
		$class = "rank3";
	else
		$class = "rank1";

	$name = $fetch2->name;
	
	if(Account::isPremium($fetch2->account_id))
		$name.= '*';
	
	$whoisonline .= '
		<tr class='.$class.'>
			<td>'.$playerCounter.'. </td>
			<td><a href="?page=character.details&char='.$fetch2->name.'">'.$name.'</a></td>
			<td>'.$fetch2->level.'</td>
			<td>'.$vocation.'</td>
		</tr>';			
}	

$whoisonline .= '</table><br>';	

echo ''.$whoisonline.'';
?>