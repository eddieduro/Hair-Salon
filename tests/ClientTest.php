<?php

	require_once 'src/Client.php';
	require_once 'src/Stylist.php';

	/**
	* @backupGlobals disabled
	* @backupStaticAttributes disabled
	*/

	// $server = 'mysql:host=localhost:8889;dbname=hair_salon_test'; <--LOCAL LAPTOP
	$server = 'mysql:host=localhost;dbname=hair_salon_test';
	$user = 'root';
	$password = 'root';
	$DB = new PDO($server, $user, $password);

	class ClientTest extends PHPUnit_Framework_TestCase
	{
		protected function teardown(){
			Client::deleteAll();
		}

		function test_getName(){

			// Arrange
			$client = 'betty';
			$stylist_id = 1;
			$new_client = new Client($client, $stylist_id);

			// Act
			$result = $new_client->getName();

			// Assert
			$this->assertEquals('betty', $result);
		}

		function test_getStylistId(){
			// Arrange
			$name = 'susy';
			$stylist_id = 1;
			$new_client = new Client($name, $stylist_id);

			// Act
			$result = $new_client->getStylistId();

			// Assert
			$this->assertEquals(1, $result);
		}

		function test_save(){

			// Arrange
			$name = 'bill';
			$stylist_id = 1;
			$new_client = new Client($name, $stylist_id);
			// Act
			$new_client->save();


			// Assert
			$result = Client::getAll();
			$this->assertEquals($new_client, $result[0]);
		}

		function test_updateName(){
			// Arrange
			$name = 'bill';
			$stylist_id = 1;
			$new_client = new Client($name, $stylist_id);
			$new_client->save();

			// Act
			$new_name = 'tom';
			$result = $new_client->updateName($new_name);


			// Assert
			$this->assertEquals('tom', $new_client->getName());
		}

		function test_getAll(){

			// Arrange
			$name = 'chris';
			$stylist_id = 1;
			$new_client = new Client($name, $stylist_id);

			// Act
			$new_client->save();
			$result = Client::getAll();

			// Assert
			$this->assertEquals([$new_client], $result);


		}

		function test_deleteAll(){

			// Arrange
			$name = 'tom';
			$stylist_id = 1;
			$new_client = new Client($name, $stylist_id);

			// Act
			$new_client->save();
			Client::deleteAll();

			// Assert
			$result = Client::getAll();
			$this->assertEquals([], $result);


		}

		function test_deleteClient(){

			// Arrange
			$name1 = 'tom';
			$stylist_id = 1;
			$client1 = new Client($name1, $stylist_id);
			$client1->save();

			$name2 = 'bob';
			$stylist_id = 1;
			$client2 = new Client($name2, $stylist_id);
			$client2->save();
			// Act

			$client1->deleteClient();

			// Assert
			$result = Client::getAll();
			$this->assertEquals([$client2], $result);


		}
	}
?>
