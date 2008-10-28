<?
echo '<tr><td class=newbar><center><b>:: Votação da enquete ::</td></tr>
<tr><td class=newtext><br>';

$acc = "";
$pass = "";
$acc = $_SESSION['account'];
$pass = $_SESSION['password'];

if ($acc != "" && $acc != null && $pass != "" && $pass != null) 
{			
	if ($_SERVER['REQUEST_METHOD'] == "POST")
	{
		$postid = filtreString($_POST['poll_id'],0);
		if(!POLL::userVoted($acc,$postid,1))
		{
			$stat = 'Erro';
			$msg = 'Você ja votou nesta enquete!';
		}
		
		elseif(!POLL::permission($acc,10))
		{
			$stat = 'Erro';
			$msg = 'Você precisa ter ao menos 1 personagem com level 10 ou superior para poder votar!';			
		}
		else
		{		
			$query = mysql_query("SELECT * FROM `polls` WHERE (`id` = '$postid')");		
			$getPoll = mysql_fetch_array($query);
			$option = filtreString($_POST['option'],0);
			$vote = $getPoll[$option]+1;
			mysql_query("UPDATE `polls` SET $option = '$vote' WHERE (`id` = '$postid')") or die(mysql_error());
			mysql_query("INSERT INTO votes_poll(poll_id, account_id, option_id) values('$postid','".$acc."','$option')");
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
CONTENT="3; URL=?page=account.main">';
}
?>