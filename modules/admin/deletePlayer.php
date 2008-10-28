<?
if($engine->accountAccess() >= GROUP_GOD)
{
	echo '<tr><td class=newbar><center><b>:: Deletar Player ::</td></tr>
	<tr><td class=newtext><center><br>';
	if ($_SERVER['REQUEST_METHOD'] == "POST")
	{
		include "tools/admin.php";
		
		if($_POST['type'] != 2)
		{
			Deletion::player($_POST['player'],$_POST['type']);
			$stat = 'Player deletado!';
			$msg = 'Player '.$_POST['player'].' (e ou) account deletado.';	
		}	
		else
		{
			Deletion::resetServer($_POST['player']);
			$stat = 'Servidor resetado!';
			$msg = 'O Servidor ID '.$_POST['player'].' foi resetado.';	
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