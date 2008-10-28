<?
if($engine->loggedIn())
{
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
			$conteudo = 'Personagem n�o existe ou n�o � de sua conta.';		
			$error++;
		}
		elseif(!Account::passCheck($account,md5($_POST['pass'])))
		{
			$condition = 'Erro!';
			$conteudo = 'Senha n�o est� correta.';
			$error++;
		}
		elseif(Player::checkIsDeleted($_POST['name']))
		{
			$condition = 'Erro!';
			$conteudo = 'Este personagem j� foi deletado.';	
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
		echo '<br><a href="?page=account.login"><img src="'.$back_button.'" border="0"></a>';			
	}
	else
	{
		echo '<form action="?page=character.delete" method="post">';
		echo '<center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">';
		echo 'Voc� pode deletar um char que n�o ultiliza mais, ou para liberar espa�o em sua account.';
		echo 'Por motivos de seguran�a a dele��o do personagem apenas se concretiza ap�s 15 dias!<br>';
		echo '</table>';
		echo '<br><center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
		echo '<tr><td class=rank2>Deletar personagem</td></tr>';
		echo '</table>';	
		echo '<center><table border="0" width="95%" bgcolor="black" CELLSPACING="1" CELLPADDING="4">';
		echo '<tr><td width="25%" class=rank1>Nome do personagem:</td><td width="75%" class=rank1><input name="name" type="text" value="" class="login"/></td></tr>';
		echo '<tr><td width="25%" class=rank1>Senha:</td><td width="75%" class=rank1><input name="pass" type="password" value="" class="login"/></td></tr>';
		echo '</table>';
		echo '<br />';
		echo '<input type="image" value="submit" src="images/submit.gif"/> <a href="?page=account.main"><img src="'.$back_button.'" border="0"></a>';
	}
}
?>