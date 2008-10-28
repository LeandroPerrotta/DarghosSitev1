<?
if($_GET["step"] == "5")
{
	$player = $engine->loadClass('Players');
	$player->loadByName($_SESSION['lostInterface']['character']);
	
	$account = $engine->loadClass('Accounts');
	$account->loadByNumber($player->getData("account_id"), array("email","questionTries","lastQuestionTries"));	
	
	$checkEmail = $engine->loadClass('Accounts');
	
	$success = false;
	
	$questions = $account->loadQuestions();
	$i = 0;
	$incorrets = 0;

	foreach($questions as $question)
	{
		$i++;
		
		if($question['answer'] != $_POST['answer_'.$i.''])
			$incorrets++;
	}	
	
	$questionTries = $account->getData('questionTries');	
	$lastQuestionTries = $account->getData('lastQuestionTries');	
	
	if($questionTries == 3 AND $account->getData('lastQuestionTries') + SUSPEND_QUESTION_TIME < time())
		$questionTries = 0;

	if($questionTries == 3)
	{
		$condition['title'] = 'Recurso bloqueado!';
		$condition['details'] = "Está conta recebeu três erros nas respostas secretas e por motivos de segurança este recurso foi bloqueado para está conta pelas proximas 24 horas.";				
	}
	elseif($incorrets != 0 AND $questionTries < 3)
	{
		$questionTries++;
		$lastQuestionTries = time(); 
		
		if($questionTries == 3)
		{
			$condition['title'] = 'Recurso bloqueado!';
			$condition['details'] = "Está conta recebeu três erros nas respostas secretas e por motivos de segurança este recurso foi bloqueado para está conta pelas proximas 24 horas.";				
		}
		else
		{
			$condition['title'] = 'Resposta incorreta';
			$condition['details'] = "Uma ou mais de suas respostas estão incorretas. Este recurso será bloqueado por 24h caso você torne a errar as respostas mais ".(USE_QUESTION_TRIES - $questionTries)." vez(es).";				
		}
	}
	else
	{
		$success = true;
		$questionTries = 0;
		$account->ereaseQuestions();
		
		$condition['title'] = 'Perguntas e Respostas removidas com sucesso!';
		$condition['details'] = "Todas as perguntas e respostas configuradas em sua conta foram removidas com sucesso! Para registrar novas perguntas e respostas agora basta acessar sua conta e clicar no botão \"Set Questions\" localizado abaixo das informações de segurança de sua conta.";			
	}
	
	$account->setData('lastQuestionTries', $lastQuestionTries);
	$account->setData('questionTries', $questionTries);
	$account->update(array('questionTries','lastQuestionTries'));

	echo '<br><center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">
	<tr><td class=rank2>'.$condition['title'].'</td></tr>
	<tr><td class=rank3>'.$condition['details'].'
	</table><br>';
	
	if($success)
		echo '<a href="?page=account.login"><img src="images/back.gif" border="0"></a>';	
	else
		echo '<a href="?page=lostInterface"><img src="images/back.gif" border="0"></a>';			
}
elseif($_GET["step"] == "4")
{
	$player = $engine->loadClass('Players');
	$player->loadByName($_SESSION['lostInterface']['character']);
	
	$account = $engine->loadClass('Accounts');
	$account->loadByNumber($player->getData("account_id"));	
	
	$success = false;
	
	$questions = $account->loadQuestions();
	
	if($account->getData("id") != $_POST['account'])
	{
		$condition['title'] = 'Conta incorreta';
		$condition['details'] = "O numero da conta informado não corresponde ao numero da conta do personagem informado.";			
	}
	elseif($account->getData("password") != $engine->encrypt($_POST['password']))
	{
		$condition['title'] = 'Senha incorreta';
		$condition['details'] = "A senha de acesso informada não corresponde a senha de acesso registrada para esta conta.";			
	}
	elseif(!$questions)
	{
		$condition['title'] = 'Nao possui este recurso';
		$condition['details'] = "Está conta não possui perguntas e respostas configuradas corretamente, este recurso está inutilizavel por esta conta.";			
	}		
	else
	{
		$success = true;
	}
	
	if(!$success)
	{
		echo '<br><center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">
		<tr><td class=rank2>'.$condition['title'].'</td></tr>
		<tr><td class=rank3>'.$condition['details'].'
		</table><br>
		
		<a href="?page=lostInterface"><img src="images/back.gif" border="0"></a>';	
	}
	else	
	{
		$i = 0;
	
		foreach($questions as $question)
		{
			$i++;
			
			$questionText .= '
			<tr>
				<td class="rank3" colspan="2" width="25%"><b>Resposta a pergunta secreta numero '.$i.'</td>
			</tr>		
			<tr>
				<td class="rank3" colspan="2" width="25%">Pergunta: '.$question['question'].'</td>
			</tr>		
			<tr>
				<td class="rank3" colspan="2" width="25%">Resposta: <input name="answer_'.$i.'" type="text" value="" class="login" size="45"/></td>
			</tr>';	
		}
	
		echo '
		<br>
		<center>
		<table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">
		Nesta etapa do processo de modificação das perguntas e respostas registradas em sua conta você terá de responder corretamente todas respostas as perguntas secretas na qual você configurou em sua conta.<br>
		<br>
		IMPORTANTE: Só é permitido '.USE_QUESTION_TRIES.' tentativas sem sucesso desta operação por dia, portanto, caso você venha a errar as respostas das perguntas secretas '.USE_QUESTION_TRIES.' vezes este recurso será desabilitado para sua conta durante 24h por motivos de segurança.
		</table>
		<br>

		<form method="POST" action="?page=lostInterface&step=5">
		<table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">
			<tr>
				<td class="rank2" colspan="2">Respostas Secretas</td>
			</tr>
			'.$questionText.'			
		</table>
		<br>
		<a href="?page=lostInterface"><img src="images/back.gif" border="0"></a> <input type="image" value="Entrar" src="images/submit.gif"/> 
		</form>
		
		<br>';		
	}	
}
elseif($_GET["step"] == "3")
{
	echo '
	<br>
	<center>
	<table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">
	Preencha todos os campos do formulario abaixo para continuar o processo de modificação de perguntas e respostas registrado em sua conta.<br>
	<br>
	IMPORTANTE: Só é permitido '.USE_QUESTION_TRIES.' tentativas sem sucesso desta operação por dia, portanto, caso você venha a errar as respostas das perguntas secretas '.USE_QUESTION_TRIES.' vezes este recurso será desabilitado para sua conta durante 24h por motivos de segurança.
	</table>
	<br>

	<form method="POST" action="?page=lostInterface&step=4">
	<table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">
	<tr>
		<td class=rank2 colspan="2">Recuperação de Conta</td>
	</tr>
	<tr>
		<td class="rank3" width="35%">Numero da conta:</td>
		<td class="rank3"><input name="account" type="password" value="" class="login" size="30"/></td>
	</tr>
	<tr>
		<td class="rank3" width="35%">Senha:</td>
		<td class="rank3"><input name="password" type="password" value="" class="login" size="30"/></td>
	</tr>	
	</table>
	<br>
	<a href="?page=lostInterface"><img src="images/back.gif" border="0"></a> <input type="image" value="Entrar" src="images/submit.gif"/> 
	</form>
	
	<br>';
}
?>