<?
if(SHOW_TICKETS == 1)
{
	if(SHOW_BUYTICKET == 1)
	{
		echo '
		<tr><td class=newbar><center><b>:: Obter Bilhetes ::</td></tr>
		<tr><td class=newtext><br>';

		if ($_SERVER['REQUEST_METHOD'] == "POST")
		{
			$account = $engine->loadClass('Accounts');
			$account->loadByNumber($_SESSION['account'], array('premdays'));
			
			$success = false;
			
			switch($_POST['tickets'])
			{
				case "1":
					$tickets['quanty'] = 1;
					$tickets['cost'] = 2;
				break;	
				
				case "2":
					$tickets['quanty'] = 2;
					$tickets['cost'] = 4;
				break;	
							
				case "3":
					$tickets['quanty'] = 3;
					$tickets['cost'] = 6;
				break;	
								
				case "4":
					$tickets['quanty'] = 4;
					$tickets['cost'] = 8;
				break;			

				case "5":
					$tickets['quanty'] = 5;
					$tickets['cost'] = 10;
				break;	

				case "6":
					$tickets['quanty'] = 10;
					$tickets['cost'] = 15;
				break;	

				default:	
					$tickets['quanty'] = 1;
					$tickets['cost'] = 2;		
				break;	
			}
			
			if($_SESSION['password'] != $engine->encrypt($_POST['password']))
			{
				$condition['title'] = 'Confirmação de senha incorreta';
				$condition['details'] = "Para agendar uma mudança de e-mail é necessario confirmar sua senha corretamente por motivos de segurança.";		
			}	
			elseif($account->getData('premdays') == 0 OR $account->getData('premdays') < $tickets['cost'])
			{
				$condition['title'] = 'Premdays necessarios';
				$condition['details'] = $account->getData('premdays')."Para participar do sorteio é necessario possuir uma conta com premium days sulficientes.";		
			}	
			else
			{
				$success = true;
				
				while($quanty < $tickets['quanty'])
				{				
					$DB->query("INSERT INTO site.account_tickets (`key`, `account_id`, `date`) values ('".$engine->random_key(5, 4, "upper+number")."', '".$_SESSION['account']."', '".time()."')");
					$quanty++;
				}
				
				$account->setData('premdays', $account->getData('premdays') - $tickets['cost']);
				$account->setData('lastday', time());
				
				$account->update(array('premdays','lastday'));
				
				$condition['title'] = "Tickets obtidos com sucesso!";
				$condition['details'] = "Os ".$tickets['quanty']." bilhetes foram obtidos por ".$tickets['cost']." premdays com sucesso! Você pode obter informações detalhadas sobre eles acessando o link Meus Bilhetes atrávez painel de sua conta.";
			}	

			echo '<center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
			echo '<tr><td class=rank2>'.$condition['title'].'</td></tr>';
			echo '<tr><td class=rank3>'.$condition['details'].'';
			echo '</table><br>';

			if($success)
				echo '<a href="?page=account.main"><img src="images/back.gif" border="0"></a>';	
			else
				echo '<a href="?page=account.getTickets"><img src="images/back.gif" border="0"></a>';				
		}
		else
		{
			echo '
			<center>
			<table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">
			Preencha os campos abaixo e você poderá trocar dias de premiums por bilhetes, e assim concorrer aos premios do sorteio do Darghos!<br><br>
			Quantos mais bilhetes maior as chanses de ganhar! Lembrando que a cada bilhete são descontados 2 dias de premium!
			</table>
			<br>
			
			<form method="POST" action="?page=account.getTickets">
			<table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">
				<tr>
					<td class="rank2" colspan="2">Obter Bilhetes para Sorteio</td>
				</tr>
				<tr>
					<td class="rank3" width="25%">Quantidade de Bilhetes:</td>
					<td class="rank3" width="75%"><select  class="login" name="tickets"><option value="1">1 bilhete (2 premdays)</option><option value="2">2 bilhetes (4 premdays)</option><option value="3">3 bilhetes (6 premdays)</option><option value="4">4 bilhetes (8 premdays)</option><option value="5">5 bilhetes (10 premdays)</option><option value="6">10 bilhetes (15 premdays)</option></select></td>
				</tr>
				<tr>
					<td class="rank3" width="25%">Senha:</td>
					<td class="rank3" width="75%"><input name="password" type="password" value="" class="login" size="30"/></td>
				</tr>
			</table><br>
			<input type="image" value="Entrar" src="images/submit.gif"/> 
			<a href="?page=account.main"><img src="images/back.gif" border="0"></a>	
			</form>	 
			';	
		}	
	}	
}
?>