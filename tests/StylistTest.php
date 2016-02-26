<?php 

	require_once 'src/Stylist.php';

	/**
  * @backupGlobals disabled
  * @backupStaticAttributes disabled
  */

	$server = 'mysql:host=localhost:8889;dbname=hair_salon_test';
	$user = 'root';
	$password = 'root';
	$DB = new PDO ($server, $user, $password);

	class StylistTest extends PHPUnit_Framework_TestCase
	{
		protected function teardown(){
			Stylist::deleteAll();
		}

		function test_getName(){

			// Arrange
			$name = 'susy';
			$new_stylist= new Stylist($name);

			// Act
			$current_stylist = $new_stylist->getName();

			// Assert
			$this->assertEquals('susy', $current_stylist);
		}

		function test_getId(){
			// Arrange
			$name = 'susy';
			$id = 1;
			$new_stylist= new Stylist($name, $id);

			// Act
			$result = $new_stylist->getId();

			// Assert
			$this->assertEquals(1, $result);
		}

		function test_save(){

			// Arrange
			$name = 'bill';
			$new_stylist= new Stylist($name);

			// Act
			$new_stylist->save();


			// Assert
			$result = Stylist::getAll();
			$this->assertEquals($new_stylist, $result[0]);
		}

		function test_updateName(){
			// Arrange
			$name = 'bill';
			$new_stylist= new Stylist($name);
			$new_stylist->save();

			// Act
			$new_name = 'tom';
			$result = $new_stylist->updateName($new_name);


			// Assert
			$this->assertEquals('tom', $new_stylist->getName());
		}

		function test_getAll(){

			// Arrange
			$name = 'chris';
			$new_stylist= new Stylist($name);

			// Act
			$new_stylist->save();
			$result = Stylist::getAll();

			// Assert
			$this->assertEquals([$new_stylist], $result);


		}

		function test_deleteAll(){

			// Arrange
			$name = 'tom';
			$new_stylist= new Stylist($name);

			// Act
			$new_stylist->save();
			Stylist::deleteAll();

			// Assert
			$result = Stylist::getAll();
			$this->assertEquals([], $result);


		}
	}
?>