<?
if($engine->accountAccess() >= GROUP_GOD)
{
	echo '<tr><td class=newbar><center><b>:: Logs de Ações do Site ::</td></tr>
	<tr><td class=newtext><br>';

	echo '<center><table width="85%" border="0" bgcolor="black" cellpadding="2" cellspacing="1">';
	echo '<tr class="rank2"><td colspan="2"><b>Lista de eventos:</td></tr>';
	echo '<tr class="rank1"><td width="25%"><b>Nome:</td><td><b>Data:</td><td><b>Valor:</td><td><b>Evento ID:</td></tr>';

	$query = mysql_query("SELECT * FROM `logs` ORDER by date DESC") or die(mysql_error());

	if(mysql_num_rows($query) != 0)
	while($fetch = mysql_fetch_object($query))
	{
		echo '<tr class="rank1"><td>'.$fetch->event.'</td><td>'.date('M d Y, H:i:s',$fetch->date).'</td><td>'.$fetch->value.'</td><td>'.$fetch->id.'</td></tr>';
	}
	else
		echo '<tr class="rank1"><td>Nenhum evento até o momento.</td></tr>';

	echo '</table><br>';	
}	
?>