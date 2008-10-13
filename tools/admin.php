<?
class News
{
	public function deleteNew($id)
	{
		mysql_query("DELETE FROM `news` WHERE (`ID` = '$id')");
	}	
}
class Deletion
{
	public function player($name,$type)
	{
		$query = mysql_query("SELECT * FROM players WHERE name = '$name'");
		$fetch = mysql_fetch_object($query);
		
		$player_id = $fetch->id;	
		$account_id = $fetch->account_id;	
		
			
		if($type == 0)
		{			
			mysql_query("DELETE FROM `guild_invites` WHERE (`player_id` = '$player_id')") or die(mysql_error());	
			mysql_query("DELETE FROM `guilds` WHERE (`ownerid` = '$player_id')") or die(mysql_error());

			mysql_query("UPDATE `houses` SET `owner` = '0'  WHERE `owner` = '$player_id'");
			mysql_query("DELETE FROM `bans` WHERE (`player` = '$player_id')") or die(mysql_error());

			mysql_query("DELETE FROM `player_deaths` WHERE (`player_id` = '$player_id')") or die(mysql_error());
			mysql_query("DELETE FROM `player_depotitems` WHERE (`player_id` = '$player_id')") or die(mysql_error());		
			mysql_query("DELETE FROM `player_items` WHERE (`player_id` = '$player_id')") or die(mysql_error());	
			mysql_query("DELETE FROM `player_skills` WHERE (`player_id` = '$player_id')") or die(mysql_error());	
			mysql_query("DELETE FROM `player_storage` WHERE (`player_id` = '$player_id')") or die(mysql_error());	
			mysql_query("DELETE FROM `player_viplist` WHERE (`player_id` = '$player_id')") or die(mysql_error());
			mysql_query("DELETE FROM `players` WHERE (`id` = '$player_id')") or die(mysql_error());		
			mysql_query("DELETE FROM `player_deletion` WHERE (`player_id` = '$player_id')") or die(mysql_error());				
		}
		elseif($type == 1)
		{
			$getAllPlayers = mysql_query("SELECT * FROM players WHERE account_id = '$account_id'");
			while($fetchAll = mysql_fetch_object($getAllPlayers))
			{
				$player_idAcc = $fetchAll->id;
				
				mysql_query("DELETE FROM `bans` WHERE (`player` = '$player_idAcc')");	
				mysql_query("DELETE FROM `guild_invites` WHERE (`player_id` = '$player_idAcc')");	
				mysql_query("DELETE FROM `guilds` WHERE (`ownerid` = '$player_idAcc')");
				if($fetch->server == 0)
				mysql_query("UPDATE `uniterian_houses` SET `owner` = '0'  WHERE `owner` = '$player_idAcc'");	
				elseif($fetch->server == 1)		
				mysql_query("UPDATE `tenerian_houses` SET `owner` = '0'  WHERE `owner` = '$player_idAcc'");	
				mysql_query("DELETE FROM `player_deaths` WHERE (`player_id` = '$player_idAcc')");
				mysql_query("DELETE FROM `player_depotitems` WHERE (`player_id` = '$player_idAcc')");		
				mysql_query("DELETE FROM `player_items` WHERE (`player_id` = '$player_idAcc')");	
				mysql_query("DELETE FROM `player_skills` WHERE (`player_id` = '$player_idAcc')");	
				mysql_query("DELETE FROM `player_storage` WHERE (`player_id` = '$player_idAcc')");	
				mysql_query("DELETE FROM `player_viplist` WHERE (`player_id` = '$player_idAcc')");
				mysql_query("DELETE FROM `players` WHERE (`id` = '$player_idAcc')");		
				mysql_query("DELETE FROM `player_deletion` WHERE (`player_id` = '$player_idAcc')");					
			}
			mysql_query("DELETE FROM `accounts` WHERE (`id` = '$account_id')");		
		}		
	}

	public function resetServer($serverId)
	{
		$getAllPlayers = mysql_query("SELECT * FROM players WHERE server = '$serverId'");
		while($fetchAll = mysql_fetch_object($getAllPlayers))
		{
			$player_idAcc = $fetchAll->id;
			
			mysql_query("DELETE FROM `bans` WHERE (`player` = '$player_idAcc')");	
			mysql_query("DELETE FROM `guild_invites` WHERE (`player_id` = '$player_idAcc')");	
			mysql_query("DELETE FROM `guilds` WHERE (`ownerid` = '$player_idAcc')");
			if($fetch->server == 0)
			mysql_query("UPDATE `uniterian_houses` SET `owner` = '0'  WHERE `owner` = '$player_idAcc'");	
			elseif($fetch->server == 1)		
			mysql_query("UPDATE `tenerian_houses` SET `owner` = '0'  WHERE `owner` = '$player_idAcc'");	
			mysql_query("DELETE FROM `player_deaths` WHERE (`player_id` = '$player_idAcc')");
			mysql_query("DELETE FROM `player_depotitems` WHERE (`player_id` = '$player_idAcc')");		
			mysql_query("DELETE FROM `player_items` WHERE (`player_id` = '$player_idAcc')");	
			mysql_query("DELETE FROM `player_skills` WHERE (`player_id` = '$player_idAcc')");	
			mysql_query("DELETE FROM `player_storage` WHERE (`player_id` = '$player_idAcc')");	
			mysql_query("DELETE FROM `player_viplist` WHERE (`player_id` = '$player_idAcc')");
			mysql_query("DELETE FROM `players` WHERE (`id` = '$player_idAcc')");		
			mysql_query("DELETE FROM `player_deletion` WHERE (`player_id` = '$player_idAcc')");					
		}
	}		
}
class Other
{
	public function allToTemple()
	{
		//Quendor Cordenadas
		$xquendor = '2020';
		$yquendor = '1903';
		$zquendor = '7';
		//Salazart Cordenadas
		$xthorn = '2383';
		$ythorn = '1856';
		$zthorn = '7';
		//Aracura Cordenadas
		$xaracura = '2105';
		$yaracura = '2142';
		$zaracura = '7';
		//Salazart Cordenadas
		$xsalazart = '2269';
		$ysalazart = '2686';
		$zsalazart = '4';			
		//temple_id
		$rook = '3';
		$quendor = '1';
		$thorn = '4';
		$aracura = '2';
		$salazart = '5';
		//script
		$quendor_sql = "UPDATE players SET posx = 2020, posy = 1903, posz = 7 WHERE town_id = '".$quendor."'";
		$aracura_sql = "UPDATE players SET posx = ".$xaracura.", posy = ".$yaracura.", posz = ".$zaracura." WHERE town_id = '".$aracura."'";
		$thorn_sql = "UPDATE players SET posx = ".$xthorn.", posy = ".$ythorn.", posz = ".$zthorn." WHERE town_id = '".$thorn."'";
		$salazart_sql = "UPDATE players SET posx = ".$xsalazart.", posy = ".$ysalazart.", posz = ".$zsalazart." WHERE town_id = '".$salazart."'";
		mysql_query($quendor_sql) or die(mysql_error());
		mysql_query($aracura_sql) or die(mysql_error());
		mysql_query($thorn_sql) or die(mysql_error());
		mysql_query($salazart_sql) or die(mysql_error());
	}
	
	public function updatePremium()
	{
		$query = mysql_query("SELECT * FROM accounts WHERE premdays != '0'");
		$updateds = 0;
		
		while($fetch = mysql_fetch_object($query))
		{
			$updateds++;
			$timenow = time();
			$lastUpdate = $fetch->lastday;
			
			$getDays = ($timenow - $lastUpdate)/60/60/24;
			
			if($fetch->premdays > $getDays)
				$newpremdays = $fetch->premdays - $getDays;
			else
				$newpremdays = 0;
				
			mysql_query("UPDATE accounts SET premdays = '$newpremdays', lastday = '$timenow' WHERE(id = '".$fetch->id."')") or die(mysql_error());		
		}
		
		return $updateds;
	}	
	public function removeFreeAracura()
	{
		$query = mysql_query("SELECT id, account_id FROM players WHERE town_id = 2 OR town_id = 5") or die(mysql_error());	
		$updateds = 0;
		
		while($fetch = mysql_fetch_object($query))
		{
			$account_id = $fetch->account_id;
			
			$query2 = mysql_query("SELECT premdays FROM accounts WHERE id = '$account_id'") or die(mysql_error());
			$fetch2 = mysql_fetch_object($query2);
			
			if($fetch2->premdays == 0)	
			{	
				mysql_query("UPDATE players SET posx = '2020', posy = '1903', posz = '7', town_id = '1' WHERE(id = '".$fetch->id."')") or die(mysql_error());		
				$updateds++;
			}
		}
		
		return $updateds;
	}		
}
class Bans
{	
	public function getPlayer($account)
	{
		$query = mysql_query("SELECT * FROM players WHERE account_id = '$account' order by level desc");
		$fetch = mysql_fetch_object($query);
		$name = $fetch->name;
		return $name;
	}	
	
	public function getName($player_id)
	{
		$query = mysql_query("SELECT * FROM players WHERE id = '$player_id'");
		$fetch = mysql_fetch_object($query);
		$name = $fetch->name;
		return $name;
	}		
}
?>