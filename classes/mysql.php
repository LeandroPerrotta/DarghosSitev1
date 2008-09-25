<?php
	class Mysql {
		/*
			TODO:
			- design login, game and site database pattern
		*/
		
		private static $link;
		
		function __construct() {
			if (!self::$link) {
				$this->connect();
			}
		}
		
		function connect() {
			self::$link = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS);
			mysql_select_db(MYSQL_DB, self::$link);
			
			return mysql_set_charset("utf8", self::$link); // $this->query("SET NAMES 'utf8'");
		}
		
		function consult($query, $loop = false) {
			$query = $this->query($query);
			
			if ($loop) {
				$count = 0;
				$data = array();
				
				while ($result = mysql_fetch_array($query, MYSQL_ASSOC)) {
					foreach ($result as $field => $value) {
						$data[$count][$field] = $value;
					}
					
					$count++;
				}
				
				return $data;
			} else {
				return mysql_fetch_array($query);
			}
		}
		
		function query($query) {
			echo '<p>' . $query . '</p>'; // DEBUG ONLY
			return mysql_query($query, $this->link);
		}
	}
?>