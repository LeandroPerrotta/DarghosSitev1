<?
if($engine->accountAccess() >= GROUP_GOD)
{
	echo '<tr><td class=newbar><center><b>:: Ativar Premium Account ::</td></tr>
	<tr><td class=newtext>';

	if ($_SERVER['REQUEST_METHOD'] == "POST")
	{
		$user = $_POST['user'];
		$prem = $_POST['premdays'];
		$premMode = $_POST['mode'];
		$premType = $_POST['type'];
		$auth = $_POST['auth'];

		if(is_numeric($user))
			$player_query = mysql_query("SELECT * FROM players WHERE account_id = '".$user."'");
		else
			$player_query = mysql_query("SELECT * FROM players WHERE name = '".$user."'");
			
		if (mysql_num_rows($player_query) != 0)
		{
			$get_acc = mysql_fetch_array($player_query);
			$acc_id = $get_acc['account_id'];

			$premQtd = mysql_query("SELECT * FROM accounts WHERE id = '".$acc_id."'");
			$premQtd_sql = mysql_fetch_array($premQtd);
			$premNow = $premQtd_sql['premdays'];
			$premTime = $premQtd_sql['premEnd'];
			$date = time();		
			
			if($premMode == 0)
			{
				mysql_query("INSERT INTO site.payments(account_id, period, activation, status, auth) VALUES('$acc_id', '$prem', '$date', '0', '$auth')") or die(mysql_error());			
			}
			elseif($premMode == 1)
			{
				$premmy_up = "UPDATE accounts SET premDays = '".$prem."', premFree = '0', lastday = '$date' WHERE id = '".$acc_id."'";
				mysql_query($premmy_up) or die(mysql_error());	
			}
			elseif($premMode == 2)
			{
				if ($premNow == 0)
				{
					
					$premmy_up = "UPDATE accounts SET premDays = '".$prem."', premFree = '1', lastday = '$date' WHERE id = '".$acc_id."'";
					mysql_query($premmy_up) or die(mysql_error());
				}
				else
				{
					$newPrem = $premNow + $prem;
					$premmy_up = "UPDATE accounts SET premDays = '".$newPrem."', premFree = '1', lastday = '$date' WHERE id = '".$acc_id."'";
					mysql_query($premmy_up) or die(mysql_error());
				}					
			}
			
			$condition = 'O jogador "<b>'.$user.'</b>" recebeu <i>'.$prem.'</i> dias de Premmium Account com sucesso!';
		}
		else
		{
			$condition = 'O jogador "<b>'.$user.'</b>" nao existe!';
		}
		
		echo '<br><center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">
		'.$condition.'
		</table>';		
	}	
	?>	
		
		<form action="?page=admin.premiumAdd" method="POST">

		<br><center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">
		Ative premium account de jogadores com este recurso!<br>
		Premium accounts gratis não precisam de aceitação, são ativadas diretos, ja premium accounts normais só são ativadas com a aceitação do player.
		</table>		
		
		<br><center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">	
		<tr><td width="25%" class=rank1>Conta ou Nome:</td><td width="75%" class=rank1><input class=login type="text" name="user" size="20"></td></tr>
		<tr><td width="25%" class=rank1>Dias:</td><td width="75%" class=rank1><input class=login type="text" name="premdays" size="20"></td></tr>	
		<tr><td width="25%" class=rank1>Auth:</td><td width="75%" class=rank1><input class=login type="text" name="auth" size="20"></td></tr>	
		<tr><td width="25%" class=rank1>Modo:</td><td width="75%" class=rank1><select class=login name="mode"><option value="0">Ativamento</option><option value="1">Revisão</option><option value="2">Gratis</option></select></td></tr>	
		</table>
		
		<br><input type="image" value="submit" src="images/submit.gif"/>


		</form>
	<?
}	
?>	