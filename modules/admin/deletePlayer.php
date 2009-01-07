<?
if($engine->accountAccess() >= GROUP_GOD)
{
	echo '<tr><td class=newbar><center><b>:: Deletar Player ::</td></tr>
	<tr><td class=newtext><center><br>';
	if ($_SERVER['REQUEST_METHOD'] == "POST")
	{		
		if($_POST['type'] == 0)
		{
			$getPlayerQuery = mysql_query("SELECT id FROM players WHERE name = '".$_POST['player']."'") or die(mysql_error());
			$getPlayerFetch = mysql_fetch_object($getPlayerQuery);
			
			mysql_query("DELETE FROM player_items WHERE player_id = '".$getPlayerFetch->id."'") or die(mysql_error());	
			mysql_query("DELETE FROM player_depotitems WHERE player_id = '".$getPlayerFetch->id."'") or die(mysql_error());	
			mysql_query("DELETE FROM player_skills WHERE player_id = '".$getPlayerFetch->id."'") or die(mysql_error());	
			mysql_query("DELETE FROM player_deaths WHERE player_id = '".$getPlayerFetch->id."'") or die(mysql_error());	
			mysql_query("DELETE FROM player_deletion WHERE player_id = '".$getPlayerFetch->id."'") or die(mysql_error());	
			mysql_query("DELETE FROM player_storage WHERE player_id = '".$getPlayerFetch->id."'") or die(mysql_error());	
			mysql_query("DELETE FROM player_tutors WHERE player_id = '".$getPlayerFetch->id."'") or die(mysql_error());	
			mysql_query("DELETE FROM player_viplist WHERE player_id = '".$getPlayerFetch->id."'") or die(mysql_error());	
			
			mysql_query("DELETE FROM player WHERE id = '".$getPlayerFetch->id."'");	
					
			$stat = 'Player deletado!';
			$msg = 'Player '.$_POST['player'].' (e ou) account deletado.';	
		}	
		elseif($_POST['type'] == 1)
		{
			$getAccQuery = mysql_query("SELECT account_id FROM players WHERE name = '".$_POST['player']."'") or die(mysql_error());
			$getAccFetch = mysql_fetch_object($getAccQuery);
				
			$getPlayersQuery = mysql_query("SELECT id, name FROM players WHERE account_id = '".$getAccFetch->account_id."'") or die(mysql_error());
			
			while($getPlayersFetch = mysql_fetch_object($getPlayersQuery))
			{
				mysql_query("DELETE FROM player_items WHERE player_id = '".$getPlayersFetch->id."'") or die(mysql_error());	
				mysql_query("DELETE FROM player_depotitems WHERE player_id = '".$getPlayersFetch->id."'") or die(mysql_error());	
				mysql_query("DELETE FROM player_skills WHERE player_id = '".$getPlayersFetch->id."'") or die(mysql_error());	
				mysql_query("DELETE FROM player_deaths WHERE player_id = '".$getPlayersFetch->id."'") or die(mysql_error());	
				mysql_query("DELETE FROM player_deletion WHERE player_id = '".$getPlayersFetch->id."'") or die(mysql_error());	
				mysql_query("DELETE FROM player_storage WHERE player_id = '".$getPlayersFetch->id."'") or die(mysql_error());	
				mysql_query("DELETE FROM player_tutors WHERE player_id = '".$getPlayersFetch->id."'") or die(mysql_error());	
				mysql_query("DELETE FROM player_viplist WHERE player_id = '".$getPlayersFetch->id."'") or die(mysql_error());	
				
				mysql_query("DELETE FROM players WHERE id = '".$getPlayersFetch->id."'") or die(mysql_error());	
			}
				
			mysql_query("DELETE FROM accounts WHERE id = '".$getAccFetch->account_id."'") or die(mysql_error());	
			
			$stat = 'Player deletado!';
			$msg = 'Player '.$_POST['player'].' (e ou) account deletado.';	
		}		
					
		echo '<center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
		echo '<tr><td class=rank2>'.$stat.'</td></tr>';
		echo '<tr><td class=rank1>'.$msg.'';
		echo '</table>';
		echo '<br><a href="account.php?subtopic=main"><img src="images/back.gif" border="0"></a>';		
	}
	else
	{
		echo '<form action="?page=admin.deletePlayer" method="POST">
		<center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">	
		<tr><td width="25%" class=rank1>Player:</td><td width="75%" class=rank1><input class=login type="text" name="player" size="20"></td></tr>
		<tr><td width="25%" class=rank1>Tipo:</td><td width="75%" class=rank1><select class=login name="type"><option value="0">Apenas o Player</option><option value="1">Deletar todos player mais account</option><option value="2">Resetar server (id do server)</option></select></td></tr>	
		</table>
		<br><input type="image" value="submit" src="images/submit.gif"/>';
	}
}
?>