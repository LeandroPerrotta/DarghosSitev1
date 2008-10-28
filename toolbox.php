<?
class Logs
{
	public function loginTries($account, $password, $success, $ip_address)
	{
		$time = time();
		mysql_query("INSERT INTO site.logs_logintries (account, password, success, ip, date) values ('$account','$password','$success','$ip_address','$time')") or die(mysql_error());
	}
}

class Kills
{
	public function updateKills()
	{
		$query = mysql_query("SELECT * FROM `players`") or die(mysql_error());
		while($fetch = mysql_fetch_object($query))
		{
			$frags_query = mysql_query("SELECT * FROM `player_deaths` WHERE killed_by = '".$fetch->name."' AND is_player = 1") or die(mysql_error());
			$frags_number = mysql_num_rows($frags_query);
			
			$deaths_query = mysql_query("SELECT * FROM `player_deaths` WHERE player_id = ".$fetch->id."") or die(mysql_error());
			$deaths_number = mysql_num_rows($deaths_query);
			
			mysql_query("UPDATE players SET frags = ".$frags_number.", deaths = ".$deaths_number." WHERE id = ".$fetch->id."") or die(mysql_error());
		}
	}
}

class POLL
{
	public function userVoted($account,$postid,$type)
	{		
		if ($type == 0)
		{
			$query = mysql_query("SELECT * FROM `votes_screen` WHERE (`account_id` = '$account')") or die(mysql_error());
			
			if (mysql_num_rows($query) != 0)
				return false;
			else
				return true;	
		}
		elseif ($type == 1)
		{
			$query = mysql_query("SELECT * FROM `votes_poll` WHERE (`account_id` = '$account' and poll_id = '$postid')") or die(mysql_error());
			
			if (mysql_num_rows($query) != 0)
				return false;
			else
				return true;			
		}		
	}
	public function permission($account,$level)
	{
		$query = mysql_query("SELECT * FROM `players` WHERE (`account_id` = '$account' and level > '$level')") or die(mysql_error());
		
		if (mysql_num_rows($query) == 0)
			return false;
		else
			return true;	
	}	
	public function end($pollid)
	{
		$query = mysql_query("SELECT * FROM `polls` where `id`  = '$pollid' and end_poll < '".time()."'") or die(mysql_error());
		
		if(mysql_num_rows($query) != 0)
			return true;
		else
			return false;		
	}
	public function createPoll($detail,$option1,$option2,$option3,$option4,$option5,$detail1,$detail2,$detail3,$detail4,$detail5,$endtime,$tittle)
	{
		$start_poll = time();
		$end_poll = (time()+60*60*24*$endtime);
		mysql_query("INSERT INTO polls(detail,option_1,option_2, option_3,option_4,option_5,start_poll,end_poll,detail_1,detail_2,detail_3,detail_4,detail_5,tittle) values('".$detail."','".$option1."','".$option2."','".$option3."','".$option4."','".$option5."','".$start_poll."','".$end_poll."','".$detail1."','".$detail2."','".$detail3."','".$detail4."','".$detail5."','".$tittle."')") or die(mysql_error());	
		return true;	
	}	
}

class Account
{	
	public function checkPremiumTest($account)
	{
		$query = mysql_query("SELECT * FROM `accounts` WHERE (`id` = '$account')") or die(mysql_error());
		$fetch = mysql_fetch_object($query);
		
		if($fetch->premTest == 0)
			return true;
		else
			return false;
	}	
	
	public function getEmail($account)
	{
		$query = mysql_query("SELECT * FROM `accounts` WHERE (`id` = '$account')") or die(mysql_error());
		$fetch = mysql_fetch_object($query);
		
		return $fetch->email;
	}	
	
	public function getWarnings($account)
	{
		$query = mysql_query("SELECT * FROM `accounts` WHERE (`id` = '$account')") or die(mysql_error());
		$fetch = mysql_fetch_object($query);
			
		return $fetch->warnings;
	}
	
	public function isLogged($account, $password)
	{
		$query = mysql_query("SELECT * FROM `accounts` WHERE (`id` = '$account' and `password` = '$password')") or die(mysql_error());
		
		if(isset($account) and isset($password) and $account != '' and $password != '' and $account != NULL and $password != NULL)
		{
			if(mysql_num_rows($query) != 0)
				return true;
			else
				return false;	
		}
		return false;	
	}

	public function getType($account)
	{
		$query = mysql_query("SELECT * FROM `accounts` WHERE (`id` = '$account')") or die(mysql_error());
		$fetch = mysql_fetch_object($query);

		return $fetch->group_id;
	}
	
	public function isAdmin($account)
	{
		$query = mysql_query("SELECT * FROM `accounts` WHERE (`id` = '$account' and group_id = '6')") or die(mysql_error());
		
		if(mysql_num_rows($query) != 0)
			return true;
		else
			return false;
	}

	public function isGM($account)
	{
		$query = mysql_query("SELECT * FROM `accounts` WHERE (`id` = '$account' and group_id = '4')") or die(mysql_error());
		
		if(mysql_num_rows($query) != 0)
			return true;
		else
			return false;
	}

	public function isCM($account)
	{
		$query = mysql_query("SELECT * FROM `accounts` WHERE (`id` = '$account' and group_id = '5')") or die(mysql_error());
		
		if(mysql_num_rows($query) != 0)
			return true;
		else
			return false;
	}	
	
	public function isTutor($account)
	{
		$query = mysql_query("SELECT * FROM `accounts` WHERE (`id` = '$account' and group_id = '2')") or die(mysql_error());
		
		if(mysql_num_rows($query) != 0)
			return true;
		else
			return false;
	}		
	
	public function isPlayer($account)
	{
		$query = mysql_query("SELECT * FROM `accounts` WHERE (`id` = '$account' and group_id = '1')") or die(mysql_error());
		
		if(mysql_num_rows($query) != 0)
			return true;
		else
			return false;
	}		
	
	public function isPremium($account)
	{
		$query = mysql_query("SELECT * FROM `accounts` WHERE (`id` = '$account')") or die(mysql_error());
		$fetch = mysql_fetch_object($query);
		
		if($fetch->premdays != 0)
			return true;
		else
			return false;
	}	
	
	public function passCheck($account,$password)
	{
		$query = mysql_query("SELECT * FROM `accounts` WHERE (`id` = '$account' and `password` = '$password')") or die(mysql_error());
		
		if(mysql_num_rows($query) != 0)
			return true;
		else
			return false;
	}	
	
	public function getPremDays($account)
	{
		$query = mysql_query("SELECT * FROM `accounts` WHERE (`id` = '$account')") or die(mysql_error());
		$fetch = mysql_fetch_object($query);
		
		return $fetch->premdays;
	}	

	public function setPremiumTest($account)
	{
		$query = mysql_query("UPDATE `accounts` SET premdays = 5, premfree = 1, lastday = ".time().", premTest = 1 WHERE (`id` = '$account')") or die(mysql_error());
		return 0;
	}		
	
	public function getLevelMasterPlayer($account)
	{
		$query = mysql_query("SELECT * FROM `players` WHERE (`account_id` = '$account') ORDER by level DESC LIMIT 1") or die(mysql_error());
		$fetch = mysql_fetch_object($query);
		
		return $fetch->level;
	}	
	
	public function removePremium($days,$account)
	{
		$query = mysql_query("SELECT * FROM `accounts` WHERE (`id` = '$account')") or die(mysql_error());
		$fetch = mysql_fetch_object($query);
		
		$newDays = $fetch->premdays - $days;
		mysql_query("UPDATE `accounts` set premdays = '$newDays' WHERE (`id` = '$account')") or die(mysql_error());
		return true;
	}	
}

class Shop
{
	public function giveItemToDepot($itemShopId,$player_id,$depot_id,$account)
	{
		$item_array = Shop::getItemShop($itemShopId);
		$item_name = $item_array['name'];
		$item_id = $item_array['id'];
		$item_price = $item_array['price'];
		
		if(isset($item_array['count']))
			$item_count = $item_array['count'];
		else
			$item_count = 1;
		
		$getDepot = mysql_query("SELECT * FROM `player_depotitems` WHERE (`player_id` = '$player_id' and pid = '$depot_id')") or die(mysql_error());	
		$getDepot_fetch = mysql_fetch_object($getDepot);	
		$depotExists = mysql_num_rows($getDepot);
		
		$getLastSid = mysql_query("SELECT * FROM `player_depotitems` WHERE (`player_id` = '$player_id') ORDER by sid desc") or die(mysql_error());	
		$getLastSid_fetch = mysql_fetch_object($getLastSid);	
		$newSid = $getLastSid_fetch->sid + 1;
		$pid = $getDepot_fetch->sid;
		
		if($depotExists != 0)
		{
			if($item_array['countainer'] == true)
			{
				$sidBp = $newSid;
				$quanty = 0; 
				mysql_query("INSERT INTO `player_depotitems` (player_id, sid, pid, itemtype, count)values ('$player_id', '$newSid', '$pid', '1988', '1')") or die(mysql_error());
				while($quanty < 20)
				{
					$quanty++;
					$sidBp++;
					mysql_query("INSERT INTO `player_depotitems` (player_id, sid, pid, itemtype, count)values ('$player_id', '$sidBp', '$newSid', '$item_id', '$item_count')") or die(mysql_error());					
				}	
				mysql_query("INSERT INTO `item_shop` (item_name, account_id, date, price)values ('bp_".$item_name."', '$account', '".time()."', '$item_price')") or die(mysql_error());						
				return true;
			}		
			else
			{		
				mysql_query("INSERT INTO `player_depotitems` (player_id, sid, pid, itemtype, count)values ('$player_id', '$newSid', '$pid', '$item_id', '$item_count')") or die(mysql_error());
				mysql_query("INSERT INTO `item_shop` (item_name, account_id, date, price)values ('$item_name', '$account', '".time()."', '$item_price')") or die(mysql_error());
				return true;					
			}
		}
		else
			return false;
	}	
	
	public function getItemShop($itemShopId)
	{
		if($itemShopId == 1)
			$item = array( 'name' => 'Haunted Blade', 'id' => '7407', 'price' => '5' );
		if($itemShopId == 2)
			$item = array( 'name' => 'Orcish Maul', 'id' => '7392', 'price' => '5' );			
		if($itemShopId == 3)
			$item = array( 'name' => 'Headchopper', 'id' => '7380', 'price' => '5' );		
		if($itemShopId == 4)
			$item = array( 'name' => 'Giant Sword', 'id' => '2393', 'price' => '7' );	
		if($itemShopId == 5)
			$item = array( 'name' => 'Dragon Lance', 'id' => '2414', 'price' => '7' );				
		if($itemShopId == 6)
			$item = array( 'name' => 'Golden Armor', 'id' => '2466', 'price' => '8' );			
		if($itemShopId == 7)
			$item = array( 'name' => 'Dragon Scale Mail', 'id' => '2492', 'price' => '15' );	
		if($itemShopId == 8)
			$item = array( 'name' => 'Magic Plate Armor', 'id' => '2472', 'price' => '25' );	
		if($itemShopId == 9)
			$item = array( 'name' => 'Vampire Shield', 'id' => '2534', 'price' => '5' );
		if($itemShopId == 10)
			$item = array( 'name' => 'Demon Shield', 'id' => '2520', 'price' => '12' );	
		if($itemShopId == 11)
			$item = array( 'name' => 'Mastermind Shield', 'id' => '2514', 'price' => '18' );
		if($itemShopId == 12)
			$item = array( 'name' => 'Crown Legs', 'id' => '2488', 'price' => '5' );	
		if($itemShopId == 13)
			$item = array( 'name' => 'Golden Legs', 'id' => '2470', 'price' => '15' );	
		if($itemShopId == 14)
			$item = array( 'name' => 'Boots of Haste', 'id' => '2195', 'price' => '10' );
		if($itemShopId == 15)
			$item = array( 'name' => 'Royal Helmet', 'id' => '2498', 'price' => '10' );
		if($itemShopId == 16)
			$item = array( 'name' => 'Ring of Healing', 'id' => '2214', 'price' => '10', 'countainer' => true);	
		if($itemShopId == 17)
			$item = array( 'name' => 'Stone Skin Amulet', 'id' => '2197', 'count' => '5', 'price' => '20', 'countainer' => true);	
		if($itemShopId == 18)
			$item = array( 'name' => 'Amulet of Loss', 'id' => '2173', 'price' => '10' );	
		if($itemShopId == 19)
			$item = array( 'name' => 'Infernal Bolt', 'id' => '6529', 'count' => '100', 'price' => '2' );			
		if($itemShopId == 20)
			$item = array( 'name' => 'Blue Robe', 'id' => '2656', 'price' => '4' );		
		if($itemShopId == 21)
			$item = array( 'name' => 'Infernal Bolt', 'id' => '6529', 'count' => '100', 'price' => '20', 'countainer' => true );				
		if($itemShopId == 22)
			$item = array( 'name' => '5k', 'id' => '2152', 'count' => '50', 'price' => '1' );	
		if($itemShopId == 23)
			$item = array( 'name' => '50k', 'id' => '2160', 'count' => '5', 'price' => '10' );			
		if($itemShopId == 24)
			$item = array( 'name' => '100k', 'id' => '2160', 'count' => '10', 'price' => '15' );
		if($itemShopId == 25)
			$item = array( 'name' => 'Sudden Death', 'id' => '2268', 'count' => '100', 'price' => '20', 'countainer' => true );				
		if($itemShopId == 26)
			$item = array( 'name' => 'Ultimate Healing', 'id' => '2273', 'count' => '100', 'price' => '15', 'countainer' => true );		
		if($itemShopId == 27)
			$item = array( 'name' => 'Explosion', 'id' => '2313', 'count' => '100', 'price' => '12', 'countainer' => true );					
		if($itemShopId == 28)
			$item = array( 'name' => 'Teleport Scroll', 'id' => '4328', 'count' => '1', 'price' => '3');	
		if($itemShopId == 29)
			$item = array( 'name' => 'Iron Ore', 'id' => '5880', 'count' => '5', 'price' => '5');		
		if($itemShopId == 30)
			$item = array( 'name' => 'Ape Fur', 'id' => '5883', 'count' => '10', 'price' => '5');		
		if($itemShopId == 31)
			$item = array( 'name' => 'Vampire Dust', 'id' => '5905', 'count' => '5', 'price' => '10');		
		if($itemShopId == 32)
			$item = array( 'name' => 'Demon Dust', 'id' => '5906', 'count' => '5', 'price' => '10');		
		if($itemShopId == 33)
			$item = array( 'name' => 'Spool of Yarn', 'id' => '5886', 'count' => '1', 'price' => '10');		
		if($itemShopId == 34)
			$item = array( 'name' => 'Giant Spider Silk', 'id' => '5879', 'count' => '10', 'price' => '5');		
		if($itemShopId == 35)
			$item = array( 'name' => 'Minotaur Leather', 'id' => '5878', 'count' => '100', 'price' => '5');	
		if($itemShopId == 36)
			$item = array( 'name' => 'Chicken Feather', 'id' => '5890', 'count' => '100', 'price' => '12');		
		if($itemShopId == 37)
			$item = array( 'name' => 'Honeycombs', 'id' => '5902', 'count' => '50', 'price' => '3');		
		if($itemShopId == 38)
			$item = array( 'name' => 'Assassin Star', 'id' => '7368', 'count' => '100', 'price' => '5');		
		if($itemShopId == 39)
			$item = array( 'name' => 'Royal Steel', 'id' => '5887', 'count' => '1', 'price' => '10');			
		if($itemShopId == 40)
			$item = array( 'name' => 'White Piece of Cloth', 'id' => '5909', 'count' => '50', 'price' => '15');			
		if($itemShopId == 41)
			$item = array( 'name' => 'Yellow Piece of Cloth', 'id' => '5914', 'count' => '50', 'price' => '15');
		if($itemShopId == 42)
			$item = array( 'name' => 'Red Piece of Cloth', 'id' => '5911', 'count' => '50', 'price' => '15');
		if($itemShopId == 43)
			$item = array( 'name' => 'Brown Piece of Cloth', 'id' => '5913', 'count' => '50', 'price' => '15');			
		if($itemShopId == 44)
			$item = array( 'name' => 'Green Piece of Cloth', 'id' => '5910', 'count' => '50', 'price' => '15');			
		if($itemShopId == 45)
			$item = array( 'name' => 'Blue Piece of Cloth', 'id' => '5912', 'count' => '50', 'price' => '15');			
		if($itemShopId == 46)
			$item = array( 'name' => 'Piece of Hell Steel', 'id' => '5888', 'count' => '1', 'price' => '30');			
		if($itemShopId == 47)
			$item = array( 'name' => 'Mandrake', 'id' => '5015', 'count' => '1', 'price' => '40');			
		if($itemShopId == 48)
			$item = array( 'name' => 'Huge Chunk of Crude Iron', 'id' => '5892', 'count' => '1', 'price' => '30');
		if($itemShopId == 49)
			$item = array( 'name' => 'Piece of Draconian Steel', 'id' => '5889', 'count' => '1', 'price' => '30');	
		if($itemShopId == 50)
			$item = array( 'name' => 'Shard', 'id' => '7290', 'count' => '1', 'price' => '3');	
		if($itemShopId == 51)
			$item = array( 'name' => 'Dworc Voodoo Doll', 'id' => '3955', 'count' => '1', 'price' => '5');
		if($itemShopId == 52)
			$item = array( 'name' => 'Banana Staff', 'id' => '3966', 'count' => '1', 'price' => '5');
		if($itemShopId == 53)
			$item = array( 'name' => 'Tribal Mask', 'id' => '3967', 'count' => '1', 'price' => '5');
		if($itemShopId == 54)
			$item = array( 'name' => 'Simon the Beggars Favorite Staff', 'id' => '6107', 'count' => '1', 'price' => '40');
		if($itemShopId == 55)
			$item = array( 'name' => 'Holy Orchid', 'id' => '5922', 'count' => '10', 'price' => '10');
		if($itemShopId == 56)
			$item = array( 'name' => 'Hook', 'id' => '6097', 'count' => '10', 'price' => '10');
		if($itemShopId == 57)
			$item = array( 'name' => 'Peg Leg', 'id' => '2162', 'count' => '10', 'price' => '10');
		if($itemShopId == 58)
			$item = array( 'name' => 'Eye Patch', 'id' => '6102', 'count' => '10', 'price' => '10');
		if($itemShopId == 59)
			$item = array( 'name' => 'Elanes Crossbow', 'id' => '5947', 'count' => '1', 'price' => '40');
		if($itemShopId == 60)
			$item = array( 'name' => 'First Nightmare Addon', 'id' => '6387', 'count' => '1', 'price' => '40');
		if($itemShopId == 61)
			$item = array( 'name' => 'Second Nightmare Addon', 'id' => '6388', 'count' => '1', 'price' => '40');
		if($itemShopId == 62)
			$item = array( 'name' => '100 Turtle Shells', 'id' => '5899', 'count' => '100', 'price' => '30');			
			
		
		
		return $item;
	}	
	
	public function getRewardById($rewardId)
	{
		switch($rewardId)
		{
			case 1;
				$rewardId = array('5 premium days','5','20');
				break;
		}		
			
		return $rewardId;
	}	
	
	public function giveBless($playerName)
	{
		mysql_query("UPDATE `players` SET `blessings` = '31' WHERE (`name` = '$playerName')") or die(mysql_error());	
		mysql_query("INSERT INTO shop_log (name, time, action) values('$playerName','".time()."','bless')") or die(mysql_error());
	}
	
	public function givePromotion($playerName)
	{
		$query = mysql_query("SELECT * FROM `players` WHERE (`name` = '$playerName')") or die(mysql_error());
		$fetch = mysql_fetch_object($query);
		
		$promote = $fetch->vocation + 4;
		mysql_query("UPDATE `players` SET `vocation` = '$promote' WHERE (`name` = '$playerName')") or die(mysql_error());
		mysql_query("INSERT INTO shop_log (name, time, action) values('$playerName','".time()."','promotion')") or die(mysql_error());
	}
	
	public function giveRank($playerName)
	{
		mysql_query("UPDATE `players` SET `status` = '1' WHERE (`name` = '$playerName')") or die(mysql_error());
		mysql_query("INSERT INTO shop_log (name, time, action) values('$playerName','".time()."','rank')") or die(mysql_error());
	}

	public function changePvp($playerName)
	{
		$query = mysql_query("SELECT pvpmode FROM `players` WHERE (`name` = '$playerName')") or die(mysql_error()) or die(mysql_error());
		$fetch = mysql_fetch_object($query);
		
		$oldPvpMode = $fetch->pvpmode;
		$account = $fetch->account_id;		
		
		if($oldPvpMode == 0)
		{
			$newPvpMode = 1;	
		}	
		elseif($oldPvpMode != 0)
		{
			$newPvpMode = 0;				
		}	
	
		mysql_query("UPDATE `players` SET pvpmode = '$newPvpMode' WHERE (`name` = '$playerName')") or die(mysql_error());
		mysql_query("INSERT INTO shop_log (name, time, action) values('$playerName','".time()."','change pvp mode')") or die(mysql_error());
			
		return 0;
	}		
	
	public function changeName($playerName,$newName)
	{
		mysql_query("INSERT INTO shop_log (name, time, action, obs) values('$playerName','".time()."','change name','$newName')") or die(mysql_error());
	
		$query = mysql_query("SELECT * FROM `players` WHERE (`name` = '$playerName')") or die(mysql_error());
		$fetch = mysql_fetch_object($query);
		
		$account = $fetch->account_id;			
		
		mysql_query("UPDATE `players` SET name = '$newName', old_name = '$playerName' WHERE (`name` = '$playerName')") or die(mysql_error());

		$query1 = mysql_query("SELECT * FROM `accounts` WHERE (`id` = '$account')") or die(mysql_error());	
		$fetch1 = mysql_fetch_object($query1);
		
		$newPremDays = $fetch1->premdays - 10;
		
		mysql_query("UPDATE `accounts` SET premdays = '$newPremDays' WHERE (`id` = '$account')") or die(mysql_error());			
		return 0;
	}
	
	public function changeSex($playerName,$account)
	{
		$query = mysql_query("SELECT * FROM `players` WHERE (`name` = '$playerName')") or die(mysql_error());
		$fetch = mysql_fetch_object($query);
		
		$oldSex = $fetch->sex;
		$account = $fetch->account_id;
		
		$lookbody = 116;
		$lookfeet = 116;
		$lookhead = 116;
		$looklegs = 116;			
		
		if($oldSex == 0)
		{
			$looktype = 128;	
			$newsex = 1;
		}	
		elseif($oldSex == 1)
		{
			$looktype = 136;	
			$newsex = 0;			
		}	
			
		mysql_query("UPDATE `players` SET sex = '$newsex', lookbody = '$lookbody', lookfeet = '$lookfeet', lookhead = '$lookhead', looklegs = '$looklegs', looktype = '$looktype' WHERE (`name` = '$playerName')") or die(mysql_error());	
			
		$query1 = mysql_query("SELECT * FROM `accounts` WHERE (`id` = '$account')") or die(mysql_error());
		$fetch1 = mysql_fetch_object($query1);
		
		$newPremDays = $fetch1->premdays - 5;
		
		mysql_query("UPDATE `accounts` SET premdays = '$newPremDays' WHERE (`id` = '$account')") or die(mysql_error());
		mysql_query("INSERT INTO shop_log (name, time, action) values('$playerName','".time()."','change sex')") or die(mysql_error());
			
		return 0;
	}
}

class Player
{	
	public function getPlayerAccount($player_id)
	{
		$query = mysql_query("SELECT * FROM `players` WHERE (`id` = '$player_id')") or die(mysql_error());
		$fetch = mysql_fetch_object($query);
		return $fetch->account_id;	
	}
	
	/*public function checkWorld($playerId, $worldid)
	{
		$query = mysql_query("SELECT * FROM `players` WHERE (`id` = '$playerId')") or die(mysql_error());
		$fetch = mysql_fetch_object($query);
		if($fetch->server != $worldid)
			return false;
		else		
			return true;	
	}*/

	public function isBlessed($playerName)
	{
		$query = mysql_query("SELECT * FROM `players` WHERE (`name` = '$playerName')") or die(mysql_error());
		$fetch = mysql_fetch_object($query);
		
		if($fetch->blessing != 0)
			return 1;
		else
			return 0;
	}
	
	public function isPromoted($playerName)
	{
		$query = mysql_query("SELECT * FROM `players` WHERE (`name` = '$playerName')") or die(mysql_error());
		$fetch = mysql_fetch_object($query);
		
		if($fetch->vocation == 0)
			return 1;
		elseif($fetch->vocation > 4)	
			return 1;
		else
			return 0;
	}

	public function checkStatus($playerName)
	{
		$query = mysql_query("SELECT * FROM `players` WHERE (`name` = '$playerName')") or die(mysql_error());
		$fetch = mysql_fetch_object($query);
		
		if($fetch->status != 0)
			return 1;
		else
			return 0;
	}	
	
	public function playerExists($playerName)
	{
		$query = mysql_query("SELECT * FROM `players` WHERE (`name` = '$playerName')") or die(mysql_error());
		$rows = mysql_num_rows($query);
	
		return $rows;
	}
	
	public function isOnline($playerName)
	{
		$query = mysql_query("SELECT * FROM `players` WHERE (`name` = '$playerName')") or die(mysql_error());
		$fetch = mysql_fetch_object($query);
		
		$online = $fetch->online;
		return $online;
	}	

	public function getPlayerNameById($playerId)
	{
		$query = mysql_query("SELECT * FROM `players` WHERE (`id` = '$playerId')") or die(mysql_error());
		$fetch = mysql_fetch_object($query);
		
		$playername = $fetch->name;
		return $playername;
	}
	
	public function getPlayerIdByName($name)
	{
		$query = mysql_query("SELECT * FROM `players` WHERE (`name` = '$name')") or die(mysql_error());
		$fetch = mysql_fetch_object($query);
		
		$playerId = $fetch->id;
		return $playerId;
	}
	
	public function getPlayerLevel($playerId)
	{
		$query = mysql_query("SELECT * FROM `players` WHERE (`id` = '$playerId')") or die(mysql_error());
		$fetch = mysql_fetch_object($query);
		
		$playerlevel = $fetch->level;
		return $playerlevel;
	}	
	
	public function getPlayerIP($playerId)
	{
		$query = mysql_query("SELECT * FROM `players` WHERE (`id` = '$playerId')") or die(mysql_error());
		$fetch = mysql_fetch_object($query);
		
		$playerIp = $fetch->lastip;
		return $playerIp;
	}		

	public function checkAccountPlayer($account,$player)
	{
		$query = mysql_query("SELECT * FROM `players` WHERE (`account_id` = '$account' and `name` = '$player')") or die(mysql_error());
		
		if(mysql_num_rows($query) != 0)
			return true;
		else
			return false;		
	}
	
	public function dupliedName($name)
	{
		$query = mysql_query("SELECT * FROM `players` WHERE (`name` = '$name' and `duplied_name` = 1)") or die(mysql_error());
		
		if(mysql_num_rows($query) != 0)
			return true;
		else
			return false;		
	}	
	
	public function changeDupliedName($name, $newname)
	{
		$query = mysql_query("UPDATE `players` SET name = '$newname', duplied_name = 0 WHERE (`name` = '$name' AND duplied_name = 1)") or die(mysql_error());
		
		if($query)
			return true;
		else
			return false;		
	}		
	
	public function checkPlayersDeleted($account)
	{
		$query = mysql_query("SELECT * FROM `players` WHERE (`account_id` = '$account')") or die(mysql_error());
		$players = 0;
		
		while($fetch = mysql_fetch_array($query))
		{
			$player_id = $fetch['id'];
			$query2 = mysql_query("SELECT * FROM `player_deletion` WHERE (`player_id` = '$player_id')") or die(mysql_error());
			
			if(mysql_num_rows($query2) != 0)
				$players++;
		}
		
		if($players != 0)
			return true;
		else
			return false;		
	}	
	
	public function checkIsDeleted($player)
	{
		$query = mysql_query("SELECT * FROM `players` WHERE (`name` = '$player')") or die(mysql_error());
		$fetch = mysql_fetch_array($query);
		$player_id = $fetch['id'];
		
		$query2 = mysql_query("SELECT * FROM `player_deletion` WHERE (`player_id` = '$player_id')") or die(mysql_error());
		if(mysql_num_rows($query2) != 0)
			return true;
		else
			return false;		
	}	
	
	public function agendarDeletamento($player)
	{		
		$query = mysql_query("SELECT `id` FROM `players` WHERE (`name` = '$player')") or die(mysql_error());		
		$date = time() + (60*60*24*30);
		$player_id = mysql_fetch_array($query);
		
		
		mysql_query("INSERT INTO player_deletion(player_id, time) values('".$player_id['id']."','$date')") or die(mysql_error());
		return $date;
	}

	public function undeletePlayer($player)
	{		
		$query = mysql_query("SELECT `id` FROM `players` WHERE (`name` = '$player')") or die(mysql_error());
		$fetch = mysql_fetch_array($query);
		$player_id = $fetch['id'];
		
		mysql_query("DELETE FROM player_deletion WHERE (`player_id` = '$player_id')") or die(mysql_error());
	}	
	
	public function isDeleted($playerid)
	{	
		$query = mysql_query("SELECT * FROM `player_deletion` WHERE (`player_id` = '$playerid')") or die(mysql_error());	
		
		if(mysql_num_rows($query) != 0)
			return true;
		else
			return false;
	}	

	public function exists($name)
	{	
		$query = mysql_query("SELECT * FROM `players` WHERE (`name` = '$name')") or die(mysql_error());	
		
		if(mysql_num_rows($query) != 0)
			return true;
		else
			return false;
	}		
}

class Guilds
{
	public function getGuildNameById($guild_id)
	{
		$query = mysql_query("SELECT * FROM `guilds` WHERE (`id` = '$guild_id')") or die(mysql_error());
		$fetch = mysql_fetch_object($query);
		
		$guild_name = $fetch->name;
		return $guild_name;
	}
	
	public function getUserLevel($guild_id,$account)
	{
		$lastLevel = 21;
		$user_query = mysql_query("SELECT * FROM `players` WHERE (`account_id` = '$account')") or die(mysql_error());
		while($user_fetch = mysql_fetch_object($user_query))
		{
			$userRank_query = mysql_query("SELECT * FROM `guild_ranks` WHERE (`id` = '".$user_fetch->rank_id."' and `guild_id` = '$guild_id')") or die(mysql_error());
			$userRank_fetch = mysql_fetch_object($userRank_query);
			if(mysql_num_rows($userRank_query) != 0)
			{
				if($userRank_fetch->level < $lastLevel)
					$lastLevel = $userRank_fetch->level;
			}		
		}
		
		return $lastLevel;
	}

	public function getMemberLevel($guild_id,$member)
	{
		$member_query = mysql_query("SELECT * FROM `players` WHERE (`id` = '$member')") or die(mysql_error());
		$member_fetch = mysql_fetch_object($member_query);
		
		$memberRank_query = mysql_query("SELECT * FROM `guild_ranks` WHERE (`id` = '".$member_fetch->rank_id."')") or die(mysql_error());
		$memberRank_fetch = mysql_fetch_object($memberRank_query);
		
		return $memberRank_fetch->level;
	}		
	
	public function totalMembers($guildid)
	{
		$getRanks = mysql_query("SELECT * FROM `guild_ranks` WHERE (`guild_id` = '$guildid')") or die(mysql_error());
		$members = 0;
		
		while($ranks_sql = mysql_fetch_array($getRanks))
		{
			$rankid = $ranks_sql['id'];
			$getPlayers = mysql_query("SELECT * FROM `players` WHERE (`rank_id` = '$rankid' and level > '24')") or die(mysql_error());
				while($player_sql = mysql_fetch_array($getPlayers))
				{
					$members++;
				}
		}
		return $members;
	}

	public function invite($name,$guildid)
	{
		$query = mysql_query("SELECT * FROM `players` WHERE (`name` = '$name')") or die(mysql_error());
		$fetch = mysql_fetch_object($query);
		
		mysql_query("INSERT INTO guild_invites(player_id, guild_id) values('".$fetch->id."','$guildid')") or die(mysql_error());	
	}	
	
	public function join($player_id,$guild_id)
	{
		$query = mysql_query("SELECT * FROM `guild_ranks` WHERE (`guild_id` = '$guild_id') ORDER by level desc") or die(mysql_error());
		$fetch = mysql_fetch_object($query);
				
		mysql_query("UPDATE players SET `rank_id` = ".$fetch->id." WHERE (`id` = '$player_id')") or die(mysql_error());	
		mysql_query("DELETE FROM guild_invites WHERE player_id = '$player_id'") or die(mysql_error());
		
		return true;	
	}		

	public function excludeMember($player_id)
	{		
		mysql_query("UPDATE players SET `rank_id` = '0' and `guildnick` = '' WHERE (`id` = '$player_id')") or die(mysql_error());	
		
		return true;	
	}
	
	public function disband($guild_id)
	{		
		$guild_query = mysql_query("SELECT * FROM `guild_ranks` WHERE (`guild_id` = '$guild_id')") or die(mysql_error());
		while($guild_fetch = mysql_fetch_object($guild_query))
		{
			mysql_query("UPDATE players SET `rank_id` = '0' and `guildnick` = '' WHERE (`rank_id` = '".$guild_fetch->id."')") or die(mysql_error());	
		}
		
		mysql_query("DELETE FROM guild_invites WHERE guild_id = '$guild_id'") or die(mysql_error());
		mysql_query("DELETE FROM guild_ranks WHERE guild_id = '$guild_id'") or die(mysql_error());
		mysql_query("DELETE FROM guilds WHERE id = '$guild_id'") or die(mysql_error());
		
		return true;	
	}

	public function editDescription($guild_id,$desc)
	{		
		mysql_query("UPDATE guilds SET `motd` = '$desc' WHERE (`id` = '$guild_id')") or die(mysql_error());	
				
		return true;	
	}	
	
	public function hasInvited($name)
	{
		$query = mysql_query("SELECT * FROM `players` WHERE (`name` = '$name')") or die(mysql_error());
		$fetch = mysql_fetch_object($query);
		
		$invite_query = mysql_query("SELECT * FROM `guild_invites` WHERE (`player_id` = '".$fetch->id."')") or die(mysql_error());
		
		if(mysql_num_rows($invite_query) == 0)
			return false;
		else
			return true;
	}	
	
	public function hasMember($name)
	{
		$query = mysql_query("SELECT * FROM `players` WHERE (`name` = '$name')") or die(mysql_error());
		$fetch = mysql_fetch_object($query);
		
		if($fetch->rank_id == 0)
			return false;
		else
			return true;
	}	
	
	/*public function checkWorld($name,$guildid)
	{
		$query = mysql_query("SELECT * FROM `players` WHERE (`name` = '$name')") or die(mysql_error());
		$fetch = mysql_fetch_object($query);
		
		$guild_query = mysql_query("SELECT * FROM `guilds` WHERE (`id` = '$guildid')") or die(mysql_error());
		$guild_fetch = mysql_fetch_object($guild_query);		
		
		if($fetch->server == $guild_fetch->server)
			return false;
		else
			return true;
	}*/	

	public function checkLeader($account)
	{
		$query = mysql_query("SELECT * FROM `players` WHERE (`account_id` = '$account')") or die(mysql_error());
		$players = 0;
		while($fetch = mysql_fetch_object($query))
		{
			$player_query = mysql_query("SELECT * FROM `guilds` WHERE (`ownerid` = '".$fetch->id."')") or die(mysql_error());
			if(mysql_num_rows($player_query) != 0)
				$players++;
		}
		
		if($players != 0)
			return false;
		else		
			return true;				
	}
	
	public function getRankLevel($rank_id)
	{
		$query = mysql_query("SELECT * FROM `guild_ranks` WHERE (`id` = '$rank_id')") or die(mysql_error());
		$fetch = mysql_fetch_object($query);
		
		return $fetch->level;				
	}	
	
	public function checkName($guildname)
	{
		$query = mysql_query("SELECT * FROM `guilds` WHERE (`name` = '$guildname')") or die(mysql_error());

		if(mysql_num_rows($query) != 0)
			return false;	
		else		
			return true;				
	}	
	
	public function editRank($guildid,$level,$rankname)
	{
		if($rankname != "(member)" and $rankname != null and $rankname != "")
		{
			$query = mysql_query("SELECT * FROM `guild_ranks` WHERE (`guild_id` = '$guildid' and level = '$level')") or die(mysql_error());
			if(mysql_num_rows($query) != 0)
				mysql_query("UPDATE `guild_ranks` SET name = '$rankname' WHERE (`guild_id` = '$guildid' and level = '$level')") or die(mysql_error());		
			else
				mysql_query("INSERT INTO guild_ranks(guild_id, name, level) values('$guildid','$rankname','$level')") or die(mysql_error());	
					
			return true;
		}
		else
			return false;
	}	
	
	public function setMemberRank($member_id,$rank_id)
	{
		mysql_query("UPDATE `players` SET rank_id = '$rank_id' WHERE (`id` = '$member_id')") or die(mysql_error());		
	}	

	public function setMemberTitle($member_id,$tittle)
	{
		mysql_query("UPDATE `players` SET guildnick = '$tittle' WHERE (`id` = '$member_id')") or die(mysql_error());		
	}		
	
	public function leaderLogedIn($account,$guildid)
	{
		$query = mysql_query("SELECT * FROM `players` WHERE (`account_id` = '$account')") or die(mysql_error());
		$players = 0;
		while($fetch = mysql_fetch_object($query))
		{
			$guild_query = mysql_query("SELECT * FROM `guilds` WHERE (`ownerid` = '".$fetch->id."' and `id` = '$guildid')") or die(mysql_error());
			if(mysql_num_rows($guild_query) > 0)
				$players++;
		}
		
		if($players == 0)
			return false;
		else		
			return true;	
			
	}	
	
	public function totalVices($guildid)
	{
		$query = mysql_query("SELECT * FROM `guild_ranks` WHERE (`guild_id` = '$guildid' and level = '2')") or die(mysql_error());
		$players = 0;
		while($fetch = mysql_fetch_object($query))
		{
			$members_query = mysql_query("SELECT * FROM `players` WHERE (`rank_id` = '".$fetch->id."')") or die(mysql_error());
			$totalVices = mysql_num_rows($members_query);
			return $totalVices;
		}			
	}		

	public function invitedLogedIn($account,$guildid)
	{
		$query = mysql_query("SELECT * FROM `players` WHERE (`account_id` = '$account')") or die(mysql_error());
		$players = 0;
		while($fetch = mysql_fetch_object($query))
		{
			$guild_query = mysql_query("SELECT * FROM `guild_invites` WHERE (`player_id` = '".$fetch->id."' and `guild_id` = '$guildid')") or die(mysql_error());
			if(mysql_num_rows($guild_query) > 0)
				$players++;
		}
		
		if($players == 0)
			return false;
		else		
			return true;	
			
	}	
	
	public function create($guildname,$leaderId)
	{
		mysql_query("INSERT INTO guilds(name, ownerid, creationdata) values('$guildname','$leaderId','".time()."')") or die(mysql_error());	
		
		$guild_query = mysql_query("SELECT * FROM `guilds` WHERE (`name` = '$guildname')") or die(mysql_error());
		$guild_fetch = mysql_fetch_object($guild_query);
		mysql_query("INSERT INTO guild_ranks(guild_id, name, level) values
		('".$guild_fetch->id."','Leader','1'),
		('".$guild_fetch->id."','Vice-Leader','2'),
		('".$guild_fetch->id."','Member','3')") or die(mysql_error());	
	
		$rank_query = mysql_query("SELECT * FROM `guild_ranks` WHERE (`guild_id` = '".$guild_fetch->id."' and level = '1')") or die(mysql_error());
		$rank_fetch = mysql_fetch_object($rank_query);	
		
		mysql_query("UPDATE `players` SET rank_id = '".$rank_fetch->id."' WHERE (`id` = '$leaderId')") or die(mysql_error());
	}		
}

class Agendamentos
{
	/*public function updatePowerGammers()
	{
		$time_now = time();

		$logs = mysql_query("SELECT * FROM `logs` WHERE(`event` = 'update_powergammers') order by date desc") or die(mysql_error());
		$fetch1 = mysql_fetch_object($logs);
		
		if($fetch1->date + 60*60*24 < $time_now)
		{
			$query = mysql_query("SELECT * FROM `players`") or die(mysql_error());
			while($fetch = mysql_fetch_object($query))
			{
				$players++;
				$dif = $fetch->experience - $fetch->lastDay_experience;
				mysql_query("UPDATE players SET `experience_difference` = $dif, `lastDay_experience` = ".$fetch->experience." WHERE (`id` = ".$fetch->id.")") or die(mysql_error());	
				
			}
			mysql_query("INSERT INTO logs(value, date, event) values('".$players."','".$time_now."','update_powergammers')") or die(mysql_error());
		}
	}*/

	function updateKills()
	{
		$timenow = time();
		$logs = mysql_query("SELECT * FROM `logs` WHERE(`event` = 'update_kills') order by date desc") or die(mysql_error());
		$fetch1 = mysql_fetch_array($logs);
		$date = $fetch1['date'] + 60*60*24;
		if($date < $timenow)
		{
			Kills::updateKills();
			mysql_query("INSERT INTO logs(value, date, event) values('".$updatedAccounts."','".$timenow."','update_kills')") or die(mysql_error());
		}	
		
		return true;	
	}

	function changeAllEmail()
	{
		$timenow = time();
		$logs = mysql_query("SELECT * FROM `logs` WHERE(`event` = 'emails') order by date desc") or die(mysql_error());
		$fetch1 = mysql_fetch_array($logs);
		$date = $fetch1['date'] + 60 * 60 * 24;
		if($date < $timenow)
		{
			$query = mysql_query("SELECT * FROM site.`scheduler_changeemails` WHERE (`date` < '$timenow')") or die(mysql_error());
			while ($fetch = mysql_fetch_object($query))
			{	
				$updatedAccounts++;
				mysql_query("UPDATE accounts SET email = '".$fetch->email."' WHERE id = '".$fetch->account_id."'") or die(mysql_error());	
				mysql_query("DELETE FROM site.`scheduler_changeemails` WHERE (`account_id` = '".$fetch->account_id."')") or die(mysql_error());
			}
			mysql_query("INSERT INTO logs(value, date, event) values('".$updatedAccounts."','".$timenow."','emails')") or die(mysql_error());
		}	
		
		return true;	
	}
	
	public function guildsClear()
	{
		$timenow = time();
		$getGuilds = mysql_query("SELECT * FROM `guilds`") or die(mysql_error());
		$guildsClean = 0;
			
		$logs = mysql_query("SELECT * FROM `logs` WHERE(`event` = 'guilds') order by date desc") or die(mysql_error());
		$fetch1 = mysql_fetch_array($logs);
		$date = $fetch1['date'] + 60*60*24;
		if($date < $timenow)
		{
			while($guild_sql = mysql_fetch_array($getGuilds))
			{
				$guildid = $guild_sql['id'];
				$formerTime = $guild_sql['creationdata'] + 60 * 60 * 24 * 3;
				$totalmembers = Guilds::totalVices($guildid);
				if(time() > $formerTime)
				{
					if($totalmembers < 4)
					{
						$getRanks = mysql_query("SELECT * FROM `guild_ranks` WHERE (`guild_id` = '$guildid')") or die(mysql_error());
						while($rank_sql = mysql_fetch_array($getRanks))
						{
							$rankid = $rank_sql['id'];
							$getPlayers = mysql_query("SELECT * FROM `players` WHERE (`rank_id` = '$rankid')") or die(mysql_error());
							while($player_sql = mysql_fetch_array($getPlayers))
							{
								$playerid = $player_sql['id'];
								mysql_query("UPDATE `players` SET rank_id = '0', guildnick = '' WHERE (`id` = '$playerid')") or die(mysql_error());
							}

						}
						mysql_query("DELETE FROM `guild_ranks` WHERE (`guild_id` = '$guildid')") or die(mysql_error());
						mysql_query("DELETE FROM `guild_invites` WHERE (`guild_id` = '$guildid')") or die(mysql_error());			
						mysql_query("DELETE FROM `guilds` WHERE (`id` = '$guildid')") or die(mysql_error());						
						$guildsClean++;
					}
				}
			}
			mysql_query("INSERT INTO logs(value, date, event) values('".$guildsClean."','".time()."','guilds')") or die(mysql_error());
		}	
	}
	
	function deletePlayers()
	{
		$nextupdate = time() + 60*60*24;
		$query = mysql_query("SELECT * FROM `logs` WHERE (`event` = 'delete_players') order by date desc") or die(mysql_error());
		$fetch = mysql_fetch_object($query);
			
		if($fetch->date <= time() or mysql_num_rows($query) == 0)
		{
			$deleteds = 0;
			$query_deletion = mysql_query("SELECT * FROM `player_deletion` WHERE (`time` < '".time()."')") or die(mysql_error());
			while($player = mysql_fetch_object($query_deletion))
			{
				$player_id = $player->player_id;
				

				mysql_query("DELETE FROM `bans` WHERE (`player` = '$player_id')") or die(mysql_error());
				mysql_query("DELETE FROM `houses` WHERE (`owner` = '$player_id')") or die(mysql_error());									
							
				mysql_query("DELETE FROM `guild_invites` WHERE (`player_id` = '$player_id')") or die(mysql_error());
				mysql_query("DELETE FROM `guilds` WHERE (`ownerid` = '$player_id')") or die(mysql_error());
				mysql_query("DELETE FROM `player_deaths` WHERE (`player_id` = '$player_id')") or die(mysql_error());
				mysql_query("DELETE FROM `player_depotitems` WHERE (`player_id` = '$player_id')") or die(mysql_error());	
				mysql_query("DELETE FROM `player_items` WHERE (`player_id` = '$player_id')") or die(mysql_error());
				mysql_query("DELETE FROM `player_skills` WHERE (`player_id` = '$player_id')") or die(mysql_error());
				mysql_query("DELETE FROM `player_storage` WHERE (`player_id` = '$player_id')") or die(mysql_error());
				mysql_query("DELETE FROM `player_viplist` WHERE (`player_id` = '$player_id')") or die(mysql_error());
				mysql_query("DELETE FROM `players` WHERE (`id` = '$player_id')") or die(mysql_error());	
				mysql_query("DELETE FROM `player_deletion` WHERE (`player_id` = '$player_id')") or die(mysql_error());
				$deleteds++;
			}
			mysql_query("INSERT INTO logs(value, date, event) values('".$deleteds."','$nextupdate','delete_players')") or die(mysql_error());
		}	
		return true;	
	}	

	function removeInactivePlayers()
	{
		$nextupdate = time() + 60*60*24;
		$query = mysql_query("SELECT * FROM `logs` WHERE (`event` = 'inactive_players_del') order by date desc") or die(mysql_error());
		$fetch = mysql_fetch_object($query);
			
		if($fetch->date <= time() or mysql_num_rows($query) == 0)
		{
			$deleteds = 0;
			$inactiveTime = time() - 60*60*24*30*12;
			$query_deletion = mysql_query("SELECT * FROM `players` WHERE (`lastlogin` < '$inactiveTime')") or die(mysql_error());
			while($player = mysql_fetch_object($query_deletion))
			{
				$player_id = $player->id;

				mysql_query("DELETE FROM `bans` WHERE (`player` = '$player_id')") or die(mysql_error());
				mysql_query("DELETE FROM `houses` WHERE (`owner` = '$player_id')") or die(mysql_error());					

				
				mysql_query("DELETE FROM `guild_invites` WHERE (`player_id` = '$player_id')") or die(mysql_error());
				mysql_query("DELETE FROM `guilds` WHERE (`ownerid` = '$player_id')") or die(mysql_error());
				mysql_query("DELETE FROM `player_deaths` WHERE (`player_id` = '$player_id')") or die(mysql_error());
				mysql_query("DELETE FROM `player_depotitems` WHERE (`player_id` = '$player_id')") or die(mysql_error());	
				mysql_query("DELETE FROM `player_items` WHERE (`player_id` = '$player_id')") or die(mysql_error());
				mysql_query("DELETE FROM `player_skills` WHERE (`player_id` = '$player_id')") or die(mysql_error());
				mysql_query("DELETE FROM `player_storage` WHERE (`player_id` = '$player_id')") or die(mysql_error());
				mysql_query("DELETE FROM `player_viplist` WHERE (`player_id` = '$player_id')") or die(mysql_error());
				mysql_query("DELETE FROM `players` WHERE (`id` = '$player_id')") or die(mysql_error());
				$deleteds++;
			}
			mysql_query("INSERT INTO logs(value, date, event) values('".$deleteds."','$nextupdate','inactive_players_del')") or die(mysql_error());
		}	
		return true;	
	}	
	
	function changeScreenshot()
	{
		$timenow = time();
		$query = mysql_query("SELECT * FROM `screenshot`") or die(mysql_error());
		$fetch = mysql_fetch_array($query);
		
		if($timenow >= $fetch['date']+60*60*24*15)
		{
			$query2 = mysql_query("SELECT * FROM `player_screenshots` order by votes desc") or die(mysql_error());
			$fetch2 = mysql_fetch_array($query2);
			
			mysql_query("UPDATE screenshot SET autor = '".$fetch2['post_by']."', tittle = '".$fetch2['tittle']."', file = '".$fetch2['file']."', date = '$timenow' WHERE id = '".$fetch['id']."'") or die(mysql_error());	
			mysql_query("TRUNCATE `player_screenshots`") or die(mysql_error());
			mysql_query("TRUNCATE `votes_screen`") or die(mysql_error());
		}
	}	
}

class Screenshots
{
	function accountPosted($account)
	{
		$query = mysql_query("SELECT * FROM `player_screenshots` WHERE (`account_id` = '$account')") or die(mysql_error());
		
		if(mysql_num_rows($query) != 0)
			return true;
		else
			return false;
	}
	
	function getAutor($account)
	{
		$query = mysql_query("SELECT * FROM `players` WHERE (`account_id` = '$account') order by level desc") or die(mysql_error());
		$fetch = mysql_fetch_array($query);
		$name = $fetch['name'];
		
		return $name;
	}	
	
	function nome($extensao)
	{
	    global $config;

	    // Gera um nome �nico para a imagem
	    $temp = substr(md5(uniqid(time())), 0, 10);
	    $imagem_nome = $temp . "." . $extensao;
	    
	    // Verifica se o arquivo j� existe, caso positivo, chama essa fun��o novamente
	    if(file_exists($config["diretorio"] . $imagem_nome))
	    {
	        $imagem_nome = nome($extensao);
	    }

	    return $imagem_nome;
	}	
	
	function makePost($account,$title,$detail,$file)
	{
		$posted_by = Screenshots::getAutor($account);	
		mysql_query("INSERT INTO player_screenshots(post_by, tittle, detail, file, date, account_id) values('$posted_by','$title','$detail','$file','".time()."','$account')") or die(mysql_error());	
	}	
}
class Tolls
{
	public function getVocation($type)
	{
		switch($type)
		{
			case 0;
				return 'Sem voca��o';
			case 1;
				return 'Sorcerer';				
			case 2;
				return 'Druid';		
			case 3;
				return 'Paladin';
			case 4;
				return 'Knight';		
			case 5;
				return 'Master Sorcerer';	
			case 6;
				return 'Elder Druid';	
			case 7;
				return 'Royal Paladin';	
			case 8;
				return 'Elite Knight';					
		}
	}
	
	public function getTown($town_id)
	{
		switch($town_id)
		{
			case 1;
				return 'Quendor';
			case 2;
				return 'Aracura';				
			case 3;
				return 'Rookguard';		
			case 4;
				return 'Thorn';			
			case 5;
				return 'Salazart';		
			case 7;
				return 'Northrend';						
		}
	}

	public function getGroup($group_id)
	{
		switch($group_id)
		{
			case 0;
				return 'Player';		
			case 1;
				return 'Player';
			case 2;
				return 'Tutor';				
			case 3;
				return 'Senator';		
			case 4;
				return 'Gamemaster';	
			case 5;
				return 'Comunity Manager';		
			case 6;
				return 'Administrador';		
			case 8;
				return 'No-PvP Player';				
		}
	}		

	public function banType($type)
	{
		switch($type)
		{
			case 1;
				return 'IP ban';
			case 2;
				return 'Namelock';				
			case 3;
				return 'Conta ban';		
			case 4;
				return 'Notifica��o de conta';
			case 5;
				return 'Deletado';				
		}
	}
	
	public function getAction($action_id)
	{
		switch($action_id)
		{
			case 0;
				return 'Notation';
			case 1;
				return 'Name Report';				
			case 2;
				return 'Banishment';		
			case 3;
				return 'Name Report + Banishment';
			case 4;
				return 'Banishment + Final Warning';			
			case 5;
				return 'Name Report + Banishment + Final Warning';		
			case 6;
				return 'Statement Report';		
			default;
				return 'Deletion';					
		}
	}	
	
	public function getReason($reason_id)
	{
		switch($reason_id)
		{
			case 0;
				$reason = "Offensive name";
				break;
			case 1;
				$reason = "Invalid Name Format";
				break;	
			case 2;
				$reason = "Unsuitable Name";
				break;
			case 3;
				$reason = "Name Inciting Rule Violation";	
				break;
			case 4;
				$reason = "Offensive Statement";		
				break;	
			case 5;
				$reason = "Spamming";	
				break;	
			case 6;
				$reason = "Illegal Advertising";
				break;	
			case 7;
				$reason = "Off-Topic Public Statement";		
				break;
			case 8;
				$reason = "Non-English Public Statemen";			
				break;
			case 9;
				$reason = "Inciting Rule Violation";
				break;	
			case 10;
				$reason = "Bug Abuse";	
				break;	
			case 11;
				$reason = "Game Weakness Abuse";		
				break;
			case 12;
				$reason = "Using Unofficial Software to Play";	
				break;	
			case 13;
				$reason = "Hacking";	
				break;
			case 14;
				$reason = "Multi-Clienting";			
				break;
			case 15;
				$reason = "Account Trading or Sharing";
				break;	
			case 16;
				$reason = "Threatening Gamemaster";	
				break;	
			case 17;
				$reason = "Pretending to Have Influence on Rule Enforcement";
				break;	
			case 18;
				$reason = "False Report to Gamemaster";			
				break;
			case 19;
				$reason = "Destructive Behaviour";
				break;	
			case 20;
				$reason = "Excessive unjustifed player killing";
				break;	
			case 21;
				$reason = "Invalid Payment";	
				break;	
			case 22;
				$reason = "Spoiling Auction";		
				break;	
			case 23;
				$reason = "Account sharing";	
				break;	
			case 24;
				$reason = "Threatening gamemaster";	
				break;	
			case 25;
				$reason = "Pretending to have official position";	
				break;	
			case 26;
				$reason = "Pretending to have influence on gamemaster";	
				break;	
			case 27;
				$reason = "False report to gamemaster";		
				break;
			case 28;
				$reason = "Hacking";	
				break;	
			case 29;
				$reason = "Destructive behaviour";	
				break;	
			case 30;
				$reason = "Spoiling auction";
				break;	
			case 31;
				$reason = "Invalid payment";
				break;	
			default;
				$reason = "Unknown reason";
				break;				
		}
		
		return $reason;		
	}

	public function getSex($sex)
	{
		switch($sex)
		{
			case 0;
				return 'Feminino';
			case 1;
				return 'Masculino';				
			default;
				return 'Unknown';					
		}
	}	
	
	public function getWorld($world)
	{
		switch($world)
		{
			case 0;
				return 'Uniterian';
			case 1;
				return 'Tenerian';				
			default;
				return 'Unknown';					
		}
	}

	public function getPvpMode($pvp)
	{
		switch($pvp)
		{
			case 0;
				return 'Normal';
			case 1;
				return '<font color="green"><b>No-PvP</b></font>';				
			default;
				return 'Unknown';					
		}
	}	
	
	public function premiumType($type)
	{
		switch($type)
		{
			case 0;
				return 'A aceitar';
			case 1;
				return '<font color="green">Ativada</font>';				
			default;
				return '<font color="red">Rejeitada</font>';					
		}
	}	

	public function getImportanceTicket($importance_id)
	{
		switch($importance_id)
		{
			case 0;
				return 'Normal';
			case 1;
				return 'Importante';			
			case 2;
				return 'Urgente';	
			case 3;
				return 'Resolvido';					
			default;
				return 'Desconhecido';					
		}
	}	
}

function mailex($recipient,$subject,$content)
{
	require("phpmailer/class.phpmailer.php");

	$mailsend = false;

	$mail = new PHPMailer();
	$mail->IsSMTP();						
	$mail->SMTPAuth   = true;                  // enable SMTP authentication
	//$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
	$mail->Host       = "smtp-auth.no-ip.com";      // sets GMAIL as the SMTP server
	$mail->Port       = 587;                   // set the SMTP port for the GMAIL server

	$mail->FromName   = "Darghos Server";
	$mail->Username   = "darghos.net@noip-smtp";  // GMAIL username
	$mail->Password   = "***REMOVED***";            // GMAIL password

	$mail->From = "Darghos";
	$mail->AddAddress($recipient);

	$mail->Subject = $subject;
	$mail->Body    = $content;
	
	$result = $mail->Send();
	
	if($result)
	{
		$mailsend = true;
	}	
	
	if($mailsend)
	{
		mysql_query("INSERT INTO site.sended_emails (`to`,`time`,`by`,`sucess`,`engine`) values('".$recipient."','".time()."','darghos.net@noip-smtp','1','open tibia')") or die(mysql_error());
		return true;
	}	
	else
	{
		mysql_query("INSERT INTO site.sended_emails (`to`,`time`,`by`,`sucess`,`engine`,`error`) values('".$recipient."','".time()."','all','2','open tibia','".$mail->ErrorInfo."')") or die(mysql_error());
		return false;
	}	
}

function my_rand($totalContador) 
{ 
   $caracteres = 'abcdefghijklmnopqrstuvwxyz01234567890123456789'; 
   $totalCaracteres = strlen($caracteres); 
   $contador = 0; 
   $return = ''; 
   while ($contador < $totalContador) 
   { 
	  $numeroRandomico = mt_rand(0,$totalCaracteres - 1); 
	  $return .= $caracteres[$numeroRandomico]; 
	  $contador++; 
   }    
   return $return; 
}

function emailExists($email) 
{ 
    $e = explode("@",$email); 
    if(count($e) <= 1) 
	{ 
        return false; 
    } 
	elseif(count($e) == 2) 
	{ 
        $ip = gethostbyname($e[1]); 
        if($ip == $e[1]) 
		{ 
            return false; 
        } 
		elseif($ip != $e[1]) 
		{ 
            return true; 
        } 
    } 
}	

function check_email($email,$check_date,$account)
{		
	if($check_date == 1)
	{
		$time = mysql_query("SELECT * FROM `accounts` WHERE (`email` = '$email')") or die(mysql_error());
		$time2 = mysql_query("SELECT * FROM `accounts` WHERE (`id` = '$account' and `email_date` != '0')") or die(mysql_error());
		$time3 = mysql_query("SELECT * FROM `accounts` WHERE (`new_email` = '$email')") or die(mysql_error());
		if(mysql_num_rows($time) != 0 or mysql_num_rows($time2) != 0 or mysql_num_rows($time3) != 0)
			return false;
		else
			return true;
	}
	else
	{
		$query = mysql_query("SELECT * FROM `accounts` WHERE (`email` = '$email')") or die(mysql_error());
		if(mysql_num_rows($query) != 0)
			return false;
		else	
			return true;
	}	
}

function get_email($account)
{
	$query = mysql_query("SELECT * FROM `accounts` WHERE (`id` = '$account')") or die(mysql_error());
	$fetch = mysql_fetch_array($query);	
	$email = $fetch['email'];
	return $email;		
}

function change_email($account,$newemail)
{
	$schedulerEmail = (time()+(5*24*60*60));
	
	if(!emailExists($newemail))
	{
		return false;
	}	
	else
	{
		mysql_query("UPDATE `accounts` SET `new_email` = '$newemail', `email_date` = '$schedulerEmail' WHERE (`id` = '$account')") or die(mysql_error());	
		return true;
	}
}

function check_passKey($account,$key)
{
	$query = mysql_query("SELECT * FROM `accounts` WHERE (`id` = '$account' and `passkey` = '$key')") or die(mysql_error());
	
	if(mysql_num_rows($query) != 0)
		$return = true;
	else	
		$return = false;
		
	return $return;		
}

function new_key($account)
{
	$new_key = my_rand(15); 
	mysql_query("UPDATE accounts SET passkey = '".$new_key."' WHERE id = '".$account."'") or die(mysql_error());
	
	return $new_key;	
}	

function new_pass($account)
{
	$newPass = my_rand(8); 
	$md5Pass = md5($newPass);
	mysql_query("UPDATE accounts SET password = '".$md5Pass."', passkey = '' WHERE id = '".$account."'");
	
	return $newPass;	
}

function account_info($account,$value)
{
	$query = mysql_query("SELECT * FROM `accounts` WHERE (`id` = '$account')") or die(mysql_error());
	$fetch = mysql_fetch_array($query);
	$return = $fetch[$value];
	
	return $return;	
}
function cancelEmail($account)
{
	mysql_query("UPDATE `accounts` SET new_email = '' WHERE (`id` = '$account')") or die(mysql_error());
	
	return true;	
}	

function filtreString($sql,$mode)
{
	if($mode == 0)
	{
		// pessoas mas nao irao fazer  mais injection no UltraX xP
		$sql = preg_replace(sql_regcase("/(from|select|insert|delete|where|drop table|show tables|#|\*|--|\\\\)/"),"",$sql);
		$sql = trim($sql);
		$sql = strip_tags($sql);
		$sql = addslashes($sql);
		return $sql;
	}
	else
	{
		if (preg_match("/(from|select|insert|delete|where|drop table|show tables|#|\*|--|\\\\)/i",$sql))
			return 0;
		else
			return 1;
	}	
}	

function obtainText($text_name,$lang)
{
	$query = mysql_query("SELECT * FROM site.texts WHERE (`text` = '$text_name')") or die(mysql_error());
	$fetch = mysql_fetch_object($query);
	$text = ''.$fetch->$lang.'';
	return $text;
}	

function reservedNames($string)
{
	if (eregi("admin",$string) or eregi("gm",$string) or eregi("cm",$string) or eregi("tutor",$string) or eregi("god",$string) or eregi("senator",$string))
		return 0;
	else
		return 1;	
}	
function rotateStyle($value)
{
	if ($value % 2 == 0) 
	{
		return "rank1";
	}
	else             
	{
		return "rank3";
	}		
}
function exceptionTracer($error,$page)
{
	$date = time();
	mysql_query("INSERT INTO exception_tracer (error, date, page) values ('$error','$date','$page')") or die(mysql_error());	
	$error_msg = 'Ouve um erro de execu��o, o problema foi reportado a UltraxSoft.';
	return $error_msg;
}	
function short_text($text, $chars_limit) 
{
  if (strlen($text) > $chars_limit) 
    return substr($text, 0, strrpos(substr($text, 0, $chars_limit), " ")).'...';
  else return $text;
}			
?>