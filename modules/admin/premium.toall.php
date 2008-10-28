<?
if($engine->accountAccess() >= GROUP_GOD)
{
	echo '<tr><td class=newbar><center><b>:: Premium para todos ::</td></tr>
	<tr><td class=newtext><center><br>';
	if ($_SERVER['REQUEST_METHOD'] == "POST")
	{
				
		$accsupdts = 0;
		$query = mysql_query("SELECT * FROM accounts");
		while($fetch = mysql_fetch_object($query))
		{
			if($fetch->premdays != 0)
			{
				$newDays = $fetch->premdays + $_POST['days'];
				$date = time();
				mysql_query("UPDATE `accounts` SET premdays = '$newDays', lastday = '$date' WHERE (`id` = '".$fetch->id."')") or die(mysql_error());	
			}
			else
			{
				$newDays = $_POST['days'];
				$date = time();
				mysql_query("UPDATE `accounts` SET premdays = '$newDays', lastday = '$date', premFree = '1' WHERE (`id` = '".$fetch->id."')") or die(mysql_error());		
			}
			$accsupdts++;
		}	
		
		echo '<center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
		echo '<tr><td class=rank2>Sucesso</td></tr>';
		echo '<tr><td class=rank3>Todos premium accounts receberam '.$_POST['days'].' dias de premium account extra! - '.$accsupdts.' accounts atualizadas.';
		echo '</table>';
		echo '<br><a href="?page=account.main"><img src="images/back.gif" border="0"></a>';		
	}
	else
	{
		echo '
		<form action="?page=admin.premiumToAll" method="POST">
		<center>
		
		<table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">
		<tr class=rank2>
			<td colspan="2">Adicionar premium account a todos jogadores</td>
		</tr>			
		<tr class=rank3>
			<td width="25%">Quantidade de Dias:</td><td width="75%">
				<input class=login type="text" name="days" size="20">
			</td>
		</tr>

		</table>
		<br><input type="image" value="submit" src="images/submit.gif"/>';			
	}
}	
?>