<?php
	class Account {
		function create($email, $password) {
			return $mysql->query("INSERT INTO accounts VALUES (null, '" . $password . "', '" . $email . "', 0, 0, 0, '" . $this->key() . "')");
		}
		
		function delete($id) {
			return $mysql->query("UPDATE accounts SET deleted = 1 WHERE id = " . $id);
		}
		
		function get($criteria, $fields = "*", $loop = false, $order = "email ASC") {
			return $mysql->consult("SELECT " . $fields . " FROM accounts " . ($criteria ? "WHERE " . $criteria : null) . " " . ($order ? "ORDER BY " . $order : null), $loop);
		}
		
		function key() {
			$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
			
			for ($i = 0; $i < 20; $i++) {
				$key .= $chars[rand(0, strlen($chars) - 1)];
			}
			
			return $key;
		}
		
		function update($id, $email, $password) {
			return $mysql->query("UPDATE accounts SET password = '" . $password . "', email = '" . $email . "' WHERE id = " . $id);
		}
	}
	
	$account = new Account();
?>