<?php
	class Player {
		/*
			TODO
			- player comment support
			- hide from char list option
			- when deleted, goto wait list
		*/
		
		function create($account_id, $group_id, $name, $sex, $vocation, $rook = false) {
			switch ($sex) {
				case 2:
					$look_type = CONFIG_PLAYERSTARTLOOKTYPEFEMALE;
				break;
				
				case 3:
					$look_type = CONFIG_PLAYERSTARTLOOKTYPEGOD;
				break;
				
				case 4:
					$look_type = CONFIG_PLAYERSTARTLOOKTYPECM;
				break;
				
				default:
					$look_type = CONFIG_PLAYERSTARTLOOKTYPEMALE;
				break;
			}
			
			$data = $this->get("account_id = " . $account_id, "premend", false, null);
			
			if ($rook) {
				return $mysql->query("INSERT INTO players VALUES (null, '" . $name . "', " . $account_id . ", " . $group_id . ", " . $data["premend"] . ", " . $sex . ", " . $vocation . ", " . CONFIG_PLAYERROOKSTARTEXP . ", " . CONFIG_PLAYERROOKSTARTLEVEL . ", " . CONFIG_PLAYERROOKSTARTMAGICLEVEL . ", " . CONFIG_PLAYERROOKSTARTHEALTH . ", " . CONFIG_PLAYERROOKSTARTHEALTH . ", " . CONFIG_PLAYERROOKSTARTMANA . ", " . CONFIG_PLAYERROOKSTARTMANA . ", 0, " . CONFIG_PLAYERROOKSTARTSOUL . ", 0, " . CONFIG_PLAYERSTARTLOOKBODY . ", " . CONFIG_PLAYERSTARTLOOKFEET . ", " . CONFIG_PLAYERSTARTLOOKHEAD . ", " . CONFIG_PLAYERSTARTLOOKLEGS . ", " . $look_type . ", 0, " . CONFIG_PLAYERROOKSTARTPOSX . ", " . CONFIG_PLAYERROOKSTARTPOSY . ", " . CONFIG_PLAYERROOKSTARTPOSZ . ", " . CONFIG_PLAYERROOKSTARTCAP . ", 0, 0, 1, null, 0, 0, null, " . CONFIG_PLAYERROOKSTARTLOSSEXP . ", " . CONFIG_PLAYERROOKSTARTLOSSMANA . ", " . CONFIG_PLAYERROOKSTARTLOSSKILLS . ", " . CONFIG_PLAYERROOKSTARTLOSSITEMS . ", 0, " . CONFIG_PLAYERROOKSTARTTOWNID . ", 0)");
			} else {
				return $mysql->query("INSERT INTO players VALUES (null, '" . $name . "', " . $account_id . ", " . $group_id . ", " . $data["premend"] . ", " . $sex . ", " . $vocation . ", " . CONFIG_PLAYERSTARTEXP . ", " . CONFIG_PLAYERSTARTLEVEL . ", " . CONFIG_PLAYERSTARTMAGICLEVEL . ", " . CONFIG_PLAYERSTARTHEALTH . ", " . CONFIG_PLAYERSTARTHEALTH . ", " . CONFIG_PLAYERSTARTMANA . ", " . CONFIG_PLAYERSTARTMANA . ", 0, " . CONFIG_PLAYERSTARTSOUL . ", 0, " . CONFIG_PLAYERSTARTLOOKBODY . ", " . CONFIG_PLAYERSTARTLOOKFEET . ", " . CONFIG_PLAYERSTARTLOOKHEAD . ", " . CONFIG_PLAYERSTARTLOOKLEGS . ", " . $look_type . ", 0, " . CONFIG_PLAYERSTARTPOSX . ", " . CONFIG_PLAYERSTARTPOSY . ", " . CONFIG_PLAYERSTARTPOSZ . ", " . CONFIG_PLAYERSTARTCAP . ", 0, 0, 1, null, 0, 0, null, " . CONFIG_PLAYERSTARTLOSSEXP . ", " . CONFIG_PLAYERSTARTLOSSMANA . ", " . CONFIG_PLAYERSTARTLOSSKILLS . ", " . CONFIG_PLAYERSTARTLOSSITEMS . ", 0, " . CONFIG_PLAYERSTARTTOWNID . ", 0)");
			}
		}
		
		function delete($id) {
			$mysql->query("DELETE FROM bans WHERE type = 2 AND value = " . $id);
			$mysql->query("DELETE FROM player_depotitems WHERE player_id = " . $id);
			$mysql->query("DELETE FROM player_items WHERE player_id = " . $id);
			$mysql->query("DELETE FROM player_skills WHERE player_id = " . $id);
			$mysql->query("DELETE FROM player_spells WHERE player_id = " . $id);
			$mysql->query("DELETE FROM player_storage WHERE player_id = " . $id);
			$mysql->query("DELETE FROM player_viplist WHERE player_id = " . $id);
			$mysql->query("UPDATE guilds SET ownerid = 0 WHERE ownerid = " . $id);
			$mysql->query("UPDATE houses SET owner = 0 WHERE owner = " . $id);
			
			return $mysql->query("DELETE FROM players WHERE id = " . $id);
		}
		
		function get($criteria, $fields = "*", $loop = false, $order = "name ASC") {
			return $mysql->consult("SELECT " . $fields . " FROM players " . ($criteria ? "WHERE " . $criteria : null) . " " . ($order ? "ORDER BY " . $order : null), $loop);
		}
	}
	
	$player = new Player();
?>