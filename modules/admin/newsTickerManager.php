<?
if($engine->accountAccess() >= GROUP_COMMUNITYMANAGER)
{
	echo '<tr><td class=newbar><center><b>:: Add News Ticker ::</td></tr>';
	echo '<tr><td class=newtext>';

	if ($_SERVER['REQUEST_METHOD'] == "POST")
	{
		$time = time();
		$ticker = $_POST['text'] ;
		$autor = $account;	
			
		if ($ticker == '')
		{
			$condition = 'Seu ticker deve conter um assunto!';
		}	
		else
		{
			mysql_query("INSERT INTO site.fastnews(account_poster, date, new_br, new_us) VALUES('$autor', '$time', '$ticker', 'in english')") or die(mysql_error());
			$condition = 'Sucesso! Notícia postada, clique <a href="index.php">aqui</a> para visualizá-la.';
		}	
		
		echo '<br><center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">
		'.$condition.'
		</table>		
		
		<br><a href="?page=account.main"><img src="images/back.gif" border="0"></a>';		
	}		
	else
	{			

		echo '<form action="?page=admin.tickerManager" method="POST">';

		echo '<br><center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">';
		echo 'Escreva um news ticker para ir ao site.<br>';
		echo '</table>';
		
		echo '<br><center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';	
		echo '<tr><td colspan="2" width="25%" class=rank1>
		<TEXTAREA class="login" NAME="text" ROWS=3 COLS=45 WRAP="virtual"></textarea>	';		
		echo '</td></tr>';	
		echo '</table>';
		
		echo '<br><input type="image" value="submit" src="images/submit.gif"/>';


		echo '</form>';
	}
}
?>