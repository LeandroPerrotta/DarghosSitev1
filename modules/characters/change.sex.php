<?
if($engine->loggedIn())
{
	if(Account::isPremium($account))
	{
		echo '<tr><td class=newbar><center><b>:: Change Sex ::</td></tr>';
		echo '<tr><td class=newtext><br><center>';		
		
		if ($_SERVER['REQUEST_METHOD'] == "POST")
		{
			$error = 0;
			if(filtreString($_POST['name'],1) == 0 or filtreString(md5($_POST['pass']),1) == 0)
			{
				$condition = 'Erro!';
				$conteudo = 'Personagem inexistente ou sintaxes reservada.';		
				$error++;
			}		
			elseif(!Player::checkAccountPlayer($account,$_POST['name']))
			{
				$condition = 'Erro!';
				$conteudo = 'Personagem não existe ou não é de sua conta.';		
				$error++;
			}
			elseif(!Account::passCheck($account,md5($_POST['pass'])))
			{
				$condition = 'Erro!';
				$conteudo = 'Senha não está correta.';
				$error++;
			}					
			elseif(Account::getPremDays($account) < 5)
			{
				$condition = 'Few days of Premium.';
				$conteudo = 'To make the change of sex you need a premium account with at least 5 days.';
				$error++;
			}			
			elseif(Player::isOnline($_POST['name']) == 1)
			{
				$condition = 'Player is loged in!';
				$conteudo = 'Please, log out you character to make a change sex.';
				$error++;
			}			
			elseif($error == 0)
			{
				$agendamento = Shop::changeSex($_POST['name'],$account);
				$condition = 'Your sex has been changed successfully.';
				$conteudo = 'A sex of '.$_POST['name'].' has been changed successfully!';	
			}
			
			echo '<center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
			echo '<tr><td class=rank2>'.$condition.'</td></tr>';
			echo '</table>';
			echo '<center><table border="0" width="95%" bgcolor="black" CELLSPACING="1" CELLPADDING="2">';
			echo '<tr><td class=rank1>'.$conteudo.'</td></tr>';
			echo '</table>';
			echo '<br><a href="?page=account.main"><img src="'.$back_button.'" border="0"></a>';					
		}
		else
		{
			echo '<center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">';
			echo 'If you choose your gender wrong in the creation of his character, or want to change their looks, in Darghos you can change your sex for 5 days of premium account. For this to fill in the fields below:<br><br>
			<font color="red"><b>Attention:</b></font><br>
			The change of sex spends 5 days of your premium account.<br>
			To make the change you need exit the game (logout).';
			echo '</table><br>';
			echo '<form action="?page=character.changeSex" method=post  ENCTYPE="multipart/form-data">';
			echo '<center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
			echo '<tr class=rank2><td colspan=2>Character information: </td></tr>';		
			echo '<tr><td width="25%" class=rank1>Character:</td><td width="75%" class=rank1><input name="name" type="text" value="" class="login"/></td></tr>';
			echo '<tr><td width="25%" class=rank1>Password:</td><td width="75%" class=rank1><input name="pass" type="password" value="" class="login"/></td></tr>';
			echo '</table><br>';
			echo '<input type="image" value="submit" src="images/submit.gif"/> <a href="?page=account.main"><img src="'.$back_button.'" border="0"></a>';
			echo '</form>';				
		}		
	}	
}	
?>	