<?
if($engine->accountAccess() >= GROUP_GAMEMASTER)
{
	echo '<tr><td class=newbar><center><b>:: Painel de Banições ::</td></tr>
	<tr><td class=newtext><center><br>';

	echo '<table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="2">';
	echo '<tr class=rank1><td>Tipo de Ban:</td><td>Player:</td><td>Até:</td><td>Motivo:</td><td>Ação:</td><td>Por:</td><td>Comentarios:</td></tr>';			
	$query = mysql_query("SELECT * FROM bans");
	while($fetch = mysql_fetch_object($query))
	{
		$type = Tolls::banType($fetch->type);
		
		if($fetch->player == 0)
		{
			$player = ''.Bans::getPlayer($fetch->account).' (acc '.$fetch->account.')';
		}
		else
		{
			$player = ''.Bans::getName($fetch->player).'';
		}
		
		$reason = Tolls::getReason($fetch->reason_id);
		$action = Tolls::getAction($fetch->action_id);
		$banned_by = ''.Bans::getName($fetch->banned_by).'';
		
		switch($fetch->time)
		{
			case 0;
				$time = '<center> -';
				break;
			default;
				$time = date('d/m/Y h:i A',$fetch->time);
				break;
		}	
		
		echo '<tr class=rank1><td>'.$type.'</td><td>'.$player.'(id '.$fetch->player.')</td><td>'.$time.'</td><td>'.$reason.'</td><td>'.$action.'</td><td>'.$banned_by.'</td><td>'.$fetch->comment.'</td></tr>';			
	}					
	echo '</table><br>';
}	
?>