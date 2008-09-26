<? 
// connects to database
$ots = POT::getInstance();
$ots->connect(POT::DB_MYSQL, $userdb);

$status2_query = mysql_query("SELECT * FROM `status` WHERE `server` = '2'") or die(mysql_error());
$status2_update = mysql_fetch_array($status2_query);
$timenow = time();

if(mysql_num_rows($status2_query) == 0 or $timenow >= $status2_update['next_update'] or $status2_update['uptime'] == "offline")
{
	$status = $ots->serverStatus("localhost", 7171);
	
	if ($status) 
	{ 
		$state = "Online";
		$players_online = $status->getOnlinePlayers();
		$players_max = $status->getMaxPlayers();
		$playerson = ''.$players_online.' / '.$players_max.'';
		$players_peak = $status->getPlayersPeak();
		$monsters = $status->getMonstersCount();
		
		$uptime['hour'] = floor($status->getUptime() / 3600);
		$uptime['min'] = floor(($status->getUptime() - $uptime['hour'] * 3600) / 60);
		$uptime = "".$uptime['hour']."h ".$uptime['min']."m";
	} 
	else 
	{ 
		$state = 'Offline'; 
	}  
	
	if($players_online > $status2_update['players_record'])
	{
		$newrecord = $players_online;
		$newrecord_time = time();
	}
	else
	{
		$newrecord = $status2_update['players_record'];
		$newrecord_time = $status2_update['record_date'];
	}

	$status_time = 60*1; //atualizaחדo do status
	$nextupdate = (time()+$status_time);

	if($state == "Online")
	{
		if(mysql_num_rows($status2_query) == 0)
		{
			mysql_query("INSERT INTO status (playerson, monsters, uptime, next_update, status, server, players_record, record_date) VALUES('$players_online', '$monsters', '$uptime', '$nextupdate', '$state','2','$newrecord','$newrecord_time')") or die(mysql_error());
		}
		else
		{
			mysql_query("UPDATE status SET playerson = '$players_online', monsters = '$monsters', uptime = '$uptime', next_update = '$nextupdate', status = '$state', players_record = '$newrecord', record_date = '$newrecord_time' WHERE server = '2'") or die(mysql_error());
		}
	}
	else
	{
		if(mysql_num_rows($status2_query) == 0)
		{
			mysql_query("INSERT INTO status (next_update, status, server) VALUES('$nextupdate', '$state','2')") or die(mysql_error());
		}
		else
		{
			mysql_query("UPDATE status SET next_update = '$nextupdate', status = '$state' WHERE server = '2'") or die(mysql_error());
		}	
		
		mysql_query("UPDATE players SET online = 0 WHERE online = '1'") or die(mysql_error());
	}
}
?>