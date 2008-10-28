<?
if($engine->loggedIn())
{
	echo '<tr><td class=newbar><center><b>:: Premium Test ::</td></tr>
	<tr><td class=newtext>';
	if ($_SERVER['REQUEST_METHOD'] == "POST")
	{		
		if(!Account::passCheck($account,md5($_POST['pass'])))
		{
			$condition = 'Error';
			$conteudo = 'This password is not correct.';
		}	
		elseif(!Account::checkPremiumTest($account))
		{
			$condition = 'Error';
			$conteudo = 'Your account already received the premium test period.';
		}	
		elseif(Account::getLevelMasterPlayer($account) < 100)
		{
			$condition = 'Error';
			$conteudo = 'Only accounts with characters level 100 or more can receive the premium test period.';
		}	
		elseif(Account::isPremium($account))
		{
			$condition = 'Error';
			$conteudo = 'Sorry, the premium test period only can be obtained by free accounts.';
		}		
		else
		{	
			Account::setPremiumTest($account);
			$condition = 'Premium test period successfuly actived';
			$conteudo = 'Congratulations! Your account has been received the premium test period sucessfuly! Now you can enjoy of all premium beneficts by 5 days! Please re-log your character to activate your premium. Have good fun!';
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
		echo 'Confirm bellow your account password to receive the premium test period.
		</table><br>';
		echo '<form action="?page=account.getPremiumTest" method=post  ENCTYPE="multipart/form-data">';
		echo '<center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
		echo '<tr class=rank2><td colspan=2>Confirm your password: </td></tr>';		
		echo '<tr><td width="25%" class=rank1>Password:</td><td width="75%" class=rank1><input name="pass" type="password" value="" class="login"/></td></tr>';
		echo '</table><br>';
		echo '<input type="image" value="submit" src="images/confirm.gif"/> <a href="?page=account.main"><img src="'.$back_button.'" border="0"></a>';
		echo '</form>';	
	}	
}
?>