<?php
	class Character extends Mysql {
		/*
			TODO
			- player comment support
			- hide from char list option
			- when deleted, goto wait list
		*/
		
		function create($account_id, $group_id, $name, $sex, $vocation, $rook = false) {
			switch ($sex) {
				case 2:
					$look_type = CONFIG_CHARACTERSTARTLOOKTYPEFEMALE;
				break;
				
				case 3:
					$look_type = CONFIG_CHARACTERSTARTLOOKTYPEGOD;
				break;
				
				case 4:
					$look_type = CONFIG_CHARACTERSTARTLOOKTYPECM;
				break;
				
				default:
					$look_type = CONFIG_CHARACTERSTARTLOOKTYPEMALE;
				break;
			}
			
			$data = $this->get("account_id = " . $account_id, "premend", false, null);
			
			if ($rook) {
				return $this->query("INSERT INTO players VALUES (null, '" . $name . "', " . $account_id . ", " . (($group_id == 4 && $data["premend"] > 0) ? 3 : $group_id) . ", " . $data["premend"] . ", " . $sex . ", " . $vocation . ", " . CONFIG_CHARACTERROOKSTARTEXP . ", " . CONFIG_CHARACTERROOKSTARTLEVEL . ", " . CONFIG_CHARACTERROOKSTARTMAGICLEVEL . ", " . CONFIG_CHARACTERROOKSTARTHEALTH . ", " . CONFIG_CHARACTERROOKSTARTHEALTH . ", " . CONFIG_CHARACTERROOKSTARTMANA . ", " . CONFIG_CHARACTERROOKSTARTMANA . ", 0, " . CONFIG_CHARACTERROOKSTARTSOUL . ", 0, " . CONFIG_CHARACTERSTARTLOOKBODY . ", " . CONFIG_CHARACTERSTARTLOOKFEET . ", " . CONFIG_CHARACTERSTARTLOOKHEAD . ", " . CONFIG_CHARACTERSTARTLOOKLEGS . ", " . $look_type . ", 0, " . CONFIG_CHARACTERROOKSTARTPOSX . ", " . CONFIG_CHARACTERROOKSTARTPOSY . ", " . CONFIG_CHARACTERROOKSTARTPOSZ . ", " . CONFIG_CHARACTERROOKSTARTCAP . ", 0, 0, 1, '', 0, 0, '', " . CONFIG_CHARACTERROOKSTARTLOSSEXP . ", " . CONFIG_CHARACTERROOKSTARTLOSSMANA . ", " . CONFIG_CHARACTERROOKSTARTLOSSKILLS . ", " . CONFIG_CHARACTERROOKSTARTLOSSITEMS . ", 0, " . CONFIG_CHARACTERROOKSTARTTOWNID . ", 0)");
			} else {
				return $this->query("INSERT INTO players VALUES (null, '" . $name . "', " . $account_id . ", " . $group_id . ", " . $data["premend"] . ", " . $sex . ", " . $vocation . ", " . CONFIG_CHARACTERSTARTEXP . ", " . CONFIG_CHARACTERSTARTLEVEL . ", " . CONFIG_CHARACTERSTARTMAGICLEVEL . ", " . CONFIG_CHARACTERSTARTHEALTH . ", " . CONFIG_CHARACTERSTARTHEALTH . ", " . CONFIG_CHARACTERSTARTMANA . ", " . CONFIG_CHARACTERSTARTMANA . ", 0, " . CONFIG_CHARACTERSTARTSOUL . ", 0, " . CONFIG_CHARACTERSTARTLOOKBODY . ", " . CONFIG_CHARACTERSTARTLOOKFEET . ", " . CONFIG_CHARACTERSTARTLOOKHEAD . ", " . CONFIG_CHARACTERSTARTLOOKLEGS . ", " . $look_type . ", 0, " . CONFIG_CHARACTERSTARTPOSX . ", " . CONFIG_CHARACTERSTARTPOSY . ", " . CONFIG_CHARACTERSTARTPOSZ . ", " . CONFIG_CHARACTERSTARTCAP . ", 0, 0, 1, '', 0, 0, '', " . CONFIG_CHARACTERSTARTLOSSEXP . ", " . CONFIG_CHARACTERSTARTLOSSMANA . ", " . CONFIG_CHARACTERSTARTLOSSKILLS . ", " . CONFIG_CHARACTERSTARTLOSSITEMS . ", 0, " . CONFIG_CHARACTERSTARTTOWNID . ", 0)");
			}
		}
		
		function delete($id) {
			$this->query("DELETE FROM bans WHERE type = 2 AND value = " . $id);
			$this->query("DELETE FROM player_depotitems WHERE player_id = " . $id);
			$this->query("DELETE FROM player_items WHERE player_id = " . $id);
			$this->query("DELETE FROM player_skills WHERE player_id = " . $id);
			$this->query("DELETE FROM player_spells WHERE player_id = " . $id);
			$this->query("DELETE FROM player_storage WHERE player_id = " . $id);
			$this->query("DELETE FROM player_viplist WHERE player_id = " . $id);
			$this->query("UPDATE guilds SET ownerid = 0 WHERE ownerid = " . $id);
			$this->query("UPDATE houses SET owner = 0 WHERE owner = " . $id);
			
			return $this->query("DELETE FROM players WHERE id = " . $id);
		}
		
		function get($criteria, $fields = "*", $loop = false, $order = null) {
			return $this->consult("SELECT " . $fields . " FROM players " . ($criteria ? "WHERE " . $criteria : null) . " " . ($order ? "ORDER BY " . $order : null), $loop);
		}
	}
	
	$character = new Character();
?>