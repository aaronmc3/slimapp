<?php

//this file is part of a tutorial on slim php and here for information, not part of the property search slim app

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

// Render Twig template in route
$app->get('/customers', function ($request, $response, $args) {
    
	$sql = "SELECT * FROM customers";

	try{
		//get db object
		$db = new db();
		//connect
		$db = $db->connect();

		$stmt = $db->query($sql);
		$customers = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		//render view
		return $this->view->render($response, 'customers.twig', ['customers' => $customers]);

	} catch(Exception $e){
		echo '{"error": {"text": ' .$e->getMessage().'}';
	}

})->setName('profile');





/*****API*****/
// get all customers
$app->get('/api/customers', function(Request $request, Response $response){
	$sql = "SELECT * FROM customers";

	try{
		//get db object
		$db = new db();
		//connect
		$db = $db->connect();

		$stmt = $db->query($sql);
		$customers = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;

		echo json_encode($customers);

	} catch(PDOException $e){
		echo '{"error": {"text": ' .$e->getMessage().'}';
	}

});

// get single customer
$app->get('/api/customer/{id}', function(Request $request, Response $response){

	$id = $request->getAttribute('id');

	$sql = "SELECT * FROM customers WHERE id = '.$id.'";

	try{
		//get db object
		$db = new db();
		//connect
		$db = $db->connect();

		$stmt = $db->query($sql);
		//$stmt->bindParam(':id', $id);

		$customer = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;

		echo json_encode($customer);

	} catch(PDOException $e){
		echo '{"error": {"text": ' .$e->getMessage().'}';
	}

});

//add customer
$app->post('/api/customer/add', function(Request $request, Response $response){

	$first_name = $request->getParam('first_name');
	$last_name = $request->getParam('last_name');

	$sql = "INSERT INTO customers (first_name, last_name) VALUES(:first_name, :last_name)";

	try{
		//get db object
		$db = new db();
		//connect
		$db = $db->connect();

		$stmt = $db->prepare($sql);

		$stmt->bindParam(':first_name', $first_name);
		$stmt->bindParam(':last_name', $last_name);

		$stmt->execute();

		echo '{"notice": {"text": "Customer Added"}';


	} catch(PDOException $e){
		echo '{"error": {"text": ' .$e->getMessage().'}';
	}

});

//update customer
$app->put('/api/customer/update/{id}', function(Request $request, Response $response){

	$id = $request->getAttribute('id');

	$first_name = $request->getParam('first_name');
	$last_name = $request->getParam('last_name');

	$sql = "UPDATE customers SET
		first_name = :first_name,
		last_name = :last_name
		WHERE id = :id";

	try{
		//get db object
		$db = new db();
		//connect
		$db = $db->connect();

		$stmt = $db->prepare($sql);

		$stmt->bindParam(':first_name', $first_name);
		$stmt->bindParam(':last_name', $last_name);
		$stmt->bindParam(':id', $id);

		$stmt->execute();

		echo '{"notice": {"text": "Customer Added"}';


	} catch(PDOException $e){
		echo '{"error": {"text": ' .$e->getMessage().'}';
	}

});

// delete single customer

$app->delete('/api/customer/delete/{id}', function(Request $request, Response $response){

	$id = $request->getAttribute('id');

	$sql = "DELETE FROM customers WHERE id = :id";

	try{
		//get db object
		$db = new db();
		//connect
		$db = $db->connect();

		$stmt = $db->prepare($sql);
		
		$stmt->bindParam(':id', $id);

		$stmt->execute();
		$db = null;

		echo '{"notice": {"text": "Customer ' . $id . ' deleted"}';

	} catch(PDOException $e){
		echo '{"error": {"text": ' .$e->getMessage().'}';
	}

});