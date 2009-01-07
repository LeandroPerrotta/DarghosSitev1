<?
if($engine->loggedIn())
{
	if(Account::isPremium($account) AND SHOW_ITEMSHOP == 1)
	{
		echo '<tr><td class=newbar><center><b>:: Shopping ::</td></tr>';
		echo '<tr><td class=newtext><br><center>';		
		
		if ($_SERVER['REQUEST_METHOD'] == "POST")
		{
			$bless = $_POST['bless'];
			$promotion = $_POST['promotion'];
			$resetFrags = $_POST['resetFrags'];
			
			if($bless == 1)
				$prem['bless'] = 10;
			if($promotion == 1)	
				$prem['promotion'] = 5;
			if($resetFrags == 1)	
				$prem['resetFrags'] = 15;				
				
			$looseDays = $prem['bless'] + $prem['promotion'] + $prem['resetFrags'];
			
			
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
			elseif(!Account::passCheck($account,md5($_POST['pass'])))
			{
				$condition = 'Password error!';
				$conteudo = 'This password is not correct.';
				$error++;
			}			
			elseif(Account::getPremDays($account) < $looseDays)
			{
				$condition = 'Few days of Premium.';
				$conteudo = 'To receive all maarked beneficts you need '.$looseDays.' days of premium account.';
				$error++;
			}			
			elseif(Player::isOnline($_POST['name']) == 1)
			{
				$condition = 'Character as loged in!';
				$conteudo = 'Please, log out you character to make a change sex.';			
				$error++;
			}			
			elseif($bless == 1 and Player::isBlessed($_POST['name']) == 1)
			{
				$condition = 'Character is already blessed!';
				$conteudo = 'This character has already been blessed.';
				$error++;
			}	
			elseif($promotion == 1 and Player::isPromoted($_POST['name']) == 1)
			{
				$condition = 'Character is already promoted!';
				$conteudo = 'This character has already been promoted.';
				$error++;
			}	
			elseif($rank == 1 and Player::checkStatus($_POST['name']) == 1)
			{
				$condition = 'Character already has this status!';
				$conteudo = 'This character already has this status.';
				$error++;
			}			
			elseif($error == 0)
			{
				if($bless == 1)
					Shop::giveBless($_POST['name']);
				if($promotion == 1)	
					Shop::givePromotion($_POST['name']);
				if($resetFrags == 1)	
					Shop::resetFrags($_POST['name']);					
					
				Account::removePremium($looseDays,$account);	
					
				$condition = 'Your benefits bought out successfully.';
				$conteudo = 'The character '.$_POST['name'].' received all benefits marked with success!';				
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
			echo '<center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="4">';
			echo 'Welcome to shop, here you can buy some benefits in the game by your premium days. Mark the desired benefits:<br><br>
			<font color="red"><b>Attention:</b></font><br>
			To buy any benefits here you need exit the game (logout).';
			echo '</table><br>';
			echo '<form action="?page=character.getBeneficts" method=post  ENCTYPE="multipart/form-data">';
			echo '<center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
			echo '<tr class=rank2><td colspan=3>Step 1/2: </td></tr>';		
			echo '<tr><td width="5%" class=rank1></td><td class=rank1><b>Benefit</td><td width="15%" class=rank1><b>Price</td></tr>';
			echo '<tr class=rank3><td><input type="checkbox" name="bless" value="1"></td><td>All blessing\'s</td><td>10 days</td></tr>';
			echo '<tr class=rank1><td><input type="checkbox" name="promotion" value="1"></td><td>Promotion</td><td>5 days</td></tr>';
			echo '<tr class=rank1><td><input type="checkbox" name="resetFrags" value="1"></td><td>Limpas todas Frags de um personagem (incluindo red skulls)</td><td>15 days</td></tr>';
			echo '</table><br>';
			echo '<center><table width="60%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
			echo '<tr class=rank2><td colspan=2>Step 2/2: </td></tr>';		
			echo '<tr class=rank1><td width="25%">Character:</td><td width="75%" class=rank1><input name="name" type="text" value="" class="login"/></td></tr>';
			echo '<tr class=rank1><td width="25%">Password:</td><td width="75%" class=rank1><input name="pass" type="password" value="" class="login"/></td></tr>';
			echo '</table><br>';			
			echo '<input type="image" value="submit" src="images/submit.gif"/> <a href="?page=account.main"><img src="'.$back_button.'" border="0"></a>';
			echo '</form>';				
		}		
	}
}
?>