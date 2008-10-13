<?
session_start();
include "top.php";
include_once("fckeditor/fckeditor.php") ;


// connects to database
$ots = POT::getInstance();
$ots->connect(POT::DB_MYSQL, $userdb);

$account = $_SESSION['account'];
$password = $_SESSION['password'];

$getcm_query = mysql_query("SELECT * FROM `accounts` WHERE (`id` = '".$account."') ") or die(mysql_error());
$getcm_sql = mysql_fetch_array($getcm_query);

## ADMINISTRATOR // GOD ##
if(Account::isLogged($account,$password))
{
if(Account::isAdmin($account))
{
	if($_GET['subtopic'] == 'news')
	{
		echo '<tr><td class=newbar><center><b>:: Notícias ::</td></tr>';
		echo '<tr><td class=newtext>';
		$editnew = trim($_REQUEST['edit']);
		$delnew = trim($_REQUEST['del']);
		
		if($editnew)
		{
			$query_edit = mysql_query("SELECT * FROM `news` WHERE(`ID` = '$editnew')") or die(mysql_error());
			$fetch_edit = mysql_fetch_object($query_edit);
			echo '<form action="admin.php?subtopic=news&action=edit" method="POST">';

			echo '<br><center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">';
			echo 'Edite ou modifique esta noticia usando este recurso!<br>';
			echo 'Dica: Use tags HTML para decorar sua notícia.';
			echo '</table>';		
					
			echo '<br><center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';	
			echo '<tr><td width="25%" class=rank1>Titulo:</td><td width="75%" class=rank1><input type="text" class="login" name="title" VALUE="'.$fetch_edit->post_title.'" size ="40" MAXLENGTH="39"></td></tr>';
			echo '<tr><td colspan="2" width="25%" class=rank1>';
			$oFCKeditor = new FCKeditor('FCKeditor1') ;
			$oFCKeditor->BasePath = 'fckeditor/' ;
			$oFCKeditor->Value = ''.$fetch_edit->post.'' ;
			$oFCKeditor->Create() ;				
			echo '</td></tr>';	
			echo '<tr class=rank1><td colspan=2><INPUT TYPE="CHECKBOX" NAME="preview" VALUE="1"> Modo preview?</td></tr>';
			echo '</table>';
			
			echo '<br><input type="image" value="submit" src="images/submit.gif"/> <a href="community.php?subtopic=news"><img src="images/back.gif" border="0"></a>';
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
				mysql_query("UPDATE news SET post_title = '$tittle', post = '$post' WHERE id = '".$_POST['new_id']."'") or die(mysql_error());

				echo '<br><center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">
				Noticia Editada com Sucesso!
				</table>		
				
				<br><a href="account.php?subtopic=main"><img src="images/back.gif" border="0"></a>';					
			}
		}
		elseif($delnew)
		{
			include "tools/admin.php";
			News::deleteNew($delnew);
			
			echo '<br><center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">
			Notícia excluida com exito!
			</table>		
			
			<br><a href="account.php?subtopic=main"><img src="../images/back.gif" border="0"></a>';		
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
					mysql_query("INSERT INTO news(autor, post, post_title, post_data,new_status) VALUES('$autor', '$news', '$titulo', '$time','$preview')") or die(mysql_error());
					$condition = 'Sucesso! Notícia postada, clique <a href="index.php">aqui</a> para visualizá-la.';
				}	
				
				echo '<br><center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">
				'.$condition.'
				</table>		
				
				<br><a href="account.php?subtopic=main"><img src="images/back.gif" border="0"></a>';
			}
			else
			{			
		
				echo '<form action="admin.php?subtopic=news" method="POST">';

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
				
				echo '<br><input type="image" value="submit" src="images/submit.gif"/> <a href="account.php?subtopic=main"><img src="../images/back.gif" border="0"></a>';


				echo '</form>';
			}	


		}	
	}
	elseif($_GET['subtopic'] == 'editText')
	{
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
		
		echo '<form action="admin.php?subtopic=editText" method="POST">';
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
	elseif($_GET['subtopic'] == 'newsticker')
	{
		include_once("fckeditor/fckeditor.php") ;
		echo '<tr><td class=newbar><center><b>:: Add News Ticker ::</td></tr>';
		echo '<tr><td class=newtext>';

		if ($_SERVER['REQUEST_METHOD'] == "POST")
		{
			$time = time();
			$ticker = $_POST['text'] ;
			$autor = $account;	
				
			if ($ticker == '')
			{
				$condition = 'Seu ticker deve conter um assunto!';
			}	
			else
			{
				mysql_query("INSERT INTO site.news_tickers(author, date, text) VALUES('$autor', '$time', '$ticker')") or die(mysql_error());
				$condition = 'Sucesso! Notícia postada, clique <a href="index.php">aqui</a> para visualizá-la.';
			}	
			
			echo '<br><center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">
			'.$condition.'
			</table>		
			
			<br><a href="account.php?subtopic=main"><img src="images/back.gif" border="0"></a>';		
		}		
		else
		{			
	
			echo '<form action="admin.php?subtopic=newsticker" method="POST">';

			echo '<br><center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">';
			echo 'Escreva um news ticker para ir ao site.<br>';
			echo '</table>';
			
			echo '<br><center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';	
			echo '<tr><td colspan="2" width="25%" class=rank1>
			<TEXTAREA class="login" NAME="text" ROWS=3 COLS=45 WRAP="virtual"></textarea>	';		
			echo '</td></tr>';	
			echo '</table>';
			
			echo '<br><input type="image" value="submit" src="images/submit.gif"/> <a href="account.php?subtopic=main"><img src="images/back.gif" border="0"></a>';


			echo '</form>';
		}		
	}	
	elseif($_GET['subtopic'] == 'polls')
	{
		echo "<tr><td class=newbar><center><b>:: Nova enquete ::</td></tr><tr><td class=newtext><center><br>";
		
		if ($_SERVER['REQUEST_METHOD'] == "POST")
		{
			POLL::createPoll($_POST[detail],$_POST[option_1],$_POST[option_2],$_POST[option_3],$_POST[option_4],$_POST[option_5],$_POST[detail_1],$_POST[detail_2],$_POST[detail_3],$_POST[detail_4],$_POST[detail_5],$_POST[end],$_POST[tittle]);
			
			$stat = 'Enquete criada com sucesso!';
			$msg = 'A sua enquete foi criada com sucesso!';
			
			echo '<center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
			echo '<tr><td class=rank2>'.$stat.'</td></tr>';
			echo '<tr><td class=rank1>'.$msg.'';
			echo '</table>';
			echo '<br><a href="account.php?subtopic=main"><img src="images/back.gif" border="0"></a>';		
		}

		else
		{	
		
			echo '<center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">
	Campos em branco serão ignorados pela enquete!<br>
	</table><br>';
			echo '<center><table border="0" width="90%" bgcolor="black" CELLSPACING="1" CELLPADDING="4">';
			echo '<form action="admin.php?subtopic=polls" method="POST">';
			echo '<tr><td width="70%" class=rank1 colspan=3><center>Titulo:<br><TEXTAREA class="login" NAME="tittle" ROWS=2 COLS=45 WRAP="virtual"></textarea></td></tr>';	
			echo '<tr><td width="70%" class=rank1 colspan=3><center>Detalhe da enquete:<br><TEXTAREA class="login" NAME="detail" ROWS=5 COLS=45 WRAP="virtual"></textarea></td></tr>';	
			echo '<tr class=rank1><td>Opção 1:<br><input name="option_1" type="text" value="" class="login" size="25" MAXLENGTH="45"/></td><td>Detalhes:<br><TEXTAREA class="login" NAME="detail_1" ROWS=2 COLS=30 WRAP="virtual"></textarea></td></tr>';
			echo '<tr class=rank1><td>Opção 2:<br><input name="option_2" type="text" value="" class="login" size="25" MAXLENGTH="45"/></td><td>Detalhes:<br><TEXTAREA class="login" NAME="detail_2" ROWS=2 COLS=30 WRAP="virtual"></textarea></td></tr>';
			echo '<tr class=rank1><td>Opção 3:<br><input name="option_3" type="text" value="" class="login" size="25" MAXLENGTH="45"/></td><td>Detalhes:<br><TEXTAREA class="login" NAME="detail_3" ROWS=2 COLS=30 WRAP="virtual"></textarea></td></tr>';
			echo '<tr class=rank1><td>Opção 4:<br><input name="option_4" type="text" value="" class="login" size="25" MAXLENGTH="45"/></td><td>Detalhes:<br><TEXTAREA class="login" NAME="detail_4" ROWS=2 COLS=30 WRAP="virtual"></textarea></td></tr>';
			echo '<tr class=rank1><td>Opção 5:<br><input name="option_5" type="text" value="" class="login" size="25" MAXLENGTH="45"/></td><td>Detalhes:<br><TEXTAREA class="login" NAME="detail_5" ROWS=2 COLS=30 WRAP="virtual"></textarea></td></tr>';	
			echo '<tr><td width="70%" class=rank1 colspan=3>Termino:<br><select name="end" class=login><option value="5">5 dias</option><option value="10">10 dias</option><option value="15">15 dias</option><option value="20">20 dias</option><option value="30">30 dias</option><</select></td></tr>';	
			echo '</table>';
			echo '<br><input type="image" value="submit" src="images/submit.gif"/> <a href="account.php?subtopic=main"><img src="images/back.gif" border="0"></a>';
			echo '</form>';
		}	
	}
	elseif($_GET['subtopic'] == 'premium')
	{

		echo '<tr><td class=newbar><center><b>:: Ativar Premium Account ::</td></tr>
		<tr><td class=newtext>';
		
		if ($_SERVER['REQUEST_METHOD'] == "POST")
		{
			$user = $_POST['user'];
			$prem = $_POST['premdays'];
			$premMode = $_POST['mode'];
			$premType = $_POST['type'];

			if($premType == 0)
				$player_query = mysql_query("SELECT * FROM players WHERE account_id = '".$user."'");
			else
				$player_query = mysql_query("SELECT * FROM players WHERE name = '".$user."'");
			if (mysql_num_rows($player_query) != 0)
			{
				$get_acc = mysql_fetch_array($player_query);
				$acc_id = $get_acc['account_id'];

				$premQtd = mysql_query("SELECT * FROM accounts WHERE id = '".$acc_id."'");
				$premQtd_sql = mysql_fetch_array($premQtd);
				$premNow = $premQtd_sql['premdays'];
				$premTime = $premQtd_sql['premEnd'];
				$date = time();		
				
				if($premMode == 0)
				{
					mysql_query("INSERT INTO premium(account_id, premdays, date, premstatus) VALUES('$acc_id', '$prem', '$date', '0')") or die(mysql_error());			
				}
				elseif($premMode == 1)
				{
					$premmy_up = "UPDATE accounts SET premDays = '".$prem."', premFree = '0', lastday = '$date' WHERE id = '".$acc_id."'";
					mysql_query($premmy_up) or die(mysql_error());	
				}
				elseif($premMode == 2)
				{
					if ($premNow == 0)
					{
						
						$premmy_up = "UPDATE accounts SET premDays = '".$prem."', premFree = '1', lastday = '$date' WHERE id = '".$acc_id."'";
						mysql_query($premmy_up) or die(mysql_error());
					}
					else
					{
						$newPrem = $premNow + $prem;
						$premmy_up = "UPDATE accounts SET premDays = '".$newPrem."', premFree = '1', lastday = '$date' WHERE id = '".$acc_id."'";
						mysql_query($premmy_up) or die(mysql_error());
					}					
				}
				
				$condition = 'O jogador "<b>'.$user.'</b>" recebeu <i>'.$prem.'</i> dias de Premmium Account com sucesso!';
			}
			else
			{
				$condition = 'O jogador "<b>'.$user.'</b>" nao existe!';
			}
			
			echo '<br><center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">
			'.$condition.'
			</table>';		
		}	
	?>	
			
			<form action="admin.php?subtopic=premium" method="POST">

			<br><center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">
			Ative premium account de jogadores com este recurso!<br>
			Premium accounts gratis não precisam de aceitação, são ativadas diretos, ja premium accounts normais só são ativadas com a aceitação do player.
			</table>		
			
			<br><center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">	
			<tr><td width="25%" class=rank1>Usuario:</td><td width="75%" class=rank1><input class=login type="text" name="user" size="20"></td></tr>
			<tr><td width="25%" class=rank1>Dias:</td><td width="75%" class=rank1><input class=login type="text" name="premdays" size="20"></td></tr>	
			<tr><td width="25%" class=rank1>Modo:</td><td width="75%" class=rank1><select class=login name="mode"><option value="0">Ativamento</option><option value="1">Revisão</option><option value="2">Gratis</option></select></td></tr>	
			<tr><td width="25%" class=rank1>Ativar por:</td><td width="75%" class=rank1><select class=login name="type"><option value="0">Account Number</option><option value="2">Name</option></select></td></tr>	
			</table>
			
			<br><input type="image" value="submit" src="images/submit.gif"/> <a href="account.php?subtopic=main"><img src="images/back.gif" border="0"></a>


			</form>
	<?	
	}
	elseif($_GET['subtopic'] == 'deletePlayer')
	{
		echo '<tr><td class=newbar><center><b>:: Deletar Player ::</td></tr>
		<tr><td class=newtext><center><br>';
		if ($_SERVER['REQUEST_METHOD'] == "POST")
		{
			include "tools/admin.php";
			
			if($_POST['type'] != 2)
			{
				Deletion::player($_POST['player'],$_POST['type']);
				$stat = 'Player deletado!';
				$msg = 'Player '.$_POST['player'].' (e ou) account deletado.';	
			}	
			else
			{
				Deletion::resetServer($_POST['player']);
				$stat = 'Servidor resetado!';
				$msg = 'O Servidor ID '.$_POST['player'].' foi resetado.';	
			}	
						
			echo '<center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
			echo '<tr><td class=rank2>'.$stat.'</td></tr>';
			echo '<tr><td class=rank1>'.$msg.'';
			echo '</table>';
			echo '<br><a href="account.php?subtopic=main"><img src="images/back.gif" border="0"></a>';		
		}
		else
		{
			echo '<form action="admin.php?subtopic=deletePlayer" method="POST">
			<center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">	
			<tr><td width="25%" class=rank1>Player:</td><td width="75%" class=rank1><input class=login type="text" name="player" size="20"></td></tr>
			<tr><td width="25%" class=rank1>Tipo:</td><td width="75%" class=rank1><select class=login name="type"><option value="0">Apenas o Player</option><option value="1">Deletar todos player mais account</option><option value="2">Resetar server (id do server)</option></select></td></tr>	
			</table>
			<br><input type="image" value="submit" src="images/submit.gif"/> <a href="account.php?subtopic=main"><img src="images/back.gif" border="0"></a>';
		}
	}
	
	elseif($_GET['subtopic'] == 'logs_logintries')
	{
		$query = mysql_query("SELECT * FROM site.logs_logintries ORDER by date desc LIMIT 500") or die(mysql_error());
		echo '<tr><td class=newbar><center><b>:: Login Tries Logs ::</td></tr>
		<tr><td class=newtext><center><br>';
		echo '<center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
		echo '<tr class=rank2><td colspan=4><b>All Premium Accounts</td></tr>';
		echo '<tr class=rank1>
				<td width="40%"><b>Account</td>
				<td width="10%"><b>Success</td>
				<td width="10%"><b>IP Addr</td>
				<td width="40%"><b>Date</td>
		</tr>';
		
		while($fetch = mysql_fetch_object($query))
		{	
			echo '<tr class=rank3>
				<td>'.$fetch->account.'</a></td>
				<td>'.$fetch->success.'</td>
				<td>'.$fetch->ip.'</td>
				<td>'.date('M d Y, H:i:s',$fetch->date).'</td>
			</tr>';
		}
		echo '</table><br>';
	}		
	
	elseif($_GET['subtopic'] == 'viewPremiums')
	{
		$query = mysql_query("SELECT * FROM `accounts` WHERE `premDays` != '0' ORDER by premDays desc") or die(mysql_error());
		echo '<tr><td class=newbar><center><b>:: Premium Accounts ::</td></tr>
		<tr><td class=newtext><center><br>';
		echo '<center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
		echo '<tr class=rank2><td colspan=4><b>All Premium Accounts</td></tr>';
		echo '<tr class=rank1>
				<td width="40%"><b>Nome</td>
				<td width="10%"><b>PremDays</td>
				<td width="10%"><b>Tipo</td>
				<td width="40%"><b>Atualização</td>
		</tr>';
		
		while($fetch = mysql_fetch_object($query))
		{	
			$t++;
			$style = rotateStyle($t);			
			$query2 = mysql_query("SELECT * FROM `players` WHERE `account_id` = '".$fetch->id."' ORDER by level desc") or die(mysql_error());
			$player_fetch = mysql_fetch_object($query2);
			$name = $player_fetch->name;
			$account_id = $player_fetch->account_id;
			$premDays = $fetch->premdays;
			$lastDay = $fetch->lastday;
			echo '<tr class='.$style.'>
				<td><a href="community.php?subtopic=details&char='.$name.'">'.$name.'</a></td>
				<td>'.$premDays.'</td>
				<td>'.$fetch->premFree.'</td>
				<td>'.date('M d Y, H:i:s',$lastDay).'</td>
			</tr>';
		}
		echo '</table><br>';
	}	
	
	elseif($_GET['subtopic'] == 'paymentsList')
	{
		$query = mysql_query("SELECT * FROM `premium` ORDER by date desc") or die(mysql_error());	
		echo '<tr><td class=newbar><center><b>:: Payment List ::</td></tr>
		<tr><td class=newtext><center><br>';
		echo '<center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
		echo '<tr><td width="25%" class=rank1>Account of:</td><td width="5%" class=rank1>Days</td><td width="45%" class=rank1>Date</td><td width="25%" class=rank1>Status</td></tr>';
		while($fetch = mysql_fetch_object($query))
		{	
		$query2 = mysql_query("SELECT * FROM `players` WHERE `account_id` = '".$fetch->account_id."' ORDER by level desc") or die(mysql_error());
		$player_fetch = mysql_fetch_object($query2);
		$name = $player_fetch->name;
		echo '<tr><td class=rank1><a href="community.php?subtopic=details&char='.$name.'">'.$fetch->account_id.'</a></td><td class=rank1>'.$fetch->premdays.'</td><td class=rank1>'.date('M d Y, H:i:s',$fetch->date).'</td><td class=rank1>'.Tolls::premiumType($fetch->premstatus).'</td></tr>';
		}
		echo '</table><br>';
	}	

	elseif($_GET['subtopic'] == 'viewVotes')
	{
		$query = mysql_query("SELECT id, votes FROM `accounts` WHERE votes > 0 ORDER by votes desc") or die(mysql_error());	
		echo '<tr><td class=newbar><center><b>:: Votos no WoW ::</td></tr>
		<tr><td class=newtext><center><br>';
		echo '<center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
		echo '<tr><td width="25%" class=rank1>Account:</td><td width="5%" class=rank1>Votos</td></tr>';
		$totalVotes = 0;
		while($fetch = mysql_fetch_object($query))
		{	
		$query2 = mysql_query("SELECT * FROM `players` WHERE `account_id` = '".$fetch->id."' ORDER by level desc") or die(mysql_error());
		$player_fetch = mysql_fetch_object($query2);
		$name = $player_fetch->name;
		$totalVotes = $totalVotes + $fetch->votes;
		echo '<tr><td class=rank1><a href="community.php?subtopic=details&char='.$name.'">'.$fetch->id.'</a></td><td class=rank1>'.$fetch->votes.'</td></tr>';
		}
		echo '<tr><td class=rank1>Total Votes</td><td class=rank1>'.$totalVotes.'</td></tr>';
		echo '</table><br>';
	}	
	
	elseif($_GET['subtopic'] == 'getItems')
	{
		echo '<tr><td class=newbar><center><b>:: Buscar Itens ::</td></tr>
		<tr><td class=newtext><center><br>';
		if ($_SERVER['REQUEST_METHOD'] == "POST")
		{
			$itemID = $_POST['item'];
			$count = $_POST['count'];
			
			$item_query = mysql_query("SELECT * FROM `player_items` WHERE `itemtype` = '$itemID' and `count` > '$count'") or die(mysql_error());
			echo '<center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="2">';
			echo '<tr><td class=rank2>Player Items</td></tr>';
			echo '<tr class=rank1><td width="25%">Nome</td><td width="25%">Level</td><td width="25%">Player ID</td><td width="25%"Player IP</td><td width="25%">Count</td><tr>';
			while($item_fetch = mysql_fetch_object($item_query))
			{
				$playerId = $item_fetch->player_id;	
				
				$playerName = Player::getPlayerNameById($playerId);
				$playerLevel = Player::getPlayerLevel($playerId);
				$playerIp = Player::getPlayerIp($playerId);
				echo '<tr><td width="25%" class=rank1><a target="_blank" href="community.php?subtopic=details&char='.$playerName.'">'.$playerName.'</a></td><td width="25%" class=rank1>'.$playerLevel.'</td><td width="25%" class=rank1>'.$playerId.'</td><td width="25%" class=rank1>'.$playerIp.'</td><td width="25%" class=rank1>'.$item_fetch->count.'</td><tr>';
			}
			echo '</table>';
			
			$itemdp_query = mysql_query("SELECT * FROM `player_depotitems` WHERE `itemtype` = '$itemID' and `count` > '$count' ORDER by player_id DESC") or die(mysql_error());
			echo '<br><br><center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="2">';
			echo '<tr><td class=rank2>Player Depot</td></tr>';
			echo '<tr class=rank1><td width="25%">Nome</td><td width="25%">Level</td><td width="25%">Player ID</td><td width="25%"Player IP</td><td width="25%">Count</td><tr>';
			while($itemdp_fetch = mysql_fetch_object($itemdp_query))
			{
				$playerId = $itemdp_fetch->player_id;	
				
				$playerName = Player::getPlayerNameById($playerId);
				$playerLevel = Player::getPlayerLevel($playerId);
				$playerIp = Player::getPlayerIp($playerId);
				echo '<tr><td width="25%" class=rank1><a target="_blank" href="community.php?subtopic=details&char='.$playerName.'">'.$playerName.'</a></td><td width="25%" class=rank1>'.$playerLevel.'</td><td width="25%" class=rank1>'.$playerId.'</td><td width="25%" class=rank1>'.$playerIp.'</td><td width="25%" class=rank1>'.$itemdp_fetch->count.'</td><tr>';
			}
			echo '</table>';	

			$itemtile_query = mysql_query("SELECT * FROM `uniterian_tile_items` WHERE `itemtype` = '$itemID' and `count` > '$count'") or die(mysql_error());
			echo '<br><br><center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="2">';
			echo '<tr><td class=rank2>Ground Items</td></tr>';
			echo '<tr class=rank1><td width="25%">Tile ID</td><td width="25%">Count</td><tr>';
			while($itemtile_fetch = mysql_fetch_object($itemtile_query))
			{
				echo '<tr><td width="25%" class=rank1>'.$itemtile_fetch->tile_id.'</td><td width="25%" class=rank1>'.$itemtile_fetch->count.'</td><tr>';
			}
			echo '</table>';				
		}
		else
		{
			echo '<form action="admin.php?subtopic=getItems" method="POST">
			<center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">	
			<tr><td width="25%" class=rank1>Item ID:</td><td width="75%" class=rank1><input class=login type="text" name="item" size="9"> <input class=login type="text" name="count" size="5"></td></tr>
			</table>
			<br><input type="image" value="submit" src="images/submit.gif"/> <a href="account.php?subtopic=main"><img src="images/back.gif" border="0"></a>';
		}
	}
	
	elseif($_GET['subtopic'] == 'extraDays')
	{
		echo '<tr><td class=newbar><center><b>:: Extra Premium Days ::</td></tr>
		<tr><td class=newtext><center><br>';
		if ($_SERVER['REQUEST_METHOD'] == "POST")
		{
			
			$stat = 'Sucesso!';
			$msg = 'Todos premium accounts receberam '.$_POST['days'].' dias de premium account extra!';
			
			$accsupdts = 0;
			$query = mysql_query("SELECT * FROM accounts WHERE premdays != 0");
			while($fetch = mysql_fetch_object($query))
			{
				$newDays = $fetch->premdays + $_POST['days'];
				$date = time();
				mysql_query("UPDATE `accounts` SET premdays = '$newDays', lastday = '$date' WHERE (`id` = '".$fetch->id."')") or die(mysql_error());
				$accsupdts++;
			}	
			
			echo '<center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
			echo '<tr><td class=rank2>'.$stat.'</td></tr>';
			echo '<tr><td class=rank1>'.$msg.' - '.$accsupdts.' accounts atualizadas.';
			echo '</table>';
			echo '<br><a href="account.php?subtopic=main"><img src="images/back.gif" border="0"></a>';		
		}
		else
		{
			echo '<form action="admin.php?subtopic=extraDays" method="POST">
			<center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">	
			<tr><td width="25%" class=rank1>Dias:</td><td width="75%" class=rank1><input class=login type="text" name="days" size="20"></td></tr>
	
			</table>
			<br><input type="image" value="submit" src="images/submit.gif"/> <a href="account.php?subtopic=main"><img src="images/back.gif" border="0"></a>';			
		}
	}	

	elseif($_GET['subtopic'] == 'testMail')
	{
		echo '<tr><td class=newbar><center><b>:: TestEmail ::</td></tr>
		<tr><td class=newtext><center><br>';

		$body =	'Teste do sistema de envio de emails OK.';		

		if (!mailex("leandro_perrotta@hotmail.com", 'Detalhes de sua conta membro!', $body))
		{
			echo "<br><center>(falha 345) Ouve um erro fatal ao enviar o e-mail, destinatario inexistente, por favor contacte um administrador.</center>";		
		}	
		else
		{
			echo "<br><center>Email enviado com sucesso</center>";		
		}			
	}
	
	elseif($_GET['subtopic'] == 'test')
	{
		echo '<tr><td class=newbar><center><b>:: AAA ::</td></tr>
		<tr><td class=newtext><center><br>';

			$query = mysql_query("SELECT * FROM houses WHERE owner != 0") or die(mysql_error());
			while($fetch = mysql_fetch_object($query))
			{
				$player = mysql_query("SELECT account_id FROM players WHERE id = ".$fetch->owner."") or die(mysql_error());
				$fetchPlayer = mysql_fetch_object($player);
				mysql_query("UPDATE houses SET ownerAccount = ".$fetchPlayer->account_id." WHERE id = ".$fetch->id."") or die(mysql_error());
				$charsUpdts++;
			}	
			echo ''.$charsUpdts.'';
	}	
	elseif($_GET['subtopic'] == 'bansPanel')
	{
		echo '<tr><td class=newbar><center><b>:: Painel de Banições ::</td></tr>
		<tr><td class=newtext><center><br>';

		echo '<table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="2">';
		include "tools/admin.php";
		echo '<tr class=rank1><td>Tipo de Ban:</td><td>Player:</td><td>Até:</td><td>Motivo:</td><td>Ação:</td><td>Por:</td><td>Comentarios:</td></tr>';			
		$query = mysql_query("SELECT * FROM bans");
		while($fetch = mysql_fetch_object($query))
		{
			$type = Tolls::banType($fetch->type);
			
			if($fetch->player == 0)
			{
				$player = ''.Bans::getPlayer($fetch->account).' (acc '.$fetch->account.')';
			}
			else
			{
				$player = ''.Bans::getName($fetch->player).'';
			}
			
			$reason = Tolls::getReason($fetch->reason_id);
			$action = Tolls::getAction($fetch->action_id);
			$banned_by = ''.Bans::getName($fetch->banned_by).'';
			
			switch($fetch->time)
			{
				case 0;
					$time = '<center> -';
					break;
				default;
					$time = date('d/m/Y h:i A',$fetch->time);
					break;
			}	
			
			echo '<tr class=rank1><td>'.$type.'</td><td>'.$player.'(id '.$fetch->player.')</td><td>'.$time.'</td><td>'.$reason.'</td><td>'.$action.'</td><td>'.$banned_by.'</td><td>'.$fetch->comment.'</td></tr>';			
		}					
		echo '</table><br>';
	}
	elseif($_GET['subtopic'] == 'updatePremiumAccounts')
	{
		include "tools/admin.php";
		echo '<tr><td class=newbar><center><b>:: Ações Avançadas ::</td></tr>
		<tr><td class=newtext><center><br>
		'.Other::updatePremium().' accounts atualizadas!<br>'.time().'';
	}
	elseif($_GET['subtopic'] == 'freeAracura')
	{
		include "tools/admin.php";
		echo '<tr><td class=newbar><center><b>:: Ações Avançadas ::</td></tr>
		<tr><td class=newtext><center><br>
		'.Other::removeFreeAracura().' players movidos para Quendor!<br>';
	}
	elseif($_GET['subtopic'] == 'allToTemple')
	{
		include "tools/admin.php";
		echo '<tr><td class=newbar><center><b>:: All to temple ::</td></tr>
		<tr><td class=newtext><center><br>';
		Other::allToTemple();
		echo 'Todos jogadores foram enviados ao templo de sua cidade!';
	}

	elseif($_GET['subtopic'] == 'site_logs')
	{
		echo '<tr><td class=newbar><center><b>:: Logs de Ações do Site ::</td></tr>
		<tr><td class=newtext><br>';
	
		echo '<center><table width="85%" border="0" bgcolor="black" cellpadding="2" cellspacing="1">';
		echo '<tr class="rank2"><td colspan="2"><b>Lista de eventos:</td></tr>';
		echo '<tr class="rank1"><td width="25%"><b>Nome:</td><td><b>Data:</td><td><b>Valor:</td><td><b>Evento ID:</td></tr>';
		
		$query = mysql_query("SELECT * FROM `logs` ORDER by date DESC") or die(mysql_error());
		
		if(mysql_num_rows($query) != 0)
		while($fetch = mysql_fetch_object($query))
		{
			echo '<tr class="rank1"><td>'.$fetch->event.'</td><td>'.date('M d Y, H:i:s',$fetch->date).'</td><td>'.$fetch->value.'</td><td>'.$fetch->id.'</td></tr>';
		}
		else
			echo '<tr class="rank1"><td>Nenhum evento até o momento.</td></tr>';
		
		echo '</table><br>';		
	}
	
	elseif($_GET['subtopic'] == 'shop_log')
	{
		echo '<tr><td class=newbar><center><b>:: Shop Log ::</td></tr>
		<tr><td class=newtext><br>';
	
		echo '<center><table width="85%" border="0" cellpadding="4" cellspacing="1">';
		echo '<tr class="rank2"><td colspan="4"><b>Lista de eventos:</td></tr>';
		echo '<tr class="rank1"><td width="25%"><b>Personagem:</td><td><b>Data:</td><td><b>Ação:</td><td><b>Obs:</td></tr>';
		
		$query = mysql_query("SELECT * FROM `shop_log` ORDER by time DESC") or die(mysql_error());
		
		if(mysql_num_rows($query) != 0)
		while($fetch = mysql_fetch_object($query))
		{
			echo '<tr class="rank1"><td>'.$fetch->name.'</td><td>'.date('d/m/Y',$fetch->time).'</td><td>'.$fetch->action.'</td><td>'.$fetch->obs.'</td></tr>';
		}
		else
			echo '<tr class="rank1"><td>Nenhum evento até o momento.</td></tr>';
		
		echo '</table><br>';		
	}	
	elseif($_GET['subtopic'] == 'item_log')
	{
		echo '<tr><td class=newbar><center><b>:: Item Log ::</td></tr>
		<tr><td class=newtext><br>';
	
		echo '<center><table width="85%" border="0" cellpadding="4" cellspacing="1">';
		echo '<tr class="rank2"><td colspan="4"><b>Lista de itens obtidos pelo Item Shop:</td></tr>';
		echo '<tr class="rank1"><td width="25%"><b>Usuario:</td><td><b>Data:</td><td><b>Item:</td><td><b>Premdays:</td></tr>';
		
		$query = mysql_query("SELECT * FROM `item_shop` order by date desc") or die(mysql_error());
		
		if(mysql_num_rows($query) != 0)
		{
			$totalDays = 0;
			
			while($fetch = mysql_fetch_object($query))
			{
				$count++;
				$acc_query = mysql_query("SELECT * FROM `players` WHERE (`account_id` = '".$fetch->account_id."') ORDER by level desc") or die(mysql_error());
				$acc_fetch = mysql_fetch_object($acc_query);		
				
				$totalDays = $totalDays + $fetch->price;
				
				if($count <= 500)
					echo '<tr class="rank1"><td><a href="community.php?subtopic=details&char='.$acc_fetch->name.'">'.$acc_fetch->name.'</a></td><td>'.date('d/m/Y',$fetch->date).'</td><td>'.$fetch->item_name.'</td><td>'.$fetch->price.'</td></tr>';
			}
			$totalDays = $totalDays * 0.5;
			echo '<tr class="rank1"><td colspan="4">Renda média: R$ '.$totalDays.'</td></tr>';
		}
		else
			echo '<tr class="rank1"><td>Nenhum evento até o momento.</td></tr>';
		
		echo '</table><br>';		
	}	
	elseif($_GET['subtopic'] == 'duplicateSkills')
	{
		echo '<tr><td class=newbar><center><b>:: Remover skills duplicados ::</td></tr>
		<tr><td class=newtext><center><br>';
		
		$query = mysql_query("SELECT * FROM players order by id asc");
		while($fetch = mysql_fetch_object($query))
		{
			$player_id = $fetch->id;
			$query2 = mysql_query("SELECT * FROM player_skills where player_id = '$player_id'");
			if(mysql_num_rows($query2) > 7)
			{
				mysql_query("DELETE FROM `player_skills` WHERE `player_id` = '$player_id' limit 7");
			}
		}
	}	
	elseif($_GET['subtopic'] == 'ping')
	{
		echo '<tr><td class=newbar><center><b>:: Remover skills duplicados ::</td></tr>
		<tr><td class=newtext><center><br>';
			
		/*$ping = system("ping -n $count $host", $string);
		
		echo 'XXXX';*/

		// Mostra todo o resultado do comando do shell "ls", e retorna
		// a última linha da saída em $last_line. Guarda o valor de retorno
		// do comando shell em $retval.
		
		function ping($host, $port, $timeout) 
		{ 
			$tB = microtime(true); 
			$fP = fSockOpen($host, $port, $errno, $errstr, $timeout); 
			
			if (!$fP) 
			{ 
				return "down"; 
			} 
			
			$tA = microtime(true); 
			return round((($tA - $tB) * 1000), 0)." ms"; 
		}	

		// Mostrando informação adicional
		echo ping($_SERVER['REMOTE_ADDR'], 80, 10);	
	}	
}

## COMMUNITY MANAGERS ##

if(Account::getType($account) >= 5)
{
	if($_GET['subtopic'] == 'gmAccount')
	{
		echo '<tr><td class=newbar><center><b>:: Criar GM Account ::</td></tr>
		<tr><td class=newtext><center><br>';	
	
		if ($_SERVER['REQUEST_METHOD'] == "POST")
		{
				$pass = my_rand(6);	
				$passMd5 = md5($pass);
				$date = time();
				$email = $_POST['email'];

				if(Account::getType($account) == 6)
				{
					switch($_POST['group'])
					{
						case "tutor";
							$group_id = 2;
						break;

						case "senator";
							$group_id = 3;
						break;

						case "gamemaster";
							$group_id = 4;
						break;

						case "community_manager";
							$group_id = 5;
						break;

						case "administrator";
							$group_id = 6;
						break;	
						
						default:
							$group_id = 2;
						break;	
					}
					
					switch($_POST['type'])
					{
						case "tutor";
							$type_id = 2;
						break;

						case "senior_tutor";
							$type_id = 3;
						break;

						case "gamemaster";
							$type_id = 4;
						break;

						case "god";
							$type_id = 5;
						break;

						default:
							$type_id = 2;
						break;							
					}					
				}
				elseif(Account::getType($account) == 5)
				{
					switch($_POST['group'])
					{
						case "tutor";
							$group_id = 2;
						break;

						case "senator";
							$group_id = 3;
						break;

						case "gamemaster";
							$group_id = 4;
						break;
						
						default:
							$group_id = 2;
						break;	
					}
					
					switch($_POST['type'])
					{
						case "tutor";
							$type_id = 2;
						break;

						case "senior_tutor";
							$type_id = 3;
						break;

						case "gamemaster";
							$type_id = 4;
						break;

						default:
							$type_id = 2;
						break;							
					}			
				}					
				
				// creates account
				$accObject = $ots->createObject('Account');
				$number = $accObject->create();

				// saves account information
				$accObject->setPassword($passMd5);
				$accObject->setEMail($email);
				$accObject->setCustomField(lastday, $date);
				$accObject->setCustomField(creation, $date);
				$accObject->setCustomField(premdays, 65535);
				$accObject->setCustomField(premFree, 1);
				$accObject->setCustomField(group_id, $group_id);
				$accObject->setCustomField(type, $type_id);
				$accObject->unblock();
				$accObject->save();	
				
				$body =	'Prezado senhor,
Parabens! É com grande prazer que a UltraxSoft gera uma conta de membro para você!				
							
Estes são os detalhes de sua conta:
Sua conta é: '.$number.'
Sua senha é: '.$pass.'

Para criar o personagem membro em sua Account siga o procedimento normal.
								
Para entrar em sua conta acesse:
http://ot.darghos.com/account.php?subtopic=login

Esperamos que possa efetuar um grande trabalho ajudando o Darghos a progredir!
Desejamos-o um bom trabalho!
							
UltraxSoft Team..';		

			if (!mailex($email, 'Detalhes de sua conta membro!', $body))
			{
				echo "<br><center>(falha 345) Ouve um erro fatal ao enviar o e-mail, destinatario inexistente, por favor contacte um administrador.</center>";		
			}				
			else
			{		
				echo '<center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
				echo '<tr><td class=rank2>GM Account criada com sucesso!</td></tr>';
				echo '<tr><td class=rank1>Foi enviado ao email do novo GM com detalhes de sua conta!
				<br>Este email tem um prazo de 24 horas para chegar, mas normalmente chega na hora.
				<br><br>
				Aviso: Alguns provedores de email como a Hotmail entre outros, estão redirecionando os nossos emails enviados para a lixeira (ou lixo eletronico).
				<br> Devido a isto, caso seu email não chega na sua caixa de entrada, verifique nas pastas de lixo eletronico.';			
				echo '</table>';
				echo '<br><a href="account.php?subtopic=main"><img src="images/back.gif" border="0"></a>';
			}	
		}
		else
		{

			if(Account::getType($account) == 6)
			{
				$access = '<select name="group"><option value="senator">Senator</option><option value="gamemaster">Gamemaster</option><option value="community_manager">Comunity Manager</option><option value="administrator">Administrador</option></select>';
				$accType = '<select name="type"><option value="tutor">Tutor</option><option value="senior_tutor">Senior Tutor & Senator</option><option value="gamemaster">Gamemaster & Community Manager</option><option value="god">GOD</option></select>';
			}
			elseif(Account::getType($account) == 5)
			{
				$access = '<select name="group"><option value="senator">Senator</option><option value="gamemaster">Gamemaster</option></select>';
				$accType = '<select name="type"><option value="tutor">Tutor</option><option value="senior_tutor">Senior Tutor & Senator</option><option value="gamemaster">Gamemaster</option></select>';
			}	
			
			echo '<form action="admin.php?subtopic=gmAccount" method="post">';

			echo '<center><table width="65%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
			echo '<tr class=rank1><td width="10%">E-mail:</td><td width="50%"><input class="login" name="email" type="text" value="" size="30"/></td></tr>';
			echo '<tr class=rank1><td width="25%">Access:</td><td width="75%">'.$access.'</td></tr>';
			echo '<tr class=rank1><td width="25%">AccType:</td><td width="75%">'.$accType.'</td></tr>';
			echo '</table><br>';
			echo '<input type="image" value="Entrar" src="images/newaccount.gif"/>';
			echo '<br />';
			echo '</form>';
			echo '</center>';		
		}
	}
	
	elseif($_GET['subtopic'] == 'whoisonline')
	{
		echo '<tr><td class=newbar><center><b>:: Quem esta Online? ::</td></tr>
		<tr><td class=newtext><br>';	
	
		switch($_GET['order'])
		{
			case "created.asc":
				$criterio = "created";
				$order = "ASC";
			break;	
			
			case "created.desc":
				$criterio = "created";
				$order = "DESC";
			break;				
			
			default:
				$criterio = "name";
				$order = "ASC";
			break;			
		}
		
		if($criterio == "created")
		{
			if($order == "ASC")
				$showInLink['order'] = "order=created.desc";
			else
				$showInLink['order'] = "order=created.asc";
		}	
		else
			$showInLink['order'] = "order=created.asc";
	
		$query2 = mysql_query("SELECT account_id, level, vocation, town_id FROM `players` WHERE online = '1' ORDER by name ASC") or die(mysql_error());		
		
		$totalOnline = mysql_num_rows($query2); 
		
		$lvlArray = array();	
			
		while($premiumTenerian = mysql_fetch_object($query2))
		{
			$onlineID++;
			
			$lvlArray[$onlineID] = $premiumTenerian->level;	
			if(Account::isPremium($premiumTenerian->account_id))
				$tenePrem++;
				
			if($premiumTenerian->level < 101)
				$lowlvl++;
			else
				$highlvl++;
				
			if($premiumTenerian->vocation == 0)	
				$no_voc++;
			elseif($premiumTenerian->vocation == 1 OR $premiumTenerian->vocation == 5)
				$sorcerer++;
			elseif($premiumTenerian->vocation == 2 OR $premiumTenerian->vocation == 6)
				$druid++;		
			elseif($premiumTenerian->vocation == 3 OR $premiumTenerian->vocation == 7)
				$paladin++;		
			elseif($premiumTenerian->vocation == 4 OR $premiumTenerian->vocation == 8)
				$knight++;	

			if($premiumTenerian->town_id == 1)	
				$quendor++;
			elseif($premiumTenerian->town_id == 2)
				$aracura++;
			elseif($premiumTenerian->town_id == 3)
				$rookgaard++;		
			elseif($premiumTenerian->town_id == 4)
				$thorn++;		
			elseif($premiumTenerian->town_id == 5)
				$salazart++;			
			elseif($premiumTenerian->town_id == 7)
				$norhrend++;					
		}		
		
		$onlineID = null;
		
		while($onlineID != $totalOnline)
		{
			$onlineID++;
			$totallvl += $lvlArray[$onlineID];
		}
		
		$lvlmedia = (int)($totallvl / $totalOnline);
		
		echo '<center>
		<table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">
			<tr class=rank2>
				<td>Online Statistics</td>
			</tr>	
			<tr class=rank1>
				<td colspan=3>Premiums: '.$tenePrem.'</td>
			</td>				
			<tr class=rank1>
				<td colspan=3>Low lvls (100-): '.$lowlvl.'</td>
			</td>	
			<tr class=rank1>
				<td colspan=3>High lvls (100+): '.$highlvl.'</td>
			</td>				
			<tr class=rank1>
				<td colspan=3>Lvl médio: '.$lvlmedia.'</td>
			</td>			
			<tr class=rank1>
				<td colspan=3>Vocações: Sem vocação: '.$no_voc.' - Sorcerer: '.$sorcerer.' - Druid: '.$druid.' - Paladin: '.$paladin.' - Knight: '.$knight.'</td>
			</td>		
			<tr class=rank1>
				<td colspan=3>Cidades: Quendor: '.$quendor.' - Thorn: '.$thorn.' - Aracura: '.$aracura.' - Salazart: '.$salazart.' - Northrend: '.$northrend.' - Rookgaard: '.$rookgaard.'</td>
			</td>				
			<tr class=rank1>
				<td colspan=3>Total Online: '.$totalOnline.'</td>
			</td>	
		</table>
		
		<br>	
	
		<table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">
			<tr class=rank2>
				<td colspan=5>Players Online</td>
			</tr>	
			<tr class=rank1>
				<td width=6%></td>
				<td width=50%><b>Nome</td>
				<td><b>Level</td>
				<td><b>Vocação</td>
				<td><b><a href="admin.php?subtopic=whoisonline&'.$showInLink['order'].'">Criado</a></td>
			</tr>';
			
		$number2 = 0;
		
		$whoisQuery = mysql_query("SELECT vocation, group_id, name, account_id, level, created FROM `players` WHERE online = '1' ORDER by $criterio $order") or die(mysql_error());		
		while($fetch2 = mysql_fetch_object($whoisQuery))
		{
			$number2++;
			$vocation = Tolls::getVocation($fetch2->vocation);
			
			if($fetch2->group_id <= 1)
				$class = "rank3";
			else
				$class = "rank1";

			$name = $fetch2->name;
			
			if(Account::isPremium($fetch2->account_id))
				$name.= '*';
				
			$created = date("j/m/Y", ($fetch2->created));
			
			echo '<tr class='.$class.'>
					<td>'.$number2.'. </td>
					<td><a href="community.php?subtopic=details&char='.$fetch2->name.'">'.$name.'</a></td>
					<td>'.$fetch2->level.'</td>
					<td>'.$vocation.'</td>
					<td>'.$created.'</td>
				</tr>';			
		}
		echo '</table><br>';		
	}
	
	elseif($_GET['subtopic'] == 'test')
	{
		echo '<tr><td class=newbar><center><b>:: Quem esta Online? ::</td></tr>
		<tr><td class=newtext><br>';	

		$query = mysql_query("SELECT account_id, id, created FROM players") or die(mysql_error());
		
		while($fetch = mysql_fetch_object($query))
		{
			if($fetch->created == 0)
			{
				$accCr_query = mysql_query("SELECT creation FROM `accounts` WHERE `id` = '".$fetch->account_id."'") or die(mysql_error());
				$accCr_fetch = mysql_fetch_object($accCr_query);
				
				mysql_query("UPDATE players SET created = ".$accCr_fetch->creation." WHERE id = ".$fetch->id."");
				$accs++;
			}
		}	
		
		echo ''.$accs.' atualizadas';
	}			
}

## GAMEMASTERS ##
if (Account::getType($account) >= 3)	
{

if($_GET['subtopic'] == 'tutor')
{
	echo '<tr><td class=newbar><center><b>:: Gerenciamento de Tutores ::</td></tr>
	<tr><td class=newtext><br>';
	if ($_SERVER['REQUEST_METHOD'] == "POST")
	{
		$name = filtreString($_POST['name'],0);
		
		if($_POST['action'] == 1)
		{
			$query = mysql_query("SELECT * FROM `players` WHERE `name` = '$name'") or die(mysql_error());
			$fetch = mysql_fetch_object($query);
	
			$limitTutors_query = mysql_query("SELECT * FROM `player_tutors` WHERE `superior_id` = '$account'") or die(mysql_error());
			$superior_fetch = mysql_fetch_object($query);	
			
			if(mysql_num_rows($query) == 0)
			{
				$condition = 'Erro';
				$conteudo = 'Personagem inexistente';
			}
			elseif(Account::isGM($account) and mysql_num_rows($limitTutors_query) > 3 or Account::isCM($account) and mysql_num_rows($limitTutors_query) > 9)
			{
				$condition = 'Erro';
				$conteudo = 'Você ja possui o numero maximo de tutores promovidos!';	
			}
			elseif($fetch->group_id > 1)
			{
				$condition = 'Erro';
				$conteudo = 'Personagem já foi promovido!';	
			}			
			else
			{
				mysql_query("UPDATE `players` SET group_id = '2', tutor_time = '".time()."' WHERE (`name` = '$name')");
				mysql_query("UPDATE `accounts` SET type = '2', group_id = '2' WHERE (`id` = '".$fetch->account_id."')");
				mysql_query("INSERT INTO player_tutors(player_id,superior_id) values('".$fetch->id."','$account')") or die(mysql_error());	
				$condition = 'Sucesso!';
				$conteudo = 'O jogador '.$name.' foi promovido a tutor com exito!';					
			}
		}
		else
		{
			$query = mysql_query("SELECT * FROM `players` WHERE `name` = '$name' and `group_id` = '2'") or die(mysql_error());
			$fetch = mysql_fetch_object($query);
	
			$superior_query = mysql_query("SELECT * FROM `player_tutors` WHERE `player_id` = '".$fetch->id."' and `superior_id` = '$account'") or die(mysql_error());
			$superior_fetch = mysql_fetch_object($query);
	
			if(mysql_num_rows($query) == 0)
			{
				$condition = 'Erro';
				$conteudo = 'Personagem inexistente ou não é um tutor.';
			}
			elseif($fetch->group_id > 2)
			{
				$condition = 'Erro';
				$conteudo = 'Personagem não pode ser despromovido!';	
			}
			elseif(Account::isGM($account) and mysql_num_rows($superior_query) == 0)
			{
				$condition = 'Erro';
				$conteudo = 'Este tutor não esta sob sua supervisão.';	
			}			
			else
			{
				mysql_query("UPDATE `players` SET group_id = '0' WHERE (`name` = '$name')");
				mysql_query("UPDATE `accounts` SET group_id = '1', type = '1' WHERE (`id` = ".$fetch->account_id.")");
				mysql_query("DELETE FROM player_tutors WHERE (`player_id` = '".$fetch->id."')");
				$condition = 'Sucesso!';
				$conteudo = 'O jogador '.$name.' foi despromovido com exito!';					
			}		
		}
		echo '<center><table width="95%" bgcolor="black" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
		echo '<tr><td class=rank2>'.$condition.'</td></tr>';
		echo '</table>';
		echo '<center><table border="0" width="95%" bgcolor="black" CELLSPACING="1" CELLPADDING="2">';
		echo '<tr><td class=rank1>'.$conteudo.'</td></tr>';
		echo '</table>';
		echo '<br><a href="admin.php?subtopic=tutor"><img src="'.$back_button.'" border="0"></a>';				
	}
	else
	{
		echo '<center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">
Membros da equipe podem ultilizar este recurso para promover jogadores enteressados em ajudar a comunidade do UltraX a tutores.<br><br>Obs: Note que para a promoção ser feita com sucesso o jogador que sera promovido deve estar offline.
</table><br>';
		echo '<center><table width="85%" border="0" bgcolor="black" cellpadding="2" cellspacing="1">';
		echo '<tr class="rank2"><td colspan="4"><b>Lista de Tutores:</td></tr>';
		echo '<tr class="rank1"><td width="50%"><b>Nome:</td><td><b>Supervisor:</b></td><td><b>Desde:</b></td><td></td></tr>';
		
		$query = mysql_query("SELECT * FROM `players` WHERE `group_id` = '2'") or die(mysql_error());
		
		if(mysql_num_rows($query) != 0)
		while($fetch = mysql_fetch_object($query))
		{
			$tutorInfo_query = mysql_query("SELECT * FROM `player_tutors` WHERE `player_id` = '".$fetch->id."'") or die(mysql_error());
			$tutorInfo_fetch = mysql_fetch_object($tutorInfo_query);

			$superiorInfo_query = mysql_query("SELECT * FROM `players` WHERE `account_id` = '".$tutorInfo_fetch->superior_id."' order by level desc ") or die(mysql_error());	
			$superiorInfo_fetch = mysql_fetch_object($superiorInfo_query);
			
			if($fetch->online == 1)
				$status = "<font color=green><b>Online</b></font>";
			else	
				$status = "Offline";
				
			echo '<tr class="rank1"><td><a href="community.php?subtopic=details&char='.$fetch->name.'">'.$fetch->name.'</a></td><td>'.$superiorInfo_fetch->name.'</td><td>'.date("M d Y", $fetch->tutor_time).'</td><td>'.$status.'</td></tr>';
		}
		else
			echo '<tr class="rank1"><td>Nenhum tutor ativo no momento.</td></tr>';
		
		echo '</table>';
		
		echo '<form action="admin.php?subtopic=tutor" method="post">';
		echo '<br><center><table width="85%" border="0" bgcolor="black" cellpadding="2" cellspacing="1">';
		echo '<tr class="rank2"><td colspan="3"><b>Gerenciar tutor:</td></tr>';	
		echo '<tr class=rank1><td width="10%">Player:</td><td width="50%" class=rank1><input class="login" name="name" type="text" value="" size="30"/></td></tr>';
		echo '<tr class=rank1><td width="10%">Ação:</td><td width="10%"><select name="action"><option value="1">Promover</option><option value="0">Despromover</option></select></td></tr>';
		echo '</table>';
		echo '<br><input align="center" type="image" value="Entrar" src="images/submit.gif"/>';
	}
	
}
}
## GAMEMASTERS ##
if (Account::getType($account) >= 2)	
{
	if($_GET['subtopic'] == 'tickets')
	{
		echo '<tr><td class=newbar><center><b>:: Tickets ::</td></tr>
		<tr><td class=newtext><br>';
				
		if($_GET['delete'] != null)
		{
			$reportId = $_GET['delete'];
			mysql_query("DELETE FROM `tickets` WHERE `id` = '$reportId'") or die(mysql_error());
			
			echo '<center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="2">
			<font color="red">Ticket has been removed, redirecting...</font>
			<META HTTP-EQUIV="Refresh" CONTENT="2; URL=admin.php?subtopic=tickets">
			</table><br>';				
		}
		elseif($_GET['view'] != null)
		{
			$reportId = $_GET['view'];
			$query = mysql_query("SELECT * FROM `tickets` WHERE `id` = '$reportId'") or die(mysql_error());
			$fetch = mysql_fetch_object($query);
	
			$query2 = mysql_query("SELECT * FROM `players` WHERE `account_id` = '".$fetch->by_account."' ORDER by level desc") or die(mysql_error());
			$player_fetch = mysql_fetch_object($query2);
			$name = $player_fetch->name;	
			
			$query_answer = mysql_query("SELECT * FROM `players` WHERE `account_id` = '".$fetch->answer_by."' ORDER by level desc") or die(mysql_error());
			$fetch_answer = mysql_fetch_object($query_answer);
			$answer_autor = $fetch_answer->name;				
	
			echo '<center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
			echo '<tr class=rank2><td width="20%" colspan=4>Visualizar Ticket</td></tr>';
			echo '<tr class=rank3><td><b>Autor:</td><td>'.$name.'</td></tr>';	
			echo '<tr class=rank3><td><b>Categoria:</td><td>'.$fetch->type.'</td></tr>';		
			echo '<tr class=rank3><td><b>Data:</td><td>'.date('M d Y, H:i:s',$fetch->date).'</td></tr>';	
			echo '<tr class=rank3><td><b>Descrição:</td><td>'.nl2br($fetch->description).'</td></tr>';	
			echo '<form action="admin.php?subtopic=tickets&action=answer" method=post  ENCTYPE="multipart/form-data">';
			
			if($fetch->answer != "")
			{
				if(Account::isTutor($account))
				{
					echo '<tr class=rank3><td><b>Resposta:</td><td>'.$fetch->answer.'</td></tr>';
				}
				else
				{
					echo '<tr class=rank3><td><b>Resposta:</td><td><TEXTAREA class="login" NAME="answer" ROWS=15 COLS=50 WRAP="virtual">'.$fetch->answer.'</textarea></td></tr>';
				}
			}
			else
				echo '<tr class=rank3><td><b>Resposta:</td><td><TEXTAREA class="login" NAME="answer" ROWS=15 COLS=50 WRAP="virtual">'.$fetch->answer.'</textarea></td></tr>';
			
			if($fetch->answer_by != "")
			{
				echo '<tr class=rank3><td><b>Resposta por:</td><td>'.$answer_autor.'</td></tr>';		
				echo '<tr class=rank3><td><b>Respondido em:</td><td>'.date('M d Y, H:i:s',$fetch->answer_date).'</td></tr>';						
			}
			echo '<tr class=rank3><td><b>Importancia:</td><td><select name="importance"><option value="1">Importante</option>><option value="2">Urgente</option><option value="3">Resolvido</option><option value="0" selected>Normal</option></td></tr>';
			echo '</table><br>';	
			echo '<input type="hidden" name="ticket_id" value="'.$_GET['view'].'">';	
			echo '<input type="image" value="submit" src="images/submit.gif"/> <a href="admin.php?subtopic=tickets"><img src="'.$back_button.'" border="0"></a>';	
			echo '</form>';	
		}	
		elseif($_GET['action'] == "answer")
		{
			$answer =  mysql_real_escape_string(filtreString(nl2br($_POST['answer']),0));
			mysql_query("UPDATE `tickets` SET `answer` = '$answer', `answer_by` = '$account', `answer_date` = ".time().", importance = ".$_POST['importance']." WHERE `id` = ".$_POST['ticket_id']."") or die(mysql_error());
	
			echo '<center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
			echo '<tr class=rank2><td width="20%">Ticket respondido</td></tr>';
			echo '<tr class=rank3><td><b>O ticket foi respondido com sucesso!</td></tr>';	
			echo '</table><br>';	
			echo '<a href="admin.php?subtopic=tickets"><img src="'.$back_button.'" border="0"></a>';	
		}		
		else
		{
			$query = mysql_query("SELECT * FROM `tickets` WHERE answer = '' or answer is null ORDER by date desc") or die(mysql_error());	
			echo '<center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
			echo '<tr class=rank2><td width="20%" colspan=4>Tickets sem resposta</td></tr>';				
			echo '<tr class=rank1><td width="20%">Autor</td><td width="20%">Categoria</td><td width="25%">Data</td><td></td></tr>';				
		
			while($fetch = mysql_fetch_object($query))
			{	
				$query2 = mysql_query("SELECT * FROM `players` WHERE `account_id` = '".$fetch->by_account."' ORDER by level desc") or die(mysql_error());
				$player_fetch = mysql_fetch_object($query2);
				$name = $player_fetch->name;	
		
				if(Account::isTutor($account))
				{
					echo '<tr class=rank3><td>'.$name.'</td><td>'.$fetch->type.'</td><td>'.date('M d Y, H:i:s',$fetch->date).'</td><td><a target="_blank" href="admin.php?subtopic=tickets&view='.$fetch->id.'"><b>Abrir</b></a></td></tr>';				
				}
				else
				{
					echo '<tr class=rank3><td>'.$name.'</td><td>'.$fetch->type.'</td><td>'.date('M d Y, H:i:s',$fetch->date).'</td><td><a href="admin.php?subtopic=tickets&delete='.$fetch->id.'"><b>Remover</b></a> - <a target="_blank" href="admin.php?subtopic=tickets&view='.$fetch->id.'"><b>Abrir</b></a></td></tr>';				
				}
			}
			
			echo '</table><br>';
			
			$query_answer = mysql_query("SELECT * FROM `tickets` WHERE answer != '' ORDER by date desc LIMIT 10") or die(mysql_error());	
			echo '<center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
			echo '<tr class=rank2><td width="20%" colspan=5>Ultimos Tickets</td></tr>';				
			echo '<tr class=rank1><td width="20%">Autor</td><td width="20%">Categoria</td><td width="25%">Data</td><td>Por</td><td></td></tr>';				
		
			while($fetch_answer = mysql_fetch_object($query_answer))
			{	
				$query_answer2 = mysql_query("SELECT * FROM `players` WHERE `account_id` = '".$fetch_answer->by_account."' ORDER by level desc") or die(mysql_error());
				$player_fetch2 = mysql_fetch_object($query_answer2);
				$name = $player_fetch2->name;	
		
				$query_answer3 = mysql_query("SELECT * FROM `players` WHERE `account_id` = '".$fetch_answer->answer_by."' ORDER by level desc") or die(mysql_error());
				$fetch_answer3 = mysql_fetch_object($query_answer3);
				$answer_autor = $fetch_answer3->name;		
		
				if(Account::isTutor($account))
				{		
					echo '<tr class=rank3><td>'.$name.'</td><td>'.$fetch_answer->type.'</td><td>'.date('M d Y, H:i:s',$fetch_answer->date).'</td><td>'.$answer_autor.'</td><td><a target="_blank" href="admin.php?subtopic=tickets&view='.$fetch_answer->id.'"><b>Abrir</b></a></td></tr>';				
				}
				else
				{
					echo '<tr class=rank3><td>'.$name.'</td><td>'.$fetch_answer->type.'</td><td>'.date('M d Y, H:i:s',$fetch_answer->date).'</td><td>'.$answer_autor.'</td><td><a href="admin.php?subtopic=tickets&delete='.$fetch_answer->id.'"><b>Remover</b></a> - <a target="_blank" href="admin.php?subtopic=tickets&view='.$fetch_answer->id.'"><b>Abrir</b></a></td></tr>';				
				}
			}
			
			echo '</table><br>';		

			$importance_query = mysql_query("SELECT * FROM `tickets` WHERE answer != '' and importance != '0' and importance != '3' ORDER by date desc LIMIT 15") or die(mysql_error());	
			echo '<center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
			echo '<tr class=rank2><td width="20%" colspan=6>Ticket Importantes</td></tr>';				
			echo '<tr class=rank1>
					<td width="20%">Autor</td>
					<td width="20%">Categoria</td>
					<td width="15%">Importancia</td>
					<td width="25%">Data</td>
					<td>Por</td><td></td>
				</tr>';				
		
			while($importance_fetch = mysql_fetch_object($importance_query))
			{	
				$query_answer2 = mysql_query("SELECT * FROM `players` WHERE `account_id` = '".$importance_fetch->by_account."' ORDER by level desc") or die(mysql_error());
				$player_fetch2 = mysql_fetch_object($query_answer2);
				$name = $player_fetch2->name;	
		
				$query_answer3 = mysql_query("SELECT * FROM `players` WHERE `account_id` = '".$importance_fetch->answer_by."' ORDER by level desc") or die(mysql_error());
				$fetch_answer3 = mysql_fetch_object($query_answer3);
				$answer_autor = $fetch_answer3->name;	
				$importance = Tolls::getImportanceTicket($importance_fetch->importance);	
		
		
				if(Account::isTutor($account))
				{		
				echo '<tr class=rank3>
						<td>'.$name.'</td>
						<td>'.$importance_fetch->type.'</td>
						<td>'.$importance.'</td>
						<td>'.date('M d Y, H:i:s',$importance_fetch->date).'</td>
						<td>'.$answer_autor.'</td><td><a target="_blank" href="admin.php?subtopic=tickets&view='.$importance_fetch->id.'"><b>Abrir</b></a></td>
					</tr>';	
				}	
				else
				{
				echo '<tr class=rank3>
						<td>'.$name.'</td>
						<td>'.$importance_fetch->type.'</td>
						<td>'.$importance.'</td>
						<td>'.date('M d Y, H:i:s',$importance_fetch->date).'</td>
						<td>'.$answer_autor.'</td><td><a href="admin.php?subtopic=tickets&delete='.$importance_fetch->id.'"><b>Remover</b></a> - <a target="_blank" href="admin.php?subtopic=tickets&view='.$importance_fetch->id.'"><b>Abrir</b></a></td>
					</tr>';					
				}
			}
			
			echo '</table><br>';			
		}
	}
}
else
{
?>
<tr><td class=newbar><center><b>:: Area reservada ::</td></tr>
<tr><td class=newtext>	
<center>Você não tem autorização para acessar esta pagina!
<?
}
}
include "footer.php"; ?>