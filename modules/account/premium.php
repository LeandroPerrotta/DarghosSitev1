<?
if($engine->loggedIn())
{
	echo '
	<tr><td class=newbar><center><b>:: Minha conta ::</td></tr>
	<tr><td class=newtext>';		

	$acc = $_SESSION['account'];
	$pass = $_SESSION['password'];
	$id = $_GET['id'];

	if ($acc != "" && $acc != null && $pass != "" && $pass != null) 
	{		

		if($_GET['action'] == 'accept')
		{
			$premiumact_query = mysql_query("SELECT * FROM site.`payments` WHERE (`account_id` = '".$acc."' and status = '0') ") or die(mysql_error());
			$premiumact = mysql_fetch_array($premiumact_query);	

			$days = $premiumact['period'];
			
			$premQtd = mysql_query("SELECT * FROM accounts WHERE id = '".$acc."'");
			$premQtd_sql = mysql_fetch_array($premQtd);
			
			$premNow = $premQtd_sql['premdays'];
			$date = time();

			if(mysql_num_rows($premiumact_query) != 0)
			{	
				if ($premNow == 0)
				{				
					$premmy_up = "UPDATE accounts SET premDays = '".$days."', premFree = '0', lastday = '$date' WHERE id = '".$acc."'";
					mysql_query($premmy_up) or die(mysql_error());
					$premiumst = "UPDATE site.payments SET status = '1' WHERE account_id = '".$acc."' and id = '".$id."'";
					mysql_query($premiumst) or die(mysql_error());	
				}
				else
				{
					$newPrem = $premNow + $days;
					$premmy_up = "UPDATE accounts SET premDays = '".$newPrem."', premFree = '0', lastday = '$date' WHERE id = '".$acc."'";
					mysql_query($premmy_up) or die(mysql_error());
					$premiumst = "UPDATE site.payments SET status = '1' WHERE account_id = '".$acc."' and id = '".$id."'";
					mysql_query($premiumst) or die(mysql_error());
				}	

				echo '<br><center><table border="0" bgcolor="black" width="95%" CELLSPACING="1" CELLPADDING="2">';
				echo '
				<tr class=rank2><td>Ativação de Premium Account</td></tr>
				<tr class=rank1><td><b>PARABENS!!</b><br>
				Sua premium account foi ativada com exito! Agora você podera desfrutar de todo o Darghos!<br>
				Lembre-se de gerar seu numero de recovery key, que é uma das vantagens em adquirir premium account!<br><br>
				O Darghos lhe deseja um otimo jogo!
				</td></tr>';
				echo '</table>';
				echo '<center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';	
				echo '<tr><td><center><a href="?page=account.main"><img src="images/back.gif" border="0"></a></td></tr>';
				echo '</table>';		
			}
		}
		elseif($_GET['action'] == 'reject')	
		{
			$premiumact_query = mysql_query("SELECT * FROM site.`payments` WHERE (`account_id` = '".$acc."' and status = '0') ") or die(mysql_error());
			$premiumact = mysql_fetch_array($premiumact_query);	

			if(mysql_num_rows($premiumact_query) != 0)	
			{
				$reject = "UPDATE site.payments SET status = '2' WHERE account_id = '".$acc."' and id = '".$id."'";
				mysql_query($reject) or die(mysql_error());	

				echo '<br><center><table border="0" bgcolor="black" width="95%" CELLSPACING="1" CELLPADDING="2">';
				echo '
				<tr class=rank2><td>Ativação de Premium Account</td></tr>
				<tr class=rank1><td>Premium account rejeitada com sucesso!<br>
				Se não foi desta vez não desanime, adquira uma autentica premium account agora mesmo! Clique <a href="?page=contribute.informations">aqui</a> e saiba como!<br>
				O Darghos lhe deseja um otimo jogo!
				</td></tr>';
				echo '</table>';
				echo '<center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';	
				echo '<tr><td><center><a href="?page=account.main"><img src="images/back.gif" border="0"></a></td></tr>';
				echo '</table>';					
			}	
		}
	}
}
?>