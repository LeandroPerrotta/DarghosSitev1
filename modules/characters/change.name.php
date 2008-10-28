<?
if($engine->loggedIn())
{
	if(Account::isPremium($account))
	{
		echo '<tr><td class=newbar><center><b>:: Change Name ::</td></tr>';
		echo '<tr><td class=newtext><br><center>';		
		
		if ($_SERVER['REQUEST_METHOD'] == "POST")
		{
			$error = 0;
			if(filtreString($_POST['name'],1) == 0 or filtreString(md5($_POST['pass']),1) == 0 or filtreString($_POST['new_name'],1) == 0)
			{
				$condition = 'Erro!';
				$conteudo = 'Character does not exist or uses syntaxes reserved.';		
				$error++;
			}		
			elseif(!Player::checkAccountPlayer($account,$_POST['name']))
			{
				$condition = 'Erro!';
				$conteudo = 'Character does not exist or is not in your account.';		
				$error++;
			}
			elseif (!preg_match("/^[a-zA-Z][a-zA-Z ]*$/", $_POST['new_name']))  
			{
				$condition = 'Illegal new name!';
				$conteudo = 'This new name contains illegal characters.';
				$error++;
			}
			elseif(!Account::passCheck($account,md5($_POST['pass'])))
			{
				$condition = 'Password error!';
				$conteudo = 'This password is not correct.';
				$error++;
			}
			elseif(Player::playerExists($_POST['new_name']) != 0)
			{
				$condition = 'Name in use!';
				$conteudo = 'This name is already in use by another character, please choose another name.';
				$error++;
			}				
			elseif(Account::getPremDays($account) < 10)
			{
				$condition = 'Few days of Premium.';
				$conteudo = 'To make the change of name you need a premium account with at least 5 days.';
				$error++;
			}	
			elseif(Account::getType($account) > 2 and Account::getType($account) < 6)
			{
				$condition = 'Error';
				$conteudo = 'Illegal account type.';
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
				$agendamento = Shop::changeName($_POST['name'],$_POST['new_name']);
				$condition = 'Your name has been changed successfully.';
				$conteudo = 'A name of character '.$_POST['name'].' has been changed to '.$_POST['new_name'].' successfully!';				
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
			echo 'With this feature you can change the name of her character for 10 days of your premium account in Darghos. For this fill in the fields below:<br><br>
			<font color="red"><b>Attention:</b></font><br>
			The change of name spends 10 days of your premium account.<br>
			To make the change you need exit the game (logout).';
			echo '</table><br>';
			echo '<form action="?page=character.changeName" method=post  ENCTYPE="multipart/form-data">';
			echo '<center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
			echo '<tr class=rank2><td colspan=2>Character information: </td></tr>';		
			echo '<tr><td width="25%" class=rank1>Character:</td><td width="75%" class=rank1><input name="name" type="text" value="" class="login"/></td></tr>';
			echo '<tr><td width="25%" class=rank1>New name:</td><td width="75%" class=rank1><input name="new_name" type="text" value="" class="login"/></td></tr>';
			echo '<tr><td width="25%" class=rank1>Password:</td><td width="75%" class=rank1><input name="pass" type="password" value="" class="login"/></td></tr>';
			echo '</table><br>';
			echo '<input type="image" value="submit" src="images/submit.gif"/> <a href="?page=account.main"><img src="'.$back_button.'" border="0"></a>';
			echo '</form>';				
		}		
	}	
}	
?>	