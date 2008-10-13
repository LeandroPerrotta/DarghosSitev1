<?
session_start();
include "top.php";

// connects to database
$ots = POT::getInstance();
$ots->connect(POT::DB_MYSQL, $userdb);

if($_GET['subtopic'] == 'create'){

$error = 0;
$id = 0;
$id++;
$email = $_POST['email'];
$acceptemail = ($_POST['acceptemail']);
$privacidade = ($_POST['privacidade']);

if ($_SERVER['REQUEST_METHOD'] == "POST")
{
	echo '<tr><td class=newbar><center><b>:: Criação de Conta ::</td></tr>
<tr><td class=newtext>';
	if (isset($email) && $email != "") 
	{

		$chkEmail = mysql_query("SELECT * FROM `accounts` WHERE (`email` = '".$email."')") or die(mysql_error());

		if( !preg_match('/^[a-z][\w\.+-]*[a-z0-9]@[a-z0-9][\w\.+-]*\.[a-z][a-z\.]*[a-z]$/i', $email) )
		{
			echo '<br><center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
			echo '<tr><td class=rank2>Invalid e-mail!</td></tr>';
			echo '<tr><td class=rank1>This e-mail is not a valid, please try again with another email.';
			echo '</table>';
			echo '<br><a href="account.php?subtopic=create"><img src="images/back.gif" border="0"></a>';
			include "footer.php";
			die;		
		}
		
		if(mysql_num_rows($chkEmail) != 0)		
		{
			echo '<br><center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
			echo '<tr><td class=rank2>E-mail already used!</td></tr>';
			echo '<tr><td class=rank1>This email already used, please try again with another email.';
			echo '</table>';
			echo '<br><a href="account.php?subtopic=create"><img src="images/back.gif" border="0"></a>';
			include "footer.php";
			die;
		}	
		
		else if(!emailExists($email))
		{
			echo '<br><center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
			echo '<tr><td class=rank2>E-mail does not exist!</td></tr>';
			echo '<tr><td class=rank1>Communication failed to this email, or it does not exist or your provider is not responding at the moment. Try again with another email or try again later.';
			echo '</table>';
			echo '<br><a href="account.php?subtopic=create"><img src="images/back.gif" border="0"></a>';
			include "footer.php";
			die;		
		}
		
		else if(filtreString($email,1) == 0)		
		{
			echo '<br><center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
			echo '<tr><td class=rank2>Invalid syntax!</td></tr>';
			echo '<tr><td class=rank1>This email contains invalid syntax. Please try again with another email.';
			echo '</table>';
			echo '<br><a href="account.php?subtopic=create"><img src="images/back.gif" border="0"></a>';
			include "footer.php";
			die;
		}		

		else if($privacidade != 1)		
		{
			echo '<br><center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
			echo '<tr><td class=rank2>Termos não aceitos</td></tr>';
			echo '<tr><td class=rank1>Somente podemos oferecer o Darghos a quem aceitar e concordar com todos termos e politicas de nosso trabalho.';
			echo '</table>';
			echo '<br><a href="account.php?subtopic=create"><img src="images/back.gif" border="0"></a>';
			include "footer.php";
			die;
		}			
		
		else 
		{
			
			if ($error == 0) 
			{

				$pass = my_rand(6);	
				$passMd5 = md5($pass);
				$date = time();
		

				// creates account
				$account = $ots->createObject('Account');
				$number = $account->create();

				// saves account information
				$account->setPassword($passMd5);
				$account->setEMail($email);
				$account->setCustomField(lastday, $date);
				$account->setCustomField(creation, $date);
				$account->unblock();
				$account->save();	
				
				$body = 
				'Dear  player of Darghos,
Your account has been successfully created!
				
Below follows the details of your account:
Your account is: '.$number.'
Your password is: '.$pass.'
					
To create you character and start the game visit:
ot.darghos.com/account.php?subtopic=login
				
See you in World of Darghos!
UltraxSoft Team.';
				
				if (!mailex($email, 'Account details!', $body))
				{
					echo '<br><center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
					echo '<tr><td class=rank2>Falha ao enviar email</td></tr>';
					echo '</table>';
					echo '<center><table border="0" width="95%" bgcolor="black" CELLSPACING="1" CELLPADDING="2">';
					echo '<tr><td class=rank1>Ouve um congestionamento no sistema de envio de emails que impossibilitou o envio do seu email. Tente novamente mais tarde.</td></tr>';
					echo '</table>';
					echo '<br><a href="account.php?subtopic=create"><img src="images/back.gif" border="0"></a>';	
					include "footer.php";
					die();			
				}				
				else
				{	
					echo '<br><center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
					echo '<tr><td class=rank2>Email sent successfully!</td></tr>';
					echo '<tr><td class=rank1>Congratulations! Your account has been created sucessfuly!
					<br>Your account number is: <font size=6><b>'.$number.'</b></font>
					<br><br>
					Your password has been sent to the email address registered in your account: <b>'.$email.'</b><br><br>
					Never give your account to anyone!
					<br><br>Have a nice game!<br>UltraxSoft Team.</td></tr>';			
					echo '</table>';
					echo '<br><a href="account.php?subtopic=login"><img src="images/login.gif" border="0"></a>';
					include "footer.php";
					die;	
				}					

			}  
			session_unset();		
		}
	}

	else 
	{
		echo '<br><center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
		echo '<tr><td class=rank2>Email is needed!</td></tr>';
		echo '</table>';
		echo '<center><table border="0" width="95%" bgcolor="black" CELLSPACING="1" CELLPADDING="2">';
		echo '<tr><td class=rank1>
		<br>Fill the field email properly and try again.';
		echo '</table>';
		echo '<br><a href="account.php?subtopic=create"><img src="images/back.gif" border="0"></a>';
		include "footer.php";
		die;
	}
}	


echo '<tr><td class=newbar><center><b>:: Account Creation ::</td></tr>
<tr><td class=newtext>

<center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="4">
Crie agora mesmo sua account e começe a se divertir no Darghos!</table>

<br>

<form action="account.php?subtopic=create" method="post">

<center>
<table width="90%" BORDER="0" CELLSPACING="1" CELLPADDING="4">
	<tr>
		<td class=rank2>Crie uma conta no Darghos</td>
	</tr>
	<tr class=rank3>
		<td>
			Endereço de E-mail: <input class="login" name="email" type="text" value="" size="30"/>
		</td>
	</tr>
	<tr class=rank3>
		<td><br>
			<b>Termos de politica de privacidade</b>
	<center><textarea class="login" rows="7" wrap="physical" cols="55" readonly="true">Nosso compromisso em garantir a sua privacidade.

Nossa política de privacidade visa assegurar que nenhum dado pessoal dos usuários utilizado no registro de contas serão publicadas, fornecidas ou comercializadas em qualquer circunstância. O darghos obtém os dados dos usuários atravéz de três maneiras: Cookies, Sessões e Registro.

1. Cookies e Sessões

- O Darghos coleta as informações atravéz de cookies ou sessões (informações enviadas de nosso servidor ao computador do usuário para identifica-lo), os Cookies e Sessões são utilizados unicamente como um controle de acesso, exceto quando este desrespeita as regras de segurança com o fim de prejudicar o bom funcionamento do site ou servidor (hackear o serviço). A aceitaçao dos cookies pode ser livremente alterada na configuraçao do seu navegador.

2. Registro

- Para desfrutar de tudo que o darghos oferece, é nescessario um registro em nosso servidor, criando uma conta, para a partir disso criar um personagem. O registro é feito sob um endereço de e-mail, onde os dados de sua conta serão enviados, e que também poderá ser utilizado por você no futuro, por exemplo, para recuperar sua conta em caso de perda. Nós também podemos usar seu email para enviar mensagens sobre o Darghos. As contas, assim como todos os dados necessários para registro são mantidos em um banco de dados protegido e sigiloso em nosso servidor. Não divulgamos o seu endereço de email em qualquer circunstância.

3. Segurança das informações

- Todos os dados pessoais informados ao nosso site, são armazenados em um banco de dados reservado e com acesso restrito a alguns funcionários habilidados, que são obrigados, por contrato,  manter confidencial todas as informações e não utilizadas inadequadamente.

Assegurar a sua privacidade é mais um compromisso do Darghos com você!</textarea></center></td>
	</tr>
	<tr class=rank3>
		<td>
			<input type="checkbox" name="privacidade" value="1"> Eu concordo com os termos da politica de privacidade oferecidos pelo darghos.
		</td>
	</tr>
</table><br>
<input type="image" value="Entrar" src="images/newaccount.gif"/>
<br />
</form>
</center>
</ul>';

}

elseif($_GET['subtopic'] == 'main'){

	echo '<tr><td class=newbar><center><b>:: '.$lang['account_title'].' ::</td></tr>
<tr><td class=newtext>';

$acc = "";
$pass = "";
$acc = $_SESSION['account'];
$pass = $_SESSION['password'];

echo "<script language=\"JavaScript\">\n";
    
    echo "function askConfirm(txt,url) {\n";
        echo "if (confirm(txt) == true) {\n";
        echo "document.location=url\n";
        echo "return true;\n";
        echo "} \n";
    echo "}\n";
    
    echo "</script>";

if ($acc != "" && $acc != null && $pass != "" && $pass != null) {


	$login = $_GET['login'];
	
	$query2 = mysql_query("SELECT * FROM `accounts` WHERE (`id` = '".$acc."') ") or die(mysql_error());
	$premiumact_query = mysql_query("SELECT * FROM `premium` WHERE (`account_id` = '".$acc."' and premstatus = '0') ") or die(mysql_error());
	
	while($sql2 = mysql_fetch_array($query2)){
	
		echo '<center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">';

		if (($sql2['premdays'] != 0) and ($sql2['rk_number'] == null or $sql2['rk_number'] == 0))
		{
			echo '<br><font color=red>ATENÇÃO:</font> Parabens por adquirir sua conta premium! Com ela você podera desfrutar do Darghos por inteiro! Por ser uma conta premium, ela tem uma segurança adicional, a recovery key. É altamente recomendavel que você gere sua recovery key neste instante clicando no botão abaixo! Após gera-la você nao verá mais esta mensagem! O Darghos lhe deseja um bom jogo e muito mais diversão com sua conta premium! Nos vemos no jogo!';
		}	
		
		echo '</table>';
		
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
		$changepass = '<a href="main.php?subtopic=changepass"><img align="left" src="'.$imagedir.'changepass.gif" border="0"></a>';
		$changemail = '<img align="left" src="'.$imagedir.'changemail.gif" border="0">';
		$logout = '<img align="right" src="'.$imagedir.'logout.gif" border="0">';
		$editbutton = '<img align="right" src="'.$imagedir.'edit.gif" border="0">';
		$recoverykeybutton = '<img align="left" src="'.$imagedir.'recoverykey.gif" border="0">';
		$cancelbutton = '<img align="right" src="'.$imagedir.'cancel.gif" border="0">';
		$cancelDelbutton = '<img align="left" src="'.$imagedir.'cancelDel.gif" border="0">';
		$deleteCharbutton = '<img align="left" src="'.$imagedir.'delChar.gif" border="0">';
		$donateButton = '<a href="main.php?subtopic=payments"><img align="left" src="'.$imagedir.'contribute.gif" border="0"></a>';
		
		if(Account::isPremium($acc))
		{
			$changeSex = '<a href="main.php?subtopic=change_sex"><img align="left" src="'.$changeSex_button.'" border="0"></a>';
			$changeName = '<a href="main.php?subtopic=change_name"><img align="left" src="'.$imagedir.'changeName.gif" border="0"></a>';
			$shopButton = '<a href="main.php?subtopic=shop"><img align="left" src="'.$imagedir.'shopping.gif" border="0"></a>';
			$itemButton = '<a href="main.php?subtopic=item_shop"><img align="left" src="'.$imagedir.'item_shop.gif" border="0"></a>';
			$getTutor = '<a href="main.php?subtopic=getTutor"><img align="left" src="'.$imagedir.'get_a_tutor.gif" border="0"></a>';
		}	
		
		if(Account::isPremium($acc) and ($sql2['rk_number'] == null or $sql2['rk_number'] == 0))
			$recoverykey = '<a href="main.php?subtopic=get_recoverykey">'.$recoverykeybutton.'</a>';
			
		if($sql2['new_email'] == '')
			$changeEmail_button = '<a href="main.php?subtopic=changeemail">'.$changemail.'</a>';			
			
		if(Account::getLevelMasterPlayer($acc) >= 100 and Account::checkPremiumTest($acc) and !Account::isPremium($acc))
			$premiumTest_button = '<a href="main.php?subtopic=getPremiumTest"><img align="left" src="'.$imagedir.'get_premium_test.gif" border="0"></a>';	
	
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
			echo '<tr><td><center><a href="account.php?subtopic=premium&action=accept&id='.$prem_id.'"><img src="images/acceptPremium.gif" border="0"></a></td><td><center><a href="account.php?subtopic=premium&action=reject&id='.$prem_id.'"><img src="images/rejectPremium.gif" border="0"></a></td></tr>';
			echo '</table>';
		}		

		//Alerta de mudança de e-mail
		
		if($sql2['new_email'] != '')
		{
		$emailDate = (date('d/m/Y',$sql2['email_date']));
		echo '<br><center><table width="95%" BGcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">
		<tr class=rank1><td><font color=red><b>Atenção:</b> Foi solicitada uma mudança de e-mail em sua conta para: <b>'.$sql2['new_email'].'</b><br><br>
		Para a sua segurança a mudança so estará concluida na data de: '.$emailDate.'<br>
		Caso você nao tenha acesso a este e-mail ou não solicitou esta mudança cancele isto imediatamente clicando no botão "cancelar" abaixo!</font><br><br>
		<a href="main.php?subtopic=cancel_email">'.$cancelbutton.'</a></td></tr>';	
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
		echo '<tr class=rank3><td><b>'.$lang['account_email'].':</td><td>'.$sql2['email'].'</td></tr>';	
		echo '</table>';
		
		echo '<center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="2">';	
		echo '<tr><td>'.$changepass.''.$changeEmail_button.''.$recoverykey.'</td><td><a href="logout.php">'.$logout.'</a></td></tr>';	
		echo '<tr><td colspan="2">'.$itemButton.''.$shopButton.''.$donateButton.''.$premiumTest_button.'</td></tr>';
		
		echo '</table>';

		$rlname = $sql2['rlname'];
		$location = $sql2['location'];
		$site = $sql2['url'];
		if($sql2['rlname'] == '') $rlname = 'nao especificado';
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
		echo '<tr><td colspan=3 width="25%"><a href="main.php?subtopic=changeinfo">'.$editinfo.'</a></td></tr>';			
		echo '</table>';

		
		//Outros Personagens	
		echo '<br><center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';		
		echo '<tr><td colspan=3 class=rank2>'.$lang['account_characters'].'</td></tr>';
		echo '<tr class=rank3><td width="50%"><b>'.$lang['name'].':</td><td width="40%"><b>'.$lang['status'].':</td><td width="10%"></td></tr>';		
		
		$query = mysql_query("SELECT * FROM `players` WHERE (`account_id` = '".$acc."') ") or die(mysql_error());
		
		if(Player::checkPlayersDeleted($acc))
			$undelButton = ' <a href="main.php?subtopic=undelete_char">'.$cancelDelbutton.'</a>';
		
		
		if (mysql_num_rows($query) > 0)
		{
			$deletebutton = ' <a href="main.php?subtopic=delete_char">'.$deleteCharbutton.'</a>';
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
					
				echo '<tr class='.$style.'><td width="30%"><a href="community.php?subtopic=details&char='.$sql['name'].'">'.$sql['name'].'</a></td><td width="60%">'.$status.'</td><td width="10%"><center><a href="char_edit.php?charname='.$sql['name'].'">'.$editbutton.'</a></td></tr>';		
			}			
		}	
		else
		{
			echo '<tr><td colspan=3" class=rank1>There is no character created in your account.</td></tr>';
		}
		echo '</table>';	
		echo '<center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';	
		echo '<tr><td colspan=3><a href="main.php?subtopic=newchar">'.$newchar.'</a>'.$deletebutton.''.$undelButton.'<br>'.$changeSex.' '.$changeName.''.$getTutor.'</td></tr>';	
		echo '</table>';	
		
	}                
}
}

elseif($_GET['subtopic'] == 'premium'){

	$acc = $_SESSION['account'];
	$pass = $_SESSION['password'];
	$id = $_GET['id'];

	echo '<tr><td class=newbar><center><b>:: Minha conta ::</td></tr>
	<tr><td class=newtext>';		
	
	if ($acc != "" && $acc != null && $pass != "" && $pass != null) 
	{		
	
		if($_GET['action'] == 'accept')
		{
			$premiumact_query = mysql_query("SELECT * FROM `premium` WHERE (`account_id` = '".$acc."' and premstatus = '0') ") or die(mysql_error());
			$premiumact = mysql_fetch_array($premiumact_query);	

			$days = $premiumact['premdays'];
			
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
					$premiumst = "UPDATE premium SET premstatus = '1' WHERE account_id = '".$acc."' and id = '".$id."'";
					mysql_query($premiumst) or die(mysql_error());	
				}
				else
				{
					$newPrem = $premNow + $days;
					$premmy_up = "UPDATE accounts SET premDays = '".$newPrem."', premFree = '0', lastday = '$date' WHERE id = '".$acc."'";
					mysql_query($premmy_up) or die(mysql_error());
					$premiumst = "UPDATE premium SET premstatus = '1' WHERE account_id = '".$acc."' and id = '".$id."'";
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
				echo '<tr><td><center><a href="account.php?subtopic=main"><img src="images/back.gif" border="0"></a></td></tr>';
				echo '</table>';		
			}
		}
		elseif($_GET['action'] == 'reject')	
		{
			$premiumact_query = mysql_query("SELECT * FROM `premium` WHERE (`account_id` = '".$acc."' and premstatus = '0') ") or die(mysql_error());
			$premiumact = mysql_fetch_array($premiumact_query);	
	
			if(mysql_num_rows($premiumact_query) != 0)	
			{
				$reject = "UPDATE premium SET premstatus = '2' WHERE account_id = '".$acc."' and id = '".$id."'";
				mysql_query($reject) or die(mysql_error());	

				echo '<br><center><table border="0" bgcolor="black" width="95%" CELLSPACING="1" CELLPADDING="2">';
				echo '
				<tr class=rank2><td>Ativação de Premium Account</td></tr>
				<tr class=rank1><td>Premium account rejeitada com sucesso!<br>
				Se não foi desta vez não desanime, adquira uma autentica premium account agora mesmo! Clique <a href="about.php?subtopic=featurespremium">aqui</a> e saiba como!<br>
				O Darghos lhe deseja um otimo jogo!
				</td></tr>';
				echo '</table>';
				echo '<center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';	
				echo '<tr><td><center><a href="account.php?subtopic=main"><img src="images/back.gif" border="0"></a></td></tr>';
				echo '</table>';					
			}	
		}
	}
}

elseif($_GET['subtopic'] == 'login')
{

	$editbutton = '<img src="'.$imagedir.'login.gif" border="0">';
	if (!isset($_SESSION['account']))
	{ ?>
<tr><td class=newbar><center><b>:: Login ::</td></tr>
<tr><td class=newtext>	
<form action="login.php" method="post">

<br><center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">
Please enter your account number and password.<br>
If you don't have an account, you can create an account clicking <a href="account.php?subtopic=create">here</a>.<br>
</table>

<br><center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">
<tr><td class=rank2 colspan=2>Account Login</td></tr>
<tr class=rank3><td width="25%"><b>Account Number</td><td width="75%"><input class="login" name="account" type="password" value="" class="login" size="10"/></td></tr>
<tr class=rank3><td width="25%"><b>Password</td><td width="75%"><input class="login" name="password" type="password" value="" class="login"/></td></tr>
</table>
<br />
<input type="image" value="Entrar" src="images/login.gif">
</form>
<? 

	}
	else{
	echo '<META HTTP-EQUIV="Refresh" CONTENT="3; URL=account.php?subtopic=main">';
	}
}

elseif($_GET['subtopic'] == 'accountRecovery')
{

	$editbutton = '<img src="'.$imagedir.'login.gif" border="0">'; ?>
<tr><td class=newbar><center><b>:: Recuperação de Conta ::</td></tr>
<tr><td class=newtext>	

<br><center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2"><font color=black>
Caso você tenha perdido um ou mais dados de sua conta ainda é possivel recupera-la ultilizando este recurso. 
Para que você possa recuperar com exito sua account, caso você nao possua uma Recovery Key, é necessario ter acesso ao e-mail na qual sua conta foi registrada, caso contrario será impossivel a recuperação.</a><br>
</table>

<br><center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">
<tr><td class=rank2>Recuperação de conta</td></tr>
<tr class=rank1><td width="25%"><a href="account.php?subtopic=lost_account"><li>Quero recuperar o numero de minha conta</a></li></td></tr>
<tr class=rank1><td width="25%"><a href="account.php?subtopic=lost_password"><li>Quero recuperar minha senha</a></li></td></tr>
<tr class=rank1><td width="25%"><a href="account.php?subtopic=lost_full"><li>Quero recuperar minha senha e meu numero de conta</a></li></td></tr>
<tr class=rank1><td width="25%"><a href="account.php?subtopic=recovery_key"><li>Quero recuperar minha account ultilizando minha recovery key.</a></li></td></tr>
</table><br>	
<? 

}

elseif($_GET['subtopic'] == 'lost_full'){

echo '<tr><td class=newbar><center><b>:: Recuperação da Account ::</td></tr>
<tr><td class=newtext>';

	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		$nick = filtreString($_POST['nick'],0);
		$email = filtreString($_POST['email'],0);
		$nickQuery = mysql_query("SELECT * FROM players WHERE name = '$nick'");
		$button = '<a href="account.php?subtopic=lost_full"><img src="images/back.gif" border="0"></a>';
		$nickFetch = mysql_fetch_object($nickQuery);
		$getAccountOfPlayer = $nickFetch->account_id;
		$accountQuery = mysql_query("SELECT * FROM accounts WHERE id = '$getAccountOfPlayer'");
		$accountFetch = mysql_fetch_object($accountQuery);
		$getEmailOfAccount = $accountFetch->email;			
		
		$body = 
		'Dear player of Darghos,
The request for recovery of your account was made successfully!
				
Your account is: '.$accountFetch->id.'
					
To recovery you password visit:
ot.darghos.com/home/account.php?subtopic=lost_password
				
See you in World of Darghos!
UltraxSoft Team.';		

		if(mysql_num_rows($nickQuery) == 0)
		{	
		
			$condition = 'Erro';
			$conteudo = 'Personagem não existe';		
		}	
		elseif($email != $getEmailOfAccount)
		{
			$condition = 'Erro';
			$conteudo = 'Este email está incorreto';
		}
		elseif(!mailex($email, 'Account details!', $body))
		{
			$condition = 'Erro!';
			$conteudo = "<br><center>(fail 345) - This was a fatal error to send your email, if it is first time you read this screen please try again with another email. If it is not the first time, please contact the UltraxSoft Team.</center>";			
		}
		else
		{
			$condition = 'Sucesso!';
			$conteudo = 'Sua conta foi recuperada com sucesso!<br>Foi-lhe enviado um e-mail contendo os dados de sua conta!';
			$button = '<a href="account.php?subtopic=login"><img src="images/back.gif" border="0"></a>';	
		}			
		
		echo '<br><center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
		echo '<tr><td class=rank2>'.$condition.'</td></tr>';
		echo '</table>';
		echo '<center><table border="0" width="95%" bgcolor="black" CELLSPACING="1" CELLPADDING="2">';
		echo '<tr><td class=rank1>'.$conteudo.'</td></tr>';
		echo '</table>';
		echo '<br>'.$button.'';	
		include "footer.php";
		die();
	}

	echo '<br><center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">';
	echo 'Recupere o numero de sua conta e senha preenchendo o campo abaixo.<br>';
	echo 'Dica: Memorize sua conta para evitar esse tipo de problema no futuro.';
	echo '</table>';
	echo '<center>';
	echo '<form method="POST" action="account.php?subtopic=lost_full">';

	echo '<center><table border="0" width="95%" bgcolor="black" CELLSPACING="1" CELLPADDING="4">';
	echo '<tr class=rank1><td width="25%">E-mail:</td><td width="75%"><input name="email" type="text" value="" class="login" size="30"/></td></tr>';
	echo '<tr class=rank1><td width="25%">Personagem da conta:</td><td width="75%"><input name="nick" type="text" value="" class="login" size="30"/></td></tr>';
	echo '</table>';
	echo '<br />';
	echo '<input type="image" value="Entrar" src="images/submit.gif"/> <a href="account.php?subtopic=accountRecovery"><img src="images/back.gif" border="0"></a>';
	echo '</form>';
	echo '<br>';

}

elseif($_GET['subtopic'] == 'lost_account'){
$a = md5(filtreString($_POST['pass'],0));
$e = filtreString($_POST['email'],0);

echo '<tr><td class=newbar><center><b>:: Recuperação da Account ::</td></tr>
<tr><td class=newtext>';

	if($a != NULL && $e != NULL)
	{
		$pattern = "([A-Z_a-z_0-9])+@([a-zA-Z_0-9]).([A-Z_a-z_0-9])+";
		if(ereg($pattern,$e) == false)
		{
			$tipo = 2;
			$causa2 = '<font color=red>Você precisa colocar um e-mail válido.</font>';
			$erro = 1;
		}
			$query = mysql_query("SELECT * FROM `accounts` WHERE (`password` = '$a' AND `email` = '$e')");
			if(mysql_num_rows($query) == 1)
			{
				while($row = mysql_fetch_object($query))
				{
				
					$body = 
					'Dear player of Darghos,
The request for recovery of your password was made successfully!
				
Your account is: '.$row->id.'
					
To access your home account visit:
ot.darghos.com/account.php?subtopic=login
				
See you in World of Darghos!
UltraxSoft Team.';	
				
					if (!mailex($e, 'Account details!', $body))
					{
						echo '<br><center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
						echo '<tr><td class=rank2>Falha ao enviar email</td></tr>';
						echo '</table>';
						echo '<center><table border="0" width="95%" bgcolor="black" CELLSPACING="1" CELLPADDING="2">';
						echo '<tr><td class=rank1>Ouve um congestionamento no sistema de envio de emails que impossibilitou o envio do seu email. Tente novamente mais tarde.</td></tr>';
						echo '</table>';
						echo '<br><a href="account.php?subtopic=create"><img src="images/back.gif" border="0"></a>';	
						include "footer.php";
						die();			
					}				
					else
					{					
						echo '<br><center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
						echo '<tr><td class=rank2>E-mail enviado com exito!</td></tr>';
						echo '<tr><td class=rank1>Foi lhe enviado um email com os dados de sua conta para recuperação!
						<br>Este email tem um prazo de 24 horas para chegar, mas normalmente chega na hora.
						<br><br>
						Aviso: Alguns provedores de email como a Hotmail entre outros, estão redirecionando os nossos emails enviados para a lixeira (ou lixo eletronico).
						<br> Devido a isto, caso seu email não chega na sua caixa de entrada, verifique nas pastas de lixo eletronico.
						<br>
						<br>Atenciosamente,
						<br>Darghos Team.</td></tr>';
						echo '</table>';
						echo '<br><a href="account.php?subtopic=login"><img src="images/login.gif" border="0"></a>';
						include "footer.php";
						die;	
					}				
				}
			}
			else
			{
				echo '<br><center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
				echo '<tr><td class=rank2>Erro!</td></tr>';
				echo '</table>';
				echo '<center><table border="0" width="95%" bgcolor="black" CELLSPACING="1" CELLPADDING="2">';
				echo '<tr><td class=rank1>
				<br>Não foi possivel recuperar sua conta.</b>
				<br>Confime a sua senha e seu e-mail e tente novamente. ';
				echo '</table>';
				echo '<br><a href="account.php?subtopic=lost_account"><img src="images/back.gif" border="0"></a>';			
				include "footer.php";
				die;
			}
	}
?>
<br><center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">
Recupere o numero de sua conta preenchendo o campo abaixo.<br>
Dica: Memorize sua conta para evitar esse tipo de problema no futuro.
</table>
<center>
<form method="POST" action="account.php?subtopic=lost_account">

<center><table border="0" width="95%" bgcolor="black" CELLSPACING="1" CELLPADDING="4">
<tr class=rank1><td width="25%">E-mail:</td><td width="75%"><input name="email" type="text" value="" class="login" size="30"/></td></tr>
<tr class=rank1><td width="25%">Senha:</td><td width="75%"><input name="pass" type="password" value="" class="login"/></td></tr>
</table>
<br />
<input type="image" value="Entrar" src="images/submit.gif"/> <a href="account.php?subtopic=accountRecovery"><img src="images/back.gif" border="0"></a>
</form>
<br>
<?
}

elseif($_GET['subtopic'] == 'lost_password'){
$a = filtreString($_POST['acc'],0);
$e = filtreString($_POST['email'],0);

echo '<tr><td class=newbar><center><b>:: Recuperação da Account ::</td></tr>
<tr><td class=newtext>';

	if($a != NULL && $e != NULL){
		$pattern = "([A-Z_a-z_0-9])+@([a-zA-Z_0-9]).([A-Z_a-z_0-9])+";
		if(ereg($pattern,$e) == false)
		{
			$tipo = 2;
			$causa2 = '<font color=red>Você precisa colocar um e-mail válido.</font>';
			$erro = 1;
		}
		$query = mysql_query("SELECT * FROM `accounts` WHERE (`id` = '$a' AND `email` = '$e')");
		if(mysql_num_rows($query) == 1)
		{
			while($row = mysql_fetch_object($query))
			{
					$key = new_key($a);	
					$body = 
					'Dear player of Darghos,
The request for change your password was made successfully!
				
To change your password visit the link and insert a key:
ot.darghos.com/account.php?subtopic=check_losspassword

Your key is: '.$key.'
				
See you in World of Darghos!
UltraxSoft Team.';	
				
					if (!mailex($e, 'Account details!', $body))
					{
						echo '<br><center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
						echo '<tr><td class=rank2>Falha ao enviar email</td></tr>';
						echo '</table>';
						echo '<center><table border="0" width="95%" bgcolor="black" CELLSPACING="1" CELLPADDING="2">';
						echo '<tr><td class=rank1>Ouve um congestionamento no sistema de envio de emails que impossibilitou o envio do seu email. Tente novamente mais tarde.</td></tr>';
						echo '</table>';
						echo '<br><a href="account.php?subtopic=create"><img src="images/back.gif" border="0"></a>';	
						include "footer.php";
						die();				
					}				
					else
					{					
						echo '<br><center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
						echo '<tr><td class=rank2>E-mail enviado com exito!</td></tr>';
						echo '<tr><td class=rank1>Foi lhe enviado um email com os dados de sua conta para recuperação!
						<br>Este email tem um prazo de 24 horas para chegar, mas normalmente chega na hora.
						<br><br>
						Aviso: Alguns provedores de email como a Hotmail entre outros, estão redirecionando os nossos emails enviados para a lixeira (ou lixo eletronico).
						<br> Devido a isto, caso seu email não chega na sua caixa de entrada, verifique nas pastas de lixo eletronico.
						<br>
						<br>Atenciosamente,
						<br>Darghos Team.</td></tr>';
						echo '</table>';
						echo '<br><a href="account.php?subtopic=login"><img src="images/login.gif" border="0"></a>';
						include "footer.php";
						die;	
					}			
			}
		}
		else
		{
			echo '<br><center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
			echo '<tr><td class=rank2>Erro!</td></tr>';
			echo '</table>';
			echo '<center><table border="0" width="95%" bgcolor="black" CELLSPACING="1" CELLPADDING="2">';
			echo '<tr><td class=rank1>
			<br>Não foi possivel recuperar sua senha.</b>
			<br>Confime o numero de account e o e-mail e tente novamente. ';
			echo '</table>';
			echo '<br><a href="account.php?subtopic=lost_password"><img src="images/back.gif" border="0"></a>';		
			include "footer.php";
			die;	
		}
	}
?>

<br><center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">
Recupere sua senha preenchendo o campo abaixo.<br>
Dica: Memorize sua senha para evitar esse tipo de problema no futuro.
</table>
<center>
<form method="POST" action="account.php?subtopic=lost_password">

<center><table border="0" width="95%" bgcolor="black" CELLSPACING="1" CELLPADDING="4">
<tr class=rank1><td width="25%">E-mail:</td><td width="75%"><input name="email" type="text" value="" class="login" size="30"/></td></tr>
<tr class=rank1><td width="25%">Numero da conta:</td><td width="75%"><input name="acc" type="password" value="" class="login"/></td></tr>
</table>
<br />
<input type="image" value="Entrar" src="images/submit.gif"/> <a href="account.php?subtopic=accountRecovery"><img src="images/back.gif" border="0"></a>

</form>
<br>
<?
}

elseif($_GET['subtopic'] == 'check_losspassword'){

echo '<tr><td class=newbar><center><b>:: Chave de recuperação ::</td></tr>
<tr><td class=newtext><br>';

$a = filtreString($_POST['account'],0);
$k = filtreString($_POST['key'],0);
$email = Account::getEmail($a);

if ($_SERVER['REQUEST_METHOD'] == "POST")
{
	if(check_passKey($a,$k) == true)
	{
		$newPass = new_pass($a);
		$body = 
		'Dear player of Darghos,
Your new password was generated successfully!
				
Your new password is: '.$newPass.'

Ps: Change your password to one of your preference.
					
To acess you home account visit:
ot.darghos.com/account.php?subtopic=login
				
See you in World of Darghos!
UltraxSoft Team.';	
		
		if (!mailex($email, 'Account details!', $body))
		{
			echo '<br><center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
			echo '<tr><td class=rank2>Falha ao enviar email</td></tr>';
			echo '</table>';
			echo '<center><table border="0" width="95%" bgcolor="black" CELLSPACING="1" CELLPADDING="2">';
			echo '<tr><td class=rank1>Ouve um congestionamento no sistema de envio de emails que impossibilitou o envio do seu email. Tente novamente mais tarde.</td></tr>';
			echo '</table>';
			echo '<br><a href="account.php?subtopic=create"><img src="images/back.gif" border="0"></a>';	
			include "footer.php";
			die();			
		}				
		else
		{					
			echo '<center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
			echo '<tr><td class=rank2>E-mail enviado com exito!</td></tr>';
			echo '<tr><td class=rank1>Foi lhe enviado um email com os dados de sua conta para recuperação!
			<br>Este email tem um prazo de 24 horas para chegar, mas normalmente chega na hora.
			<br><br>
			Aviso: Alguns provedores de email como a Hotmail entre outros, estão redirecionando os nossos emails enviados para a lixeira (ou lixo eletronico).
			<br> Devido a isto, caso seu email não chega na sua caixa de entrada, verifique nas pastas de lixo eletronico.
			<br>
			<br>Atenciosamente,
			<br>Darghos Team.</td></tr>';
			echo '</table>';
			echo '<br><a href="account.php?subtopic=login"><img src="images/login.gif" border="0"></a>';
			include "footer.php";
			die;	
		}
	}
	else
	{
		echo '<br><center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
		echo '<tr><td class=rank2>Erro!</td></tr>';
		echo '</table>';
		echo '<center><table border="0" width="95%" bgcolor="black" CELLSPACING="1" CELLPADDING="2">';
		echo '<tr><td class=rank1>
		<br>Não foi possivel gerar sua nova senha.</b>
		<br>Numero de conta ou chave invalidas.';
		echo '</table>';
		echo '<br><a href="account.php?subtopic=check_losspassword"><img src="images/back.gif" border="0"></a>';		
		include "footer.php";
		die;		
	}
	
}
else
{
	echo '<center>';
	echo '<form method="POST" action="account.php?subtopic=check_losspassword">';
	echo '<center><table border="0" width="95%" bgcolor="black" CELLSPACING="1" CELLPADDING="4">';
	echo '<tr class=rank1><td width="25%">Conta:</td><td width="75%"><input name="account" type="password" value="" class="login"/></td></tr>';
	echo '<tr class=rank1><td width="25%">Chave de recuperação:</td><td width="75%"><input name="key" type="text" value="" class="login"/></td></tr>';
	echo '</table>';
	echo '<br />';
	echo '<input type="image" value="Entrar" src="images/submit.gif"/> <a href="account.php?subtopic=login"><img src="images/back.gif" border="0"></a>';
	echo '</form>';	
	echo '<br>';	
}


}

elseif($_GET['subtopic'] == 'recovery_key'){

echo '<tr><td class=newbar><center><b>:: Login ::</td></tr>
<tr><td class=newtext>';

?>
<br>

<center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">
Bem vindo ao sistema de recuperação de contas avançado.
Jogadores que obterem uma conta premium ganham uma chave de recuperação para sua conta, garantindo que ela seja SEMPRE sua. Escolha abaixo o metodo de recuperação desejado.<br>
</table><br>

<center><table width="65%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">
<tr><td class=rank2>Account Lost por Recovery Key</td></tr>
</table>	
<center><table border="0" width="65%" bgcolor="black" CELLSPACING="1" CELLPADDING="4">
<tr><td width="25%" class=rank1><a href="account.php?subtopic=rk_account"><li>Recuperar conta e senha usando minha recovery key</a></li></td></tr>
<tr><td width="25%" class=rank1><a href="account.php?subtopic=rk_email"><li>Quero mudar meu email usando minha recovery key</a></li></td></tr>
</table>
<br><a href="account.php?subtopic=accountRecovery"><img src="images/back.gif" border="0"></a>
<?
}

elseif ($_GET['subtopic'] == 'rk_account')
{
echo '<tr><td class=newbar><center><b>:: Login ::</td></tr>
<tr><td class=newtext>';
?>

<br><center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">
Recupere sua conta preenchendo o campo abaixo.<br>
Dica: Memorize sua conta para evitar esse tipo de problema no futuro.
</table>
<center>
<form method="POST" action="account.php?action=getaccount">

<center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">
<tr><td class=rank2>Recuperação da conta via Recovery Key</td></tr>
</table>	
<center><table border="0" width="95%" bgcolor="black" CELLSPACING="1" CELLPADDING="4">
<tr><td width="25%" class=rank1>Recovery Key:</td><td width="75%" class=rank1><input name="recoverykey" type="password" value="" class="login"/></td></tr>
</table>
<br />
<input type="image" value="Entrar" src="images/submit.gif"/> <a href="account.php?subtopic=recovery_key"><img src="images/back.gif" border="0"></a>

</form>
<br>

<?
}

elseif ($_GET['subtopic'] == 'rk_email')
{
echo '<tr><td class=newbar><center><b>:: Login ::</td></tr>
<tr><td class=newtext>';
?>

<br><center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">
Modifique seu e-mail instantaneamente ultilizando sua recovery key!<br>
Não compartilhe os dados da sua conta com ninguem e lembre-se, nenhum membro do Darghos nunca pedira seus dados.
</table>
<center>
<form method="POST" action="account.php?action=changeemail">

<center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">
<tr><td class=rank2>Mudar E-Mail com a Recovery Key</td></tr>
</table>	
<center><table border="0" width="95%" bgcolor="black" CELLSPACING="1" CELLPADDING="4">
<tr><td width="25%" class=rank1>Recovery Key:</td><td width="75%" class=rank1><input name="recoverykey" type="password" value="" class="login"/></td></tr>
<tr><td width="25%" class=rank1>Novo E-mail:</td><td width="75%" class=rank1><input name="newemail" type="text" value="" class="login" MAXLENGTH="35"/></td></tr>
</table>
<br />
<input type="image" value="Entrar" src="images/submit.gif"/> <a href="account.php?subtopic=recovery_key"><img src="images/back.gif" border="0"></a>

</form>
<br>

<?
}

	elseif ($_REQUEST['action'] == 'getaccount')
	{

	echo '<tr><td class=newbar><center><b>:: Login ::</td></tr>
<tr><td class=newtext>';
	
		$rk = md5($_POST['recoverykey']);
		$rk_query = mysql_query("SELECT * FROM `accounts` WHERE (`rk_number` = '$rk')");
		$rk_fetch = mysql_fetch_array($rk_query);
		if ($rk == "" or $rk == null)
		{
			echo '<br><center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
			echo '<tr><td class=rank2>Erro!</td></tr>';
			echo '</table>';
			echo '<center><table border="0" width="95%" bgcolor="black" CELLSPACING="1" CELLPADDING="2">';
			echo '<tr><td class=rank1>
			<br>Digite todos campos corretamente.</b>';
			echo '</table>';
			echo '<br><a href="accounts.php?subtopic=changeemail"><img src="images/back.gif" border="0"></a>';			
			include "footer.php";
			die;		
		}
		elseif (mysql_num_rows($rk_query) != 0) 
		{
			$account_rec = $rk_fetch['id'];
			$password_rec = new_pass($account_rec);
			echo '<br><center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
			echo '<tr><td class=rank2>Sua conta foi recuperada com sucesso!</td></tr>';
			echo '</table>';
			echo '<center><table border="0" width="95%" bgcolor="black" CELLSPACING="1" CELLPADDING="2">';
			echo '<tr><td class=rank1>
			<br>Sua conta é: <b>'.$account_rec.'</b>
			<br>Sua senha é: <b>'.$password_rec.'</b>';
			echo '</table>';
			echo '<br><a href="account.php?subtopic=login"><img src="images/back.gif" border="0"></a>';			
			include "footer.php";
			$password_rec = null;
			$account_rec = null;
			die;	
		}
		
		else
		{
			echo 'Recovery key não encontrada';
			include "footer.php";
			die;
		}
	}

	elseif ($_REQUEST['action'] == 'changeemail')
	{
	
	echo '<tr><td class=newbar><center><b>:: Login ::</td></tr>
<tr><td class=newtext>';
	
		$rk = md5(filtreString($_POST['recoverykey'],0));
		$newemail = filtreString($_POST['newemail'],0);
		$email_check = mysql_query("SELECT * FROM `accounts` WHERE (`email` = '$newemail')");
		$rk_query = mysql_query("SELECT * FROM `accounts` WHERE (`rk_number` = '$rk')");
		$rk_fetch = mysql_fetch_array($rk_query);
				
		if (mysql_num_rows($rk_query) != 0)
		{
			if (($newemail == '') or ($newemail == null) or $rk == null or $rk == "")
			{
					echo '<br><center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
					echo '<tr><td class=rank2>Erro!</td></tr>';
					echo '</table>';
					echo '<center><table border="0" width="95%" bgcolor="black" CELLSPACING="1" CELLPADDING="2">';
					echo '<tr><td class=rank1>
					<br>Digite todos campos corretamente.</b>';
					echo '</table>';
					echo '<br><a href="accounts.php?subtopic=changeemail"><img src="images/back.gif" border="0"></a>';			
					include "footer.php";
					die;
			}		

			elseif (mysql_num_rows($email_check) != 0)	
			{
					echo '<br><center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
					echo '<tr><td class=rank2>Erro!</td></tr>';
					echo '</table>';
					echo '<center><table border="0" width="95%" bgcolor="black" CELLSPACING="1" CELLPADDING="2">';
					echo '<tr><td class=rank1>
					<br>Este e-mail já esta em uso em nosso banco de dados.</b>';
					echo '</table>';
					echo '<br><a href="accounts.php?subtopic=changeemail"><img src="images/back.gif" border="0"></a>';			
					include "footer.php";
					die;
			}
								
			else
			{
				$update_email = "UPDATE accounts SET email = '".$newemail."' WHERE rk_number = '".$rk ."'";
				mysql_query($update_email) or die(mysql_error());			
				echo '<br><center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
				echo '<tr><td class=rank2>E-mail modificado com sucesso!</td></tr>';
				echo '</table>';
				echo '<center><table border="0" width="95%" bgcolor="black" CELLSPACING="1" CELLPADDING="2">';
				echo '<tr><td class=rank1>
				<br>Seu e-mail foi modificado com sucesso!</b>';
				echo '</table>';
				echo '<br><a href="account.php?subtopic=login"><img src="images/back.gif" border="0"></a>';			
				include "footer.php";
				die;				
			}
		}
		
		else
		{
			echo '<br><center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
			echo '<tr><td class=rank2>Erro!</td></tr>';
			echo '</table>';
			echo '<center><table border="0" width="95%" bgcolor="black" CELLSPACING="1" CELLPADDING="2">';
			echo '<tr><td class=rank1>
			<br>Esta recovery key não existe.</b>';
			echo '</table>';
			echo '<br><a href="accountloss_rk.php?subtopic=changeemail"><img src="images/back.gif" border="0"></a>';			
			include "footer.php";
			die;
		}
	}
include "footer.php"; ?>