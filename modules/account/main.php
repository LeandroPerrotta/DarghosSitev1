<?
echo '
<tr><td class=newbar><center><b>:: '.$lang['account_title'].' ::</td></tr>
<tr><td class=newtext>';

$acc = $_SESSION['account'];
$pass = $_SESSION['password'];

$account = $engine->loadClass('Accounts');
$account->loadByNumber($_SESSION['account']);

$query2 = mysql_query("SELECT * FROM `accounts` WHERE (`id` = '".$acc."') ") or die(mysql_error());
$premiumact_query = mysql_query("SELECT * FROM `premium` WHERE (`account_id` = '".$acc."' and premstatus = '0') ") or die(mysql_error());

while($sql2 = mysql_fetch_array($query2))
{			
	$creation = date('M d Y, H:i:s',$sql2['creation']);
	if($sql2['premdays'] != 0)
	{
		$prem_status = '<font color=0B8011><b>Premium account</b></font>';
	}	
	else
	{
		$prem_status = 'Free account';
	}	
	
	$getDays = ($sql2['premdays']);
	$warnings = $sql2['warnings'];
	
	if($sql2['warnings'] == 3 or $sql2['warnings'] == 4)
		$warnings = '<font color=red>'.$sql2['warnings'].'</font>';
	elseif($sql2['warnings'] == 0)
		$warnings = 'None.';
	else
		$warnings = ''.$sql2['warnings'].'';	
	
	$editinfo = '<img align="left" src="'.$imagedir.'editinfo.gif" border="0">';
	$newchar = '<img align="left" src="'.$imagedir.'newchar.gif" border="0">';
	$changepass = '<a href="?page=account.changePassword"><img align="left" src="'.$imagedir.'changepass.gif" border="0"></a>';
	$changemail = '<img align="left" src="'.$imagedir.'changemail.gif" border="0">';
	$logout = '<img align="right" src="'.$imagedir.'logout.gif" border="0">';
	$editbutton = '<img align="right" src="'.$imagedir.'edit.gif" border="0">';
	$recoverykeybutton = '<img align="left" src="'.$imagedir.'recoverykey.gif" border="0">';
	$cancelbutton = '<img align="right" src="'.$imagedir.'cancel.gif" border="0">';
	$cancelDelbutton = '<img align="left" src="'.$imagedir.'cancelDel.gif" border="0">';
	$deleteCharbutton = '<img align="left" src="'.$imagedir.'delChar.gif" border="0">';
	$donateButton = '<a href="?page=contribute.make"><img align="left" src="'.$imagedir.'contribute.gif" border="0"></a>';
	
	if(Account::isPremium($acc))
	{
		$changeSex = '<a href="?page=character.changeSex"><img align="left" src="'.$changeSex_button.'" border="0"></a>';
		$changeName = '<a href="?page=character.changeName"><img align="left" src="'.$imagedir.'changeName.gif" border="0"></a>';
		$shopButton = '<a href="?page=character.getBeneficts"><img align="left" src="'.$imagedir.'shopping.gif" border="0"></a>';
		$itemButton = '<a href="?page=character.itemShop"><img align="left" src="'.$imagedir.'item_shop.gif" border="0"></a>';
		$getTutor = '<a href="?page=character.getTutor"><img align="left" src="'.$imagedir.'get_a_tutor.gif" border="0"></a>';
	}	
	
	if(Account::isPremium($acc) and ($sql2['rk_number'] == null or $sql2['rk_number'] == 0))
		$recoverykey = '<a href="?page=account.getRecoveryKey">'.$recoverykeybutton.'</a>';
		
	if(!$account->loadEmailChanger())
		$changeEmail_button = '<a href="?page=account.changeEmail">'.$changemail.'</a>';			
		
	if(Account::getLevelMasterPlayer($acc) >= 100 and Account::checkPremiumTest($acc) and !Account::isPremium($acc))
	{
		$premiumTest_button = '<a href="?page=account.getPremiumTest"><img align="left" src="'.$imagedir.'get_premium_test.gif" border="0"></a>';	
		$premiumTest = "Clique no botão \"Get Premium Test\" abaixo e obtenha 5 dias de premium account gratuitos para teste agora mesmo!";
	}	
	else
	{
		if(!Account::checkPremiumTest($acc))
			$premiumTest = "Está conta já obteve o beneficio para teste de premium.";
		else
			$premiumTest = "Requer um personagem com nivel 100 ou superior nesta conta.";
	}

	while($premiumact = mysql_fetch_array($premiumact_query))
	{
		echo '<form>';
		$prem_id = $premiumact['id'];
		echo '<center><table border="0" bgcolor="black" width="95%" CELLSPACING="1" CELLPADDING="2">';
		echo '
		<tr class=rank2><td colspan=2>Aceitar Premium Account</td></tr>
		<tr class=rank1><td width="25%">Numero de dias:</td><td>'.$premiumact['premdays'].'</td></tr>
		<tr class=rank1><td width="25%">Liberada em:</td><td>'.date('d/m/Y - H:i',$premiumact['date']).'</td></tr>
		<tr class=rank1><td colspan=2><b>Parabens!!</b><br>
		Está premium account foi ativa com sucesso! Agora você está a poucos passos de tudo que o Darghos pode-lhe oferecer!
		Para ativar sua premium account, apenas clique no botão abaixo "Aceitar Premium Account" e pronto!<br><br>
		<font color=red><b>ATENÇÃO:</b></font><br><br>
		Note que você pode ter sido alvo de um golpe, e ao aceitar a premium accout você esta assumindo todos os riscos da mesma, portanto em caso de pagamento falso sua account sera bloqueada até o pagamento real do valor mais o acrescentamento de juros para desbloqueio!	
		Apenas ative sua premium account se você realmente fez a compra da mesma, se você nao comprou, ou não tem ideia de como pagaram para você e altamente recomdavel que você REJEITE a premium account!<br>
		<br>A UltraxSoft agradeçe a preferencia! Tenham um bom jogo!
		</td></tr>';
		echo '</table>';
		echo '<center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';	
		echo '<tr><td><center><a href="?page=account.premium&action=accept&id='.$prem_id.'"><img src="images/acceptPremium.gif" border="0"></a></td><td><center><a href="?page=account.premium&action=reject&id='.$prem_id.'"><img src="images/rejectPremium.gif" border="0"></a></td></tr>';
		echo '</table>';
	}		

	//Alerta de mudança de e-mail
	if($account->loadEmailChanger())
	{
	$emailDate = date('d/m/Y', $account->getEmailChangerData('date'));
	echo '<br><center><table width="95%" BGcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">
	<tr class=rank1><td><font color=red><b>Atenção:</b> Foi solicitado um agendamento de mudança de e-mail registrado em sua conta para: <b>'.$account->getEmailChangerData('email').'.</b><br><br>
	Está mudança será concretizada na data de: '.$emailDate.'<br>
	Caso você nao tenha acesso a este e-mail ou não solicitou esta mudança cancele isto imediatamente clicando no botão "cancelar" abaixo!</font><br><br>
	<a href="?page=account.cancelChangeEmail">'.$cancelbutton.'</a></td></tr>';	
	echo '</table>';	
	}	
	
	//Informações Gerais
	echo '<br><center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';		
	echo '<tr><td colspan=2 class=rank2>'.$lang['account_information'].'</td></tr>
	<tr class=rank3><td width="25%"><b>'.$lang['created_in'].':</td><td>'.$creation.'</td></tr>
	<tr class=rank1><td><b>'.$lang['account_status'].':</td><td>'.$prem_status.'</td></tr>';		
	if($sql2['premdays'] != 0)
	{
		echo '<tr class=rank3><td><b>'.$lang['premium_status'].':</td><td>'.(int)$getDays.' '.$lang['premium_time'].'.</td></tr>';
	}
	echo '<tr class=rank1><td><b>'.$lang['account_warnings'].':</td><td>'.$warnings.'</td></tr>';
	echo '<tr class=rank3><td><b>Premium Test:</td><td>'.$premiumTest.'</td></tr>';	
	echo '</table>';
	
	echo '<center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="2">';	
	echo '<tr><td>'.$itemButton.''.$shopButton.''.$donateButton.''.$premiumTest_button.'</td><td><a href="logout.php">'.$logout.'</a></td></tr>';	
	
	echo '</table>';
	
	//Informações de Segurança
	echo '<br><center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';		
	echo '<tr><td colspan=2 class=rank2>Segurança da Conta</td></tr>';
	
	$security = "Médio";
	
	echo '<tr class=rank3><td><b>'.$lang['account_email'].':</td><td>'.$sql2['email'].'</td></tr>';	
	
	if($account->loadQuestions())
	{
		$security = "Maximo";
		$question['status'] = "Possui uma ou mais perguntas e respostas configuradas.";
		
	}	
	else	
	{
		$question['status'] = "Está conta não possui perguntas e respostas configuradas, clique no botão \"Set Questions\" abaixo para aumentar o nivel de segurança de sua conta.";
		$question['button'] = '<a href="?page=account.setSecretQuestion"><img align="left" src="'.$imagedir.'setquestion.gif" border="0"></a>';
	}	
		
	echo '<tr class=rank3><td width="30%"><b>Perguntas e Respostas:</td><td>'.$question['status'].'</td></tr>';	
	echo '<tr class=rank3><td width="30%"><b>Nivel de Segurança:</td><td>'.$security.'</td></tr>';	
		
	echo '</table>';
	
	echo '<center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="2">';	
	echo '<tr><td>'.$changepass.''.$changeEmail_button.''.$question['button'].'</td></tr>';	
	echo '</table>';

	$rlname = $sql2['real_name'];
	$location = $sql2['location'];
	$site = $sql2['url'];
	if($sql2['real_name'] == '') $rlname = 'nao especificado';
	if($sql2['location'] == '') $location = 'nao especificado';
	if($sql2['url'] == '') $site = 'nao especificado';
	
	//Informações Personalizadas
	echo '<br><center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';		
	echo '<tr class=rank2><td colspan=2>'.$lang['account_personal'].'</td></tr>';		
	echo '<tr class=rank3><td width="25%">'.$lang['real_name'].':</td><td>'.$rlname.'</td></tr>';	
	echo '<tr class=rank1><td>'.$lang['country'].':</td><td>'.$location.'</td></tr>';
	echo '<tr class=rank3><td>'.$lang['website'].':</td><td>'.$site.'</td></tr>';
	echo '</table>';
	
	echo '<center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';	
	echo '<tr><td colspan=3 width="25%"><a href="?page=account.changeInformations">'.$editinfo.'</a></td></tr>';			
	echo '</table>';

	
	//Outros Personagens	
	echo '<br><center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';		
	echo '<tr><td colspan=3 class=rank2>'.$lang['account_characters'].'</td></tr>';
	echo '<tr class=rank3><td width="50%"><b>'.$lang['name'].':</td><td width="40%"><b>'.$lang['status'].':</td><td width="10%"></td></tr>';		
	
	$query = mysql_query("SELECT * FROM `players` WHERE (`account_id` = '".$acc."') ") or die(mysql_error());
	
	if(Player::checkPlayersDeleted($acc))
		$undelButton = ' <a href="?page=character.cancelDeletion">'.$cancelDelbutton.'</a>';
	
	
	if (mysql_num_rows($query) > 0)
	{
		$deletebutton = ' <a href="?page=character.delete">'.$deleteCharbutton.'</a>';
		$TipoCor == true;
		while($sql = mysql_fetch_array($query))
		{
			if ($TipoCor == true) 
			{
				$style = "rank3";
			} 
			else 
			{
				$style = "rank1";
			}

			if ($TipoCor == true) 
			{
				$TipoCor = false;
			} 
			else 
			{
				$TipoCor = true;
			}			
			$status = Null;
			if($sql['hide'] != '0') $status = 1;
			if(Player::isDeleted($sql['id'])) $status = $status+2;
			
			if($status == 1)
				$status = 'hidden';
			elseif($status == 2)
				$status = 'deleted';	
			elseif($status == 3)
				$status = 'hidden, deleted';		
				
			echo '<tr class='.$style.'><td width="30%"><a href="?page=character.details&char='.$sql['name'].'">'.$sql['name'].'</a></td><td width="60%">'.$status.'</td><td width="10%"><center><a href="?page=character.edit&charname='.$sql['name'].'">'.$editbutton.'</a></td></tr>';		
		}			
	}	
	else
	{
		echo '<tr><td colspan=3" class=rank1>There is no character created in your account.</td></tr>';
	}
	echo '</table>';	
	echo '<center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';	
	echo '<tr><td colspan=3><a href="?page=character.create">'.$newchar.'</a>'.$deletebutton.''.$undelButton.'<br>'.$changeSex.' '.$changeName.''.$getTutor.'</td></tr>';	
	echo '</table>';	
	
}                
?>