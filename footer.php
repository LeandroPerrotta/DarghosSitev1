</td></tr>
</table>
<br>
	  <td class="rcont">
<br>

<?

$account = $_SESSION['account'];
$password = $_SESSION['password'];

if (Account::isLogged($account,$password))	
{
	$accountCountent = '
<table border="0" cellpadding="0" cellspacing="0" width="183px">
	<tr>
		<td><img src="images/buttons/mbutton_account_panel.jpg"></td>
	</tr>
	<tr>
		<td class=menuTop><a href="account.php?subtopic=main"><b>'.$lang['home_account'].'</b></a></td>
	</tr>
	<tr>
		<td class=menuCenter><a href="main.php?subtopic=show_commands"><b>'.$lang['commands_panel'].'</b></a></td>
	</tr>
	';

if(Account::isPremium($account))
{
	$accountCountent .= '
	<!--<tr>
		<td class=menuCenter><a href="main.php?subtopic=tickets"><b>'.$lang['ticket_records'].'</b></a></td>
	</tr>	-->
	<tr>
		<td class=menuDown><a href="main.php?subtopic=post_screenshot"><b>'.$lang['post_screenshot'].'</b></a></td>
	</tr>';
}	
else
{
	$accountCountent .= '
	<tr>
		<td class=menuDown><a href="main.php?subtopic=duplied_name"><b>Nomes Duplicados</b></a></td>
	</tr>';
}	
	

$accountCountent .= '</table><br>';

if(Account::getType($account) >= 3)
{
	$accountCountent .= '
<table border="0" cellpadding="0" cellspacing="0" width="183px">
	<tr>
		<td><img src="images/buttons/mbutton_admin_panel.jpg"></td>
	</tr>	
	
	<tr>
		<td class=menuTop><a href="admin.php?subtopic=tutor"><b>Gerenciar Tutores</b></a></td>
	</tr>';
	
	if(Account::getType($account) >= 4)
	{
		$accountCountent .= '
	<tr>
		<td class=menuCenter><a href="community.php?subtopic=statistics"><b>Estatisticas</b></a></td>
	</tr>
	<tr>
		<td class=menuCenter><a href="admin.php?subtopic=whoisonline"><b>Who is Online</b></a></td>
	</tr>';
	}
	if(Account::getType($account) == 6)
	{
		$accountCountent .= '
	<tr>
		<td class=menuCenter><a href="admin.php?subtopic=polls"><b>Nova enquete</b></a></td>
	</tr>
	<tr>
		<td class=menuCenter><a href="admin.php?subtopic=newsticker"><b>Add Ticker</b></a></td>
	</tr>
	<tr>
		<td class=menuCenter><a href="admin.php?subtopic=news"><b>Escrever notícia</b></a></td>
	</tr>
	<tr>
		<td class=menuCenter><a href="admin.php?subtopic=premium"><b>Ativar Premium Account</b></a></td>
	</tr>
	<tr>
		<td class=menuCenter><a href="admin.php?subtopic=viewPremiums"><b>View Premium Accounts</b></a></td>
	</tr>
	<tr>
		<td class=menuCenter><a href="admin.php?subtopic=paymentsList"><b>Payments List</b></a></td>
	</tr>
	<tr>
		<td class=menuCenter><a href="admin.php?subtopic=updatePremiumAccounts"><b>Atualizar Accounts</b></a></td>
	</tr>		
	<tr>
		<td class=menuCenter><a href="admin.php?subtopic=freeAracura"><b>Retirar Frees de Aracura</b></a></td>
	</tr>	
	<tr>
		<td class=menuCenter><a href="admin.php?subtopic=deletePlayer"><b>Deletar Player</b></a></td>
	</tr>
	<tr>
		<td class=menuCenter><a href="admin.php?subtopic=bansPanel"><b>Painel de Banições</b></a></td>
	</tr>
	<tr>
		<td class=menuCenter><a href="admin.php?subtopic=allToTemple"><b>All to temple</b></a></td>
	</tr>
	<tr>
		<td class=menuCenter><a href="admin.php?subtopic=extraDays"><b>Extra Days</b></a></td>
	</tr>
	<tr>
		<td class=menuCenter><a href="admin.php?subtopic=site_logs"><b>Logs</b></a></td>
	</tr>
	<tr>
		<td class=menuCenter><a href="admin.php?subtopic=shop_log"><b>Shop Log</b></a></td>
	</tr>
	<tr>
		<td class=menuCenter><a href="admin.php?subtopic=item_log"><b>Item Shop Log</b></a></td>
	</tr>
	<tr>
		<td class=menuCenter><a href="admin.php?subtopic=logs_logintries"><b>Logins Log</b></a></td>
	</tr>
	<tr>
		<td class=menuCenter><a href="admin.php?subtopic=getItems"><b>Item Checker</b></a></td>
	</tr>
	<tr>
		<td class=menuCenter><a href="admin.php?subtopic=viewVotes"><b>Votes</b></a></td>
	</tr>';
	}
	$accountCountent .= '
	<tr>
		<td class=menu2Down></td>
	</tr>		
</table><br>';
}

}
else
{
$accountCountent = '
<form action="login.php" method="post">
<table border="0" cellpadding="0" cellspacing="0" width="183px">
	<tr>
		<td>
			<img src="images/buttons/mbutton_login.jpg">
		</td>
	</tr>
	
	<tr>
		<td class=menu2Top></td>
	</tr>	
	<tr>
		<td class=menu2Center>
			<center>
			<table class=status2 width="40%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td><input class="login" name="account" type="password" size="13"/></td>			
				</tr>
				<tr>
					<td><input class="login" name="password" type="password" size="13"/></td>
				</tr>
			</table>	
			<a href="account.php?subtopic=accountRecovery"><font size=1>'.$lang['forgot_account'].'</font></a>
			<br><br>
			<input class="login" type="submit" name="Submit" value="'.$lang['login'].'!" /><br>
			<font size=1>'.$lang['not_have_account'].'<a href="account.php?subtopic=create">'.$lang['clicking_here'].'</b></font></a>!
		</td>
	</tr>
	<tr>
		<td class=menu2Down></td>
	</tr>	
</table></form>';

}

echo ''.$accountCountent.'';

$get_poll = mysql_query("SELECT tittle, end_poll FROM `polls` order by id desc ") or die(mysql_error());
$poll = mysql_fetch_object($get_poll);

if(time() <= $poll->end_poll)
{
	echo '           
	<table border="0" cellpadding="0" cellspacing="0" width="183px">
		<tr>
			<td><img src="images/buttons/mbutton_last_poll.jpg"></td>
		</tr>
		<tr>
			<td class=menu2Top></td>
		</tr>		
		<tr>
			<td class=menu2Center><center><font size=1><b>'.$poll->tittle.'</b>
			<br><br>
			<a href="community.php?subtopic=polls"><img src="'.$vote_button.'" border="0"></a>
			</td>
		</tr>	
		<tr>
			<td class=menu2Down></td>
		</tr>	
		</table>
	<br>';
}

$get_screenshot = mysql_query("SELECT * FROM `screenshot`") or die(mysql_error());
$fetch_ss = mysql_fetch_array($get_screenshot);

echo '           
<table border="0" cellpadding="0" cellspacing="0" width="183px">
	<tr>
		<td><img src="images/buttons/mbutton_last_screen.jpg"></td>
	</tr>
	<tr>
		<td class=menu2Top></td>
	</tr>		
	<tr>
		<td class=menu2Center><center><a href="screenshots/'.$fetch_ss['file'].'"><img border="0" src="screenshots/'.$fetch_ss['file'].'" alt="'.$fetch_ss['tittle'].'" width="170" height="140" /></td>
	</tr>
	<tr>
		<td class=menu2Center><center><font size=1>'.$lang['post_by'].': <b><a href="community.php?subtopic=details&char='.$fetch_ss['autor'].'">'.$fetch_ss['autor'].'</b></td>
	</tr>
	<tr>
		<td class=menu2Down></td>
	</tr>		
</table>';
?>
<br>
<br>

	  </td>
	</tr>
      </table>
    </td>
  </tr>
      </td>
  </tr>
</table>
<table background="images/bk_down.jpg" width="1004px" height="200px">
<tr><td>
</td></tr>
</table>
</center>
<?
$starttime = explode(' ', microtime());
$starttime = $starttime[1] + $starttime[0];

$mtime = explode(' ', microtime());
$totaltime = $mtime[0] + $mtime[1] - $starttime;

echo 'Carregado em '.$totaltime.' segundos.';
?>
</body>
</html>
