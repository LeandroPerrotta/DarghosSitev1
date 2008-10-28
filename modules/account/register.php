<?
echo '<tr><td class=newbar><center><b>:: '.$page['subTitle'].' ::</td></tr>
<tr><td class=newtext><br>';	

if ($_SERVER['REQUEST_METHOD'] == "POST")
{
	$success = false;
	$chk_email = $engine->loadClass('Accounts');

	if(!$_POST['email'])
	{
		$condition['title'] = "Campos em brancos!";
		$condition['details'] = "Os campos do formulario estão vazios, para criar sua conta é necessario preencher todos campos do formulario corretamente.";
	}
	elseif(!$engine->filtreString($_POST['email']))
	{
		$condition['title'] = "Caracteres reservados!";
		$condition['details'] = "Este endereço de e-mail contem caracteres reservados ou proibidos, por favor, tente novamente com outro endereço e-mail.";
	}	
	elseif(!$engine->isEmailFormat($_POST['email']))
	{
		$condition['title'] = "E-mail invalido!";
		$condition['details'] = "Este não é um endereço de e-mail valido, por favor, tente novamente com outro endereço e-mail.";
	}		
	elseif($chk_email->loadByEmail($_POST['email']))		
	{
		$condition['title'] = "E-mail já em uso!";
		$condition['details'] = "Esteendereço de e-mail já está em uso por outra conta, por favor, tente novamente com outro endereço e-mail.";		
	}	
	elseif($_POST['privacidade'] != 1)		
	{
		$condition['title'] = "Termos não aceitos!";
		$condition['details'] = "Somente oferecemos o Darghos a quem aceitar e concordar com todos termos e politicas de nosso trabalho.";			
	}			
	else 
	{
		$pass = $engine->random_key(8, 1);	
		
		$account = $engine->loadClass('Accounts');
		$number = $account->getNumber();

		$account->setData("password", $engine->encrypt($pass));
		$account->setData("email", $_POST['email']);
		$account->setData("lastday", time());
		$account->setData("creation", time());
		
		$body = 
		'Caro jogador do Darghos,
A sua conta foi criada com sucesso!

Abaixo segue os detalhes da sua conta:
Sua conta é: '.$number.'
Sua senha é: '.$pass.'

Para criar um personagem e começar a jogar visite:
'.GLOBAL_URL.'/index.php?page=account.login

Nos vemos no Darghos!
UltraxSoft Team.';
		
		if(!$engine->sendEmail($_POST['email'], 'Detalhes da Conta!', $body))
		{		
			$condition['title'] = "Falha ao enviar email!";
			$condition['details'] = "Ouve uma falha em nosso servidor de emails que impossibilitou o envio do seu email. A criação de sua conta foi anulada. Tente novamente mais tarde.";								
		}				
		else
		{	
			$success = true;
			$account->saveNumber();
			
			$condition['title'] = "E-mail enviado com sucesso!";
			$condition['details'] = "Parabens! Sua conta foi criada com sucesso!<br>
			O numero de sua conta é: <font size=6><b>$number</b></font><br>
			<br>
			A senha para acesso de sua conta foi enviada email registrado: <b>".$_POST['email']."</b><br>
			Para sua segurança jamais entregue os dados de sua conta a ninguem!<br>
			<br>
			Tenha um bom jogo!<br>
			Equipe UltraxSoft.";								
		}				
	}
	
	echo '<center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
	echo '<tr><td class=rank2>'.$condition['title'].'</td></tr>';
	echo '<tr><td class=rank3>'.$condition['details'].'';
	echo '</table><br>';
	
	if($success)
	{
		echo '<a href="?page=account.login"><img src="images/login.gif" border="0"></a>';	
	}
	else
	{
		echo '<a href="?page=account.register"><img src="images/back.gif" border="0"></a>';	
	}
}
else 
{
	echo '
	<center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="4">
	Crie agora mesmo sua account e começe a se divertir no Darghos!</table>

	<br>

	<form action="?page=account.register" method="post">

	<center>
	<table width="90%" BORDER="0" CELLSPACING="1" CELLPADDING="4">
		<tr>
			<td class="rank2">Crie uma conta no Darghos</td>
		</tr>
		<tr>
			<td class="rank3">Endereço de E-mail: <input class="login" name="email" type="text" value="" size="30"/></td>
		</tr>
		<tr>
			<td class="rank3"><br><b>Termos de politica de privacidade</b>
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
		<tr>
			<td class="rank3"><input type="checkbox" name="privacidade" value="1"> Eu concordo com os termos da politica de privacidade oferecidos pelo darghos.</td>
		</tr>
	</table><br>
	<input type="image" value="Entrar" src="images/newaccount.gif"/>
	<br />
	</form>
	</center>
	</ul>';
}
?>