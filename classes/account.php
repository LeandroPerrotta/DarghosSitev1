<?php
	class Account extends Mysql {
		function create($id, $email, $password) {
			return $this->query("INSERT INTO accounts VALUES (" . $id . ", '" . $password . "', '" . $email . "', 0, 0, 0, '" . $this->key() . "')");
		}
		
		function delete($id) {
			return $this->query("UPDATE accounts SET deleted = 1 WHERE id = " . $id);
		}
		
		function get($criteria, $fields = "*", $loop = false, $order = null) {
			return $this->consult("SELECT " . $fields . " FROM accounts " . ($criteria ? "WHERE " . $criteria : null) . " " . ($order ? "ORDER BY " . $order : null), $loop);
		}
		
		function id() {
			$id = rand(111111, 999999);
			
			do {
				$data = $this->get("id = " . $id, "id");
				
				if ($data) {
					$id++;
				}
			} while ($data["id"]);
			
			return $id;
		}
		
		function key() {
			$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
			
			for ($i = 0; $i < 20; $i++) {
				$key .= $chars[rand(0, strlen($chars) - 1)];
			}
			
			return $key;
		}
		
		function update($id, $email, $password) {
			return $this->query("UPDATE accounts SET password = '" . $password . "', email = '" . $email . "' WHERE id = " . $id);
		}
	}
	
	$account = new Account();
?>