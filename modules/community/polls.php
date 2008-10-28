<?
echo '<tr><td class=newbar><center><b>:: Enquetes ::</td></tr>
<tr><td class=newtext><br>';

$poll = trim($_REQUEST['showpoll']);
$screenshot = trim($_REQUEST['showscreen']);
$account = $_SESSION['account'];
$password = $_SESSION['password'];

if(!$poll)
{	
}
if($poll)
{
	if((isset($account) && isset($password) && $account != null && $account != "" && $password != null && $password != ""))
	{
		if (!get_magic_quotes_gpc()) 
		{
			$poll = addslashes($poll);
		}	
		
		$isPoll = mysql_query("SELECT * FROM `polls` where `id`= '$poll'");
		
		if(mysql_num_rows($isPoll) != 0)
		{
			$span = '2';
			while($pollInfo = mysql_fetch_array($isPoll))
			{	
				$poll_status[1] = '<font color=green><b>Enquete em andamento!</b></font>';
				$poll_status[2] = 'Esta enquete será encerrada em: ';
				$total = $pollInfo['votes_1'] + $pollInfo['votes_2'] + $pollInfo['votes_3'] + $pollInfo['votes_4'] + $pollInfo['votes_5'];
				
				if(POLL::userVoted($account,$poll,1) and !POLL::end($poll))
				{
					$vote_status[1] = '<td><input type="radio" name="option" value="votes_1" style="border: 0;" /></td>';
					$vote_status[2] = '<td><input type="radio" name="option" value="votes_2" style="border: 0;" /></td>';	
					$vote_status[3] = '<td><input type="radio" name="option" value="votes_3" style="border: 0;" /></td>';	
					$vote_status[4] = '<td><input type="radio" name="option" value="votes_4" style="border: 0;" /></td>';	
					$vote_status[5] = '<td><input type="radio" name="option" value="votes_5" style="border: 0;" /></td>';								
			
					$voteIn = '<input type="image" value="submit" src="'.$vote_button.'"/>';
					$span = '3';
				}
				
				if(POLL::end($poll))
				{
					$total_option[1] = (int)(($pollInfo['votes_1']*100)/$total);
					$total_option[2] = (int)(($pollInfo['votes_2']*100)/$total);
					$total_option[3] = (int)(($pollInfo['votes_3']*100)/$total);
					$total_option[4] = (int)(($pollInfo['votes_4']*100)/$total);
					$total_option[5] = (int)(($pollInfo['votes_5']*100)/$total);
					$vote_status[1] = '<td>'.$total_option[1].'%</td>';
					$vote_status[2] = '<td>'.$total_option[2].'%</td>';	
					$vote_status[3] = '<td>'.$total_option[3].'%</td>';	
					$vote_status[4] = '<td>'.$total_option[4].'%</td>';	
					$vote_status[5] = '<td>'.$total_option[5].'%</td>';	
					
					$poll_status[1] = '<font color=red><b>Enquete encerrada!</b></font><br>';
					$poll_status[2] = 'Esta enquete foi encerrada em: ';

					$span = '3';							
				}
				elseif(Account::isAdmin($account))
				{
					$total_option[1] = (int)(($pollInfo['votes_1']*100)/$total);
					$total_option[2] = (int)(($pollInfo['votes_2']*100)/$total);
					$total_option[3] = (int)(($pollInfo['votes_3']*100)/$total);
					$total_option[4] = (int)(($pollInfo['votes_4']*100)/$total);
					$total_option[5] = (int)(($pollInfo['votes_5']*100)/$total);
					$vote_status[1] = '<td>'.$pollInfo['votes_1'].' - '.$total_option[1].'%</td>';
					$vote_status[2] = '<td>'.$pollInfo['votes_2'].' - '.$total_option[2].'%</td>';	
					$vote_status[3] = '<td>'.$pollInfo['votes_3'].' - '.$total_option[3].'%</td>';	
					$vote_status[4] = '<td>'.$pollInfo['votes_4'].' - '.$total_option[4].'%</td>';	
					$vote_status[5] = '<td>'.$pollInfo['votes_5'].' - '.$total_option[5].'%</td>';	
					$span = '3';		
				}
				
				echo '<form action="?page=community.voteInPoll" method="POST">';
				echo '<center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="4">';
				echo 'Status da enquete: '.$poll_status[1].'';								
				echo '<br><b>'.$pollInfo['tittle'].'</b><br><br>';
				echo ''.$pollInfo['detail'].'';
				echo '</table><br>';
				echo '<table width="95%"BORDER="0" CELLSPACING="1" CELLPADDING="4">';
				echo '<tr><td colspan='.$span.' class="rank2">Opções:</td></tr>';
				echo '<tr class=rank1>'.$vote_status[1].'<td width="10%">'.$pollInfo['option_1'].'</td><td>'.$pollInfo['detail_1'].'</td></tr>';
				echo '<tr class=rank1>'.$vote_status[2].'<td>'.$pollInfo['option_2'].'</td><td>'.$pollInfo['detail_2'].'</td></tr>';
				if($pollInfo['option_3'] != '')
					echo '<tr class=rank1>'.$vote_status[3].'<td>'.$pollInfo['option_3'].'</td><td>'.$pollInfo['detail_3'].'</td></tr>';
				if($pollInfo['option_4'] != '')
					echo '<tr class=rank1>'.$vote_status[4].'<td>'.$pollInfo['option_4'].'</td><td>'.$pollInfo['detail_4'].'</td></tr>';
				if($pollInfo['option_5'] != '')
					echo '<tr class=rank1>'.$vote_status[5].'<td>'.$pollInfo['option_5'].'</td><td>'.$pollInfo['detail_5'].'</td></tr>';					
				echo '</table></center>';
				
				$start_poll = date('d/m/Y',$pollInfo['start_poll']);
				$end_poll = date('d/m/Y',$pollInfo['end_poll']);
				echo '';		
				echo '<br><center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="4">';
				echo 'Esta enquete foi iniciada em: '.$start_poll.'.<br>';
				echo ''.$poll_status[2].''.$end_poll.'.<br>';
				if(Account::isAdmin($account))
				{
					echo 'Votos totais: '.$total.'';
				}
				echo '<input type="hidden" name="poll_id" value="'.$pollInfo['id'].'">
				<center><br>'.$voteIn.' <a href="?page=community.polls"><img src="'.$back_button.'" border="0"></a></center>';	
				echo '</table><br></center>';					
			}
		}
	}
	else
	{
		echo '<center><table width="95%"BORDER="0" CELLSPACING="1" CELLPADDING="4">
			<tr><td class="rank2">Login Necessario</td></tr>
			<tr><td class=rank1>Para acessar está pagina é necessario que você esteja logado em sua account, redirecionando para pagina de login...
			</table>
			<META HTTP-EQUIV="Refresh"
CONTENT="3; URL=?page=account.login">';
	}
}
elseif($screenshot)
{
	if((isset($account) && isset($password) && $account != null && $account != "" && $password != null && $password != ""))
	{
		if (!get_magic_quotes_gpc()) 
		{
			$screenshot = addslashes($screenshot);
		}	
		
		$getScreen = mysql_query("SELECT * FROM `player_screenshots` where `id`= '$screenshot'");
		
		if(mysql_num_rows($getScreen) != 0)
		{
			while($screenInfo = mysql_fetch_array($getScreen))
			{					
				echo '<form action="?page=screenshot.vote" method="POST">';
				echo '<center><table width="85%" CELLSPACING="1" CELLPADDING="4">';							
				echo '<tr class="rank2"><td colspan=2>Detalhes da screenshot:</td></tr>';
				echo '<tr class=rank1><td><b>Autor:</b><br>'.$screenInfo['post_by'].'</td><td><b>Titulo:</b><br>'.$screenInfo['tittle'].'</td></tr>';
				echo '<tr class=rank1><td colspan=2><b>Detalhes:</b><br>'.$screenInfo['detail'].'</td></tr>';
				echo '<tr class=rank1><td width="40%"><b>Postado em:</b><br>'.date('d/m/Y h:i A',$screenInfo['date']).'</td><td><b>Votos:</b><br>'.$screenInfo['votes'].'</td></tr>';
				echo '<tr class=rank1><td colspan=2><center><a href="'.$screendir.''.$screenInfo['file'].'"><img src="'.$screendir.''.$screenInfo['file'].'" height=440 width=500></a></td></tr>';
				echo '</table>';	
				echo '<input type="hidden" name="screen_id" value="'.$screenInfo['id'].'">';
				echo '<center><br><input type="image" value="submit" src="'.$vote_button.'"/> <a href="?page=community.polls"><img src="'.$back_button.'" border="0"></a></center>';	
								
			}
		}			
	}
	else
	{
		echo '<center><table width="95%"BORDER="0" CELLSPACING="1" CELLPADDING="4">
			<tr><td class="rank2">Login Necessario</td></tr>
			<tr><td class=rank1>Para acessar está pagina é necessario que você esteja logado em sua account, redirecionando para pagina de login...
			</table>
			<META HTTP-EQUIV="Refresh"
CONTENT="3; URL=?page=account.login">';
	}		
}
else
{
	echo '<center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="4">
	<font color="#4F2700">
	Bem vindo a secção de enquetes! Aqui você pode expressar sua opinião em relação ao Darghos e assim ajudar a melhorarmos cada vez mais o Darghos, por isso lembre-se, sua opinião é muito importante para nós!<br><br>
	As enquetes ficam abertas durante um periodo (de 5 dias a 30 dias) e o resutado e apenas exibido ao fechamento da enquete.<br><br>
	Escolha um topico e escolha a opção que mais lhe agradar, para votar você precisa apenas estar logado em sua conta e conter ao menos um personagem com level 25 ou superior.
	</table><br>';	
	
	$getPollsOpen = mysql_query("SELECT id, tittle, end_poll FROM `polls` where `end_poll` > '".time()."' order by id desc");
	$getPollsClosed = mysql_query("SELECT id, tittle, end_poll FROM `polls` where `end_poll` < '".time()."' order by end_poll desc");
	$lastScreenshot_query = mysql_query("SELECT * FROM `screenshot` order by id desc") or die(mysql_error());
	$getLastDate = mysql_fetch_array($lastScreenshot_query);
	$lastScreenshot = ($getLastDate['date']+60*60*24*15);

	echo '<table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
	echo '<tr><td colspan=2 class=rank2>Active Polls</td></tr>';
	echo '<tr class=rank1><td><b>Topic</td><td><b>End</td></tr>';		
	
	if(mysql_num_rows($getPollsOpen) != 0)
	{			
		while($polls = mysql_fetch_array($getPollsOpen))
		{
			$t++;
			$style = rotateStyle($t);	
			
			$end_poll = date('M d Y',$polls['end_poll']);
			echo '<tr class='.$style.'><td width="80%"><a href="?page=community.polls&showpoll='.$polls['id'].'">'.$polls['tittle'].'</a></td><td>'.$end_poll.'</td></tr>';
			
		}
	}
	else
		echo '<tr class="rank3"><td colspan="2" width="80%">Não há nenhuma enquete aberta.</td></tr>';		

	
	echo '</table>';
	
	
	if(mysql_num_rows($getPollsClosed) != 0)
	{
		echo '<br><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
		echo '<tr class=rank2><td colspan=2>Closed Polls</td></tr>';
		echo '<tr class=rank1><td><b>Topic</td><td><b>End</td></tr>';
		
		$t=0;
		while($polls = mysql_fetch_array($getPollsClosed))
		{
			
			$t++;
			$style = rotateStyle($t);	
			
			$end_poll = date('M d Y',$polls['end_poll']);
			echo '<tr class='.$style.'><td width="80%"><a href="?page=community.polls&showpoll='.$polls['id'].'">'.$polls['tittle'].'</a></td><td>'.$end_poll.'</td></tr>';
			
		}
		
		echo '</table></center>';		
	}	
						
	$getScreenshots = mysql_query("SELECT date, id, file, tittle, post_by FROM `player_screenshots` where (`date` > '".$getLastDate['date']."' and `date`< '".$lastScreenshot."') order by votes desc") or die(mysql_error());		
	if(mysql_num_rows($getScreenshots) != 0)
	{
		echo '<center><table border="0" width="95%" CELLSPACING="1" CELLPADDING="4">';
		echo '<br>Data para encerramento desta votação para screenshot quinzenal: <b>'.date('d/m/Y h:i A',$lastScreenshot).'</b>';
		echo '<br>Para votar em uma screenshot é necessario ter ao menos um personagem level 10 ou superior em sua conta.';
		echo '<br><br><b>Atenção:</b> É apenas permitido um (1) voto por conta, portanto, olhe todas screenshots para ter certeza em qual irá votar.';
		echo '</table>';		
		echo '<center><table width="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4">';
		echo '<br><tr><td colspan=4 class=rank2>Poll to next Screenshot</td></tr>';
		echo '<tr class=rank1><td><b>View</td><td><b>Title</td><td><b>Author</td><td><b>Post in</td></tr>';
		
		
		while($screenshot = mysql_fetch_array($getScreenshots))
		{
			$t++;
			$style = rotateStyle($t);		
			
			$date_post = date('d/m/Y',$screenshot['date']);
			echo '<tr class='.$style.'><td width="15%"><a href="?page=community.polls&showscreen='.$screenshot['id'].'"><img border=0 src="'.$screendir.''.$screenshot['file'].'" width=128 height=128></a></td><td width="50%"><a href="?page=community.polls&showscreen='.$screenshot['id'].'">'.$screenshot['tittle'].'</a></td><td><a href="?page=character.details&char='.$screenshot['post_by'].'">'.$screenshot['post_by'].'</td><td>'.$date_post.'</td></tr>';
			
		}
		
		echo '</table>';		
	}		
	echo '<br>';
}
?>