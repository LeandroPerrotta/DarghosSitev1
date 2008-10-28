<?
if($engine->loggedIn())
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
			echo '<br><a href="?page=account.main"><img src="'.$back_button.'" border="0"></a>';		
		}	
		
		else
		{	
			echo '<center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">';
			echo 'Você pode postar uma screenshot para ser avalidada por outros jogadores, a cada 15 dias o Darghos troca a screenshot do site pela mais votada! 
			Ultilize sua criatividade e ganhe os votos dos jogadores!';
			echo '<br><br>Atenção: A votação é para eleger a melhor screenshot, porem isto é relacionado ao Darghos, qualquer screenshot enviada fora do contexto do assunto ela será retirada e o usuario será punido.';
			echo '</table>';	
			echo '<form action="?page=screenshot.post" method=post  ENCTYPE="multipart/form-data">';
			echo '<center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
			echo '<tr class=rank2><td colspan=2>Informações da Screenshot: </td></tr>';
			echo '<tr class=rank1><td colspan=2><font color=red>Atenção:</font> A imagem deve seguir os seguintes padrões: Ser do formato JPG; Resolução maxima: 1024x768; Tamanho maximo: 300 kb.<br>
			O titulo não deve conter mais de 45 carateres.<br>
			Os detalhes não deve conter mais de 200 carateres.</td></tr>';			
			echo '<tr class=rank1><td colspan=2><center><input class=login type=file size=30 name=foto> </td></tr>';
			echo '<tr class=rank1><td>Titulo:<br><TEXTAREA class="login" NAME="tittle" ROWS=2 COLS=30 WRAP="virtual"></textarea><td>Detalhes:<br><TEXTAREA class="login" NAME="detail" ROWS=4 COLS=30 WRAP="virtual"></textarea> </td></tr>';
			echo '</table><br>';
			echo '<input type="image" value="submit" src="images/submit.gif"/> <a href="?page=account.main"><img src="'.$back_button.'" border="0"></a>';
			echo '</form>';	
		}
	}
}	
?>	