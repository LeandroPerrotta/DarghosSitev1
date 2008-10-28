<?
if($engine->accountAccess() >= GROUP_COMMUNITYMANAGER)
{
	include("fckeditor/fckeditor.php");
	echo '<tr><td class=newbar><center><b>:: Edição de Textos ::</td></tr>';
	echo '<tr><td class=newtext>';	

	if ($_SERVER['REQUEST_METHOD'] == "POST")
	{
		$query = mysql_query("UPDATE site.texts SET pt_br = '".$_POST['FCKeditor1']."' WHERE id = ".$_POST['id']."") or die(mysql_error());
		if($query)
		{
			$condition = "Texto Editado com sucesso!";
		}
		else
		{
			$condition = "Ouve um problema na edição!";
		}

		echo '<br><center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
		echo '<tr><td class=rank2>'.$condition.'</td></tr>';
		echo '</table>';	

		$text_id = $_POST['id'];	
	}
	else
	{
		$text_id = $_GET['id'];
	}

	$query = "";	
	$query = mysql_query("SELECT * FROM site.texts WHERE id = $text_id") or die(mysql_error());
	$fetch = mysql_fetch_object($query);

	echo '<form action="?page=admin.editText" method="POST">';
	echo '<br><center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';	
	echo '<tr><td width="25%" class=rank1>Texto para Editar:</td></tr>';
	echo '<tr><td colspan="2" width="25%" class=rank1>';

	$oFCKeditor = new FCKeditor('FCKeditor1') ;
	$oFCKeditor->BasePath = 'fckeditor/' ;
	$oFCKeditor->Value = ''.$fetch->pt_br.'' ;
	$oFCKeditor->Create() ;		

	echo '</td></tr>';	
	echo '</table>';
	echo '<input type="hidden" name="id" value="'.$text_id.'">';			
	echo '</form>';
}
?>