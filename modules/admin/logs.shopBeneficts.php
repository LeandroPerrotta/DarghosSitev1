<?
if($engine->accountAccess() >= GROUP_GOD)
{
	echo '<tr><td class=newbar><center><b>:: Shop Log ::</td></tr>
	<tr><td class=newtext><br>';

	echo '<center><table width="85%" border="0" cellpadding="4" cellspacing="1">';
	echo '<tr class="rank2"><td colspan="4"><b>Lista de eventos:</td></tr>';
	echo '<tr class="rank1"><td width="25%"><b>Personagem:</td><td><b>Data:</td><td><b>Ação:</td><td><b>Obs:</td></tr>';

	$query = mysql_query("SELECT * FROM `shop_log` ORDER by time DESC") or die(mysql_error());

	if(mysql_num_rows($query) != 0)
	while($fetch = mysql_fetch_object($query))
	{
		echo '<tr class="rank1"><td>'.$fetch->name.'</td><td>'.date('d/m/Y',$fetch->time).'</td><td>'.$fetch->action.'</td><td>'.$fetch->obs.'</td></tr>';
	}
	else
		echo '<tr class="rank1"><td>Nenhum evento até o momento.</td></tr>';

	echo '</table><br>';
}	
?>