<?php

	class Stylist
	{
		private $name;

		function __construct($name){
			$this->name = $name;
		}

		function getName(){
			return $this->name;
		}

		function save(){
			$GLOBALS['DB']->exec("INSERT INTO stylists (name) VALUES ('{$this->getName()}');");
		}

		static function getAll(){
			$returned_stylists = $GLOBALS['DB']->query("SELECT * FROM stylists");

			$stylists = array();

			foreach($returned_stylists as $stylist){
				$name = $stylist['name'];
				$new_stylist = new Stylist($name);
				array_push($stylists, $new_stylist);
			}
			return $stylists;
		}

		static function deleteAll(){
			$GLOBALS['DB']->exec("DELETE FROM stylists");
		}
	}
?>