<?
if($engine->accountAccess() >= GROUP_COMMUNITYMANAGER)
{
	include("fckeditor/fckeditor.php");
	echo '<tr><td class=newbar><center><b>:: Notícias ::</td></tr>';
	echo '<tr><td class=newtext>';
	$editnew = trim($_REQUEST['edit']);
	$delnew = trim($_REQUEST['del']);

	if($editnew)
	{
		$query_edit = mysql_query("SELECT * FROM site.`news` WHERE(`ID` = '$editnew')") or die(mysql_error());
		$fetch_edit = mysql_fetch_object($query_edit);
		echo '<form action="?page=admin.newsManager&action=edit" method="POST">';

		echo '<br><center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">';
		echo 'Edite ou modifique esta noticia usando este recurso!<br>';
		echo 'Dica: Use tags HTML para decorar sua notícia.';
		echo '</table>';		
				
		echo '<br><center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';	
		echo '<tr><td width="25%" class=rank1>Titulo:</td><td width="75%" class=rank1><input type="text" class="login" name="title" VALUE="'.$fetch_edit->title.'" size ="40" MAXLENGTH="39"></td></tr>';
		echo '<tr><td colspan="2" width="25%" class=rank1>';
		$oFCKeditor = new FCKeditor('FCKeditor1') ;
		$oFCKeditor->BasePath = 'fckeditor/' ;
		$oFCKeditor->Value = ''.$fetch_edit->post.'' ;
		$oFCKeditor->Create() ;				
		echo '</td></tr>';	
		echo '<tr class=rank1><td colspan=2><INPUT TYPE="CHECKBOX" NAME="preview" VALUE="1"> Modo preview?</td></tr>';
		echo '</table>';
		
		echo '<br><input type="image" value="submit" src="images/submit.gif"/> <a href="?page=news.files"><img src="images/back.gif" border="0"></a>';
		echo '<input type="hidden" name="new_id" value="'.$fetch_edit->id.'">';

		echo '</form>';	
	}
	elseif($_GET['action'] == 'edit')
	{
		if($_SERVER['REQUEST_METHOD'] == "POST")
		{
			$tittle = $_POST['title'];
			$post = $_POST['FCKeditor1'];
			$preview = $_POST['preview'];
			mysql_query("UPDATE site.news SET title = '$tittle', post = '$post' WHERE id = '".$_POST['new_id']."'") or die(mysql_error());

			echo '<br><center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">
			Noticia Editada com Sucesso!
			</table>		
			
			<br><a href="?page=account.main"><img src="images/back.gif" border="0"></a>';					
		}
	}
	elseif($delnew)
	{
		News::deleteNew($delnew);
		
		echo '<br><center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">
		Notícia excluida com exito!
		</table>		
		
		<br><a href="?page=account.main"><img src="../images/back.gif" border="0"></a>';		
	}
	else
	{

		if ($_SERVER['REQUEST_METHOD'] == "POST")
		{
			$time = time();
			$titulo = $_POST['title'];
			$news = $_POST['FCKeditor1'] ;
			$autor = $account;	

			if($_POST['preview'] == 1)
				$preview = 1;
			else
				$preview = 0;
			
			if ($titulo == '' or $news == '')
			{
				$condition = 'Escreva um titulo e o texto de sua notícia!';
			}	
			else
			{
				mysql_query("INSERT INTO site.news(author_account, post, title, date) VALUES('$autor', '$news', '$titulo', '$time')") or die(mysql_error());
				$condition = 'Sucesso! Notícia postada, clique <a href="index.php">aqui</a> para visualizá-la.';
			}	
			
			echo '<br><center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">
			'.$condition.'
			</table>		
			
			<br><a href="?page=account.main"><img src="images/back.gif" border="0"></a>';
		}
		else
		{			

			echo '<form action="?page=admin.newsManager" method="POST">';

			echo '<br><center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">';
			echo 'Escreva uma nova notícia para ir ao site usando este recurso!<br>';
			echo '</table>';
			
			echo '<br><center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';	
			echo '<tr><td width="25%" class=rank1>Titulo:</td><td width="75%" class=rank1><input type="text" class="login" name="title" VALUE="" size ="40" MAXLENGTH="39"></td></tr>';
			echo '<tr><td colspan="2" width="25%" class=rank1>';
			$oFCKeditor = new FCKeditor('FCKeditor1') ;
			$oFCKeditor->BasePath = 'fckeditor/' ;
			$oFCKeditor->Value = '' ;
			$oFCKeditor->Create() ;				
			echo '</td></tr>';	
			echo '<tr class=rank1><td colspan=2><INPUT TYPE="CHECKBOX" NAME="preview" VALUE="1"> Modo preview?</td></tr>';
			echo '</table>';
			
			echo '<br><input type="image" value="submit" src="images/submit.gif"/>';


			echo '</form>';
		}	
	}
}
?>