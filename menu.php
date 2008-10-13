<?
$account = $_SESSION['account'];
$password = $_SESSION['password'];
echo ' <br>


<table class="surround" border="0" cellpadding="0" cellspacing="0"">
	<tr>
		<td>
			<img src="images/buttons/mbutton_community.jpg">
		</td>
	</tr>
	<tr>
		<td class=menuTop>
			<a href="community.php?subtopic=news">'.$lang['arquivo_noticias'].'</a>
		</td>
	</tr>
	<tr>
		<td class=menuCenter>
			<a href="community.php?subtopic=details">'.$lang['personagens'].'</a>
		</td>
	</tr>
	<tr>
		<td class=menuCenter>
			<a href="community.php?subtopic=highscores">'.$lang['highscores'].'</a>
		</td>
	</tr>
	<tr>
		<td class=menuCenter>
			<a href="community.php?subtopic=guilds">'.$lang['guilds'].'</a>
		</td>
	</tr>
	<tr>
		<td class=menuCenter>
			<a href="community.php?subtopic=houses">'.$lang['houses'].'</a>
		</td>
	</tr>	
	<tr>
		<td class=menuCenter>
			<a href="community.php?subtopic=lastKills">'.$lang['last_kills'].'</a>
		</td>
	</tr>	
	<tr>
		<td class=menuCenter>
			<a href="darghopedia.php?subtopic=main">'.$lang['darghopedia'].'</a>
		</td>
	</tr>	
	<tr>
		<td class=menuDown>
			<a href="community.php?subtopic=polls">'.$lang['imagens_enquetes'].'</a>
		</td>
	</tr>		
</table>

<br>';
include "server.php";
$status_sql1 = mysql_query("SELECT * FROM `status` WHERE `server` = '2'") or die(mysql_error());
$get_status1 = mysql_fetch_object($status_sql1);

if($get_status1->status == 'Online')
	$tenerianStatus = $get_status1->playerson;
else
	$tenerianStatus = '<font color=red>Offline</font>';

#####ONLINE VISITORS#####
// The ip-adress from the visitor
$ip_addr = $_SERVER['REMOTE_ADDR']; 

// The file where the information is written to
$file = 'online.dat';

// if the file doesn't excist, it will create one
if (!file_exists($file)) {
 $fp = fopen($file, 'a');
 fclose($fp);
}

// the information that must be created or must been read
$online = file_get_contents($file); 
$online = unserialize($online); 

// updating the file with the information from the visitor
$online['visitors'][$ip_addr] = time(); 

// this si the time after the visitor is show as useless visitor
$timeout = 300; // 300 seconds = 5 minutes 

foreach($online['visitors'] as $key => $val) { 
    if($val < (time() - $timeout)) { 
        unset($online['visitors'][$key]); 
    } 
} 

// showing the visitors online at this moment
$total_visitors = count($online['visitors']); 

// edits if needed the file
if($total_visitors > $get_status1->visitors_record) 
{ 
	mysql_query("UPDATE status SET visitors_record = '$total_visitors', visitors_time = '".time()."'") or die(mysql_error());
} 		

// Write the new information back to the file
$handle = fopen($file, 'w'); 
fwrite($handle, serialize($online)); 
fclose($handle); 

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
			IP: <b>ot.darghos.com</b><br>
			Versão: <b>8.11</b><br>
			'.$lang['porta'].': <b>7171</b><br><br>	
			
			<table class=status2 width="80%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td align="left">
						Jogadores Online:</a>
					</td>
					<td align="right">
						<b>'.$tenerianStatus.'</b>
					</td>
				</tr> 	
				<tr>
					<td align="center" colspan="2">
						<a href="community.php?subtopic=status">Who Is Online?</a>
					</td>	
				</tr> 				
			</table>
			<font color=green><b>Website status:</b></font><br>
			'.$lang['visitors'].': <b>'.$total_visitors.'</b><br>
			'.$lang['most_visitors'].': <b>'.$get_status1->visitors_record.'</b><br />			
		</td>
	</tr>
	<tr>	
		<td class=menu2Down>
		</td>
	</tr>	
</table>
';

echo ''.$statusContent.'';
/*
$powerGammersContent = '
<br>
<table class="surround" border="0" cellpadding="0" cellspacing="0" width="183px">
	<tr>
		<td>
			<img src="images/buttons/mbutton_power_gammers.jpg">
		</td>
	</tr>
	<tr>
		<td class=menu2Top>
		</td>
	</tr>
	<tr>	
		<td class=menu2Center>
			<center>
			<table border="0" cellpadding="4" cellspacing="1" width="92%">
				<tr class=rank2>
					<td width="65%">Name</td>
					<td>Exp</td>
				</tr>';
				
$query = mysql_query("SELECT name, experience_difference FROM `players` WHERE group_id < 2 ORDER by experience_difference DESC LIMIT 5") or die(mysql_error());
while($fetch = mysql_fetch_object($query))
{	
	$pos++;
	$powerGammersContent .= '<tr class=rank3><td><font size=1>'.$pos.'. <a href="community.php?subtopic=details&char='.urlencode($fetch->name).'"><font size=1>'.$fetch->name.'</a></td><td><font size=1>+'.$fetch->experience_difference.'</td></tr>';
}

$powerGammersContent .= '
			</table>
		</td>
	</tr>
	<tr>	
		<td class=menu2Down>
		</td>
	</tr>		
</table><br>';  

echo ''.$powerGammersContent.''; */
?>