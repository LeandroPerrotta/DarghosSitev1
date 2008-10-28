<?
echo '<tr><td class=newbar><center><b>:: '.$page["subTitle"].' ::</td></tr>
<tr><td class=newtext>';

if($_GET["step"] == "2")
{
	$player = $engine->loadClass('Players');
	
	$success = false;
	
	if(!$engine->filtreString($_POST['character']))
	{
		$condition['title'] = 'Sintaxes reservadas';
		$condition['details'] = "O seu formulario contem o uso de sintaxes reservadas ao sistema interno. Por favor tente novamente com outros valores.";
	}
	elseif(!$player->loadByName($_POST['character']))
	{
		$condition['title'] = 'Personagem inexistente';
		$condition['details'] = "Não existe nenhum personagem em nosso banco de dados com o nome informado. Verifique se digitou o nome corretamente.";	
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
		$_SESSION['lostInterface']['character'] = $_POST['character'];
		
		echo '
		<br>
		<center>
		<table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">
		Selecione a opção abaixo que mais se aproxima a solução de seu problema e então clique em "Submit"<br>
		<br>
		É importante dizer que a recuperação de numero de contas e senhas é efetuada atravez do envio de uma mensagem contendo as informações necessarias para recuperação da conta ao e-mail registrado na mesma.<br>
		<br>
		Caso você não possua mais acesso a este e-mail, é possivel modificar este e-mail para um outro e-mail que você possua acesso de forma instantanea respondendo corretamente a todas perguntas configuradas em sua conta.<br>
		<br>
		Caso você não possua mais acesso ao e-mail registrado em sua conta e não se recorde das respostas para as perguntas secretas (ou não tenha configurado as perguntas na conta, ainda quando tinha acesso a mesma) infelizmente, pelo motivo de falta de informações concretas nem a interface de recuperação de contas, nem mesmo a equipe, conseguirá recuperar está conta, que estará para sempre perdida.<br>
		</table>
		<br>
		
		<form method="POST" action="?page=lostInterface&step=3">
		<table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">
			<tr>
				<td class=rank2>Selecione abaixo uma opção</td>
			</tr>
			<tr class="rank3">
				<td width="25%"><input type="radio" name="interface" value="account"/> Eu perdi o numero de minha conta, e solicito o envio da mesma para meu e-mail.</td>
			</tr>
			<tr class="rank3">
				<td><input type="radio" name="interface" value="password"/> Eu perdi a senha de minha conta, e solicito o envio de uma nova para meu e-mail.</li></td>
			</tr>
			<tr class="rank3">
				<td><input type="radio" name="interface" value="both"/> Eu perdi o numero e a senha de minha conta, e desejo que envie-as para meu e-mail.</td>
			</tr>
			<tr class="rank3">
				<td><input type="radio" name="interface" value="change_email"/> Eu perdi acesso ao e-mail registrado em minha conta e desejo modifica-lo..</td>
				</tr>
			<tr class="rank3">
				<td><input type="radio" name="interface" value="change_questions" /> Eu preciso modificar as perguntas e respostas de minha conta.</td>
			</tr>
		</table>
		<br>
		<a href="?page=lostInterface"><img src="images/back.gif" border="0"></a> <input type="image" value="Entrar" src="images/submit.gif"/> 
		</form>';
	}	
}
elseif($_GET["step"] == "3")
{
	$_SESSION['lostInterface']['interface'] = $_POST['interface'];
	
	switch($_SESSION['lostInterface']['interface'])
	{
		case "account";
			include "modules/lostInterface/account.php";
		break;	
		
		case "password";
			include "modules/lostInterface/password.php";
		break;		

		case "both";
			include "modules/lostInterface/both.php";
		break;		

		case "change_email";
			include "modules/lostInterface/change_email.php";
		break;			

		case "change_questions";
			include "modules/lostInterface/change_questions.php";
		break;		

		default:
			include "modules/lostInterface/account.php";
		break;	
	}
}
elseif($_GET["step"] == "4")
{	
	switch($_SESSION['lostInterface']['interface'])
	{
		case "account";
			include "modules/lostInterface/account.php";
		break;	
		
		case "password";
			include "modules/lostInterface/password.php";
		break;		

		case "both";
			include "modules/lostInterface/both.php";
		break;		

		case "change_email";
			include "modules/lostInterface/change_email.php";
		break;			

		case "change_questions";
			include "modules/lostInterface/change_questions.php";
		break;			
	}
}
elseif($_GET["step"] == "5")
{	
	switch($_SESSION['lostInterface']['interface'])
	{
		case "change_email";
			include "modules/lostInterface/change_email.php";
		break;			

		case "change_questions";
			include "modules/lostInterface/change_questions.php";
		break;			
	}
}
elseif($_GET["step"] == "confirmKey")
{	
	switch($_GET["step"])
	{		
		case "confirmKey";
			include "modules/lostInterface/password.php";
		break;		
		
		default:
			include "modules/lostInterface/password.php";
		break;			
	}
}
else
{
	echo '
	<br>
	<center>
	<table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">
	Caso você tenha esquecido ou perdido o acesso a sua conta de seu personagem você ainda pode recupera-la atravez deste sistema, a interface de recuperação de contas.<br>
	<br>
	<b>O sistema de Inteface de Recuperação pode lhe ajudar a:</b><br>
	<br>
	<li>Recuperar o numero de sua conta caso você tenha esquecido o mesmo.</li>
	<li>Obter uma nova senha de acesso caso você tenha perdido a mesma.</li>
	<li>Modificar o e-mail registrado em sua conta de forma instananêa respondendo as perguntas secretas de sua conta caso você tenha perdido o acesso ao mesmo.</li>
	<li>Modificar as perguntas e respostas secretas registradas em sua conta.</li><br>
	<br>
	Para começar a recuperação de sua conta, preencha o formulario abaixo com o nome do personagem na qual você quer recuperar a conta e clique em "Submit" para que o sistema lhe auxilie no restante do processo de recuperação.
	</table>
	<br>

	<form method="POST" action="?page=lostInterface&step=2">
	<table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">
	<tr>
		<td class=rank2 colspan="2">Personagem a recuperar a conta</td>
	</tr>
	<tr>
		<td class="rank3" width="35%">Nome do personagem:</td>
		<td class="rank3"><input name="character" type="text" value="" class="login" size="30"/></td>
	</tr>
	</table>
	<br>
	<input type="image" value="Entrar" src="images/submit.gif"/> 
	</form>
	
	<br>';
}
?>