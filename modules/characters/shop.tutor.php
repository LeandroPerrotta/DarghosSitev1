<?
if($engine->loggedIn())
{
	if(Account::isPremium($account))
	{		
		echo '<tr><td class=newbar><center><b>:: Obter Tutor ::</td></tr>
		<tr><td class=newtext>';
		if ($_SERVER['REQUEST_METHOD'] == "POST")
		{	
			$player_id = $_POST['player_id'];
			$query = mysql_query("SELECT * FROM `players` WHERE `id` = '$player_id'") or die(mysql_error());
			$fetch = mysql_fetch_object($query);
		
			if(!Account::passCheck($account,md5($_POST['pass'])))
			{
				$condition = 'Error';
				$conteudo = 'This password is not correct.';
			}				
			elseif($fetch->group_id > 1)
			{
				$condition = 'Erro';
				$conteudo = 'Personagem já foi promovido!';	
			}								
			elseif(Player::isOnline(Player::getPlayerNameById($_POST['player_id'])) == 1)
			{
				$condition = 'Character as loged in!';
				$conteudo = 'Please, log out you character to use item shop.';			
			}		
			elseif(Account::getPremDays($account) < 15)
			{
				$condition = 'Few days of Premium.';
				$conteudo = 'To receive a marked item you need '.$item_price.' days of premium account.';
			}
			elseif($fetch->group_id > 1)
			{
				$condition = 'Error';
				$conteudo = 'Personagem já foi promovido!';	
			}	
			elseif(Account::getWarnings($fetch->account_id) != 0)
			{
				$condition = 'Account contem Warnings';
				$conteudo = 'Somente jogadores que nunca sofreram um warning podem ser Tutor.';	
			}			
			else
			{
				Account::removePremium(15,$account);
				mysql_query("UPDATE `players` SET group_id = '2', tutor_time = '".time()."' WHERE (`id` = '$player_id')");
				mysql_query("UPDATE `accounts` SET type = '2', group_id = '2' WHERE (`id` = '".$fetch->account_id."')");
				mysql_query("INSERT INTO shop_log (name, time, action) values('$player_id','".time()."','buy tutor')") or die(mysql_error());
				$condition = 'Promovido com sucesso!';
				$conteudo = 'O seu personagem foi promovido a Tutor com sucesso! Esperamos que efetue um bom trabalho de responsabilidade com sua nova posição! Boa sorte!';					
			}
			
			echo '<br><center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
			echo '<tr><td class=rank2>'.$condition.'</td></tr>';
			echo '<tr><td class=rank1>'.$conteudo.'</td></tr>';
			echo '</table>';
			echo '<br><a href="?page=account.main"><img src="'.$back_button.'" border="0"></a>';					
		}
		else
		{
			echo '<br><center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">';
			echo 'Bem vindo a seção para se tornar um Tutor no Darghos, como se sabe, o papel de um Tutor no jogo é extremamente importante para manter a ordem e dar suporte, por isso, somente pessoas realmente interessadas em ajudar poderão participar de tal cargo. Com isso, a promoção a Tutor custa 15 premium days, caso esteja enteressado em ajudar preencha os campos abaixo para confirmar.
			</table><br>';
			echo '<form action="?page=characater.getTutor" method=post  ENCTYPE="multipart/form-data">';
			echo '<center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
			echo '<tr class=rank2><td colspan=2>Promover a Tutor </td></tr>';	
			echo '<tr class="rank1"><td>Personagem a ser promovido</td><td><select name="player_id">';	
			$query = mysql_query("SELECT * FROM `players` WHERE (`account_id` = '$account')");	
			while($fetch = mysql_fetch_object($query))
				echo '<option value="'.$fetch->id.'">'.$fetch->name.'</option>';	
			echo'</select></td></tr>';			
			echo '<tr><td width="s25%" class=rank1>Password:</td><td width="75%" class=rank1><input name="pass" type="password" value="" class="login"/></td></tr>';
			echo '</table><br>';
			echo '<input type="image" value="submit" src="images/confirm.gif"/> <a href="?page=account.main"><img src="'.$back_button.'" border="0"></a>';
			echo '</form>';	
		}	
	}
}	
?>