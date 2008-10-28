<?
if($engine->accountAccess() >= GROUP_GOD)
{
	echo '<tr><td class=newbar><center><b>:: Extra Premium Days ::</td></tr>
	<tr><td class=newtext><center><br>';
	if ($_SERVER['REQUEST_METHOD'] == "POST")
	{
		
		$stat = 'Sucesso!';
		$msg = 'Todos premium accounts receberam '.$_POST['days'].' dias de premium account extra!';
		
		$accsupdts = 0;
		$query = mysql_query("SELECT * FROM accounts WHERE premdays != 0");
		while($fetch = mysql_fetch_object($query))
		{
			$newDays = $fetch->premdays + $_POST['days'];
			$date = time();
			mysql_query("UPDATE `accounts` SET premdays = '$newDays', lastday = '$date' WHERE (`id` = '".$fetch->id."')") or die(mysql_error());
			$accsupdts++;
		}	
		
		echo '<center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
		echo '<tr><td class=rank2>'.$stat.'</td></tr>';
		echo '<tr><td class=rank1>'.$msg.' - '.$accsupdts.' accounts atualizadas.';
		echo '</table>';
		echo '<br><a href="?page=account.main"><img src="images/back.gif" border="0"></a>';		
	}
	else
	{
		echo '<form action="?page=admin.premiumExtra" method="POST">
		<center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">	
		<tr><td width="25%" class=rank1>Dias:</td><td width="75%" class=rank1><input class=login type="text" name="days" size="20"></td></tr>

		</table>
		<br><input type="image" value="submit" src="images/submit.gif"/>';			
	}
}	
?>