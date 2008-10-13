<?
session_start();
include "top.php";

$account = $_SESSION['account'];
$password = $_SESSION['password'];

if (Account::isLogged($account,$password))
{	

##### MUDANÇA DE SENHA #####
if($_GET['subtopic'] == 'changepass')
{

	$account = $_SESSION['account'];
	$password = $_SESSION['password'];
	$npass = md5($_POST['npass']);
	$cpass = (string) md5($_POST['cpass']);
	$opass = md5($_POST['opass']);

	$query2 = mysql_query("SELECT * FROM `accounts` WHERE (`id` = '".$account."') ") or die(mysql_error());
	while($sql = mysql_fetch_array($query2))
	{
		if ($_SERVER['REQUEST_METHOD'] == "POST")
		{
			echo '<tr><td class=newbar><center><b>:: Mudança de Senha ::</td></tr>
			<tr><td class=newtext>';

			if($npass == '' or $cpass == '' or $opass == '')
			{
				echo '<br><center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
				echo '<tr><td class=rank2>Erro!</td></tr>';
				echo '</table>';
				echo '<center><table border="0" width="95%" bgcolor="black" CELLSPACING="1" CELLPADDING="2">';
				echo '<tr><td class=rank1>
				<br>Não foi possivel modificar sua senha.</b>
				<br>Voce deve preencher todos os campos.';
				echo '</table>';
				echo '<br><a href="main.php?subtopic=changepass"><img src="images/back.gif" border="0"></a>';
				include "footer.php";
				die;
			}

			elseif(filtreString($npass,1) == 0)		
			{
				echo '<br><center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
				echo '<tr><td class=rank2>Erro!</td></tr>';
				echo '</table>';
				echo '<center><table border="0" width="95%" bgcolor="black" CELLSPACING="1" CELLPADDING="2">';
				echo '<tr><td class=rank1>
				<br>Não foi possivel modificar sua senha.</b>
				<br>Esta a ultilizar sintaxes reservadas.';
				echo '</table>';
				echo '<br><a href="main.php?subtopic=changepass"><img src="images/back.gif" border="0"></a>';
				include "footer.php";
				die;
			}					
			
			elseif($password != $opass or $npass != $cpass)
			{
				echo '<br><center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
				echo '<tr><td class=rank2>Erro!</td></tr>';
				echo '</table>';
				echo '<center><table border="0" width="95%" bgcolor="black" CELLSPACING="1" CELLPADDING="2">';
				echo '<tr><td class=rank1>
				<br>Não foi possivel modificar sua senha.</b>
				<br>Esta não é sua antiga senha ou a confirmação não esta correta.';
				echo '</table>';
				echo '<br><a href="main.php?subtopic=changepass"><img src="images/back.gif" border="0"></a>';
				include "footer.php";
				die;
			}

			elseif($npass == $opass)
			{
				echo '<br><center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
				echo '<tr><td class=rank2>Erro!</td></tr>';
				echo '</table>';
				echo '<center><table border="0" width="95%" bgcolor="black" CELLSPACING="1" CELLPADDING="2">';
				echo '<tr><td class=rank1>
				<br>Não foi possivel modificar sua senha.</b>
				<br>Esta é sua senha atual, por favor use uma senha diferente da atual.';
				echo '</table>';
				echo '<br><a href="main.php?subtopic=changepass"><img src="images/back.gif" border="0"></a>';
				include "footer.php";
				die;
			}

			else
			{
				$Sql = "UPDATE accounts SET password = '$cpass' WHERE id = '".$_SESSION['account']."' AND password = '".$_SESSION['password']."'";
				if (!$Result = mysql_query($Sql)) {
					echo "Erro atualizando.<br/>\n";
					echo "O erro foi: <b>" . mysql_error() . "</b><br/>\n";
					echo "Erro no banco de dados: <b>" . $Sql . "</b><br/>\n";
					die();
				}
				else
				{
					$_SESSION['password'] = $newpassMd5;
					echo '<br><center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
					echo '<tr><td class=rank2>Senha modificada com exito!</td></tr>';
					echo '</table>';
					echo '<center><table border="0" width="95%" bgcolor="black" CELLSPACING="1" CELLPADDING="2">';
					echo '<tr><td class=rank1>
					<br>É aconselhavel que voce refassa o seu login para atualizar todos nossos sistema em segurança.';
					echo '</table>';
					echo '<br><a href="account.php?subtopic=main"><img src="images/back.gif" border="0"></a>';
					include "footer.php";
					die;
				}
			}
		}
	}

?>
<tr><td class=newbar><center><b>:: Mudança de Senha ::</td></tr>
<tr><td class=newtext>
<br><center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">
Modifique sua senha preenchendo o campo abaixo.<br>
Para sua segurança entre com sua nova senha e sua antiga senha.
</table>
<center>
<form method="POST" action="main.php?subtopic=changepass">

<center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">
<tr><td class=rank2>Troca de Senha</td></tr>
</table>
<center><table border="0" width="95%" bgcolor="black" CELLSPACING="1" CELLPADDING="4">
<tr><td width="30%" class=rank1>Nova senha:</td><td width="75%" class=rank1><input name="npass" type="password" value="" class="textfield"/></td></tr>
<tr><td width="30%" class=rank1>Confirmar nova senha:</td><td width="75%" class=rank1><input name="cpass" type="password" value="" class="textfield"/></td></tr>
<tr><td width="30%" class=rank1>Antiga senha:</td><td width="75%" class=rank1><input name="opass" type="password" value="" class="textfield"/></td></tr>
</table>
<br />
<input type="image" value="submit" src="images/submit.gif"/> <a href="account.php?subtopic=main"><img src="images/back.gif" border="0"></a>

</form>
<br>

<?
}

##### MUDANÇA DE INFORMAÇÕES #####
elseif($_GET['subtopic'] == 'changeinfo')
{
	echo '<tr><td class=newbar><center><b>:: Informações Personalizadas ::</td></tr>
	<tr><td class=newtext>';

	$account = $_SESSION['account'];
	$password = $_SESSION['password'];
	$dname = $_POST['dname'];
	$dlocation = $_POST['dlocation'];
	$durl = $_POST['durl'];

	if ($_SERVER['REQUEST_METHOD'] == "POST")
	{
		if(filtreString($dname,1) == 0 or filtreString($dlocation,1) == 0 or filtreString($durl,1) == 0)		
		{
			echo '<br><center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
			echo '<tr><td class=rank2>Erro!</td></tr>';
			echo '<tr><td class=rank1>
			<br>Uma ou mais de suas informações contem sintaxes reservadas.';
			echo '</table>';
			echo '<br><a href="main.php?subtopic=changeinfo"><img src="images/back.gif" border="0"></a>';
			include "footer.php";
			die;
		}
		else
		{
			mysql_query("UPDATE accounts SET rlname = '$dname', location = '$dlocation', url = '$durl' WHERE id = '$account'");
			echo '<br><center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
			echo '<tr><td class=rank2>Informações personalizadas modificadas</td></tr>';
			echo '<tr><td class=rank1>Suas informações personalizadas foram modificadas com sucesso!';
			echo '</table>';
			echo '<br><a href="account.php?subtopic=main"><img src="images/back.gif" border="0"></a>';
			include "footer.php";
			die;			
		}	
	}

?>
<br><center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">
Aqui você podera editar as informações personalizadas de sua conta. Os dados inserido aqui serão publicos portanto serão visualizados por outros jogadores. Para remover qualquer uma das personalizações apenas deixe o campo em branco.<br>
</table>
<form method="post" action="main.php?subtopic=changeinfo">
<center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">
<tr><td class=rank2 colspan=2>Editar Informações Personalizadas</td></tr>
<?
	$getinfo = mysql_query("SELECT * FROM `accounts` WHERE (`id` = '".$account."') ") or die(mysql_error());
	$getinfo_sql = mysql_fetch_array($getinfo);

 echo '<tr><td width="25%" class=rank1>Nome real:</td><td width="75%" class=rank1><input name="dname" type="text" value="'.$getinfo_sql['rlname'].'" class="textfield" size ="45" MAXLENGTH=40/></td></tr>';
 echo '<tr><td width="25%" class=rank1>Localização:</td><td width="75%" class=rank1><input name="dlocation" type="text" value="'.$getinfo_sql['location'].'" class="textfield" size ="45" MAXLENGTH=20/></td></tr>';
 echo '<tr><td width="25%" class=rank1>Website:</td><td width="75%" class=rank1><input name="durl" type="text" value="'.$getinfo_sql['url'].'" class="textfield" size ="45" MAXLENGTH=50/></td></tr>';
?>
 </table>
<br>
<input type="image" value="submit" src="images/submit.gif"/> <a href="account.php?subtopic=main"><img src="images/back.gif" border="0"></a>
</form>
<?
}

##### MUDANÇA DE E-MAIL #####
elseif($_GET['subtopic'] == 'changeemail')
{
	echo '<tr><td class=newbar><center><b>:: Mudar e-mail ::</td></tr>
	<tr><td class=newtext><br>';
	
	//exibe pagiina de ação de troca de email
	if ($_SERVER['REQUEST_METHOD'] == "POST")
	{
		if($_SESSION['password'] != md5($_POST['password']))
		{
			$stat = 'Erro!';
			$msg = "Senha incorreta.";		
		}
	
		//filtra a string email
		elseif(filtreString($_POST['email'],1) == 0)
		{
			$stat = 'Erro!';
			$msg = "Não ultilize sintaxes reservadas.";
		}
	
		//verifica se o email ja esta em uso e se ja existe uma mudança de email em andamento na conta
		elseif(!check_email($_POST['email'], 1, $_SESSION['account']))
		{
			$stat = 'Erro!';
			$msg = "Este email ja foi registrado no Darghos ou ja existe uma mudança de email pendente nesta conta.";
		}
		//verifica se o novo email e valido
		elseif(!change_email($_SESSION['account'], $_POST['email']))
		{
			$stat = 'Erro!';
			$msg = "E-mail invalido ou este e-mail não existe.";
		}
		else
		{
			$body = 
			'Caro jogador do Darghos,
Foi solicitado uma mudança do endereço de e-mail de sua conta para:
 '.$_POST['email'].'
Está mudança apenas será concluida em 15 dias.

Se você não solicitou esta mudança acesse imediatamente sua conta pelo link abaixo e clique no botão para cancelar a mudança!
http://Darghos.servegame.com:8090/account.php?subtopic=login 
				
Nos vemos no Darghos!
Darghos Team.'; //variavel responsavel pelo conteudo do email		
			//verifica se o driver de email esta correto, caso verdadeiro envia o email			
			$oldemail = get_email($_SESSION['account']);
			/*if (!mailex($oldemail, 'Solicitação de mudança de e-mail para sua conta no Darghos!', $body))
			{		
				$stat = 'Erro!';
				$msg = "Problema ao enviar e-mail.";		
			}
			//email enviado com sucesso	
			else
			{*/
				$stat = 'E-mail modificado com sucesso!';
				$msg = 'O endereço de e-mail de sua conta foi modificado para '.$_POST['email'].' com sucesso! Você pode cancelar esta ação a qualquer momento em que desejar.<br><b>Note que para sua segurança esta mudança so se concluira em 15 dias.';				
			//}										
		}

		echo '<center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
		echo '<tr><td class=rank2>'.$stat.'</td></tr>';
		echo '<tr><td class=rank1>'.$msg.'';
		echo '</table>';
		echo '<br><a href="account.php?subtopic=main"><img src="images/back.gif" border="0"></a>';		
	}
	//exibe pagina de mudança de email
	else
	{
		echo '<center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">';
		echo 'Mude o e-mail registrado em sua conta aqui!<br>
		<font color=red><b>Atenção:</b></font> A mudança de email apenas se concretiza apos 15 dias, para efeturar mudanças de email instantanea ultilize a recovery key (beneficio premium account).';
		echo '</table>';
		echo '<center>';
		echo '<form method="POST" action="main.php?subtopic=changeemail">';
		echo '<center><table border="0" width="95%" bgcolor="black" CELLSPACING="1" CELLPADDING="4">';
		echo '<tr class=rank1><td width="25%">Novo e-mail:</td><td width="75%"><input name="email" type="text" value="" class="login" size="30"/></td></tr>';
		echo '<tr class=rank1><td width="25%">Senha:</td><td width="75%"><input name="password" type="password" value="" class="login" size="30"/></td></tr>';
		echo '</table>';
		echo '<br />';
		echo '<input type="image" value="Entrar" src="images/submit.gif"/> <a href="account.php?subtopic=main"><img src="images/back.gif" border="0"></a>';
		echo '</form>';	
		echo '<br>';		
	}
}

##### CANCELAMENTO DE MUDANÇA DE E-MAIL #####
elseif($_GET['subtopic'] == 'cancel_email')
{
	$account = $_SESSION['account'];
	$password = $_SESSION['password'];
	
	$new_email = account_info($_SESSION['account'], 'new_email');
	$emaildate = (date('d/m/Y',account_info($_SESSION['account'], 'email_date')));

	echo '<tr><td class=newbar><center><b>:: Cancelamento de mudança de e-mail ::</td></tr>
	<tr><td class=newtext><br>';

	//exibe pagiina de ação de cancelamento de troca de email
	if ($_GET['action'] == "confirm")
	{
		cancelEmail($_SESSION['account']);
		echo '<center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
		echo '<tr><td class=rank2>Mudança do endereço de e-mail</td></tr>';
		echo '<tr><td class=rank1>Mudança de e-mail cancelada com sucesso!<br>Agora seu e-mail não sera mais modificado!';
		echo '</table>';
		echo '<br><a href="account.php?subtopic=main"><img src="images/back.gif" border="0"></a>';		
	}
	//exibe pagina de cancelamento de troca de email
	else
	{
		echo '<br><center><table width="95%" BGcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">
		<tr><td class=rank2>Mudança do endereço de e-mail</td></tr>
		<tr class=rank1><td>Foi solicitada uma mudança de e-mail em sua conta para: <b>'.$new_email.'</b>.<br><br>
	Para a sua segurança a mudança so estará concluida na data de: '.$emaildate.'<br>
	Caso você nao tenha acesso a este e-mail ou não solicitou esta mudança cancele isto imediatamente clicando no botão "cancelar" abaixo!</td></tr>';	
		echo '</table><br>';		
		echo '<a href="main.php?subtopic=cancel_email&action=confirm"><img src="images/cancel.gif" border="0"></a> <a href="account.php?subtopic=main"><img src="images/back.gif" border="0"></a>';
	}
}

##### NOVO CHAR (FORMULARIO) #####
elseif($_GET['subtopic'] == 'newchar')
{
	$account = $_SESSION['account'];
	$password = $_SESSION['password'];

	if ($_SERVER['REQUEST_METHOD'] == "POST")
	{
		if(Account::isGM($account) or Account::isAdmin($account) or Account::isCM($account))
		{
			if(Account::getType($account) == 4)
				$prefixo = '<option value="GM">GM</option>';
			elseif(Account::getType($account) == 5)
				$prefixo = '<option value="CM">CM</option>';				
			elseif(Account::getType($account) == 6)
				$prefixo = '<option value="GM">GM</option><option value="CM">CM</option><option value="GOD">GOD</option>';	
				
			if(Account::getType($account) == 6)
				$hidden = '<option value="1">Nao</option><option value="0">Sim</option>';
			else
				$hidden = '<option value="1">Nao</option>';
						
				
			echo '<tr><td class=newbar><center><b>:: Novo GameMaster ::</td></tr>';
			echo '<tr><td class=newtext>';
			echo '<br><form method="post" action="main.php?subtopic=makenewchar">';
			echo '<center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
			echo '<tr><td class=rank2 colspan=2>Criando personagem</td></tr>';
			echo '<tr><td width="25%" class=rank1>Nome:</td><td width="75%" class=rank1><select name="prefixo">'.$prefixo.'</select><input type=text name=name size ="30" MAXLENGTH="29"></td></tr>';
			echo '<tr><td width="25%" class=rank1>Sex:</td><td width="75%" class=rank1><select name="sex"><option value="male">Male</option><option value="female">Female</option></select></td></tr>';
			echo '<tr><td width="25%" class=rank1>Vocation:</td><td width="75%" class=rank1><select name="voc"><option value="sorcerer">Sorcerer</option><option value="druid">Druid</option><option value="paladin">Paladin</option><option value="knight">Knight</option></select></td></tr>';
			echo '<tr><td width="25%" class=rank1>Cidade:</td><td width="75%" class=rank1><select name="res"><option value="quendor">Quendor</option><option value="thorn">Thorn</option><option value="aracura">Aracura</option></select></td></tr>';
			echo '<tr><td width="25%" class=rank1>Esconder prefixo:</td><td width="75%" class=rank1><select name="hidden">'.$hidden.'</select></td></tr>';
			echo '<tr><td width="25%" class=rank1 colspan="2">
			<center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">
			<tr class=rank1><td width="50%"><b>Game World</b></td><td width="20%"><b>Online Since</b></td><td width="30%"><b>Additional Information</b></td></tr>
			<tr class=rank1><td><input type="radio" name="serverId" value="1" style="border: 0;" /> Tenerian</td><td>jan/2008</td><td><center><font color="green"><i>new server</i></font></td></tr>
			</table>
			</td></tr>';			
			echo '</table>';
			echo '<br>';
			echo '<input type="image" value="submit" src="images/submit.gif"/> <a href="account.php?subtopic=main"><img src="images/back.gif" border="0"></a>';
			echo '</form>';	
		}
		else
		{
			if($_POST['mode'] == 2)
			{
				if(Account::isPremium($account))
					$premium_city = '<option value="aracura">Aracura</option><option value="salazart">Salazart</option><option value="northrend">Northrend</option>';

				echo '<tr><td class=newbar><center><b>:: Criar novo personagem ::</td></tr>';
				echo '<tr><td class=newtext>';
				echo '<br><center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">';
				echo 'Por favor entre com o nome e o sexo de seu personagem. Não ultilizem nomes ilegais para seus personagens, para saber qual o tipo de nomes ilegais veja as Regras clicando <a href="suport/rules.php"><font color="blue">aqui</font></a>.<br>';
				echo '</table>';
				echo '<form method="post" action="main.php?subtopic=makenewchar">';
				echo '<center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
				echo '<tr><td class=rank2 colspan=2>Character information</td></tr>';
				echo '<tr><td width="25%" class=rank1>Name:</td><td width="75%" class=rank1><input type=text name=name size ="30" MAXLENGTH="29"></td></tr>';
				echo '<tr><td width="25%" class=rank1>Sex:</td><td width="75%" class=rank1><select name="sex"><option value="male">Male</option><option value="female">Female</option></select></td></tr>';
				echo '<tr><td width="25%" class=rank1>Vocation:</td><td width="75%" class=rank1><select name="voc"><option value="sorcerer">Sorcerer</option><option value="druid">Druid</option><option value="paladin">Paladin</option><option value="knight">Knight</option></select></td></tr>';
				echo '<tr><td width="25%" class=rank1>City:</td><td width="75%" class=rank1><select name="res"><option value="quendor">Quendor</option><option value="thorn">Thorn</option>'.$premium_city.'</select></td></tr>';
				echo '<tr><td width="25%" class=rank1 colspan="2">
				<center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">
				<tr class=rank1><td width="50%"><b>Game World</b></td><td width="20%"><b>Online Since</b></td><td width="30%"><b>Difficulty</b></td></tr>
				<tr class=rank1><td><input type="radio" name="serverId" value="tenerian" style="border: 0;" /> Tenerian</td><td>mar/2008</td><td><center>x10 (medium)  <br><font color=green><b>new server</td></tr>
				</table>
				</td></tr>';				
				echo '</table>';
				echo '<br>';
				echo '<input type="image" value="submit" src="images/submit.gif"/> <a href="main.php?subtopic=newchar"><img src="images/back.gif" border="0"></a>';
				echo '</form>';
			}
			elseif($_POST['mode'] == 1)	
			{
				echo '<tr><td class=newbar><center><b>:: Criar novo personagem ::</td></tr>';
				echo '<tr><td class=newtext>';
				echo '<br><center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">';
				echo 'Por favor entre com o nome e o sexo de seu personagem. Não ultilizem nomes ilegais para seus personagens, para saber qual o tipo de nomes ilegais veja as Regras clicando <a href="suport/rules.php"><font color="blue">aqui</font></a>.<br>';
				echo '</table>';
				echo '<form method="post" action="main.php?subtopic=makenewchar">';
				echo '<center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
				echo '<tr><td class=rank2 colspan=2>Character information</td></tr>';
				echo '<tr><td width="25%" class=rank1>Name:</td><td width="75%" class=rank1><input type=text name=name size ="30" MAXLENGTH="29"></td></tr>';
				echo '<tr><td width="25%" class=rank1>Sex:</td><td width="75%" class=rank1><select name="sex"><option value="male">Male</option><option value="female">Female</option></select></td></tr>';
				echo '<tr><td width="25%" class=rank1 colspan="2">
				<center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">
				<tr class=rank1><td width="50%"><b>Game World</b></td><td width="20%"><b>Online Since</b></td><td width="30%"><b>Difficuty</b></td></tr>
				<tr class=rank1><td><input type="radio" name="serverId" value="tenerian" style="border: 0;" /> Tenerian</td><td>jan/2008</td><td><center><center>x10 (medium)  <br><font color=green><b>new server</td></tr>
				</table>
				</td></tr>';
				echo '</table>';
				echo '<br>';
				echo '<input type="image" value="submit" src="images/submit.gif"/> <a href="main.php?subtopic=newchar"><img src="images/back.gif" border="0"></a>';
				echo '</form>';			
			}
		}
	}
	else
	{
		echo '<tr><td class=newbar><center><b>:: Criar novo personagem ::</td></tr>';
		echo '<tr><td class=newtext>';
		echo '<br><center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">';
		echo 'Selecione a seguir o modo de inicio de sua jornada, selecionando rookguard (recomendavel) você irá começar em uma ilha isolada, que terá como objetivo lhe ensinar melhor como jogar o Darghos. Selecionando Main, você irá "pular" rookguard, iniciando o jogo sem as instruções basicas e um monte de series de coisas que seria importante para sua jornada (ideial para jogadores que não sejam iniciantes).<br><br><font color=red><b>Note que é altamente recomendavel que você inicie sua jornada em rookguard, pois assim você ira passar a main já com alguma experiencia que será algo muito util no restante de sua jornada.<b></font><br>';
		echo '</table>';
		echo '<form method="post" action="main.php?subtopic=newchar">';
		echo '<center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
		echo '<tr><td class=rank2 colspan=2>Modo de inicio</td></tr>';
		echo '<tr><td width="25%" class=rank1>Modo de inicio:</td><td width="75%" class=rank1><select name="mode"><option value="1">Rookguard mode</option><option value="2" selected>Main mode</option></select></td></tr>';
		echo '</table>';
		echo '<br>';
		echo '<input type="image" value="submit" src="images/submit.gif"/> <a href="account.php?subtopic=main"><img src="images/back.gif" border="0"></a>';
		echo '</form>';	
	}	
}

##### NOVO CHAR (AÇÃO) #####
elseif($_GET['subtopic'] == 'makenewchar')
{
	$namein = $_POST['name'];
	$prefixo = $_POST['prefixo'];
	$hidden = $_POST['hidden'];
	$server = 1;
	$group_id = 1;
	
	if(Account::getType($account) == 4)
		$prefixo = 'GM';
	elseif(Account::getType($account) == 5)
		$prefixo = 'CM';				
	elseif(Account::getType($account) == 6)
		$prefixo = $_POST['prefixo'];		
	
	if(!isset($_POST['pvp']))
		$pvpmode = 0;
	else
		$pvpmode = $_POST['pvp'];		
	
	switch($_POST['sex'])
	{	
		case "male";
			$sexin = 1;
		break;
		
		case "female";
			$sexin = 0;
		break;	

		default;
			$sexin = 1;
		break;				
	}	
	
	$gmType = false;	
	$rookguard = false;
	
	if(isset($_POST['voc']) and isset($_POST['res']))
	{
		switch($_POST['voc'])
		{	
			case "sorcerer";
				$voc = 1;
			break;
			
			case "druid";
				$voc = 2;
			break;
			
			case "paladin";
				$voc = 3;
			break;	

			case "knight";
				$voc = 4;
			break;	

			default;
				$voc = 1;
			break;	
		}
		
		if(Account::isPremium($account))
		{
			switch($_POST['res'])
			{	
				case "quendor";
					$res = 1;
				break;
				
				case "aracura";
					$res = 2;
				break;
				
				case "thorn";
					$res = 4;
				break;	

				case "salazart";
					$res = 5;
				break;		

				case "norhrend";
					$res = 7;
				break;	

				default;
					$res = 1;
				break;				
			}	
		}
		else	
		{
			switch($_POST['res'])
			{	
				case "quendor";
					$res = 1;
				break;
				
				case "thorn";
					$res = 4;
				break;	

				default;
					$res = 1;
				break;				
			}
		}	
	}
	else
	{
		$res = 3;
		$voc = 0;	
		$rookguard = true;
	}
	
	$lookbody = 116;
	$lookfeet = 116;
	$lookhead = 116;
	$looklegs = 116;
	
	if($sexin == 0)
		$looktype = 136;	
	elseif($sexin == 1)
		$looktype = 128;

	if(Account::isGM($account) or Account::isCM($account) or Account::isAdmin($account))
	{
		if($hidden == 1)
			$namein = ''.$prefixo.' '.$namein.'';

		$lookbody = 91;
		$lookfeet = 91;
		$lookhead = 91;
		$looklegs = 91;	
		$gmType = true;	
	}
	
	if($gmType == true)
	{
		if($prefixo == 'GM')
		{
			$group_id = 4;
			$looktype = 75;
		}	
				
		if($prefixo == 'CM')
		{
			$group_id = 5;		
			$looktype = 266;
		}	
		if($prefixo == 'GOD')
		{
			$group_id = 6;		
			$looktype = 266;
		}			
	}

	$check = mysql_query("SELECT * FROM players WHERE name = '".addslashes($namein)."' LIMIT 1") or die(mysql_error());
	$playerOfAccount = mysql_query("SELECT * FROM players WHERE account_id = '$account'") or die(mysql_error());
	$GMOfAccount = mysql_query("SELECT * FROM players WHERE account_id = '$account' and group_id > '1'") or die(mysql_error());

	$temp = strspn("$namein", "qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM -");
		echo '<tr><td class=newbar><center><b>:: Make a new Character ::</td></tr>
	<tr><td class=newtext>';

	$button = '<br><a href="main.php?subtopic=newchar"><img src="images/back.gif" border="0"></a>';
	if (!preg_match("/^[a-zA-Z][a-zA-Z ]*$/", $namein))  
	{
		$condition = 'Não foi possivel criar seu personagem.';
		$error = 'Este nome contem carateres ilegais.';
	}
	elseif (filtreString($namein,1) == 0)
	{
		$condition = 'Não foi possivel criar seu personagem.';
		$error = 'Este nick contem sintaxes especiais.';	
	}
	elseif ($temp != strlen($namein))
	{
		$condition = 'Incorrect name';
		$error = 'Your character\'s name is not valid. Keep in mind that only letters and blankspaces are permitted. Please choose another one';			
	}
	elseif (strlen($namein) < 3 || strlen($namein) > 29)
	{
		$condition = 'Wrong length';
		$error = 'Your character\'s name is not valid. You must use a name with at least 2 letters and at most 20 letters. Please choose another one.';		
	}	
	elseif ($server == '')
	{
		$condition = 'Game Server';
		$error = 'Please select a Game Server.';	
	}	
	elseif (Account::isPlayer($account) and reservedNames($namein) == 0)
	{
		$condition = 'Não foi possivel criar seu personagem.';
		$error = 'Este nick contem sintaxes reservadas.';		
	}
	elseif(mysql_num_rows($check) == 1) 
	{ 
		$condition = 'Não foi possivel criar seu personagem.';
		$error = 'Este nick já esta em uso no jogo.';	
	}
	elseif(!Account::isAdmin($account) and mysql_num_rows($playerOfAccount) > 10 or Account::isGM($account) and mysql_num_rows($GMOfAccount) > 1 or Account::isCM($account) and mysql_num_rows($GMOfAccount) > 1) 
	{ 
		$condition = 'Não foi possivel criar seu personagem.';
		$error = 'Sua conta já esta com o numero maximo possivel de personagens criados.';	
	}	
	else
	{
		if($rookguard == true)
		{
			$level = 1;
			$experience = 0;
			$magic = 0;
			$health = 150;
			$mana = 0;
			$cap = 400;		
		}
		elseif($gmType == true)
		{
			$level = 20;
			$experience = 0;
			$magic = 0;
			$health = 1;
			$mana = 1;
			$cap = 1;		
		}
		else
		{
			$level = 8;
			$experience = 4200;
			$magic = 0;
			$health = 185;
			$mana = 35;
			$cap = 470;
		}
		
		mysql_query("INSERT INTO players (name, account_id, group_id, sex, vocation, experience, level, maglevel, health, healthmax, mana, manamax, lookbody, lookfeet, lookhead, looklegs, looktype, cap, town_id, server, pvpmode, created) values ('$namein','$account','$group_id','$sexin','$voc','$experience','$level','$magic','$health','$health','$mana','$mana','$lookbody','$lookfeet','$lookhead','$looklegs','$looktype','$cap','$res','$server','$pvpmode', '".time()."')") or die(mysql_error());

		$get_id = mysql_query("SELECT * FROM players WHERE (name = '$namein')") or die(mysql_error());
		$fetch_get_id = mysql_fetch_object($get_id);
		$playerid = $fetch_get_id->id;
		
		mysql_query("INSERT INTO player_skills(player_id, skillid, value, count) values('$playerid','0','10','0')") or die(mysql_error());
		mysql_query("INSERT INTO player_skills(player_id, skillid, value, count) values('$playerid','1','10','0')") or die(mysql_error());
		mysql_query("INSERT INTO player_skills(player_id, skillid, value, count) values('$playerid','2','10','0')") or die(mysql_error());
		mysql_query("INSERT INTO player_skills(player_id, skillid, value, count) values('$playerid','3','10','0')") or die(mysql_error());
		mysql_query("INSERT INTO player_skills(player_id, skillid, value, count) values('$playerid','4','10','0')") or die(mysql_error());
		mysql_query("INSERT INTO player_skills(player_id, skillid, value, count) values('$playerid','5','10','0')") or die(mysql_error());
		mysql_query("INSERT INTO player_skills(player_id, skillid, value, count) values('$playerid','6','10','0')") or die(mysql_error());
		
		if($gmType == true) // GM Char
		{
			mysql_query("INSERT INTO player_items(player_id, sid, pid, itemtype, count, attributes) values('$playerid','101','3','1988','1','')") or die(mysql_error());
			//backpack inside
			mysql_query("INSERT INTO player_items(player_id, sid, pid, itemtype, count, attributes) values('$playerid','102','101','2554','1','')") or die(mysql_error());
			mysql_query("INSERT INTO player_items(player_id, sid, pid, itemtype, count, attributes) values('$playerid','103','101','2120','1','')") or die(mysql_error());
			//end backpack			
		}			
		elseif($voc == 0)  // No-Voc
		{
			mysql_query("INSERT INTO player_items(player_id, sid, pid, itemtype, count, attributes) values('$playerid','101','3','1987','1','')") or die(mysql_error());
			mysql_query("INSERT INTO player_items(player_id, sid, pid, itemtype, count, attributes) values('$playerid','102','4','2467','1','')") or die(mysql_error());
			mysql_query("INSERT INTO player_items(player_id, sid, pid, itemtype, count, attributes) values('$playerid','103','6','2382','1','')") or die(mysql_error());
			//backpack inside
			mysql_query("INSERT INTO player_items(player_id, sid, pid, itemtype, count, attributes) values('$playerid','104','101','2666','2','')") or die(mysql_error());
			//end backpack			
		}			
		elseif($voc == 1)  // Sorcerer
		{
			mysql_query("INSERT INTO player_items(player_id, sid, pid, itemtype, count, attributes) values('$playerid','101','1','2480','1','')") or die(mysql_error());
			mysql_query("INSERT INTO player_items(player_id, sid, pid, itemtype, count, attributes) values('$playerid','102','3','1988','1','')") or die(mysql_error());
			mysql_query("INSERT INTO player_items(player_id, sid, pid, itemtype, count, attributes) values('$playerid','103','4','2464','1','')") or die(mysql_error());
			mysql_query("INSERT INTO player_items(player_id, sid, pid, itemtype, count, attributes) values('$playerid','104','5','2530','1','')") or die(mysql_error());
			mysql_query("INSERT INTO player_items(player_id, sid, pid, itemtype, count, attributes) values('$playerid','105','6','2190','1','')") or die(mysql_error());
			mysql_query("INSERT INTO player_items(player_id, sid, pid, itemtype, count, attributes) values('$playerid','106','7','2468','1','')") or die(mysql_error());
			mysql_query("INSERT INTO player_items(player_id, sid, pid, itemtype, count, attributes) values('$playerid','107','8','2643','1','')") or die(mysql_error());
			mysql_query("INSERT INTO player_items(player_id, sid, pid, itemtype, count, attributes) values('$playerid','108','10','2120','1','')") or die(mysql_error());
			//backpack inside
			mysql_query("INSERT INTO player_items(player_id, sid, pid, itemtype, count, attributes) values('$playerid','109','102','2666','2','')") or die(mysql_error());
			//end backpack			
		}	
		elseif($voc == 2) //Druid
		{
			mysql_query("INSERT INTO player_items(player_id, sid, pid, itemtype, count, attributes) values('$playerid','101','1','2480','1','')") or die(mysql_error());
			mysql_query("INSERT INTO player_items(player_id, sid, pid, itemtype, count, attributes) values('$playerid','102','3','1988','1','')") or die(mysql_error());
			mysql_query("INSERT INTO player_items(player_id, sid, pid, itemtype, count, attributes) values('$playerid','103','4','2464','1','')") or die(mysql_error());
			mysql_query("INSERT INTO player_items(player_id, sid, pid, itemtype, count, attributes) values('$playerid','104','5','2530','1','')") or die(mysql_error());
			mysql_query("INSERT INTO player_items(player_id, sid, pid, itemtype, count, attributes) values('$playerid','105','6','2182','1','')") or die(mysql_error());
			mysql_query("INSERT INTO player_items(player_id, sid, pid, itemtype, count, attributes) values('$playerid','106','7','2468','1','')") or die(mysql_error());
			mysql_query("INSERT INTO player_items(player_id, sid, pid, itemtype, count, attributes) values('$playerid','107','8','2643','1','')") or die(mysql_error());
			mysql_query("INSERT INTO player_items(player_id, sid, pid, itemtype, count, attributes) values('$playerid','108','10','2120','1','')") or die(mysql_error());
			//backpack inside
			mysql_query("INSERT INTO player_items(player_id, sid, pid, itemtype, count, attributes) values('$playerid','109','102','2666','2','')") or die(mysql_error());
			//end backpack	
		}		
		elseif($voc == 3) //Paladin
		{
			mysql_query("INSERT INTO player_items(player_id, sid, pid, itemtype, count, attributes) values('$playerid','101','1','2480','1','')") or die(mysql_error());
			mysql_query("INSERT INTO player_items(player_id, sid, pid, itemtype, count, attributes) values('$playerid','102','3','1988','1','')") or die(mysql_error());
			mysql_query("INSERT INTO player_items(player_id, sid, pid, itemtype, count, attributes) values('$playerid','103','4','2464','1','')") or die(mysql_error());
			mysql_query("INSERT INTO player_items(player_id, sid, pid, itemtype, count, attributes) values('$playerid','104','5','2530','1','')") or die(mysql_error());
			mysql_query("INSERT INTO player_items(player_id, sid, pid, itemtype, count, attributes) values('$playerid','105','6','2389','5','')") or die(mysql_error());
			mysql_query("INSERT INTO player_items(player_id, sid, pid, itemtype, count, attributes) values('$playerid','106','7','2468','1','')") or die(mysql_error());
			mysql_query("INSERT INTO player_items(player_id, sid, pid, itemtype, count, attributes) values('$playerid','107','8','2643','1','')") or die(mysql_error());
			mysql_query("INSERT INTO player_items(player_id, sid, pid, itemtype, count, attributes) values('$playerid','108','10','2120','1','')") or die(mysql_error());
			//backpack inside
			mysql_query("INSERT INTO player_items(player_id, sid, pid, itemtype, count, attributes) values('$playerid','109','102','2666','2','')") or die(mysql_error());
			//end backpack	
		}	
		elseif($voc == 4) //Knight
		{
			mysql_query("INSERT INTO player_items(player_id, sid, pid, itemtype, count, attributes) values('$playerid','101','1','2480','1','')") or die(mysql_error());
			mysql_query("INSERT INTO player_items(player_id, sid, pid, itemtype, count, attributes) values('$playerid','102','3','1988','1','')") or die(mysql_error());
			mysql_query("INSERT INTO player_items(player_id, sid, pid, itemtype, count, attributes) values('$playerid','103','4','2464','1','')") or die(mysql_error());
			mysql_query("INSERT INTO player_items(player_id, sid, pid, itemtype, count, attributes) values('$playerid','104','5','2530','1','')") or die(mysql_error());
			mysql_query("INSERT INTO player_items(player_id, sid, pid, itemtype, count, attributes) values('$playerid','105','6','2412','5','')") or die(mysql_error());
			mysql_query("INSERT INTO player_items(player_id, sid, pid, itemtype, count, attributes) values('$playerid','106','7','2468','1','')") or die(mysql_error());
			mysql_query("INSERT INTO player_items(player_id, sid, pid, itemtype, count, attributes) values('$playerid','107','8','2643','1','')") or die(mysql_error());
			mysql_query("INSERT INTO player_items(player_id, sid, pid, itemtype, count, attributes) values('$playerid','108','10','2120','1','')") or die(mysql_error());
			//backpack inside
			mysql_query("INSERT INTO player_items(player_id, sid, pid, itemtype, count, attributes) values('$playerid','109','102','2666','2','')") or die(mysql_error());
			mysql_query("INSERT INTO player_items(player_id, sid, pid, itemtype, count, attributes) values('$playerid','110','102','2388','1','')") or die(mysql_error());
			mysql_query("INSERT INTO player_items(player_id, sid, pid, itemtype, count, attributes) values('$playerid','111','102','2398','1','')") or die(mysql_error());
			//end backpack		
		}
		
		$condition = 'Personagem criado com sucesso!';
		$error = '<br>Caso não tenha feito o download do jogo, fassa-o agora clicando <a href="http://www.darghos.com/download/installer.exe">aqui</a>.</b>
	<br>Em seu primeiro login mude o seu outfit para o de sua preferencia.
	<br>Nos vemos no Darghos!';	
		$button = '<br><a href="account.php?subtopic=main"><img src="images/back.gif" border="0"></a>';	
	}

	echo '<br><center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
	echo '<tr><td class=rank2>'.$condition.'</td></tr>';
	echo '</table>';
	echo '<center><table border="0" width="95%" bgcolor="black" CELLSPACING="1" CELLPADDING="2">';
	echo '<tr><td class=rank1>'.$error.'';
	echo '</table>';
	echo ''.$button.'';		
}

##### OBTER RECOVERY KEY #####
elseif($_GET['subtopic'] == 'get_recoverykey'){

$account = $_SESSION['account'];
$password = $_SESSION['password'];

		echo '<tr><td class=newbar><center><b>:: Gerar Recovery Key ::</td></tr>
<tr><td class=newtext><br><center>';	
			
		$query = mysql_query("SELECT * FROM accounts WHERE (id = '".$_SESSION['account']."' AND password = '".$password."')") or die(mysql_error()); 
		$query_sql = mysql_fetch_array($query);
		
		if($query_sql['rk_number'] != 0)
		{
			echo '<br><center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
			echo '<tr><td class=rank2>Erro!</td></tr>';
			echo '</table>';
			echo '<center><table border="0" width="95%" bgcolor="black" CELLSPACING="1" CELLPADDING="2">';
			echo '<tr><td class=rank1>
			<br>Esta conta já possui uma recovery key.</b>';
			echo '</table>';
			echo '<br><a href="account.php?subtopic=main"><img src="images/back.gif" border="0"></a>';			
			include "footer.php";
			die;
		}

		elseif($query_sql['premdays'] == 0)
		{
			echo '<br><center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
			echo '<tr><td class=rank2>Erro!</td></tr>';
			echo '</table>';
			echo '<center><table border="0" width="95%" bgcolor="black" CELLSPACING="1" CELLPADDING="2">';
			echo '<tr><td class=rank1>
			<br>Tipo de conta invalida.</b>';
			echo '</table>';
			echo '<br><a href="account.php?subtopic=main"><img src="images/back.gif" border="0"></a>';			
			include "footer.php";
			die;
		}				

		else

		{
			$email = filtreString($_POST['email'],0);
			$acc = filtreString($_POST['account'],0);
			$pass = md5(filtreString($_POST['pass'],0));
			
			if ($_SERVER['REQUEST_METHOD'] == "POST")
			{								
				if (($query_sql['id'] != $acc) or ($query_sql['password'] != $pass) or ($query_sql['email'] != $email))
				{
					echo '<br><center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
					echo '<tr><td class=rank2>Erro!</td></tr>';
					echo '</table>';
					echo '<center><table border="0" width="95%" bgcolor="black" CELLSPACING="1" CELLPADDING="2">';
					echo '<tr><td class=rank1>
					<br>Numero da conta, senha ou email incorretos.
					<br>Por favor, tente novamente.
					<br>Se o problema persistir contate um administrador.';
					echo '</table>';
					echo '<br><a href="account.php?subtopic=main"><img src="images/back.gif" border="0"></a>';			
					include "footer.php";
					die;
				}							
				
				else
				{
					$acc_number = rand(1,9);
					$rk = my_rand(14);	
					$rkMd5 = md5($rk);
				
					$check_rk = mysql_query("SELECT * FROM accounts WHERE (rk_number = '".$rkMd5."')") or die(mysql_error()); 
				
					if (mysql_num_rows($check_rk) == 0)
					{
						$update_acc = "UPDATE accounts SET rk_number = '".$rkMd5."' WHERE id = '".$account."'";
						mysql_query($update_acc) or die(mysql_error());
						echo '<br><center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
						echo '<tr><td class=rank2>Sua Recovery Key foi gerada com sucesso!</td></tr>';
						echo '</table>';
						echo '<center><table border="0" width="95%" bgcolor="black" CELLSPACING="1" CELLPADDING="2">';
						echo '<tr><td class=rank1>
						<br>Sua Recovery Key é: <br><b>'.$rk.'</b>
						<br>Lembre-se que sua recovery key é unica e NÃO sera possivel gerar outra!
						<br>Memorize o numero e bom jogo!';
						echo '</table>';
						echo '<br><a href="account.php?subtopic=main"><img src="images/back.gif" border="0"></a>';
						include "footer.php";
						die;		
					}
					
					else
					{
						echo '<br><center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
						echo '<tr><td class=rank2>Erro!</td></tr>';
						echo '</table>';
						echo '<center><table border="0" width="95%" bgcolor="black" CELLSPACING="1" CELLPADDING="2">';
						echo '<tr><td class=rank1>
						<br>Ocorreu um erro ao gerar sua recovery key.
						<br>Por favor, tente novamente.
						<br>Se o problema persistir contate um administrador.';
						echo '</table>';
						echo '<br><a href="account.php?subtopic=main"><img src="images/back.gif" border="0"></a>';			
						include "footer.php";
						die;	
					}
				}				
				
			}
?>
<center>



<form action="main.php?subtopic=get_recoverykey" method="post">

<br><center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">
A recovery key e um sistema avançado de recuperação para sua conta, com ela, você podera rapidamente retomar a posse de sua conta.
Lembre-se que a recovery key só pode ser obtida uma vez e caso você a perda não será possivel gerar outro numero!<br>
</table>

<br><center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">
<tr><td class=rank2>Gerar Recovery Key</td></tr>
</table>	
<center><table border="0" width="95%" bgcolor="black" CELLSPACING="1" CELLPADDING="4">
<tr><td width="25%" class=rank1>Email: (se não possuir deixe em branco)</td><td width="75%" class=rank1><input name="email" type="text" value="" class="login"/></td></tr>
<tr><td width="25%" class=rank1>Conta:</td><td width="75%" class=rank1><input name="account" type="password" value="" class="login"/></td></tr>
<tr><td width="25%" class=rank1>Senha:</td><td width="75%" class=rank1><input name="pass" type="password" value="" class="login"/></td></tr>
</table>
<br />
<input type="image" value="submit" src="images/submit.gif"/>
</form>
<?
}
}
##### DELETAMENTO DE CHAR #####
elseif($_GET['subtopic'] == 'delete_char')
{
	$account = $_SESSION['account'];
	$password = $_SESSION['password'];
	
	echo '<tr><td class=newbar><center><b>:: Deletar personagem ::</td></tr>';
	echo '<tr><td class=newtext><br><center>';	
	
	if ($_SERVER['REQUEST_METHOD'] == "POST")
	{
		$error = 0;
		if(filtreString($_POST['name'],1) == 0 or filtreString($_POST['pass'],1) == 0)
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
		elseif(Player::checkIsDeleted($_POST['name']))
		{
			$condition = 'Erro!';
			$conteudo = 'Este personagem já foi deletado.';	
			$error++;	
		}
		elseif ($error == 0)
		{
			$agendamento = Player::agendarDeletamento($_POST['name']);
			$data = date('d/m/Y',$agendamento);
			$condition = 'Personagem deletado';
			$conteudo = 'Foi agendado o deletamento do personagem '.$_POST['name'].' de sua conta para a data de: '.$data.'.';
			
		}
		
		echo '<center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
		echo '<tr><td class=rank2>'.$condition.'</td></tr>';
		echo '</table>';
		echo '<center><table border="0" width="95%" bgcolor="black" CELLSPACING="1" CELLPADDING="2">';
		echo '<tr><td class=rank1>'.$conteudo.'</td></tr>';
		echo '</table>';
		echo '<br><a href="account.php?subtopic=main"><img src="'.$back_button.'" border="0"></a>';			
	}
	else
	{
		echo '<form action="main.php?subtopic=delete_char" method="post">';
		echo '<center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">';
		echo 'Você pode deletar um char que não ultiliza mais, ou para liberar espaço em sua account.';
		echo 'Por motivos de segurança a deleção do personagem apenas se concretiza após 15 dias!<br>';
		echo '</table>';
		echo '<br><center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
		echo '<tr><td class=rank2>Deletar personagem</td></tr>';
		echo '</table>';	
		echo '<center><table border="0" width="95%" bgcolor="black" CELLSPACING="1" CELLPADDING="4">';
		echo '<tr><td width="25%" class=rank1>Nome do personagem:</td><td width="75%" class=rank1><input name="name" type="text" value="" class="login"/></td></tr>';
		echo '<tr><td width="25%" class=rank1>Senha:</td><td width="75%" class=rank1><input name="pass" type="password" value="" class="login"/></td></tr>';
		echo '</table>';
		echo '<br />';
		echo '<input type="image" value="submit" src="images/submit.gif"/> <a href="account.php?subtopic=main"><img src="'.$back_button.'" border="0"></a>';
	}
}
##### CANCELAR DELETAMENTO DE CHAR #####
elseif($_GET['subtopic'] == 'undelete_char')
{
	$account = $_SESSION['account'];
	$password = $_SESSION['password'];
	
	echo '<tr><td class=newbar><center><b>:: Cancelar deletamento de personagem ::</td></tr>';
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
		elseif(!Player::checkIsDeleted($_POST['name']))
		{
			$condition = 'Erro!';
			$conteudo = 'Personagem não existe ou não foi deletado.';		
			$error++;
		}
		elseif(!Account::passCheck($account,md5($_POST['pass'])))
		{
			$condition = 'Erro!';
			$conteudo = 'Senha não está correta.';
			$error++;
		}
		elseif ($error == 0)
		{
			$agendamento = Player::undeletePlayer($_POST['name']);
			$condition = 'Deletamento cancelado';
			$conteudo = 'O deletamento do personagem '.$_POST['name'].' foi cancelado com sucesso!<br>'.$_POST['name'].' não será mais deletado.';
			
		}
		
		echo '<center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
		echo '<tr><td class=rank2>'.$condition.'</td></tr>';
		echo '</table>';
		echo '<center><table border="0" width="95%" bgcolor="black" CELLSPACING="1" CELLPADDING="2">';
		echo '<tr><td class=rank1>'.$conteudo.'</td></tr>';
		echo '</table>';
		echo '<br><a href="account.php?subtopic=main"><img src="'.$back_button.'" border="0"></a>';			
	}
	else
	{
		echo '<form action="main.php?subtopic=undelete_char" method="post">';
		echo '<center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">';
		echo 'Para cancelar o deletamento de um personagem da sua conta por favor preencha os dados abaixo:<br>';
		echo '</table>';
		echo '<br><center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
		echo '<tr><td class=rank2>Cancelar deletamento de personagem</td></tr>';
		echo '</table>';	
		echo '<center><table border="0" width="95%" bgcolor="black" CELLSPACING="1" CELLPADDING="4">';
		echo '<tr><td width="25%" class=rank1>Nome do personagem:</td><td width="75%" class=rank1><input name="name" type="text" value="" class="login"/></td></tr>';
		echo '<tr><td width="25%" class=rank1>Senha:</td><td width="75%" class=rank1><input name="pass" type="password" value="" class="login"/></td></tr>';
		echo '</table>';
		echo '<br />';
		echo '<input type="image" value="submit" src="images/submit.gif"/> <a href="account.php?subtopic=main"><img src="'.$back_button.'" border="0"></a>';
	}
}

##### POSTAR UMA SCREENSHOT #####
elseif($_GET['subtopic'] == 'post_screenshot')
{
	echo '<tr><td class=newbar><center><b>:: Postar screenshot ::</td></tr>';
	echo '<tr><td class=newtext><br><center>';	
	
	if(Account::isPremium($account))
	{
		$arquivo = isset($_FILES["foto"]) ? $_FILES["foto"] : FALSE;

		$config = array();
		$config["diretorio"] = "screenshots/";	
		
		$account = $_SESSION['account'];
		$password = $_SESSION['password'];	
		
		if ($_SERVER['REQUEST_METHOD'] == "POST")
		{	
			$error = 0;		
			$tamanhos = getimagesize($arquivo["tmp_name"]);

			if(Screenshots::accountPosted($account))
			{
				$condition = 'Erro!';
				$conteudo = 'Você já postou uma screenshot!';
				$error++;						
			}

			elseif (filtreString($_POST['tittle'],1) == 0 or filtreString($_POST['detail'],1) == 0)
			{
				$condition = 'Erro!';
				$conteudo = 'Não utilize sintaxes reservadas.';
				$error++;				
			}
			
			elseif (strlen($_POST['tittle']) < 2 or strlen($_POST['tittle']) > 45)
			{
				$condition = 'Erro!';
				$conteudo = 'Titulo não pode ter mais de 45 ou menos de 2 carateres!';
				$error++;				
			}			
			
			elseif (strlen($_POST['detail']) < 20 or strlen($_POST['detail']) > 200)
			{
				$condition = 'Erro!';
				$conteudo = 'Detalhes não pode ter mais de 200 ou menos de 20 carateres!';
				$error++;				
			}			
			
		    elseif(!eregi("^image\/(pjpeg|jpeg|png|gif)$", $arquivo["type"]))
		    {
				$condition = 'Erro!';
				$conteudo = 'Arquivo em formato inválido! A imagem deve ser jpg. Envie outro arquivo.';
				$error++;			
			}
			
			elseif($arquivo["size"] > 400000)
			{
				$condition = 'Erro!';
				$conteudo = 'Arquivo em tamanho muito grande! A imagem deve ser de no máximo 400 kb. Envie outro arquivo.';
				$error++;				
			}

			elseif($error == 0)
			{
				// Pega extensão do arquivo, o indice 1 do array conterá a extensão
				preg_match("/\.(gif|png|jpg|jpeg){1}$/i", $arquivo["name"], $ext);
				
				// Gera nome único para a imagem
				$imagem_nome = Screenshots::nome($ext[1]);

				// Caminho de onde a imagem ficará
				$imagem_dir = $config["diretorio"] . $imagem_nome;

				// Faz o upload da imagem
				move_uploaded_file($arquivo["tmp_name"], $imagem_dir);
				
				Screenshots::makePost($account, $_POST['tittle'], $_POST['detail'], $imagem_nome);
				
				$condition = 'Sucesso!';
				$conteudo = 'Sua screenshot foi postada para votação com sucesso! Para visualiza-la acesse o sessão de Enquetes (requer login para votação).<br>Boa Sorte!';			
			}
			
			echo '<center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
			echo '<tr><td class=rank2>'.$condition.'</td></tr>';
			echo '</table>';
			echo '<center><table border="0" width="95%" bgcolor="black" CELLSPACING="1" CELLPADDING="2">';
			echo '<tr><td class=rank1>'.$conteudo.'</td></tr>';
			echo '</table>';
			echo '<br><a href="account.php?subtopic=main"><img src="'.$back_button.'" border="0"></a>';		
		}	
		
		else
		{	
			echo '<center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">';
			echo 'Você pode postar uma screenshot para ser avalidada por outros jogadores, a cada 15 dias o Darghos troca a screenshot do site pela mais votada! 
			Ultilize sua criatividade e ganhe os votos dos jogadores!';
			echo '<br><br>Atenção: A votação é para eleger a melhor screenshot, porem isto é relacionado ao Darghos, qualquer screenshot enviada fora do contexto do assunto ela será retirada e o usuario será punido.';
			echo '</table>';	
			echo '<form action="main.php?subtopic=post_screenshot" method=post  ENCTYPE="multipart/form-data">';
			echo '<center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
			echo '<tr class=rank2><td colspan=2>Informações da Screenshot: </td></tr>';
			echo '<tr class=rank1><td colspan=2><font color=red>Atenção:</font> A imagem deve seguir os seguintes padrões: Ser do formato JPG; Resolução maxima: 1024x768; Tamanho maximo: 300 kb.<br>
			O titulo não deve conter mais de 45 carateres.<br>
			Os detalhes não deve conter mais de 200 carateres.</td></tr>';			
			echo '<tr class=rank1><td colspan=2><center><input class=login type=file size=30 name=foto> </td></tr>';
			echo '<tr class=rank1><td>Titulo:<br><TEXTAREA class="login" NAME="tittle" ROWS=2 COLS=30 WRAP="virtual"></textarea><td>Detalhes:<br><TEXTAREA class="login" NAME="detail" ROWS=4 COLS=30 WRAP="virtual"></textarea> </td></tr>';
			echo '</table><br>';
			echo '<input type="image" value="submit" src="images/submit.gif"/> <a href="account.php?subtopic=main"><img src="'.$back_button.'" border="0"></a>';
			echo '</form>';	
		}
	}	
}
##### EXIBE COMANDOS #####
elseif($_GET['subtopic'] == 'show_commands')
{
	echo '<tr><td class=newbar><center><b>:: Comandos ::</td></tr>';
	echo '<tr><td class=newtext><br><center>';	

	echo '<center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">';
	echo 'O Darghos possui alguns comandos com o fim de facilitar o jogo ou efetuar alguma ação especial, veja abaixo a lista de comandos disponiveis e sua descrição.';
	echo '</table><br>';		
	
	echo '<table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
	echo '<tr class=rank2><td colspan=2>Lista de comandos </td></tr>';
	echo '<tr class=rank1><td width="20%"><b>Comando:</b></td><td><b>Descrição:</b></td></tr>';
	echo '<tr class=rank1><td>!buyhouse</td><td>Compra uma casa. (necessita ficar de frente para a porta da casa desejada)</td></tr>';
	echo '<tr class=rank1><td>!sellhouse</td><td>Vende sua casa. (ex: !sellhouse CM Slash)</td></tr>';
	echo '<tr class=rank1><td>!leavehouse</td><td>Abandona sua casa.</td></tr>';
	echo '<tr class=rank1><td>!serverinfo</td><td>Exibe as informações do Darghos.</td></tr>';
	echo '<tr class=rank1><td>!kills</td><td>Exibe quantas mortes injustificadas você tem.</td></tr>';
	echo '<tr class=rank1><td>!mortes</td><td>Exibe as mortes de um jogador. (ex: !mortes "CM Slash)</td></tr>';
	if(Account::isPremium($account))
	{
		echo '<tr class=rank1><td>!createguild</td><td>Cria uma nova guilda. (ex: !createguild Darghos Powers)</td></tr>';
		echo '<tr class=rank1><td>!joinguild</td><td>Aceita um convite de uma guilda. (apos invitado, ex: !joinguild Darghos Powers)</td></tr>';
	}
	echo '</table><br>';

	if(Account::isGM($account) or Account::isAdmin($account) or Account::isCM($account))
	{
		echo '<table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
		echo '<tr class=rank2><td colspan=2>Lista de Gamemaster Comandos </td></tr>';
		echo '<tr class=rank1><td width="20%"><b>Comando:</b></td><td><b>Descrição:</b></td></tr>';
		echo '<tr class=rank1><td>Control + Y</td><td>Abre o painel de violações.</td></tr>';
		echo '<tr class=rank1><td>/B</td><td>Faz um broadcast. (ex: /B Boa tarde a todos)</td></tr>';
		echo '<tr class=rank1><td>/pos</td><td>Obtem as cordenadas do jogador. (ex: /pos CM Slash)</td></tr>';
		echo '<tr class=rank1><td>/t</td><td>Teletransporte para o seu templo.</td></tr>';
		echo '<tr class=rank1><td>/town</td><td>Se teletransporta para o templo de uma cidade. (ex: /town Aracura)</td></tr>';
		echo '<tr class=rank1><td>/tp</td><td>Se teletransporta para um local predefinido. (ex: /tp "dp_aracura)</td></tr>';
		echo '</table><br>';
	}	

	if(Account::isCM($account) or Account::isAdmin($account))
	{
		echo '<table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
		echo '<tr class=rank2><td colspan=2>Lista de Comunity Manager Comandos </td></tr>';
		echo '<tr class=rank1><td width="20%"><b>Comando:</b></td><td><b>Descrição:</b></td></tr>';
		echo '<tr class=rank1><td>/save</td><td>Salva o server.</td></tr>';
		echo '<tr class=rank1><td>/reload</td><td>Recarrega um sistema. (ex: /reload actions)</td></tr>';
		echo '<tr class=rank1><td>/closeserver</td><td>Fecha o server para jogadores.</td></tr>';
		echo '<tr class=rank1><td>/openserver</td><td>Abre o server para jogadores (caso esteja fechado).</td></tr>';
		echo '<tr class=rank1><td>/kick</td><td>Desconecta um jogador. (ex: /kick CM Slash)</td></tr>';
		echo '<tr class=rank1><td>/b</td><td>Bani o IP de um jogador. (ex: /b CM Slash)</td></tr>';
		echo '<tr class=rank1><td>/info</td><td>Obtem informações do personagem. (ex: /info CM Slash)</td></tr>';
		echo '<tr class=rank1><td>/raid</td><td>Inicia uma invasão. (ex: /raid aracura_demodras)</td></tr>';
		echo '<tr class=rank1><td>/clean</td><td>Limpa o chão do server.</td></tr>';
		echo '<tr class=rank1><td>/s</td><td>Sumona um NPC. (ex: /s rook_oracle)</td></tr>';
		echo '</table><br>';
	}	
}

##### MUDANÇA DE SEXO #####
elseif($_GET['subtopic'] == 'change_sex')
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
			echo '<br><a href="account.php?subtopic=main"><img src="'.$back_button.'" border="0"></a>';					
		}
		else
		{
			echo '<center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">';
			echo 'If you choose your gender wrong in the creation of his character, or want to change their looks, in Darghos you can change your sex for 5 days of premium account. For this to fill in the fields below:<br><br>
			<font color="red"><b>Attention:</b></font><br>
			The change of sex spends 5 days of your premium account.<br>
			To make the change you need exit the game (logout).';
			echo '</table><br>';
			echo '<form action="main.php?subtopic=change_sex" method=post  ENCTYPE="multipart/form-data">';
			echo '<center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
			echo '<tr class=rank2><td colspan=2>Character information: </td></tr>';		
			echo '<tr><td width="25%" class=rank1>Character:</td><td width="75%" class=rank1><input name="name" type="text" value="" class="login"/></td></tr>';
			echo '<tr><td width="25%" class=rank1>Password:</td><td width="75%" class=rank1><input name="pass" type="password" value="" class="login"/></td></tr>';
			echo '</table><br>';
			echo '<input type="image" value="submit" src="images/submit.gif"/> <a href="account.php?subtopic=main"><img src="'.$back_button.'" border="0"></a>';
			echo '</form>';				
		}		
	}		
}
##### CHANGE NAME #####
elseif($_GET['subtopic'] == 'change_name')
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
			echo '<br><a href="account.php?subtopic=main"><img src="'.$back_button.'" border="0"></a>';					
		}
		else
		{
			echo '<center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">';
			echo 'With this feature you can change the name of her character for 10 days of your premium account in Darghos. For this fill in the fields below:<br><br>
			<font color="red"><b>Attention:</b></font><br>
			The change of name spends 10 days of your premium account.<br>
			To make the change you need exit the game (logout).';
			echo '</table><br>';
			echo '<form action="main.php?subtopic=change_name" method=post  ENCTYPE="multipart/form-data">';
			echo '<center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
			echo '<tr class=rank2><td colspan=2>Character information: </td></tr>';		
			echo '<tr><td width="25%" class=rank1>Character:</td><td width="75%" class=rank1><input name="name" type="text" value="" class="login"/></td></tr>';
			echo '<tr><td width="25%" class=rank1>New name:</td><td width="75%" class=rank1><input name="new_name" type="text" value="" class="login"/></td></tr>';
			echo '<tr><td width="25%" class=rank1>Password:</td><td width="75%" class=rank1><input name="pass" type="password" value="" class="login"/></td></tr>';
			echo '</table><br>';
			echo '<input type="image" value="submit" src="images/submit.gif"/> <a href="account.php?subtopic=main"><img src="'.$back_button.'" border="0"></a>';
			echo '</form>';				
		}		
	}		
}

##### SHOP #####
elseif($_GET['subtopic'] == 'shop')
{
	if(Account::isPremium($account))
	{
		echo '<tr><td class=newbar><center><b>:: Shopping ::</td></tr>';
		echo '<tr><td class=newtext><br><center>';		
		
		if ($_SERVER['REQUEST_METHOD'] == "POST")
		{
			$bless = $_POST['bless'];
			$promotion = $_POST['promotion'];
			$rank = $_POST['rank'];
			$pvp = $_POST['pvp'];
			
			if($bless == 1)
				$prem['bless'] = 10;
			if($promotion == 1)	
				$prem['promotion'] = 5;
			if($rank == 1)	
				$prem['rank'] = 10;
			if($pvp == 1)	
				$prem['pvp'] = 20;				
				
			$looseDays = $prem['bless'] + $prem['promotion'] + $prem['rank'] + $prem['pvp'];
			
			
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
				if($rank == 1)	
					Shop::giveRank($_POST['name']);
				if($pvp == 1)	
					Shop::changePvp($_POST['name']);					
					
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
			echo '<br><a href="account.php?subtopic=main"><img src="'.$back_button.'" border="0"></a>';					
		}
		else
		{
			echo '<center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="4">';
			echo 'Welcome to shop, here you can buy some benefits in the game by your premium days. Mark the desired benefits:<br><br>
			<font color="red"><b>Attention:</b></font><br>
			To buy any benefits here you need exit the game (logout).';
			echo '</table><br>';
			echo '<form action="main.php?subtopic=shop" method=post  ENCTYPE="multipart/form-data">';
			echo '<center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
			echo '<tr class=rank2><td colspan=3>Step 1/2: </td></tr>';		
			echo '<tr><td width="5%" class=rank1></td><td class=rank1><b>Benefit</td><td width="15%" class=rank1><b>Price</td></tr>';
			echo '<tr class=rank3><td><input type="checkbox" name="bless" value="1"></td><td>All blessing\'s</td><td>10 days</td></tr>';
			echo '<tr class=rank1><td><input type="checkbox" name="promotion" value="1"></td><td>Promotion</td><td>5 days</td></tr>';
			echo '<tr class=rank3><td></td><td>Change Player vs Player mode of my character</td><td>20 days</td></tr>';
			echo '<tr class=rank1><td></td><td>Superior rank/status (Sir for male and Lady for female)</td><td>10 days</td></tr>';			
			echo '<tr class=rank3><td></td><td>Reserved House</td><td>XX days</td></tr>';
			echo '</table><br>';
			echo '<center><table width="60%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
			echo '<tr class=rank2><td colspan=2>Step 2/2: </td></tr>';		
			echo '<tr class=rank1><td width="25%">Character:</td><td width="75%" class=rank1><input name="name" type="text" value="" class="login"/></td></tr>';
			echo '<tr class=rank1><td width="25%">Password:</td><td width="75%" class=rank1><input name="pass" type="password" value="" class="login"/></td></tr>';
			echo '</table><br>';			
			echo '<input type="image" value="submit" src="images/submit.gif"/> <a href="account.php?subtopic=main"><img src="'.$back_button.'" border="0"></a>';
			echo '</form>';				
		}		
	}		
}
elseif($_GET['subtopic'] == 'report')
{
	echo '<tr><td class=newbar><center><b>:: Report Panel ::</td></tr>';
	echo '<tr><td class=newtext><br><center>';		
	
	if ($_SERVER['REQUEST_METHOD'] == "POST")
	{
		$type = $_POST['type'];
		$description =  mysql_real_escape_string(filtreString(nl2br($_POST['description']),0));
		$error = 0;
		$date = time();
		
		if(strlen($description) > 200)
		{
			$condition = 'Many characters';
			$conteudo = 'Your report can not contain more of 200 characteres.';
			$error++;
		}
		elseif($error == 0)
		{
			$condition = 'Your report has been sent successfully.';
			$conteudo = 'Your report as been sent, now DarghosSoft will examine the report and if your report is confirmed the problem will be fixed. Thanks!';	
			
			mysql_query("INSERT INTO `report` (type, description, by_account, date) VALUES('$type', '$description', '$account', '$date')") or die(mysql_error());
		}

		echo '<center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
		echo '<tr><td class=rank2>'.$condition.'</td></tr>';
		echo '</table>';
		echo '<center><table border="0" width="95%" bgcolor="black" CELLSPACING="1" CELLPADDING="2">';
		echo '<tr><td class=rank1>'.$conteudo.'</td></tr>';
		echo '</table>';
		echo '<br><a href="account.php?subtopic=main"><img src="'.$back_button.'" border="0"></a>';			
		
	}
	else
	{
		echo '<center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">';
		echo 'Welcome to report panel, here you can report a problem (bug) detected in game.<br>
		This feature can help make a Darghos with few problems and more fun!<br><br>
		<font color="red">Ps: This panel can only be used to report bugs, fails and things of this gender. If you use it for another things you will be bannished ingame.</font>';
		echo '</table><br>';
		echo '<form action="main.php?subtopic=report" method=post  ENCTYPE="multipart/form-data">';
		echo '<center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
		echo '<tr class=rank2><td colspan=2>Reports Panel: </td></tr>';		
		echo '<tr><td class=rank1>Type:</td><td class=rank1><select class=login name="type"><option value="0">Game Report</option><option value="1">Map Report</option><option value="2">Website Report</option></select></td></tr>';
		echo '<tr><td class=rank1>Description:</td><td class=rank1><TEXTAREA class="login" NAME="description" ROWS=15 COLS=50 WRAP="virtual">Describe here details of the problem detected (is very important describe the location of the problem, like the Dungeon Cave if is Map Report, or link if is WebSite Report).</textarea></td></tr>';
		echo '</table><br>';		
		echo '<input type="image" value="submit" src="images/submit.gif"/> <a href="account.php?subtopic=main"><img src="'.$back_button.'" border="0"></a>';
		echo '</form>';				
	}
}	
elseif($_GET['subtopic'] == 'tickets')
{
	if($_GET['action'] == 'submit')
	{
		echo '<tr><td class=newbar><center><b>:: Submited Ticket ::</td></tr>';
		echo '<tr><td class=newtext><br><center>';		
		
		$type = $_POST['type'];
		$description =  mysql_real_escape_string(filtreString(nl2br($_POST['description']),0));
		$error = 0;
		$date = time();
		
		if(strlen($description) > 600)
		{
			$condition = 'Many characters';
			$conteudo = 'Your ticket can not contain more of 600 characteres.';
			$error++;
		}
		elseif($error == 0)
		{
			$condition = 'Your ticket has been sent successfully.';
			$conteudo = 'Your ticket as been sent, now UltraxSoft will examine the ticket and comming soon send answer. Thanks!';	
			
			mysql_query("INSERT INTO `tickets` (type, description, by_account, date) VALUES('$type', '$description', '$account', '$date')") or die(mysql_error());
		}

		echo '<center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
		echo '<tr><td class=rank2>'.$condition.'</td></tr>';
		echo '</table>';
		echo '<center><table border="0" width="95%" bgcolor="black" CELLSPACING="1" CELLPADDING="2">';
		echo '<tr><td class=rank1>'.$conteudo.'</td></tr>';
		echo '</table>';
		echo '<br><a href="account.php?subtopic=main"><img src="'.$back_button.'" border="0"></a>';				
	}
	elseif($_GET['view'] != null)
	{
		echo '<tr><td class=newbar><center><b>:: View Ticket ::</td></tr>';
		echo '<tr><td class=newtext><br><center>';	
			
		$reportId = $_GET['view'];
		$query = mysql_query("SELECT * FROM `tickets` WHERE `id` = '$reportId'") or die(mysql_error());
		$fetch = mysql_fetch_object($query);			

		echo '<center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
		echo '<tr class=rank2><td width="20%" colspan=4>View Ticket</td></tr>';
		echo '<tr class=rank3><td><b>Category:</td><td>'.$fetch->type.'</td></tr>';	
		echo '<tr class=rank3><td><b>Date:</td><td>'.date('M d Y, H:i:s',$fetch->date).'</td></tr>';	
		echo '<tr class=rank3><td><b>Description:</td><td>'.nl2br($fetch->description).'</td></tr>';	
		if($fetch->answer != "")	
		{
			echo '<tr class=rank3><td><b>Answer:</td><td>'.nl2br($fetch->answer).'</td></tr>';	
			echo '<tr class=rank3><td><b>Answer in:</td><td>'.date('M d Y, H:i:s',$fetch->answer_date).'</td></tr>';						
		}
		echo '</table><br>';		
		echo '<a href="main.php?subtopic=tickets"><img src="'.$back_button.'" border="0"></a>';	
		echo '</form>';	
	}		
	elseif ($_SERVER['REQUEST_METHOD'] == "POST")
	{
		if($_POST['category'] == "report")
		{
			echo '<tr><td class=newbar><center><b>:: Report Ticket ::</td></tr>';
			echo '<tr><td class=newtext><br><center>';	
	
			echo '<center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">';
			echo 'Selecione abaixo o local na qual você encontrou o problema (Game, Map ou Website) e em "Description" descreva para nós os detalhes do problema. Tente usar pontos de referencia para facilitar a concordancia.<br>';
			echo '</table><br>';
	
			echo '<form action="main.php?subtopic=tickets&action=submit" method=post  ENCTYPE="multipart/form-data">';
			echo '<center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
			echo '<tr class=rank2><td colspan=2>Make a Report </td></tr>';		
			echo '<tr><td class=rank1>Location:</td><td class=rank1><select class=login name="type"><option value="game report">Game</option><option value="map report">Map</option><option value="website report">Website</option></select></td></tr>';
			echo '<tr><td class=rank1>Description:</td><td class=rank1><TEXTAREA class="login" NAME="description" ROWS=15 COLS=50 WRAP="virtual">Describe here details of the problem detected (is very important describe the location of the problem, like the Dungeon Cave if is Map Report, or link if is WebSite Report).</textarea></td></tr>';
			echo '</table><br>';		
			echo '<input type="image" value="submit" src="images/submit.gif"/> <a href="main.php?subtopic=tickets"><img src="'.$back_button.'" border="0"></a>';
			echo '</form>';			
		}
		elseif($_POST['category'] == "support")
		{
			echo '<tr><td class=newbar><center><b>:: Support Ticket ::</td></tr>';
			echo '<tr><td class=newtext><br><center>';	
	
			echo '<center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">';
			echo 'Descreva abaixo o seu problema ou questão com o maximo de detalhes possiveis.<br>';
			echo '</table><br>';
	
			echo '<form action="main.php?subtopic=tickets&action=submit" method=post  ENCTYPE="multipart/form-data">';
			echo '<center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
			echo '<tr class=rank2><td colspan=2>Request a Support </td></tr>';		
			echo '<tr><td class=rank1>Description:</td><td class=rank1><TEXTAREA class="login" NAME="description" ROWS=15 COLS=50 WRAP="virtual">Describe here details of the problem detected (is very important describe the location of the problem, like the Dungeon Cave if is Map Report, or link if is WebSite Report).</textarea></td></tr>';
			echo '</table><br>';		
			echo '<input type="hidden" name="type" value="'.$_POST['category'].'">';	
			echo '<input type="image" value="submit" src="images/submit.gif"/> <a href="main.php?subtopic=tickets"><img src="'.$back_button.'" border="0"></a>';
			echo '</form>';			
		}	
		elseif($_POST['category'] == "suggestion")
		{
			echo '<tr><td class=newbar><center><b>:: Suggestion Ticket ::</td></tr>';
			echo '<tr><td class=newtext><br><center>';	
	
			echo '<center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">';
			echo 'Descreva abaixo a sua sujestão o mais detalhadamente possivel para que possamos compreender, e se interessante, aplicar a sua ideia no Darghos.<br>';
			echo '</table><br>';
	
			echo '<form action="main.php?subtopic=tickets&action=submit" method=post  ENCTYPE="multipart/form-data">';
			echo '<center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
			echo '<tr class=rank2><td colspan=2>Make a Suggestion </td></tr>';		
			echo '<tr><td class=rank1>Description:</td><td class=rank1><TEXTAREA class="login" NAME="description" ROWS=15 COLS=50 WRAP="virtual">Describe here details of the problem detected (is very important describe the location of the problem, like the Dungeon Cave if is Map Report, or link if is WebSite Report).</textarea></td></tr>';
			echo '</table><br>';	
			echo '<input type="hidden" name="type" value="'.$_POST['category'].'">';		
			echo '<input type="image" value="submit" src="images/submit.gif"/> <a href="main.php?subtopic=tickets"><img src="'.$back_button.'" border="0"></a>';
			echo '</form>';			
		}	
		elseif($_POST['category'] == "premium")
		{
			echo '<tr><td class=newbar><center><b>:: Premium Account Ticket ::</td></tr>';
			echo '<tr><td class=newtext><br><center>';	
	
			echo '<center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">';
			echo 'Quer adquirir sua premium account e está com alguma duvida? Então tire qualquer duvida sobre premium account abrindo um ticket! Teremos prazer em lhe ajudar com qualquer questão sobre as premium accounts!<br>';
			echo '</table><br>';
	
			echo '<form action="main.php?subtopic=tickets&action=submit" method=post  ENCTYPE="multipart/form-data">';
			echo '<center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
			echo '<tr class=rank2><td colspan=2>Premium Account Ticket </td></tr>';		
			echo '<tr><td class=rank1>Description:</td><td class=rank1><TEXTAREA class="login" NAME="description" ROWS=15 COLS=50 WRAP="virtual"></textarea></td></tr>';
			echo '</table><br>';	
			echo '<input type="hidden" name="type" value="'.$_POST['category'].'">';		
			echo '<input type="image" value="submit" src="images/submit.gif"/> <a href="main.php?subtopic=tickets"><img src="'.$back_button.'" border="0"></a>';
			echo '</form>';			
		}			
	}
	else
	{
		echo '<tr><td class=newbar><center><b>:: Ticket Record ::</td></tr>';
		echo '<tr><td class=newtext><br><center>';	
	
		echo '<center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">';
		echo 'Welcome to ticket records! Here you can communicate with UltraxSoft Team to make a report of detected bug (Reports), resolve an issue (Support) or if you have a good idea to Darghos you can tell us (Suggestion).<br>
		<br><font color="red">Ps: The illegal use of Record Ticket may result a punnishment ingame (Bannishment).</font>';
		echo '</table><br>';	
	
		$query = mysql_query("SELECT * FROM `tickets` WHERE `by_account` = '$account'") or die(mysql_error());
	
		echo '<center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
		echo '<tr class=rank2><td width="20%" colspan=4>My Tickets</td></tr>';		

		if(mysql_num_rows($query) != 0)
		{	
			echo '<tr class=rank1><td width="20%"><b>Category</td><td width="25%"><b>Date</td><td width="25%"><b>Status</td><td></td></tr>';				
		
			while($fetch = mysql_fetch_object($query))
			{
				if($fetch->answer != "")
					$ticket_status = 'Answered';
				else
					$ticket_status = 'Waiting';
				echo '<tr class=rank3><td>'.$fetch->type.'</td><td>'.date('M d Y, H:i:s',$fetch->date).'</td><td>'.$ticket_status.'</td><td><a href="main.php?subtopic=tickets&view='.$fetch->id.'"><b>View</b></a></td></tr>';				
			}
		}
		else
		{
			echo '<tr class=rank3><td colspan=4>No tickets opened</td></tr>';				
		}
		echo '</table><br>';
	
		echo '<form action="main.php?subtopic=tickets" method=post  ENCTYPE="multipart/form-data">';
		echo '<center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
		echo '<tr class=rank2><td colspan=2>New Ticket </td></tr>';		
		echo '<tr><td class=rank1><b>Category: <select class=login name="category"><OPTION VALUE="" SELECTED>(choose category)</OPTION><option value="support">Request a support</option><option value="report">Make a report</option><option value="suggestion">Make a suggestion</option><option value="premium">Premium Account</option></select></td></tr>';
		echo '</table><br>';		
		echo '<input type="image" value="submit" src="images/submit.gif"/> <a href="account.php?subtopic=main"><img src="'.$back_button.'" border="0"></a>';
		echo '</form>';	
	}	
}	
elseif ($_GET['subtopic'] == 'payments')
{
	if($_GET['step'] == '1')
	{
		echo '<tr><td class=newbar><center><b>:: Contribute Step 1 ::</td></tr>
		<tr><td class=newtext>';

		echo '<br><center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">';
		echo 'Antes de comprar sua premium account, é necessario ler, e aceitar as clausulas de serviço listadas abaixo:';
		echo '</table>';	
		
		echo '<br><form method="post" action="main.php?subtopic=payments&step=2">';
		echo '<br><center><table width="90%" border="0" cellpadding="4" cellspacing="1">';
		echo '<tr class="rank2"><td colspan="2"><b>Clausulas e Regras de Contribuição</td></tr>';
		echo '<tr class="rank1">
				<td width="20%"><b>Aceitando e(ou) efetuando a contribuição com o serviço você está de acordo que:</b><br>
				<center>			
<textarea rows="10" wrap="physical" cols="55" readonly="true">Este é um documento informativo das clausulas e regras referente ao funcionamento, deveres e limitações entre outros referente aos jogadores contribuintes com o Darghos. Leia abaixo todas clausulas e regras atentamente e, somente no caso de aceitar e seguir respeitando todos os termos, assinalar a caixa "Eu li, e aceito as clausulas e regras de contribuições." e assim dar continuidade ao sistema de contribuição.

1. A estabilidade e mantimento do servidor no ar.
• A UltraxSoft e(ou) Darghos não tem a obrigação de manter o servidor sempre ligado, podendo o mesmo ser desligado a qualquer momento e por qualquer motivo, sem prévio aviso, devolução de quantias em dinheiro ou danos morais.

2. Conectividade.
• A UltraxSoft e(ou) Darghos não são responsáveis por qualquer problema de conectividade entre o jogador e o "game-server", tanto por parte do jogador, provedor de internet ou "datacenter" (empresa que hospeda o nosso game-server).

3. Seguir regras sem exceções.
• Caso você contribua com o serviço você estará sujeito a todas as regras do jogo, não possuindo nenhum direito ou vantagem extra dentro ou fora do jogo.

4. Vantagens da contribuição.
• Caso você contribua com o serviço, cabe a nós decidirmos sobre as vantagens recebidas, podendo as mesmas serem retiradas a qualquer momento sem prévio aviso nem devolução em dinheiro.

5. Direitos autorais.
• O Darghos não apóia a modificação de "softwares" sem autorização dos fabricantes, e não cobre nenhum tipo de dano a seu computador que os programas podem causar.

6. Recompensas dentro do jogo.
• Perdas de itens, contas, ou características de personagens somente serão devolvidos se o problema foi de causa interna em nossos "game-servers" e em forma de ponto de restauração (ação que efetua uma volta no tempo todo o servidor para um momento ou dia aonde a problemática não havia acontecido), e somente caso a UltraxSoft assim julgue necessário, perdas causadas por qualqueis outras causas (como problemas de conexão, desastres naturais, cuidados não eficientes com a sua conta (Hacking), entre outros) não são recompensados de maneira alguma.

7. Devoluções e troca de destino de contribuições.
• A devolução do dinheiro, ou mudança da conta na qual o contribuinte irá receber os benefícios, só é ocorrida enquanto o contribuinte não aceita a liberação do serviço. Caso algum dos recursos seja solicitado pelo contribuinte, a mudança de conta para contribuição tem um prazo de 5 a 30 dias após solicitada para ser concluída e a devolução do dinheiro em um prazo de 30 a 90 dias após solicitado. 

IMPORTANTE: Após aceitar o serviço, receber e começar a desfrutar dos beneficio em sua conta os recursos de mudança de conta e devolução do dinheiro não são mais possíveis em hipótese alguma.

A mudança deste documento pode ser efetuada sem aviso, ou prévio aviso, cabendo a você se manter atualizado às regras e ao contrato.</textarea>
				</center><br><br>
				<input type="checkbox" name="agreeClauses" value="true">Eu li, e aceito as clausulas e regras de contribuições.
				</td>
			</tr>';	
		echo '</table>';		
		echo '<br><center><input type="image" value="submit" src="images/continue.gif"/> <a href="main.php?subtopic=payments"><img src="images/back.gif" border="0"></a>';	
		echo '</form>';
	}	
	elseif($_GET['step'] == '2')
	{
		echo '<tr><td class=newbar><center><b>:: Contribute Step 1 ::</td></tr>
		<tr><td class=newtext>';
	
		if($_POST['agreeClauses'] != "true")
		{
			echo '<br><center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
			echo '<tr><td class=rank2>Clausulas e Regras de Contribuição</td></tr>';
			echo '</table>';
			echo '<center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">';
			echo '<tr><td class=rank1>Infelizmente você só está permitido a efetuar uma contribuição com a UltraxSoft se aceitar nossas clausulas e regras para este serviço.</td></tr>';
			echo '</table>';
			echo '<br><a href="main.php?subtopic=payments&step=1"><img src="images/back.gif" border="0"></a>';				
		}
		else
		{
			echo '<br><center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">';
			echo 'No Darghos você pode fazer uma contribuição e a recompensa ser ativa para você mesmo, ou para um outro jogador (um amigo por exemplo). Selecione abaixo para quem deve ser ativado a recomensa de sua doação.';
			echo '</table>';	
			
			echo '<br><form method="post" action="main.php?subtopic=payments&step=3">';
			echo '<br><center><table width="90%" border="0" cellpadding="4" cellspacing="1">';
			echo '<tr class="rank2"><td colspan="2"><b>Conta a receber a Premium Account</td></tr>';
			echo '<tr class="rank1"><td width="20%"><b>Destino</td><td><input type="radio" name="destiny" value="me" style="border: 0;" /> Eu quero adquirir a premium account para minha propria conta<br>
			<input type="radio" name="destiny" value="other" style="border: 0;" /> Eu quero adquirir a premium account para outro jogador.
			</td></tr>';	
			echo '</table>';		
			echo '<br><center><input type="image" value="submit" src="images/continue.gif"/> <a href="main.php?subtopic=payments"><img src="images/back.gif" border="0"></a>';	
			echo '</form>';
		}
	}	
	elseif($_GET['step'] == '3')
	{
		echo '<tr><td class=newbar><center><b>:: Contribute Step 2 ::</td></tr>
		<tr><td class=newtext>';

		echo '<br><center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">';
		echo 'Select bellow the payment form. PagSeguro is only if you live in Brazil. If you live out Brasil select PayPal.';
		echo '</table>';	
		
		echo '<br><form method="post" action="main.php?subtopic=payments&step=4">';
		echo '<br><center><table width="90%" border="0" cellpadding="4" cellspacing="1">';
		echo '<tr class="rank2"><td colspan="2"><b>Payment Form</td></tr>';
		echo '<tr class="rank1"><td width="20%"><b>Form</td><td><input type="radio" name="form" value="pagseguro" style="border: 0;" /> PagSeguro<br>
		<input type="radio" name="form" value="paypal" style="border: 0;" /> PayPal
		</td></tr>';	
		echo '</table>';
		echo '<input type="hidden" name="destiny" value="'.$_POST['destiny'].'">';			
		echo '<br><center><input type="image" value="submit" src="images/continue.gif"/> <a href="main.php?subtopic=payments"><img src="images/back.gif" border="0"></a>';	
		echo '</form>';
	}	
	elseif($_GET['step'] == '4')
	{
		if($_POST['form'] == "pagseguro")
		{
			if($_POST['destiny'] == "me")
			{
				echo '<tr><td class=newbar><center><b>:: Contribute Step 3 ::</td></tr>
				<tr><td class=newtext>';

				echo '<br><center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">';
				echo 'Entre com a senha de sua conta, ela é necesaria para a autenticação. Depois selecione o modo de ativação, e por fim, selecione a duração de sua contribuição e clique no botão "Continue".';
				echo '</table>';	
				
				echo '<br><form method="post" action="main.php?subtopic=payments&step=5">';
				echo '<br><center><table width="90%" border="0" cellpadding="4" cellspacing="1">';
				echo '<tr class="rank2"><td colspan="2"><b>Informações da Contribuição</td></tr>';
				echo '<tr class="rank1" width="25%"><td><b>Password</td><td><input name="pass" type="password" value="" class="login"/></td></tr>';	
				echo '<tr class="rank1"><td><b>Ativação</td><td><select name="activation"><option value="0">Normal</option></select></td></tr>';	
				echo '<tr class="rank1"><td><b>Duração</td><td>
				<input type="radio" name="duration" value="30" style="border: 0;" /> <b>R$ 10,90</b> Contribuição para 1 mês (30 dias).<br>
				<input type="radio" name="duration" value="60" style="border: 0;" /> <b>R$ 21,80</b> Contribuição para 2 mêses (60 dias).<br>
				<input type="radio" name="duration" value="90" style="border: 0;" /> <b>R$ 32,70</b> Contribuição para 3 mêses (90 dias).<br>
				<input type="radio" name="duration" value="180" style="border: 0;" /> <b>R$ 55,90</b> Contribuição para 6 mêses (180 dias).<br>
				<input type="radio" name="duration" value="360" style="border: 0;" /> <b>R$ 99,90</b> Contribuição para 1 ano (360 dias).<br>	</td></tr>';	
				echo '</table>';		
				echo '<input type="hidden" name="destiny" value="'.$_POST['destiny'].'">';	
				echo '<input type="hidden" name="form" value="'.$_POST['form'].'">';	
				echo '<br><center><input type="image" value="submit" src="images/continue.gif"/> <a href="main.php?subtopic=payments"><img src="images/back.gif" border="0"></a>';	
				echo '</form>';
			}
			elseif($_POST['destiny'] == "other")
			{
				echo '<tr><td class=newbar><center><b>:: Contribute Step 2 ::</td></tr>
				<tr><td class=newtext>';

				echo '<br><center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">';
				echo 'Preencha abaixo o seu nome real e um comentario, estes dados irão aparecer ao dono da conta quando esta premium account for ser ativada. Então selecione a duração que você desejar e clique em "Continue".';
				echo '</table>';	
				
				echo '<br><form method="post" action="main.php?subtopic=payments&step=5">';
				echo '<br><center><table width="90%" border="0" cellpadding="4" cellspacing="1">';
				echo '<tr class="rank2"><td colspan="2"><b>Informações da Contribuição</td></tr>';
				echo '<tr class="rank1" width="25%"><td><b>Nome Real</td><td><input name="rl_name" type="text" SIZE=30 MAXLENGTH=50/> <br><font size=1>(seu nome real)</td></tr>';	
				echo '<tr class="rank1" width="25%"><td><b>Comentario</td><td><input name="comment" type="text"  SIZE=45 MAXLENGTH=200/> <br><font size=1>(escreva aqui seu comentario)</td></tr>';	
				echo '<tr class="rank1"><td><b>Nome do Personagem</td><td><input name="name" type="text" value=""/> <br><font size=1>(nome do personagem que deve receber a premium account)</td></tr>';	
				echo '<tr class="rank1"><td><b>Duração</td><td>
				<input type="radio" name="duration" value="30" style="border: 0;" /> <b>R$ 10,90</b> Contribuição para 1 mês (30 dias).<br>
				<input type="radio" name="duration" value="60" style="border: 0;" /> <b>R$ 21,80</b> Contribuição para 2 mêses (60 dias).<br>
				<input type="radio" name="duration" value="90" style="border: 0;" /> <b>R$ 32,70</b> Contribuição para 3 mêses (90 dias).<br>
				<input type="radio" name="duration" value="180" style="border: 0;" /> <b>R$ 55,90</b> Contribuição para 6 mêses (180 dias).<br>
				<input type="radio" name="duration" value="360" style="border: 0;" /> <b>R$ 99,90</b> Contribuição para 1 ano (360 dias).<br>	</td></tr>';
				echo '</table>';
				echo '<input type="hidden" name="destiny" value="'.$_POST['destiny'].'">';
				echo '<input type="hidden" name="form" value="'.$_POST['form'].'">';		
				echo '<br><center><input type="image" value="submit" src="images/continue.gif"/> <a href="main.php?subtopic=payments"><img src="images/back.gif" border="0"></a>';	
				echo '</form>';		
			}
		}
		elseif($_POST['form'] == "paypal")
		{
			if($_POST['destiny'] == "me")
			{
				echo '<tr><td class=newbar><center><b>:: Contribute Step 3 ::</td></tr>
				<tr><td class=newtext>';

				echo '<br><center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">';
				echo 'Entre com a senha de sua conta, ela é necesaria para a autenticação. Depois selecione o modo de ativação, e por fim, selecione a duração de sua contribuição e clique no botão "Continue".';
				echo '</table>';	
				
				echo '<br><form method="post" action="main.php?subtopic=payments&step=5">';
				echo '<br><center><table width="90%" border="0" cellpadding="4" cellspacing="1">';
				echo '<tr class="rank2"><td colspan="2"><b>Informações da Contribuição</td></tr>';
				echo '<tr class="rank1" width="25%"><td><b>Password</td><td><input name="pass" type="password" value="" class="login"/></td></tr>';	
				echo '<tr class="rank1"><td><b>Activation Mode</td><td><select name="activation"><option value="0">Normal</option></select></td></tr>';	
				echo '<tr class="rank1"><td><b>Duration</td><td>
				<input type="radio" name="duration" value="30" style="border: 0;" /> <b>7.90 USD</b> Contribute for one month (30 days).<br>
				<input type="radio" name="duration" value="60" style="border: 0;" /> <b>15.80 USD</b> Contribute for two months (60 days).<br>
				<input type="radio" name="duration" value="90" style="border: 0;" /> <b>23.70 USD</b> Contribute for three months (90 days).<br>
				<input type="radio" name="duration" value="180" style="border: 0;" /> <b>35.90 USD</b> Contribute for six months (180 days).<br>
				<input type="radio" name="duration" value="360" style="border: 0;" /> <b>62.90 USD</b> Contribute for one year (360 days).<br>		</td></tr>';	
				echo '</table>';		
				echo '<input type="hidden" name="destiny" value="'.$_POST['destiny'].'">';	
				echo '<input type="hidden" name="form" value="'.$_POST['form'].'">';	
				echo '<br><center><input type="image" value="submit" src="images/continue.gif"/> <a href="main.php?subtopic=payments"><img src="images/back.gif" border="0"></a>';	
				echo '</form>';
			}
			elseif($_POST['destiny'] == "other")
			{
				echo '<tr><td class=newbar><center><b>:: Contribute Step 2 ::</td></tr>
				<tr><td class=newtext>';

				echo '<br><center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">';
				echo 'Preencha abaixo o seu nome real e um comentario, estes dados irão aparecer ao dono da conta quando esta premium account for ser ativada. Então selecione a duração que você desejar e clique em "Continue".';
				echo '</table>';	
				
				echo '<br><form method="post" action="main.php?subtopic=payments&step=5">';
				echo '<br><center><table width="90%" border="0" cellpadding="4" cellspacing="1">';
				echo '<tr class="rank2"><td colspan="2"><b>Informações da Contribuição</td></tr>';
				echo '<tr class="rank1" width="25%"><td><b>Nome Real</td><td><input name="rl_name" type="text" SIZE=30 MAXLENGTH=50/> <br><font size=1>(seu nome real)</td></tr>';	
				echo '<tr class="rank1" width="25%"><td><b>Comentario</td><td><input name="comment" type="text"  SIZE=45 MAXLENGTH=200/> <br><font size=1>(escreva aqui seu comentario)</td></tr>';	
				echo '<tr class="rank1"><td><b>Nome do Personagem</td><td><input name="name" type="text" value=""/> <br><font size=1>(nome do personagem que deve receber a premium account)</td></tr>';	
				echo '<tr class="rank1"><td><b>Duration</td><td>
				<input type="radio" name="duration" value="30" style="border: 0;" /> <b>7.90 USD</b> Contribute for one month (30 days).<br>
				<input type="radio" name="duration" value="60" style="border: 0;" /> <b>15.80 USD</b> Contribute for two months (60 days).<br>
				<input type="radio" name="duration" value="90" style="border: 0;" /> <b>23.70 USD</b> Contribute for three months (90 days).<br>
				<input type="radio" name="duration" value="180" style="border: 0;" /> <b>35.90 USD</b> Contribute for six months (180 days).<br>
				<input type="radio" name="duration" value="360" style="border: 0;" /> <b>62.90 USD</b> Contribute for one year (360 days).<br>		</td></tr>';					echo '</table>';
				echo '<input type="hidden" name="destiny" value="'.$_POST['destiny'].'">';	
				echo '<input type="hidden" name="form" value="'.$_POST['form'].'">';		
				echo '<br><center><input type="image" value="submit" src="images/continue.gif"/> <a href="main.php?subtopic=payments"><img src="images/back.gif" border="0"></a>';	
				echo '</form>';		
			}		
		}
	}
	elseif($_GET['step'] == '5')
	{
		if ($_SERVER['REQUEST_METHOD'] == "POST")
		{
			echo '<tr><td class=newbar><center><b>:: Contribute Step 3 ::</td></tr>
			<tr><td class=newtext>';		
			
			if($_POST['destiny'] == "me")
			{
				if(filtreString(md5($_POST['pass']),1) == 0)
				{
					$condition = 'Error';
					$conteudo = 'Character does not exist or uses syntaxes reserved.';		
					$error++;
				}			
				elseif(!Account::passCheck($account,md5($_POST['pass'])))
				{
					$condition = 'Error';
					$conteudo = 'This password is not correct.';
					$error++;
				}	
				
				$destiny = "Minha propria conta.";
			}
			else
			{
				if(filtreString($_POST['name'],1) == 0 or filtreString($_POST['rl_name'],1) == 0 or filtreString($_POST['comment'],1) == 0)
				{
					$condition = 'Error';
					$conteudo = 'Character does not exist or uses syntaxes reserved.';		
					$error++;
				}					
				elseif(Player::playerExists($_POST['name']) == 0)
				{
					$condition = 'Error';
					$conteudo = 'This character not exists.';
					$error++;			
				}
				elseif($_POST['rl_name'] == "" or $_POST['comment'] == "")
				{
					$condition = 'Error';
					$conteudo = 'Please, fill all the fields.';
					$error++;					
				}
				
				$destiny = "Conta do personagem ".$_POST['name']."";
			}
			
			if($error == 0)
			{
				if($_POST['form'] == "pagseguro")
				{				
					if($_POST['duration'] == 30)
					{
						$duration = '1 mes (30 dias)';
						$price = 'R$ 10,90';
						$priceValue = 1090;
					}	
					elseif($_POST['duration'] == 60)
					{
						$duration = '2 meses (60 dias)';
						$price = 'R$ 21,80';
						$priceValue = 2180;
					}					
					elseif($_POST['duration'] == 90)
					{
						$duration = '3 meses (90 dias)';
						$price = 'R$ 32,70';
						$priceValue = 3270;
					}	
					elseif($_POST['duration'] == 180)
					{
						$duration = '6 meses (180 dias)';
						$price = 'R$ 55,90';
						$priceValue = 5590;
					}		
					elseif($_POST['duration'] == 360)
					{
						$duration = '1 ano (360 dias)';
						$price = 'R$ 99,90';
						$priceValue = 9990;
					}						
				}
				elseif($_POST['form'] == "paypal")
				{
					if($_POST['duration'] == 30)
					{
						$duration = '1 month (30 days)';
						$price = '7.90 USD';
						$priceValue = "7.90";
					}	
					elseif($_POST['duration'] == 60)
					{
						$duration = '2 months (60 days)';
						$price = '14.80 USD';
						$priceValue = "14.80";
					}						
					elseif($_POST['duration'] == 90)
					{
						$duration = '3 months (90 days)';
						$price = '21.70 USD';
						$priceValue = "21.70";
					}	
					elseif($_POST['duration'] == 180)
					{
						$duration = '6 months (180 days)';
						$price = '35.90 USD';
						$priceValue = "35.90";
					}		
					elseif($_POST['duration'] == 360)
					{
						$duration = '1 year (360 days)';
						$price = '62.90 USD';
						$priceValue = "62.90";
					}						
				}				
				
				if($_POST['activation'] == 0 or $_POST['activation'] == null or $_POST['activation'] == "")
					$activation = 'Normal';
				else
					$activation = 'Instantânea';

				echo '<br><center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">';
				echo 'Leia atentamente os dados abaixos referentes a sua contribuição, caso tudo esteja correto, clique em "Confirm". Note que ao clicar no botão, o pagamento será processado imediatamente, portanto somente clique se tiver certeza que está tudo certo.';
				echo '</table>';	

				echo '<br><center><table width="90%" border="0" cellpadding="4" cellspacing="1">';
				echo '<tr class="rank2"><td colspan="2"><b>Resumo da Contribuição</td></tr>';
				echo '<tr class="rank1"><td>Destino: <b>'.$destiny.'</b>.<br>
				Tipo de ativação: <b>'.$activation.'</b>.<br>
				Duração: <b>'.$duration.'</b>.<br>
				Valor total: <b>'.$price.'</b>.
				</td></tr>';	
				echo '</table>';	
				
				if($_POST['form'] == "paypal")
				{
					echo '<form action="https://www.paypal.com/cgi-bin/webscr" method="post">';
					echo '<input type="hidden" name="cmd" value="_xclick">';
					echo '<input type="hidden" name="business" value="premium@darghos.com">';
					echo '<input type="hidden" name="no_shipping" value="0">';
					echo '<input type="hidden" name="no_note" value="1">';
					echo '<input type="hidden" name="currency_code" value="USD">';
					echo '<input type="hidden" name="item_name" value="'.$duration.'">';
					echo '<input type="hidden" name="amount" value="'.$priceValue.'">';
					if($_POST['destiny'] == "me")
						echo '<input type="hidden" name="on0" value="Por: '.$account.'">';
					else
						echo '<input type="hidden" name="on0" value="Por: '.$account.' para: '.$_POST['name'].'">';					
				}
				elseif($_POST['form'] == "pagseguro")
				{
					echo '<form target="pagseguro" action="https://pagseguro.uol.com.br/security/webpagamentos/webpagto.aspx" method="post">';
					echo '<input type="hidden" name="email_cobranca" value="premium@darghos.com">';
					echo '<input type="hidden" name="tipo" value="CP">';
					echo '<input type="hidden" name="moeda" value="BRL">';
					echo '<input type="hidden" name="item_id_1" value="1">';
					echo '<input type="hidden" name="item_descr_1" value="'.$duration.'">';
					echo '<input type="hidden" name="item_quant_1" value="1">';
					echo '<input type="hidden" name="item_valor_1" value="'.$priceValue.'">';
					echo '<input type="hidden" name="item_frete_1" value="000">';		
					if($_POST['destiny'] == "me")
						echo '<input type="hidden" name="ref_transacao" value="Por: '.$account.'">';
					else
						echo '<input type="hidden" name="ref_transacao" value="Por: '.$account.' para: '.$_POST['name'].'">';					
				}
				echo '<br><center><input type="image" value="submit" src="images/confirm.gif"/> <a href="main.php?subtopic=payments&step=1"><img src="images/back.gif" border="0"></a>';	
				echo '</form>';
			}
			else
			{
				echo '<br><center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
				echo '<tr><td class=rank2>'.$condition.'</td></tr>';
				echo '<tr><td class=rank1>'.$conteudo.'</td></tr>';
				echo '</table>';
				echo '<br><a href="main.php?subtopic=payments&step=1"><img src="'.$back_button.'" border="0"></a>';				
			}
		}
	}
	else
	{
		echo '<tr><td class=newbar><center><b>:: Contribute ::</td></tr>
		<tr><td class=newtext>';
		
		echo '<br><center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">';
		echo 'Aqui você pode contribuir com o Darghos. Quando você contribui, você recebe uma série de beneficios dentro e fora do jogo durante um periodo, para saber mais sobre os beneficios por favor visite a seção <a href="about.php?subtopic=featurespremium">vantagens premium</a>. <br><br>';
		echo '<br><font size=3><b>Preços</b></font>';
		echo '</table>';	
		
		echo '<center><table width="90%" border="0" cellpadding="4" cellspacing="1">';
		echo '<tr class="rank2"><td colspan="3"><b>Contribuições</td></tr>';
		echo '<tr class="rank1"><td><b>Duração</td><td width="45%"><b>PagSeguro</td><td width="25%"><b>PayPal</td></tr>';	
		echo '<tr class="rank3"><td>30 dias</td><td><del>R$ 19,90</del> <b>R$ 10,90</b> <font size=1>(R$ 0,39/dia)</font></td><td>7.90 USD</td></tr>';	
		echo '<tr class="rank1"><td>60 dias <font size="1" color=green><b>(novo!)</b></font></td><td>R$ 21,80 <font size=1>(R$ 0,39/dia)</font></td><td>15.80 USD</td></tr>';	
		echo '<tr class="rank3"><td>90 dias</td><td>R$ 32,70 <font size=1>(R$ 0,39/dia)</font></td><td>23.70 USD</td></tr>';	
		echo '<tr class="rank1"><td>180 dias</td><td><del>R$ 71,90</del> <b>R$ 55,90</b> <font size=1>(R$ 0,31/dia)</font></td><td>35.90 USD</td></tr>';	
		echo '<tr class="rank3"><td>360 dias <font size="1" color=green><b>(novo!)</b></font></td><td>R$ 99,90 <font size=1>(R$ 0,27/dia)</font></td><td>62.90 USD</td></tr>';	
		echo '</table>';
		
		echo '<br><center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">';
		echo '<font size=3><b>Metodos de Pagamentos</b></font>';
		echo '<br><br>Nós processamos os pagamentos ultilizando o PagSeguros, esta é uma conceituada, segura e tradicional empresa no setor de pagamentos virtuais a anos, note que a PagSeguro é parte integrande do grupo UOL (Universo Online). Abaixo segue uma pequena instrução de cada método de pagamento (caso ainda tenha duvidas, o PagSeguro tambem possui uma lista de instruções).';
		echo '<br><br><li><b>Boleto Bancário</b></li><br>';
		echo 'Este é o metodo mais simples, e não necessita de ter uma conta em banco. Você séra direcionado para o site do PagSeguro, aonde deve entrar com o sua conta do site deles. Caso você não possua uma conta no PagSeguro, você poderá criar uma na pagina direcionada deles, ou clicando aqui.<br>Então após completar seu pagamento, será gerado um boleto. É só imprimir-lo ou anotar a linha digitável e pagar em qualquer fila de caixa de banco ou lotérica (caixas eletronicos não são validos), ou ainda no site do seu banco. O pagamento será efetivado no proximo dia útil seguinte no metodo convencional.';
		echo '<br><br><li><b>Transferencia Eletronica</b> - validação do pagamento online (instantânea)</li><br>';
		echo 'Na tela "Formas de Pagamento" selecione o banco em que você tem conta corrente, e clique em "continuar". O valor total de sua compra aparecerá em uma tela de confirmação, clique em continuar e você será redirecionado ao site do banco escolhido para finalizar o pagamento. Após entrar no banco com seus dados e senhas, ao concluir o processo a validação e autorização dos pagamentos através dos bancos é on-line e instantânea, ou seja, é realizada e liberada em tempo real.';
		echo '<br><br><big><b><font color="red">Atenção:</font></b></big> Todo processo de contribuição deve ser feito seguindo rigorosamente as instruções do passo a passo (inclusive as instruções do site do PagSeguro). Nós não possuimos formas de pagamento convencionais, como <b><font color="red">deposito direto em conta</b></font>. O não cumprimento de qualquer etapa, ou qualquer tentativa de pagamento diferente das informadas acima resultará em <b><font color="red">não validação do pagamento</b></font>, <b><font color="red">sem opção de reembolso</b></font>. Em caso de qualquer sombra duvida entre em contato conosco ou solicite orientação de seu responsavel.';
		echo '<br><br>Caso você possua alguma duvida, ainda pode tentar exclarece-la em nosso <a href="about.php?subtopic=faq">FAQ</a> ou ainda em nosso email de suporte sobre duvidas em contribuições <a href="mailto:premium@darghos.com">premium@darghos.com</a>.';

		echo '<br><br>Caso você deseje prosseguir em sua contribuição, por favor clique em "Continue" para avançar ao proximo passo (login necessario).';
		
		if (!Account::isLogged($account,$password))
			echo '<br><br><a href="account.php?subtopic=login"><img src="images/login.gif" border="0"></a>';
		else		
		echo '<br><br><center><a href="main.php?subtopic=payments&step=1"><img src="images/continue.gif" border="0"></a>';
		echo '</table><br>';	
	}
}
	elseif ($_GET['subtopic'] == 'item_shop')
	{
		if(Account::isPremium($account))
		{	
			echo '<tr><td class=newbar><center><b>:: Item Shop List ::</td></tr>
			<tr><td class=newtext>';
			
			if ($_SERVER['REQUEST_METHOD'] == "POST")
			{
				$item_array = Shop::getItemShop($_POST['item_shop']);
				$item_price = $item_array['price'];	
				$item_name = $item_array['name'];
				
				if(filtreString(md5($_POST['pass']),1) == 0)
				{
					$condition = 'Error';
					$conteudo = 'Character does not exist or uses syntaxes reserved.';		
					$error++;
				}			
				elseif(!Account::passCheck($account,md5($_POST['pass'])))
				{
					$condition = 'Error';
					$conteudo = 'This password is not correct.';
					$error++;
				}
				elseif(Account::getType($account) > 2 and Account::getType($account) < 6)
				{
					$condition = 'Error';
					$conteudo = 'Illegal account type.';
					$error++;
				}				
				elseif($_POST['item_shop'] == "" or $_POST['item_shop'] == null)
				{
					$condition = 'Select!';
					$conteudo = 'Please, select a one item.';			
					$error++;
				}					
				elseif(Player::isOnline(Player::getPlayerNameById($_POST['player_id'])) == 1)
				{
					$condition = 'Character as loged in!';
					$conteudo = 'Please, log out you character to use item shop.';			
					$error++;
				}		
				elseif(Account::getPremDays($account) < $item_price)
				{
					$condition = 'Few days of Premium.';
					$conteudo = 'To receive a marked item you need '.$item_price.' days of premium account.';
					$error++;
				}
				elseif(!Shop::giveItemToDepot($_POST['item_shop'],$_POST['player_id'],$_POST['depot_id'],$account))
				{
					$condition = 'Depot não ativo.';
					$conteudo = 'O depot desta cidade não está ativo, para ativa-lo apenas entre em seu personagem e deixe ao menos um item neste depot.';
					$error++;
				}	
				else
				{
					Account::removePremium($item_price,$account);

					$condition = 'Compra concluida!';
					$conteudo = 'O item '.$item_name.' foi enviado ao depot da cidade de '.Tolls::getTown($_POST['depot_id']).' com sucesso!';			
				}			
				
				echo '<br><center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
				echo '<tr><td class=rank2>'.$condition.'</td></tr>';
				echo '<tr><td class=rank1>'.$conteudo.'</td></tr>';
				echo '</table>';						
			}
			
			echo '<br><center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">';
			echo 'Seja bem vindo ao Darghos Item Shop List, aqui você pode ver todos items disponiveis e sua descrição e preço. Marque todos itens que desejar, lembre-se que o valor sera somado de cada item, mais abaixo entre com a senha de sua conta, e selecione o personagem e o depot da cidade na qual os itens devem ser enviados e então clique em "Confirm" para concluir sua compra.';
			echo '</table>';
		
			echo '<form method="post" action="main.php?subtopic=item_shop">';
			echo '<br><center><table width="95%" border="0" cellpadding="4" cellspacing="1">';
			echo '<tr class="rank2"><td colspan="4"><b>Equipments</td></tr>';
			echo '<tr class="rank1"><td width="3%"></td><td width="20%"><b>Item</td><td width="25%"><b>Descrição</td><td width="10%"><b>premDays</td></tr>';
			
			echo '<tr class="rank3"><td><img src="images/items/haunted_blade.gif" border="0"></td><td><input type="radio" name="item_shop" value="1"> Haunted Blade</td><td>Atk: 40, Def: 12, Lvl: 30</td><td>5</td></tr>';
			echo '<tr class="rank3"><td><img src="images/items/orcish_maul.gif" border="0"></td><td><input type="radio" name="item_shop" value="2"> Orcish Maul</td><td>Atk: 42, Def: 18, Lvl: 35</td><td>5</td></tr>';
			echo '<tr class="rank3"><td><img src="images/items/headchopper.gif" border="0"></td><td><input type="radio" name="item_shop" value="3"> Headchopper</td><td>Atk: 42, Def: 20, Lvl: 35</td><td>5</td></tr>';	
			echo '<tr class="rank3"><td><img src="images/items/giant_sword.gif" border="0"></td><td><input type="radio" name="item_shop" value="4"> Giant Sword</td><td>Atk: 46, Def: 22, Lvl: 55</td><td>7</td></tr>';
			echo '<tr class="rank3"><td><img src="images/items/dragon_lance.gif" border="0"></td><td><input type="radio" name="item_shop" value="5"> Dragon Lance</td><td>Atk: 47, Def: 16, Lvl: 60</td><td>7</td></tr>';	
			
			echo '<tr class="rank3"><td><img src="images/items/blue_robe.gif" border="0"></td><td><input type="radio" name="item_shop" value="20"> Blue Robe</td><td>Arm: 11</td><td>4</td></tr>';
			echo '<tr class="rank3"><td><img src="images/items/golden_armor.gif" border="0"></td><td><input type="radio" name="item_shop" value="6"> Golden Armor</td><td>Arm: 14</td><td>8</td></tr>';
			echo '<tr class="rank3"><td><img src="images/items/dragon_scale_mail.gif" border="0"></td><td><input type="radio" name="item_shop" value="7"> Dragon Scale Mail</td><td>Arm: 15</td><td>15</td></tr>';	
			echo '<tr class="rank3"><td><img src="images/items/magic_plate_armor.gif" border="0"></td><td><input type="radio" name="item_shop" value="8"> Magic Plate Armor</td><td>Arm: 17</td><td>25</td></tr>';
			
			echo '<tr class="rank3"><td><img src="images/items/vampire_shield.gif" border="0"></td><td><input type="radio" name="item_shop" value="9"> Vampire Shield</td><td>Def: 34</td><td>5</td></tr>';
			echo '<tr class="rank3"><td><img src="images/items/demon_shield.gif" border="0"></td><td><input type="radio" name="item_shop" value="10"> Demon Shield</td><td>Def: 35</td><td>12</td></tr>';	
			echo '<tr class="rank3"><td><img src="images/items/mastermind_shield.gif" border="0"></td><td><input type="radio" name="item_shop" value="11"> Mastermind Shield</td><td>Def: 37</td><td>18</td></tr>';	
			
			echo '<tr class="rank3"><td><img src="images/items/crown_legs.gif" border="0"></td><td><input type="radio" name="crown_legs" value="12"> Crown Legs</td><td>Arm: 8</td><td>5</td></tr>';
			echo '<tr class="rank3"><td><img src="images/items/golden_legs.gif" border="0"></td><td><input type="radio" name="golden_legs" value="13"> Golden Legs</td><td>Arm: 9</td><td>15</td></tr>';	
			
			echo '<tr class="rank3"><td><img src="images/items/boots_of_haste.gif" border="0"></td><td><input type="radio" name="item_shop" value="14"> Boots of Haste</td><td>Faz andar mais rápidamente</td><td>10</td></tr>';		
			echo '<tr class="rank3"><td><img src="images/items/royal_helmet.gif" border="0"></td><td><input type="radio" name="item_shop" value="15"> Royal Helmet</td><td>Arm: 9</td><td>10</td></tr>';
			
			echo '<tr class="rank3"><td><img src="images/items/ring_of_healing.gif" border="0"></td><td><input type="radio" name="item_shop" value="16"> BP Ring of Healing</td><td>Recupera a Mana e Life mais rápidamente</td><td>10</td></tr>';
			echo '<tr class="rank3"><td><img src="images/items/stone_skin_amulet.gif" border="0"></td><td><input type="radio" name="item_shop" value="17"> BP Stone Skin Amulet</td><td>Absorve 80% dos danos recebidos</td><td>20</td></tr>';
			echo '<tr class="rank3"><td><img src="images/items/amulet_of_loss.gif" border="0"></td><td><input type="radio" name="item_shop" value="18"> Amulet of Loss</td><td>Não perca nenhum item ao morrer</td><td>10</td></tr>';
			
			echo '<tr class="rank3"><td><img src="images/items/infernal_bolt.gif" border="0"></td><td><input type="radio" name="item_shop" value="19"> 100 Infernal Bolt</td><td>Uma das mais poderosas munições do jogo</td><td>2</td></tr>';
			echo '<tr class="rank3"><td><img src="images/items/infernal_bolt.gif" border="0"></td><td><input type="radio" name="item_shop" value="21"> BP Infernal Bolts</td><td>BP de uma das mais poderosas munições do jogo</td><td>20</td></tr>';
			echo '<tr class="rank3"><td><img src="images/items/assassin_star.gif" border="0"></td><td><input type="radio" name="item_shop" value="38"> 100 Assassin Star\'s</td><td>Munição com dano extremamente alto</td><td>5</td></tr>';			
			
			echo '<tr class="rank3"><td><img src="images/items/platinum_coin.gif" border="0"></td><td><input type="radio" name="item_shop" value="22"> 5,000 gps</td><td>Compre o que quiser</td><td>1</td></tr>';
			echo '<tr class="rank3"><td><img src="images/items/crystal_coin.gif" border="0"></td><td><input type="radio" name="item_shop" value="23"> 50,000 gps</td><td>Compre o que quiser e um pouco mais</td><td>10</td></tr>';
			echo '<tr class="rank3"><td><img src="images/items/crystal_coin.gif" border="0"></td><td><input type="radio" name="item_shop" value="24"> 100,000 gps</td><td>Compre o que quiser e muito mais</td><td>15</td></tr>';
	
			echo '<tr class="rank3"><td><img src="images/items/sudden_death.gif" border="0"></td><td><input type="radio" name="item_shop" value="25"> BP 100x sudden death rune</td><td>Runa mais poderosa do game</td><td>20</td></tr>';
			echo '<tr class="rank3"><td><img src="images/items/ultimate_healing_rune.gif" border="0"></td><td><input type="radio" name="item_shop" value="26"> BP 100x ultimate healing rune</td><td>Runa com maior poder de regeneração</td><td>15</td></tr>';
			echo '<tr class="rank3"><td><img src="images/items/explosion.gif" border="0"></td><td><input type="radio" name="item_shop" value="27"> BP 100x explosion rune</td><td>Runa com um grande campo de dano</td><td>12</td></tr>';			
			//echo '<tr class="rank3"><td><img src="images/items/lottery_ticket.gif" border="0"></td><td><input type="radio" name="item_shop" value="28"> Teleport Scroll</td><td>Seja teleportado ao Templo a hora em que quiser. (1 carga)</td><td>3</td></tr>';	
	
			echo '</table>';
	
			echo '<br><center><table width="95%" border="0" cellpadding="4" cellspacing="1">';
			echo '<tr class="rank2"><td colspan="4"><b>Items nescessarios para addons</td></tr>';
			echo '<tr class="rank1"><td width="3%"></td><td width="20%"><b>Item</td><td width="25%"><b>Descrição</td><td width="10%"><b>premDays</td></tr>';
			
			echo '<tr class="rank3"><td><img src="images/items/iron_ore.gif" border="0"></td><td><input type="radio" name="item_shop" value="29"> 5x Iron Ore\'s</td><td>Item muito raro, necessario para addon quest.</td><td>5</td></tr>';	
			echo '<tr class="rank3"><td><img src="images/items/ape_fur.gif" border="0"></td><td><input type="radio" name="item_shop" value="30"> 5x Ape Fur\'s</td><td>Item muito raro, necessario para addon quest.</td><td>7</td></tr>';	
			echo '<tr class="rank3"><td><img src="images/items/vampire_dust.gif" border="0"></td><td><input type="radio" name="item_shop" value="31"> 5x Vampires Dust\'s</td><td>Item muito raro, necessario para addon quest.</td><td>10</td></tr>';	
			echo '<tr class="rank3"><td><img src="images/items/demon_dust.gif" border="0"></td><td><input type="radio" name="item_shop" value="32"> 5x Demons Dust\'s</td><td>Item muito raro, necessario para addon quest.</td><td>10</td></tr>';	
			echo '<tr class="rank3"><td><img src="images/items/spool_of_yarn.gif" border="0"></td><td><input type="radio" name="item_shop" value="33"> 1x Spool of Yarn</td><td>Item muito raro, necessario para addon quest.</td><td>10</td></tr>';	
			echo '<tr class="rank3"><td><img src="images/items/piece_of_royal_steel.gif" border="0"></td><td><input type="radio" name="item_shop" value="39"> 1x Royal Steel</td><td>Item muito raro, necessario para addon quest.</td><td>10</td></tr>';	
			echo '<tr class="rank3"><td><img src="images/items/giant_spider_silk.gif" border="0"></td><td><input type="radio" name="item_shop" value="34"> 10x Giant Spider Silk</td><td>Item muito raro, necessario para addon quest.</td><td>5</td></tr>';	
			echo '<tr class="rank3"><td><img src="images/items/minotaur_leather.gif" border="0"></td><td><input type="radio" name="item_shop" value="35"> 100x Minotaur Leather\'s</td><td>Item muito raro, necessario para addon quest.</td><td>5</td></tr>';	
			echo '<tr class="rank3"><td><img src="images/items/chicken_feather.gif" border="0"></td><td><input type="radio" name="item_shop" value="36"> 100x Chicken Feather\'s</td><td>Item muito raro, necessario para addon quest.</td><td>12</td></tr>';	
			echo '<tr class="rank3"><td><img src="images/items/honeycomb.gif" border="0"></td><td><input type="radio" name="item_shop" value="37"> 50x Honeycombs</td><td>Item muito raro, necessario para addon quest.</td><td>3</td></tr>';	
			echo '<tr class="rank3"><td><img src="images/items/Blue_Piece.gif" border="0"></td><td><input type="radio" name="item_shop" value="45"> 50x Blue Piece of Cloth</td><td>Item muito raro, necessario para addon quest.</td><td>15</td></tr>';
			echo '<tr class="rank3"><td><img src="images/items/Green_Piece.gif" border="0"></td><td><input type="radio" name="item_shop" value="44"> 50x Green Piece of Cloth</td><td>Item muito raro, necessario para addon quest.</td><td>15</td></tr>';			
			echo '<tr class="rank3"><td><img src="images/items/White_Piece.gif" border="0"></td><td><input type="radio" name="item_shop" value="40"> 50x White Piece of Cloth</td><td>Item muito raro, necessario para addon quest.</td><td>15</td></tr>';			
			echo '<tr class="rank3"><td><img src="images/items/Yellow_Piece.gif" border="0"></td><td><input type="radio" name="item_shop" value="41"> 50x Yellow Piece of Cloth</td><td>Item muito raro, necessario para addon quest.</td><td>15</td></tr>';
			echo '<tr class="rank3"><td><img src="images/items/Red_Piece.gif" border="0"></td><td><input type="radio" name="item_shop" value="42"> 50x Red Piece of Cloth</td><td>Item muito raro, necessario para addon quest.</td><td>15</td></tr>';			
			echo '<tr class="rank3"><td><img src="images/items/Brown_Piece.gif" border="0"></td><td><input type="radio" name="item_shop" value="43"> 50x Brown Piece of Cloth</td><td>Item muito raro, necessario para addon quest.</td><td>15</td></tr>';
			echo '<tr class="rank3"><td><img src="images/items/Hell_Steel.gif" border="0"></td><td><input type="radio" name="item_shop" value="46"> 1 Piece of Hell Steel</td><td>Item muito raro, necessario para addon quest.</td><td>30</td></tr>';
			echo '<tr class="rank3"><td><img src="images/items/Mandrake.gif" border="0"></td><td><input type="radio" name="item_shop" value="47"> 1 Mandrake</td><td>Item muito raro, necessario para addon quest.</td><td>40</td></tr>';
			echo '<tr class="rank3"><td><img src="images/items/Huge_Chunk.gif" border="0"></td><td><input type="radio" name="item_shop" value="48"> 1 Huge Chunk of Crude Iron</td><td>Item muito raro, necessario para addon quest.</td><td>30</td></tr>';
			echo '<tr class="rank3"><td><img src="images/items/Piece_of_Draconian.gif" border="0"></td><td><input type="radio" name="item_shop" value="49"> 1 Piece of Draconian Steel</td><td>Item muito raro, necessario para addon quest.</td><td>30</td></tr>';
			echo '<tr class="rank3"><td><img src="images/items/Voodoo1.gif" border="0"></td><td><input type="radio" name="item_shop" value="51"> 1 Dworc Voodoo Doll</td><td>Item muito raro, necessario para addon quest.</td><td>5</td></tr>';
			echo '<tr class="rank3"><td><img src="images/items/Shard.gif" border="0"></td><td><input type="radio" name="item_shop" value="50"> 1 Shard</td><td>Item muito raro, necessario para addon quest.</td><td>3</td></tr>';
			echo '<tr class="rank3"><td><img src="images/items/Banana_Staff.gif" border="0"></td><td><input type="radio" name="item_shop" value="52"> 1 Banana Staff</td><td>Item muito raro, necessario para addon quest.</td><td>5</td></tr>';
			echo '<tr class="rank3"><td><img src="images/items/Tribal_Mask.gif" border="0"></td><td><input type="radio" name="item_shop" value="53"> 1 Tribal Mask</td><td>Item muito raro, necessario para addon quest.</td><td>5</td></tr>';
			echo '<tr class="rank3"><td><img src="images/items/Simon.gif" border="0"></td><td><input type="radio" name="item_shop" value="54"> 1 Simon the Beggars Favorite Staff</td><td>Item muito raro, necessario para addon quest.</td><td>40</td></tr>';
			echo '<tr class="rank3"><td><img src="images/items/Holy_Orchid.gif" border="0"></td><td><input type="radio" name="item_shop" value="55"> 10x Holy Orchid</td><td>Item muito raro, necessario para addon quest.</td><td>10</td></tr>';
			echo '<tr class="rank3"><td><img src="images/items/Hook.gif" border="0"></td><td><input type="radio" name="item_shop" value="56"> 10x Hook</td><td>Item muito raro, necessario para addon quest.</td><td>10</td></tr>';
			echo '<tr class="rank3"><td><img src="images/items/Peg_Leg.gif" border="0"></td><td><input type="radio" name="item_shop" value="57"> 10x Peg Leg</td><td>Item muito raro, necessario para addon quest.</td><td>10</td></tr>';
			echo '<tr class="rank3"><td><img src="images/items/Eye_Patch.gif" border="0"></td><td><input type="radio" name="item_shop" value="58"> 10x Eye Patch</td><td>Item muito raro, necessario para addon quest.</td><td>10</td></tr>';
			echo '<tr class="rank3"><td><img src="images/items/Crossbow.gif" border="0"></td><td><input type="radio" name="item_shop" value="59"> 1 Elanes Crossbow (Engraved Crossbow)</td><td>Item muito raro, necessario para addon quest.</td><td>40</td></tr>';
			echo '<tr class="rank3"><td><img src="images/items/Turtle_Shell.gif" border="0"></td><td><input type="radio" name="item_shop" value="62"> 100 Turtle Shells</td><td>Item muito raro, necessario para addon quest.</td><td>30</td></tr>';
			
			echo '<br><center><table width="95%" border="0" cellpadding="4" cellspacing="1">';
			echo '<tr class="rank2"><td colspan="4"><b>Pacote de Addons</td></tr>';
			echo '<tr class="rank1"><td width="3%"></td><td width="20%"><b>Item</td><td width="25%"><b>Descrição</td><td width="10%"><b>premDays</td></tr>';

			echo '<tr class="rank3"><td><img src="images/items/nightmare1.gif" border="0"></td><td><input type="radio" name="item_shop" value="60"> First Nightmare Addon</td><td>Dando Use neste item você irá obter o primeiro addon do outfit Nightmare.</td><td>40</td></tr>';
			echo '<tr class="rank3"><td><img src="images/items/nightmare2.gif" border="0"></td><td><input type="radio" name="item_shop" value="61"> Second Nightmare Addon</td><td>Dando Use neste item você irá obter o segundo addon do outfit Nightmare.</td><td>40</td></tr>';
			
			
			echo '</table>';
	
			echo '<br><center><table width="70%" border="0" cellpadding="4" cellspacing="1">';
			echo '<tr class="rank2"><td colspan="2">Informações do Personagem</td></td></tr>';
			echo '<tr class="rank1"><td width="15%">Password</td><td><input name="pass" type="password" value="" class="login"/><br><font size=1>(Confirme sua senha por segurança)</td></tr>';
			echo '<tr class="rank1"><td>Personagem</td><td><select name="player_id">';
			
			$query = mysql_query("SELECT * FROM `players` WHERE (`account_id` = '$account')");	
			while($fetch = mysql_fetch_object($query))
				echo '<option value="'.$fetch->id.'">'.$fetch->name.'</option>';	
				
			echo '</select><br><font size=1>(Personagem que deve receber os itens)</td></tr>';
			echo '<tr class="rank1"><td>Depot City</td><td><select name="depot_id"><option value="0">(choose city)</option><option value="1">Quendor</option><option value="4">Thorn</option><option value="2">Aracura</option></select><br><font size=1>(Depot da cidade que deve ser enviado os itens)</td></tr>';
			echo '</table>';
			echo '<br><center><input type="image" value="submit" src="images/confirm.gif"/> <a href="account.php?subtopic=main"><img src="images/back.gif" border="0"></a>';			
			echo '</form>';	
		}	
	}
	elseif ($_GET['subtopic'] == 'getPremiumTest')
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
			echo '<br><a href="account.php?subtopic=main"><img src="'.$back_button.'" border="0"></a>';					
		}
		else
		{
			echo '<br><center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">';
			echo 'Confirm bellow your account password to receive the premium test period.
			</table><br>';
			echo '<form action="main.php?subtopic=getPremiumTest" method=post  ENCTYPE="multipart/form-data">';
			echo '<center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
			echo '<tr class=rank2><td colspan=2>Confirm your password: </td></tr>';		
			echo '<tr><td width="25%" class=rank1>Password:</td><td width="75%" class=rank1><input name="pass" type="password" value="" class="login"/></td></tr>';
			echo '</table><br>';
			echo '<input type="image" value="submit" src="images/confirm.gif"/> <a href="account.php?subtopic=main"><img src="'.$back_button.'" border="0"></a>';
			echo '</form>';	
		}	
	}	
	elseif ($_GET['subtopic'] == 'getTutor')
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
				echo '<br><a href="account.php?subtopic=main"><img src="'.$back_button.'" border="0"></a>';					
			}
			else
			{
				echo '<br><center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">';
				echo 'Bem vindo a seção para se tornar um Tutor no Darghos, como se sabe, o papel de um Tutor no jogo é extremamente importante para manter a ordem e dar suporte, por isso, somente pessoas realmente interessadas em ajudar poderão participar de tal cargo. Com isso, a promoção a Tutor custa 15 premium days, caso esteja enteressado em ajudar preencha os campos abaixo para confirmar.
				</table><br>';
				echo '<form action="main.php?subtopic=getTutor" method=post  ENCTYPE="multipart/form-data">';
				echo '<center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
				echo '<tr class=rank2><td colspan=2>Promover a Tutor </td></tr>';	
				echo '<tr class="rank1"><td>Personagem a ser promovido</td><td><select name="player_id">';	
				$query = mysql_query("SELECT * FROM `players` WHERE (`account_id` = '$account')");	
				while($fetch = mysql_fetch_object($query))
					echo '<option value="'.$fetch->id.'">'.$fetch->name.'</option>';	
				echo'</select></td></tr>';			
				echo '<tr><td width="s25%" class=rank1>Password:</td><td width="75%" class=rank1><input name="pass" type="password" value="" class="login"/></td></tr>';
				echo '</table><br>';
				echo '<input type="image" value="submit" src="images/confirm.gif"/> <a href="account.php?subtopic=main"><img src="'.$back_button.'" border="0"></a>';
				echo '</form>';	
			}	
		}	
	}
	elseif($_GET['subtopic'] == 'voteUs')
	{
		echo '<tr><td class=newbar><center><b>:: Vote em Nós ::</td></tr>
		<tr><td class=newtext><center><br>';
	
		if ($_SERVER['REQUEST_METHOD'] == "POST")
		{
			$query = mysql_query("SELECT votes, lastVote FROM accounts WHERE id = ".$account."");
			$fetch = mysql_fetch_object($query);
			
			$erros = 0;
			if(!Account::passCheck($account,md5($_POST['pass'])))
			{
				$condition = 'Error';
				$conteudo = 'This password is not correct.';
				$erros++;
			}
			elseif($fetch->lastVote + 60 * 60 * 12 > time())
			{
				$condition = 'Error';
				$conteudo = 'You already voted in the last 12 hours.';
				$erros++;			
			}
			elseif($erros == 0)
			{
				$condition = 'Confirmation';
				$conteudo = 'Para confirmar seu voto clique <a href="http://www.xtremetop100.com/in.php?site=1132241750">aqui</a>';	

				mysql_query("UPDATE accounts SET votes = votes + 1, lastVote = ".time()." WHERE id = ".$account."") or die(mysql_error());			
			}	
			
			echo '<center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
			echo '<tr><td class=rank2>'.$condition.'</td></tr>';
			echo '<tr><td class=rank1>'.$conteudo.'</td></tr>';
			echo '</table>';
			
			if($erros != 0)
				echo '<br><a href="main.php?subtopic=voteUs"><img src="'.$back_button.'" border="0"></a>';			
		}
		else
		{
			echo '<center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">
			Bem vindos a seção de Votos do Darghos! Aqui você pode votar em nosso servidor do jogo World of Warcraft e ganhar "reward points" em sua account que poderão ser trocados por muitos premios!<br><br>
			Alem dos premios você ajuda a levar o nome do Darghos a comunidades de outros servidores privados alem do Open Tibia! Lembrando que só é permitido votar a cada 12 horas.<br><br>
			Para votar basta preencher os campos abaixo com os dados de sua account para ser direcionado ao site para confirmar seu voto e ser computado os reward points, note que isto só deve aparecer se não houve um voto nas ultimas 12 horas.
			</table>';

			$query = mysql_query("SELECT votes, lastVote FROM accounts WHERE id = ".$account."");
			$fetch = mysql_fetch_object($query);
			
			if($fetch->votes >= 1)
			{
				echo '<form action="main.php?subtopic=getReward" method="post"  ENCTYPE="multipart/form-data">';
				echo '<br><center><table width="80%" BORDER="0" CELLSPACING="1" CELLPADDING="4">
				<tr><td class=rank2 colspan=2>Premios disponiveis</td></tr>';
				echo '<tr class="rank1"><td width="40%"><b>Premio</td><td><b>Reward points necessarios</td></tr>';					
				echo '<tr class="rank1"><td><input type="radio" name="reward" value="1"> 5 premium days</td><td>20 points</td></tr>';	
				echo '<table><br>';	
				echo '</center><input type="image" value="submit" src="images/submit.gif"/>';
				echo '</form>';
			}
			
			echo '<br><center><table width="60%" BORDER="0" CELLSPACING="1" CELLPADDING="4">
			<tr><td class=rank2>Votos</td></tr>';		
			echo '<tr class=rank1><td>Reward Points: <b>'.$fetch->votes.'</b></td></tr>';		
			echo '</table>';
		}		

	}	
	elseif($_GET['subtopic'] == 'getReward')
	{
		echo '<tr><td class=newbar><center><b>:: Premios ::</td></tr>
		<tr><td class=newtext><center><br>';
	
		if ($_SERVER['REQUEST_METHOD'] == "POST")
		{
			$query = mysql_query("SELECT votes, lastVote FROM accounts WHERE id = ".$account."");
			$fetch = mysql_fetch_object($query);
			
			$reward = Shop::getRewardById($_POST['reward']);
			
			if($reward[2] > $fetch->votes)
			{
				$condition = 'Erro';
				$conteudo = 'Você necessita de '.$reward[2].' reward points para obter este premio.';
				$erros++;			
			}
			elseif($erros == 0)
			{
				$condition = 'Sucesso!';
				$conteudo = 'Parabens, você acaba de trocar '.$reward[2].' reward points por '.$reward[0].'!';	

				$newvotes = $fetch->votes - $reward[2];
				if(!$newvotes > 0)
					$newvotes = 0;
					
				mysql_query("UPDATE accounts SET premdays = premdays + ".$reward[1].", votes = $newvotes WHERE id = ".$account."") or die(mysql_error());			
			}	
			
			echo '<center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
			echo '<tr><td class=rank2>'.$condition.'</td></tr>';
			echo '<tr><td class=rank1>'.$conteudo.'</td></tr>';
			echo '</table>';
			
			echo '<br><a href="main.php?subtopic=voteUs"><img src="'.$back_button.'" border="0"></a>';			
		}
	}	
	elseif($_GET['subtopic'] == 'duplied_name')
	{

		echo '<tr><td class=newbar><center><b>:: Nomes Duplicado ::</td></tr>';
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
			elseif(!Player::dupliedName($_POST['name']))
			{
				$condition = 'Erro!';
				$conteudo = 'Este personagem não necessita de mudança de nome.';		
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
			elseif(Player::isOnline($_POST['name']) == 1)
			{
				$condition = 'Player is loged in!';
				$conteudo = 'Please, log out you character to make a change sex.';
				$error++;
			}			
			elseif($error == 0)
			{
				$agendamento = Player::changeDupliedName($_POST['name'],$_POST['new_name']);
				$condition = 'Your name has been changed successfully.';
				$conteudo = 'A name of character '.$_POST['name'].' has been changed to '.$_POST['new_name'].' successfully!';				
			}
			
			echo '<center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
			echo '<tr><td class=rank2>'.$condition.'</td></tr>';
			echo '</table>';
			echo '<center><table border="0" width="95%" bgcolor="black" CELLSPACING="1" CELLPADDING="2">';
			echo '<tr><td class=rank1>'.$conteudo.'</td></tr>';
			echo '</table>';
			echo '<br><a href="account.php?subtopic=main"><img src="'.$back_button.'" border="0"></a>';					
		}
		else
		{
			echo '<center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">';
			echo 'Esta ferramenta foi desenvolvida para você ex-jogador do Extreme e foi transferido para o Darghos porem devido ao nome do seu personagem já estar em uso no Darghos é necessario uma troca de nome (gratuita).';
			echo '</table><br>';
			echo '<form action="main.php?subtopic=duplied_name" method=post  ENCTYPE="multipart/form-data">';
			echo '<center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
			echo '<tr class=rank2><td colspan=2>Mudança de Nome </td></tr>';		
			echo '<tr><td width="25%" class=rank1>Personagem:</td><td width="75%" class=rank1><input name="name" type="text" value="" class="login"/></td></tr>';
			echo '<tr><td width="25%" class=rank1>Novo Nome:</td><td width="75%" class=rank1><input name="new_name" type="text" value="" class="login"/></td></tr>';
			echo '<tr><td width="25%" class=rank1>Senha:</td><td width="75%" class=rank1><input name="pass" type="password" value="" class="login"/></td></tr>';
			echo '</table><br>';
			echo '<input type="image" value="submit" src="images/submit.gif"/> <a href="account.php?subtopic=main"><img src="'.$back_button.'" border="0"></a>';
			echo '</form>';				
		}				
	}	
}
else
{
			echo '<tr><td class=newbar><center><b>:: Login ::</td></tr>
			<tr><td class=newtext>';
		echo '<center><table width="95%"BORDER="0" CELLSPACING="1" CELLPADDING="4">
			<tr><td class="rank2">Login Necessario</td></tr>
			<tr><td class=rank1>Para acessar está pagina é necessario que você esteja logado em sua account, redirecionando para pagina de login...
			</table>
			<META HTTP-EQUIV="Refresh"
CONTENT="3; URL=account.php?subtopic=login">';
}
include "footer.php"; ?>