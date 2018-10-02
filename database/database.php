<?php
	class Database {
		public $mysql;
		
		function __construct() {
			$this->mysqli=new mysqli("localhost", "root", "", "cdmis")
				or die("There's a problem connecting to the database.");
		}
		
		function affected() {
			$num = mysqli_affected_rows($this->mysqli);
			return $num;
		}
			
		function select($var) {
			$this->result = mysqli_query($this->mysqli, $var);
			return $this->result;
		}
		
		function escape($string) {
			return mysqli_real_escape_string($this->mysqli, $string);
		}
		
		function fetch($result) {
			$this->row = mysqli_fetch_assoc($result);
			return $this->row;
		}
			
		function query($var) {
			mysqli_query($this->mysqli, $var);
		}

		function rows($result) {
			return mysqli_num_rows($result);
		}
		
		function insertID() {
			$id = mysqli_insert_id($this->mysqli);
			return $id;
		}
	}	
?>
