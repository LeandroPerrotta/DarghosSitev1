<?
if($engine->loggedIn())
{
	echo '
	<tr><td class=newbar><center><b>:: Mudan�a de E-mail ::</td></tr>
	<tr><td class=newtext><br>';
		
	if ($_SERVER['REQUEST_METHOD'] == "POST")
	{
		$account = $engine->loadClass('Accounts');
		$account->loadByNumber($_SESSION['account']);
		
		$checkEmail = $engine->loadClass('Accounts');
		
		$success = false;
		
		if($_SESSION['password'] != $engine->encrypt($_POST['password']))
		{
			$condition['title'] = 'Confirma��o de senha incorreta';
			$condition['details'] = "Para agendar uma mudan�a de e-mail � necessario confirmar sua senha corretamente por motivos de seguran�a.";		
		}			
		elseif(!$engine->filtreString($_POST['email']))
		{
			$condition['title'] = 'Sintaxes reservadas';
			$condition['details'] = "O seu formulario contem o uso de sintaxes reservadas ao sistema interno. Por favor tente novamente com outros valores.";
		}
		elseif(!$engine->isEmailFormat($_POST['email']))
		{
			$condition['title'] = "E-mail invalido!";
			$condition['details'] = "Este n�o � um endere�o de e-mail valido, por favor, tente novamente com outro endere�o e-mail.";
		}			
		elseif($checkEmail->loadByEmail($_POST['email']))
		{
			$condition['title'] = 'E-mail j� em uso';
			$condition['details'] = "J� existe uma conta registrada com este e-mail em nosso banco de dados, por favor tente novamente ultilizando outro e-mail.";
		}
		elseif($account->loadEmailChanger())
		{
			$condition['title'] = 'Mudan�a de email j� existente';
			$condition['details'] = "Esta conta j� possui uma mudan�a de e-mail agendada. Somente � possivel agendar uma mudan�a de e-mail por vez.";
		}
		else
		{	
			//variavel responsavel pelo conteudo do email		
			$body = 
'Caro jogador,
A solicita��o de agentamento para mudan�a do e-mail registrado em sua conta para '.$_POST['email'].' foi efetuada com exito!
Est� mudan�a ser� concluida em '.SCHEDULER_EMAILCHANGER.' dias.

Se voc� n�o solicitou est� mudan�a voc� pode a cancelar a qualquer momento acessando sua conta em nosso website.
'.GLOBAL_URL.'/index.php?page=account.login
			
Nos vemos no Darghos!
Equipe UltraxSoft.'; 
	
			if (!mailex($account->getData('email'), 'Agendamento de mudan�a de e-mail.', $body))
			{		
				$condition['title'] = "Falha ao enviar email!";
				$condition['details'] = "Ouve uma falha em nosso servidor de emails que impossibilitou o envio do seu email. A ultima opera��o foi anulada. Tente novamente mais tarde.";		
			}
			else
			{
				$success = true;
				
				$account->schedulerNewEmailIn($_POST['email'], time() + 60 * 60 * 24 * SCHEDULER_EMAILCHANGER);
				
				$condition['title'] = 'Agendamento efetuado com sucesso!';
				$condition['details'] = 'Foi solicitado uma agendamento de mudan�a do email registrado em sua conta para '.$_POST['email'].' com sucesso! <br><br>Um e-mail contendo maiores informa��es sobre esta mudan�a foi enviado ao e-mail registrado em sua conta atualmente.';				
			}										
		}

		echo '<center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
		echo '<tr><td class=rank2>'.$condition['title'].'</td></tr>';
		echo '<tr><td class=rank3>'.$condition['details'].'';
		echo '</table><br>';

		if($success)
			echo '<a href="?page=account.main"><img src="images/back.gif" border="0"></a>';	
		else
			echo '<a href="?page=account.changeEmail"><img src="images/back.gif" border="0"></a>';			
	}
	else
	{
		echo '
		<center>
		<table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">
		Atrav�s destes recurso voc� pode modificar o e-mail registrado em sua conta para um novo e-mail. Este recurso � �til por exemplo em caso de perda de acesso ao email registrado no momento. Por motivos de seguran�a esta mudan�a � agendada para ser efetuada em '.SCHEDULER_EMAILCHANGER.' dias.<br><br>
		Voc� ainda pode modificar o e-mail registrado em sua conta instantaneamente caso voc� seja um contribuinte e possua uma recovery key pela interface de recupera��o de contas.	
		</table>
		<br>
		
		<form method="POST" action="?page=account.changeEmail">
		<table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">
			<tr>
				<td class="rank2" colspan="2">Agendamento de mudan�a de E-mail</td>
			</tr>
			<tr>
				<td class="rank3" width="25%">Novo e-mail:</td>
				<td class="rank3" width="75%"><input name="email" type="text" value="" class="login" size="30"/></td>
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
?>	