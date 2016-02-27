<?php

	class Stylist
	{
		private $name;
		private $id;

		function __construct($name, $id = null){
			$this->name = $name;
			$this->id = $id;
		}

		function getName(){
			return $this->name;
		}

		function setName($new_name){
			$this->name = (string) $new_name;
		}

		function updateName($new_name){
			$GLOBALS['DB']->exec("UPDATE stylists SET name = {$new_name} WHERE id = {$this->getId()};");
			$this->setName($new_name);
		}

		function getId(){
			return $this->id;
		}

		function save(){
			$GLOBALS['DB']->exec("INSERT INTO stylists (name) VALUES ('{$this->getName()}');");
			$this->id = $GLOBALS['DB']->lastInsertId();
		}

		function getClients(){
			$clients = array();
			$returned_clients = $GLOBALS['DB']->query("SELECT * FROM clients WHERE stylist_id = {$this->getId()};");
			var_dump($returned_clients);
			foreach($returned_clients as $client){
				$name = $client['name'];
				$stylist_id = $client['stylist_id'];
				$id = $client['id'];
				$new_client = new Client($name, $stylist_id, $id);

				array_push($clients, $new_client);
			}
			return $clients;
		}

		// function findClient(){
		// 	$found_client = null;
		// 	foreach($current_clients as $client){
		// 		$client_id = $client->getId();
		// 		if($client_id = $id){
		// 			$found_client = $client;
		// 		}
		// 	}
		// }
		function deleteStylist(){
			$GLOBALS['DB']->exec("DELETE FROM stylists WHERE id = {$this->getId()};");
		}

		static function find($search_id){
			$found_stylist = null;
			$stylists = Stylist::getAll();

			foreach($stylists as $stylist){
				$stylist_id = $stylist->getId();
				if($stylist_id == $search_id){
					$found_stylist = $stylist;
				}
			}
			return $found_stylist;
		}

		static function getAll(){
			$returned_stylists = $GLOBALS['DB']->query("SELECT * FROM stylists");

			$stylists = array();

			foreach($returned_stylists as $stylist){
				$name = $stylist['name'];
				$id = $stylist['id'];
				$new_stylist = new Stylist($name, $id);
				array_push($stylists, $new_stylist);
			}
			return $stylists;
		}

		static function deleteAll(){
			$GLOBALS['DB']->exec("DELETE FROM stylists");
		}
	}
?>
