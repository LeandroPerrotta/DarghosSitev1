<html>
<head>
<title>Darghos - <? echo SERVER_NAME;?> Server</title>
<meta name="keywords" content="OtServ, tibia, server, otserver, ots, open tibia server, open tibia, games, mmorpg" />
<meta name="author" content="UltraxSoft" />
<meta name="description" content="Darghos é um Open Tibia RPG-Online gratuito, venha conhecer este magnifico projeto!">
<meta name="verify-v1" content="uThQU4N3a3z16281fWAYyDbkuf3XhfCdHhpDOulk5gE=">
<link rel="stylesheet" href="indexs.css" type="text/css">
</head>

<body class="backg">
<center>
<table border="0" cellpadding="0" cellspacing="0">

  <tbody>
    <tr>
    <td class="surround"> 
	
      <table border="0" cellpadding="8" cellspacing="0" width="1000">

        <tbody>
          <tr>
            <td colspan="3" class="top" align="center" background="images/logo.jpg" valign="bottom">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;		</td>

        </tr>

	<tr>

          <td colspan="3" class="nav">
            <center>
<?  
echo'        
	  <a href="index.php" class="navlink" title="Index of Darghos">  '.$lang['home'].'</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;    
	  <a href="?page=about" class="navlink" title="Informations about Darghos"> '.$lang['sobre'].'</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;      
	  <a href="?page=faq" class="navlink" title="Questions and answers frequently"> '.$lang['faq'].'</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;    
	  <a href="?page=contribute.beneficts" class="navlink" title="You want contribute with Darghos?"> '.$lang['premium'].'</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;      
	  <a href="?page=downloads" class="navlink" title="Downloads"> '.$lang['downloads'].'</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;      
	  <a href="?page=support" class="navlink" title="Need help or support?"> '.$lang['suporte'].'</a>';
?>    
  
            </center>
            </td>

          </tr>	
          <tr>
            <td class="lcont">	
<?
echo '
<br>
<table class="surround" border="0" cellpadding="0" cellspacing="0"">
	<tr>
		<td>
			<img src="images/buttons/mbutton_community.jpg">
		</td>
	</tr>
	<tr>
		<td class=menuTop>
			<a href="?page=news.files">'.$lang['arquivo_noticias'].'</a>
		</td>
	</tr>
	<tr>
		<td class=menuCenter>
			<a href="?page=character.details">'.$lang['personagens'].'</a>
		</td>
	</tr>
	<tr>
		<td class=menuCenter>
			<a href="?page=community.highscores">'.$lang['highscores'].'</a>
		</td>
	</tr>
	<tr>
		<td class=menuCenter>
			<a href="?page=community.guilds">'.$lang['guilds'].'</a>
		</td>
	</tr>
	<tr>
		<td class=menuCenter>
			<a href="?page=community.houses">'.$lang['houses'].'</a>
		</td>
	</tr>	
	<tr>
		<td class=menuCenter>
			<a href="?page=community.lastKills">'.$lang['last_kills'].'</a>
		</td>
	</tr>';
	if(SHOW_DARGHOPEDIA == 1)	
	{
		echo '
		<tr>
			<td class=menuCenter>
				<a href="?page=darghopedia">'.$lang['darghopedia'].'</a>
			</td>
		</tr>';
	}
	echo '
	<tr>
		<td class=menuDown>
			<a href="?page=community.polls">'.$lang['imagens_enquetes'].'</a>
		</td>
	</tr>		
</table>

<br>';
$DB->query("SELECT status, players, server_ip, server_port, server_id, server_name, version FROM site.servers_status");	
while($fetch = $DB->fetch())
{
	$i++;
	
	if($fetch->status == 1)
		$players = $fetch->players;
	else
		$players = '<font color=red>Offline</font>';
		
	if($fetch->server_name != "Test Server" OR SHOW_TESTSERVER == 1)	
	{
		$serversstatus .= '
			Nome: <b>'.$fetch->server_name.'</b><br>
			IP: <b><font size="1">'.$fetch->server_ip.'</font></b><br>
			Versão: <b>'.$fetch->version.'</b><br>
			Porta: <b>'.$fetch->server_port.'</b><br><br>	
				
			<table class=status2 width="90%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="60%" align="right">
						Jogadores...</a>
					</td>
					<td align="left">
						<b>'.$players.'</b>
					</td>
				</tr>
			</table><br>';
	}	
}	

$statusContent = '
<table border="0" cellpadding="0" cellspacing="0" width="183px">
	<tr>
		<td>
			<img src="images/buttons/mbutton_status.jpg">
		</td>
	</tr>
	<tr>
		<td class=menu2Top>
		</td>
	</tr>	
	<tr>
		<td class=menu2Center>
			<center>
			'.$serversstatus.'
			<table class=status2 width="80%" border="0" cellspacing="0" cellpadding="0">
				<td>
					<td align="center" colspan="2">
						<a href="?page=community.whoIsOnline">Who Is Online?</a>
					</td>	
				</tr> 				
			</table>
			<br>
			<font size="1"><b>Vote no Darghos!</b></a>
			<a href="http://www.topotserv.com/?act=otserv&serverid=25&module=vote" border="0" target="_blank" title="Vote no Darghos!"><img src="images/others/top300.png" border="0" alt="Clique para votar no TOP" title="Vote no Darghos!"></a>			
		</td>
	</tr>
	<tr>	
		<td class=menu2Down>
		</td>
	</tr>	
</table>
';

echo ''.$statusContent.'';
?>	
          <td class="ccont"><br>
			<TABLE CELLSPACING=0 CELLPADDING=2 BORDER=0 WIDTH=99% align=center class=surround>
					
				<? include_once $module; ?>	
				</td></tr>
			</table>
	</td>
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
		<td class=menuTop><a href="?page=account.main"><b>'.$lang['home_account'].'</b></a></td>
	</tr>
	';

if(Account::isPremium($account))
{
	$accountCountent .= '
	<tr>
		<td class=menuCenter><a href="?page=screenshot.post"><b>'.$lang['post_screenshot'].'</b></a></td>
	</tr>';
}	

if(SHOW_TICKETS == 1)
{
	$accountCountent .= '<tr>
		<td class=menuCenter><a href="?page=account.viewTickets"><b>Meus Bilhetes</b></a></td>
	</tr>';
}

	$accountCountent .= '
	<tr>
		<td class=menuDown><a href="?page=account.commands"><b>'.$lang['commands_panel'].'</b></a></td>
	</tr>
	</table><br>';
	

if(Account::getType($account) >= 4)
{
	$accountCountent .= '
<table border="0" cellpadding="0" cellspacing="0" width="183px">
	<tr>
		<td><img src="images/buttons/mbutton_admin_panel.jpg"></td>
	</tr>	
	
	<tr>
		<td class=menuTop><a href="?page=admin.tutorsManager"><b>Gerenciar Tutores</b></a></td>
	</tr>';
	
	if(Account::getType($account) >= 5)
	{
		$accountCountent .= '
	<tr>
		<td class=menuCenter><a href="?page=admin.statistics"><b>Estatisticas</b></a></td>
	</tr>
	<tr>
		<td class=menuCenter><a href="?page=admin.whoisonline"><b>Who is Online</b></a></td>
	</tr>';
	}
	if(Account::getType($account) == 6)
	{
		$accountCountent .= '
	<tr>
		<td class=menuCenter><a href="?page=admin.newPoll"><b>Nova enquete</b></a></td>
	</tr>
	<tr>
		<td class=menuCenter><a href="?page=admin.tickerManager"><b>Add Ticker</b></a></td>
	</tr>
	<tr>
		<td class=menuCenter><a href="?page=admin.newsManager"><b>Escrever notícia</b></a></td>
	</tr>
	<tr>
		<td class=menuCenter><a href="?page=admin.premiumAdd"><b>Ativar Premium Account</b></a></td>
	</tr>
	<tr>
		<td class=menuCenter><a href="?page=admin.premiumView"><b>View Premium Accounts</b></a></td>
	</tr>
	<tr>
		<td class=menuCenter><a href="?page=admin.premiumPayments"><b>Payments List</b></a></td>
	</tr>
	<tr>
		<td class=menuCenter><a href="?page=admin.deletePlayer"><b>Deletar Player</b></a></td>
	</tr>
	<tr>
		<td class=menuCenter><a href="?page=admin.bansView"><b>Painel de Banições</b></a></td>
	</tr>
	<tr>
		<td class=menuCenter><a href="?page=admin.allToTemple"><b>All to temple</b></a></td>
	</tr>
	<tr>
		<td class=menuCenter><a href="?page=admin.premiumExtra"><b>Extra Days</b></a></td>
	</tr>
	<tr>
		<td class=menuCenter><a href="?page=admin.premiumToAll"><b>Premium to All</b></a></td>
	</tr>	
	<tr>
		<td class=menuCenter><a href="?page=admin.updateAllAccounts"><b>Update Accounts</b></a></td>
	</tr>		
	<tr>
		<td class=menuCenter><a href="?page=admin.logs.siteActions"><b>Logs</b></a></td>
	</tr>
	<tr>
		<td class=menuCenter><a href="?page=admin.logs.shopBeneficts"><b>Shop Log</b></a></td>
	</tr>
	<tr>
		<td class=menuCenter><a href="?page=admin.logs.shopItems"><b>Item Shop Log</b></a></td>
	</tr>
	<tr>
		<td class=menuCenter><a href="?page=admin.logs.loginTries"><b>Logins Log</b></a></td>
	</tr>
	<tr>
		<td class=menuCenter><a href="?page=admin.checkItems"><b>Item Checker</b></a></td>
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
			<a href="?page=lostInterface"><font size=1>'.$lang['forgot_account'].'</font></a>
			<br><br>
			<input class="login" type="submit" name="Submit" value="'.$lang['login'].'!" /><br>
			<font size=1>'.$lang['not_have_account'].'<a href="?page=account.register">'.$lang['clicking_here'].'</b></font></a>!
		</td>
	</tr>
	<tr>
		<td class=menu2Down></td>
	</tr>	
</table></form>';

}

echo ''.$accountCountent.'';

$get_poll = mysql_query("SELECT tittle, end_poll FROM `polls` WHERE end_poll > ".time()." ORDER by id desc ") or die(mysql_error());
if(mysql_num_rows($get_poll) != 0)
{
	$poll = mysql_fetch_object($get_poll);
	
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
			<a href="?page=community.polls"><img src="'.$vote_button.'" border="0"></a>
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
		<td class=menu2Center><center><font size=1>'.$lang['post_by'].': <b><a href="?page=character.details&char='.$fetch_ss['autor'].'">'.$fetch_ss['autor'].'</b></td>
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

<table>
	<tr>
		<td>
			<img src="images/bk_down.jpg" width="1004px" height="200px" border="0" usemap="#ultraxsoft">
		</td>
	</tr>
</table>
</center>

<map id ="ultraxsoft" name="ultraxsoft">
  <area shape ="rect" coords ="275,90,735,115" href ="http://www.ultraxsoft.com" alt="UltraxSoft" />
</map>

</body>
</html>			

<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-3541977-1";
urchinTracker();
</script>