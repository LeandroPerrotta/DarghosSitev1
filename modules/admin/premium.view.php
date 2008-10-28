<?
if($engine->accountAccess() >= GROUP_GOD)
{
	$query = mysql_query("SELECT * FROM `accounts` WHERE `premDays` != '0' ORDER by premDays desc") or die(mysql_error());
	echo '<tr><td class=newbar><center><b>:: Premium Accounts ::</td></tr>
	<tr><td class=newtext><center><br>';
	echo '<center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
	echo '<tr class=rank2><td colspan=4><b>All Premium Accounts</td></tr>';
	echo '<tr class=rank1>
			<td width="40%"><b>Nome</td>
			<td width="10%"><b>PremDays</td>
			<td width="10%"><b>Tipo</td>
			<td width="40%"><b>Atualização</td>
	</tr>';

	while($fetch = mysql_fetch_object($query))
	{	
		$t++;
		$style = rotateStyle($t);			
		$query2 = mysql_query("SELECT * FROM `players` WHERE `account_id` = '".$fetch->id."' ORDER by level desc") or die(mysql_error());
		$player_fetch = mysql_fetch_object($query2);
		$name = $player_fetch->name;
		$account_id = $player_fetch->account_id;
		$premDays = $fetch->premdays;
		$lastDay = $fetch->lastday;
		echo '<tr class='.$style.'>
			<td><a href="?page=character.details&char='.$name.'">'.$name.'</a></td>
			<td>'.$premDays.'</td>
			<td>'.$fetch->premFree.'</td>
			<td>'.date('M d Y, H:i:s',$lastDay).'</td>
		</tr>';
	}
	echo '</table><br>';
}	
?>