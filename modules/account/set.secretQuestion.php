<?
if($engine->loggedIn())
{
	echo '<tr><td class=newbar><center><b>:: '.$page['subTitle'].' ::</td></tr>
	<tr><td class=newtext><br>';	
	
	$account = $engine->loadClass('Accounts');
	$account->loadByNumber($_SESSION['account']);			
	
	if(!$account->loadQuestions())
	{
		if ($_SERVER['REQUEST_METHOD'] == "POST")
		{	
			$success = false;
		
			if($_POST['terms'] != 1)		
			{
				$condition['title'] = 'Termos n�o aceitos';
				$condition['details'] = "Para configurar as perguntas e respostas em sua conta � necessario aceitar com os termos de uso e seguran�a que voc� deve ter com estas informa��es.";		
			}
			elseif($_POST['first_question'] == null or $_POST['first_question'] == "" OR $_POST['first_answer'] == null OR $_POST['first_answer'] == "")
			{
				$condition['title'] = 'Quantidade de perguntas e respostas';
				$condition['details'] = "Para configurar as perguntas e respostas corretamente em sua conta � necessario preencher ao menos a primeira pergunta e resposta.";				
			}
			elseif(strlen($_POST['first_question']) < 5 OR strlen($_POST['first_question']) > 35 OR strlen($_POST['first_answer']) < 5 OR strlen($_POST['first_answer']) > 35)
			{
				$condition['title'] = 'Quantidade de caracteres';
				$condition['details'] = "As perguntas e respostas devem possuir entre 5 e 35 caracteres.";		
			}	
			elseif(!$engine->filtreString($_POST['first_question']) OR !$engine->filtreString($_POST['first_answer']))
			{
				$condition['title'] = 'Sintaxes reservadas';
				$condition['details'] = "O seu formulario contem o uso de sintaxes reservadas ao sistema interno. Por favor tente novamente com outros valores.";
			}			
			elseif(($_POST['second_question'] != null or $_POST['second_question'] != "" OR $_POST['second_answer'] != null OR $_POST['second_answer'] != "") AND (strlen($_POST['second_question']) < 5 OR strlen($_POST['second_question']) > 35 OR strlen($_POST['second_answer']) < 5 OR strlen($_POST['second_answer']) > 35))
			{
				$condition['title'] = 'Quantidade de caracteres';
				$condition['details'] = "As perguntas e respostas devem possuir entre 5 e 35 caracteres.";		
			}			
			elseif(($_POST['second_question'] != null or $_POST['second_question'] != "" OR $_POST['second_answer'] != null OR $_POST['second_answer'] != "") AND (!$engine->filtreString($_POST['second_question']) OR !$engine->filtreString($_POST['second_answer'])))
			{
				$condition['title'] = 'Sintaxes reservadas';
				$condition['details'] = "O seu formulario contem o uso de sintaxes reservadas ao sistema interno. Por favor tente novamente com outros valores.";
			}
			elseif(($_POST['third_question'] != null or $_POST['third_question'] != "" OR $_POST['third_answer'] != null OR $_POST['third_answer'] != "") AND (strlen($_POST['third_question']) < 5 OR strlen($_POST['third_question']) > 35 OR strlen($_POST['third_answer']) < 5 OR strlen($_POST['third_answer']) > 35))
			{
					$condition['title'] = 'Quantidade de caracteres';
					$condition['details'] = "As perguntas e respostas devem possuir entre 5 e 35 caracteres.";		
			}	
			elseif(($_POST['third_question'] != null or $_POST['third_question'] != "" OR $_POST['third_answer'] != null OR $_POST['third_answer'] != "") AND (!$engine->filtreString($_POST['third_question']) OR !$engine->filtreString($_POST['third_answer'])))
			{
				$condition['title'] = 'Sintaxes reservadas';
				$condition['details'] = "O seu formulario contem o uso de sintaxes reservadas ao sistema interno. Por favor tente novamente com outros valores.";
			}		
			elseif($_SESSION['password'] != $engine->encrypt($_POST['password']))
			{
				$condition['title'] = 'Confirma��o de senha incorreta';
				$condition['details'] = "Para modificar sua senha � necessario confirmar a senha atual!";			
			}
			else
			{		
				$success = true;
				
				$account->addQuestion($_POST['first_question'], $_POST['first_answer']);
				
				if($_POST['second_question'] != null or $_POST['second_question'] != "" OR $_POST['second_answer'] != null OR $_POST['second_answer'] != "")
					$account->addQuestion($_POST['second_question'], $_POST['second_answer']);
					
				if($_POST['third_question'] != null or $_POST['third_question'] != "" OR $_POST['third_answer'] != null OR $_POST['third_answer'] != "")
					$account->addQuestion($_POST['third_question'], $_POST['third_answer']);
			
				$condition['title'] = 'Pergunta(s) e Resposta(s) configuradas com sucesso!';
				$condition['details'] = "As perguntas e respostas foram configuradas corretamente de acordo com os dados informados. A partir de agora sua conta possui um grau de seguran�a maior.";	
			}	
			
			echo '<center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
			echo '<tr><td class=rank2>'.$condition['title'].'</td></tr>';
			echo '<tr><td class=rank3>'.$condition['details'].'';
			echo '</table><br>';

			if($success)
				echo '<a href="?page=account.main"><img src="images/back.gif" border="0"></a>';	
			else
				echo '<a href="?page=account.setSecretQuestion"><img src="images/back.gif" border="0"></a>';						
		}
		else
		{
			echo '
			<center>
			<table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">
			Para aumentar a seguran�a de sua conta voc� pode configurar perguntas e respostas secretas e em sua conta. O modo de recupera��o de conta por perguntas pessoais � a forma mais efetiva de recupera��o, pois com elas � possivel modificar o e-mail registrado em sua conta de forma instantanea, e assim recuperar os dados de sua conta al�m de voc� tambem poder re-configurar novas perguntas em sua conta no futuro.<br>
			<br>
			Voc� pode configurar de uma a tr�s perguntas e respostas, sendo que quanto mais perguntas e respostas forem configuradas, maior � o grau de seguran�a.<br>
			<br>
			<b>Recomenda��es de perguntas e respostas:</b><br>
			<br>
			Ultilize fatos importantes, que voc� jamais esqueceria, e procure fazer respostas objetivas e diretas, por exemplo:<br>
			<br>
			<i><b>P:</b> Qual � meu nome?</i><br>
			<br>
			<b>R:</b> <del>Meu nome � Jo�o.</del><br>
			<font size="1">(n�o recomendado)</font><br>
			<b>R:</b> Jo�o<br>
			<font size="1">(recomendado)</font><br>
			<br>
			Recomendamos tamb�m que na hora de escolher a quantidade de perguntas e respostas voc� ultilize o famoso ditado "um � pouco, dois � bom, porem tr�s pode ser de mais".<br>
			<br>
			<b><font color="red">Notas Importantes:</font></b><br>
			<br>
			O sistema � extremamente sensivel, portanto para recuperar sua conta pelas perguntas voc� ter� de informar as respostas exatamente como as configurou.<br>		
			</table>
			<br>
			
			<form method="POST" action="?page=account.setSecretQuestion">
			<table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">
				<tr>
					<td class="rank2" colspan="2">Configura��o de Perguntas e Respostas secretas</td>
				</tr>
				<tr>
					<td class="rank3" colspan="2" width="25%"><b>Pergunta & Resposta numero 1 (obrigatoria)</td>
				</tr>			
				<tr>
					<td class="rank3" width="25%">Pergunta: </td>
					<td class="rank3" width="75%"><input name="first_question" type="text" value="" class="login" size="45"/></td>
				</tr>
				<tr>
					<td class="rank3" width="25%">Resposta:</td>
					<td class="rank3" width="75%"><input name="first_answer" type="text" value="" class="login" size="30"/></td>
				</tr>		
				<tr>
					<td class="rank3" colspan="2" width="25%"><b>Pergunta & Resposta numero 2 (recomendavel)</td>
				</tr>			
				<tr>
					<td class="rank3" width="25%">Pergunta: </td>
					<td class="rank3" width="75%"><input name="second_question" type="text" value="" class="login" size="45"/></td>
				</tr>
				<tr>
					<td class="rank3" width="25%">Resposta:</td>
					<td class="rank3" width="75%"><input name="second_answer" type="text" value="" class="login" size="30"/></td>
				</tr>	
				<tr>
					<td class="rank3" colspan="2" width="25%"><b>Pergunta & Resposta numero 3 (opcional)</td>
				</tr>			
				<tr>
					<td class="rank3" width="25%">Pergunta: </td>
					<td class="rank3" width="75%"><input name="third_question" type="text" value="" class="login" size="45"/></td>
				</tr>
				<tr>
					<td class="rank3" width="25%">Resposta:</td>
					<td class="rank3" width="75%"><input name="third_answer" type="text" value="" class="login" size="30"/></td>
				</tr>				
			</table>
			<br>
			<table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">
				<tr>
					<td class="rank2" colspan="2">Confirma��o de senha</td>
				</tr>
				<tr>
					<td class="rank3" width="25%">Senha:</td>
					<td class="rank3" width="75%"><input name="password" type="password" value="" class="login" size="30"/></td>
				</tr>						
			</table>
			<br>			
			<table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">
				<tr>
					<td class="rank2" colspan="2">Termos e Politicas sobre Perguntas & Respostas</td>
				</tr>
				<tr>
					<td class="rank3" colspan="2" width="25%"><input type="checkbox" name="terms" value="1" class="login"><b> Eu aceito que sou eu o unico responsavel em manter seguro os dados das perguntas e respostas informadas a acima, portanto eu compreendo e estou ciente que o compartilhamento, esquecimento, perda destas informa��es ou respostas simples poder� resultar em IMPOSSIBILITAR QUALQUER MANEIRA de recupera��o de minha conta ou acesso de TERCEIROS a minha conta e consequentemente a perda ETERNA de todos personagens contidos nesta conta.</td>
				</tr>						
			</table><br>		
			<input type="image" value="Entrar" src="images/submit.gif"/> 
			<a href="?page=account.main"><img src="images/back.gif" border="0"></a>	
			</form>	 
			';		
		}
	}
}
?>	