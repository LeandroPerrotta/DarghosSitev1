<?
if($engine->loggedIn())
{
	echo '<tr><td class=newbar><center><b>:: Votação da screenshot ::</td></tr>
	<tr><td class=newtext><br>';
	
	if ($_SERVER['REQUEST_METHOD'] == "POST")
	{
		$screenid = filtreString($_POST['screen_id'],0);
		$screen = 'screen';
		if(!POLL::userVoted($_SESSION['account'],$screenid,0))
		{
			$stat = 'Erro';
			$msg = 'Você ja votou em uma screenshot!';
		}
		
		elseif(!POLL::permission($_SESSION['account'],10))
		{
			$stat = 'Erro';
			$msg = 'Você precisa ter ao menos 1 personagem com level 10 ou superior para poder votar!';			
		}
		else
		{		
			$query = mysql_query("SELECT * FROM `player_screenshots` WHERE (`id` = '$screenid')");		
			$fetch = mysql_fetch_array($query);
			$option = $fetch['votes'];
			$vote = $option+1;
			mysql_query("UPDATE `player_screenshots` SET votes = '$vote' WHERE (`id` = '$screenid')") or die(mysql_error());
			mysql_query("INSERT INTO votes_screen(screen_id, account_id) values('$screenid','".$_SESSION['account']."')");
			$stat = 'Voto feito com exito!';
			$msg = 'Seu voto foi efetuado com exito!<br>Obrigado por votar, sua opinião vale muito para nós!';				
		}
		
		echo '<center><table width="95%"BORDER="0" CELLSPACING="1" CELLPADDING="4">';
		echo '<tr><td class="rank2">'.$stat.'</td></tr>';
		echo '<tr><td class=rank1>'.$msg.'';
		echo '</table>';
		echo '<br><a href="?page=community.polls"><img src="images/back.gif" border="0"></a>';	
	}
}
else
{
	echo '<center><table width="95%"BORDER="0" CELLSPACING="1" CELLPADDING="4">
		<tr><td class="rank2">Login Necessario</td></tr>
		<tr><td class=rank1>Para acessar está pagina é necessario que você esteja logado em sua account, redirecionando para pagina de login...
		</table>
		<META HTTP-EQUIV="Refresh"
CONTENT="3; URL=?page=account.login">';
}
?>