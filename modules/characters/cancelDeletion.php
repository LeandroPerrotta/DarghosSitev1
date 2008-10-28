<?
if($engine->loggedIn())
{
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
		echo '<br><a href="?page=account.main"><img src="'.$back_button.'" border="0"></a>';			
	}
	else
	{
		echo '<form action="?page=character.cancelDeletion" method="post">';
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
		echo '<input type="image" value="submit" src="images/submit.gif"/> <a href="?page=account.main"><img src="'.$back_button.'" border="0"></a>';
	}
}	
?>	