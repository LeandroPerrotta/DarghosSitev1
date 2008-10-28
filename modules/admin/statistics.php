<?
if($engine->accountAccess() >= GROUP_GOD)
{
	echo '<tr><td class=newbar><center><b>:: Estatisticas ::</td></tr>
	<tr><td class=newtext><center><br>';

	$qtd_premium_query = mysql_query("SELECT * FROM `accounts` WHERE (`premdays` > '0' and `premFree` = '0') ") or die(mysql_error());
	$qtd_premium = mysql_num_rows($qtd_premium_query);
	
	$premFree = mysql_query("SELECT * FROM `accounts` WHERE (`premdays` > '0' and `premFree` = '1') ") or die(mysql_error());
	$premFree_sql = mysql_num_rows($premFree);
	
	$premFull_query = mysql_query("SELECT * FROM `premium` WHERE (`premstatus` = '0' or `premstatus` = '1') ") or die(mysql_error());
	$premFull = mysql_num_rows($premFull_query);
	
	$premActived_query = mysql_query("SELECT * FROM `premium` WHERE (`premstatus` = '1') ") or die(mysql_error());
	$premActived = mysql_num_rows($premActived_query);	
	
	$accounts_query = mysql_query("SELECT * FROM `accounts`") or die(mysql_error());
	$accounts = mysql_num_rows($accounts_query);	

	$players_query = mysql_query("SELECT * FROM `players`") or die(mysql_error());
	$players = mysql_num_rows($players_query);		

	$pvpPlayers_query = mysql_query("SELECT * FROM `players` WHERE pvpmode = '0'") or die(mysql_error());
	$pvpPlayers = mysql_num_rows($pvpPlayers_query);	
	
	$noPvpPlayers_query = mysql_query("SELECT * FROM `players` WHERE pvpmode = '1'") or die(mysql_error());
	$noPvpPlayers = mysql_num_rows($noPvpPlayers_query);		
	
	$playersUni_query = mysql_query("SELECT * FROM `players` WHERE server = '0'") or die(mysql_error());
	$playersUni = mysql_num_rows($playersUni_query);		
	
	$playersTen_query = mysql_query("SELECT * FROM `players` WHERE server = '1'") or die(mysql_error());
	$playersTen = mysql_num_rows($playersTen_query);		
	
	$sorc_query = mysql_query("SELECT * FROM `players` where vocation = 1 or vocation = 5") or die(mysql_error());
	$sorcs = mysql_num_rows($sorc_query);	

	$druid_query = mysql_query("SELECT * FROM `players` where vocation = 2 or vocation = 6") or die(mysql_error());
	$druids = mysql_num_rows($druid_query);		
	
	$paladin_query = mysql_query("SELECT * FROM `players` where vocation = 3 or vocation = 7") or die(mysql_error());
	$paladins = mysql_num_rows($paladin_query);			
	
	
	$knight_query = mysql_query("SELECT * FROM `players` where vocation = 4 or vocation = 8") or die(mysql_error());
	$knights = mysql_num_rows($knight_query);	

	$novoc_query = mysql_query("SELECT * FROM `players` where vocation = 0") or die(mysql_error());
	$novocs = mysql_num_rows($novoc_query);		
	
	$timedia = time() - 60*60*24;
	$timeontem = time() - 60*60*24*2;
	$timesem = time() - 60*60*24*7;
	$timequin = time() - 60*60*24*15;
	
	$loginsdia_query = mysql_query("SELECT * FROM `players` where lastlogin > '$timedia'") or die(mysql_error());
	$loginsdia = mysql_num_rows($loginsdia_query);		
	
	$loginssem_query = mysql_query("SELECT * FROM `players` where lastlogin > '$timesem'") or die(mysql_error());
	$loginssem = mysql_num_rows($loginssem_query);		
	
	$loginsquin_query = mysql_query("SELECT * FROM `players` where lastlogin > '$timequin'") or die(mysql_error());
	$loginsquin = mysql_num_rows($loginsquin_query);		

	$loginsontem_query = mysql_query("SELECT * FROM `players` where lastlogin > '$timeontem' and lastlogin < '$timedia'") or die(mysql_error());
	$loginsontem = mysql_num_rows($loginsontem_query);		
	
	echo '<center><table width="95%"BORDER="0" CELLSPACING="1" CELLPADDING="4">';		
	echo '<tr class="rank2"><td colspan=2>Senso de Contas e Jogadores</td></tr>';
	echo '<tr class=rank1><td width="25%">Contas premium:</td><td width="75%">'.$qtd_premium.'</td></tr>
	<tr class=rank1><td width="25%">Free Premium:</td><td width="75%">'.$premFree_sql.'</td></tr>
	<tr class=rank1><td width="25%">Total de Premium:</td><td width="75%">'.$premFull.'</td></tr>
	<tr class=rank1><td width="25%">Premium Ativadas:</td><td width="75%">'.$premActived.'</td></tr>
	<tr class=rank1><td width="25%">Numero de Contas:</td><td width="75%">'.$accounts.'</td></tr>
	<tr class=rank1><td width="25%">Numero de Players:</td><td width="75%">'.$players.'</td></tr>
	<tr class=rank1><td width="25%">Players em Uniterian:</td><td width="75%">'.$playersUni.'</td></tr>
	<tr class=rank1><td width="25%">Players em Tenerian:</td><td width="75%">'.$playersTen.'</td></tr>
	<tr class=rank1><td width="25%">Players PvP:</td><td width="75%">'.$pvpPlayers.'</td></tr>
	<tr class=rank1><td width="25%">Players No-PVP:</td><td width="75%">'.$noPvpPlayers.'</td></tr>
	
	';
	echo '</table><br>';	
	
	echo '<center><table width="95%"BORDER="0" CELLSPACING="1" CELLPADDING="4">';		
	echo '<tr class="rank2"><td colspan=2>Senso de vocações</td></tr>';
	echo '<tr class=rank1><td width="25%">Sorcerers:</td><td width="75%">'.$sorcs.'</td></tr>
	<tr class=rank1><td width="25%">Druids:</td><td width="75%">'.$druids.'</td></tr>
	<tr class=rank1><td width="25%">Paladins:</td><td width="75%">'.$paladins.'</td></tr>
	<tr class=rank1><td width="25%">Knights:</td><td width="75%">'.$knights.'</td></tr>
	<tr class=rank1><td width="25%">Sem-Vocação:</td><td width="75%">'.$novocs.'</td></tr>
	';
	echo '</table><br>';		
	
	echo '<center><table width="95%"BORDER="0" CELLSPACING="1" CELLPADDING="4">';		
	echo '<tr class="rank2"><td colspan=2>Senso de atividade</td></tr>';
	echo '<tr class=rank1><td width="85%">Logins nas ultimas 24h:</td><td width="75%">'.$loginsdia.'</td></tr>
	<tr class=rank1><td>Logins dia anterior:</td><td width="75%">'.$loginsontem.'</td></tr>
	<tr class=rank1><td>Logins na ultima semana:</td><td width="75%">'.$loginssem.'</td></tr>
	<tr class=rank1><td>Logins nos ultimos 15 dias:</td><td width="75%">'.$loginsquin.'</td></tr>
	';
	echo '</table><br>';	
}
?>