<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

//TEST controller
$app->get('/test', 'TestController:index')->setName('test-controller');

//route replacement for view list of properties
$app->get('/properties', 'ViewAllController:index')->setName('view-all-controller');


$app->get('/hello/{name}', 'Controllers\\HelloController:index');

// RETRIEVE LIST OF PROPERTIES
// Render Twig template in route
$app->get('/properties/old', function ($request, $response, $args) {

	$sql = "SELECT * FROM property";

	try {

		$stmt = $this->db->query($sql);
		$properties = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
//render view
		return $this->view->render($response, 'properties.twig', ['properties' => $properties]);

	} catch(Exception $e){
		echo '{"error": {"text": ' .$e->getMessage().'}';
	}

})->setName('property-list');

// RETRIEVE DETAILS OF SINGLE PROPERTY
$app->get('/properties/view/{id}', function (Request $request, Response $response, $args) {

	$id = $request->getAttribute('id');

	$sql = 'SELECT * FROM property WHERE ID = ' . $id .'';

	try{
		$db = new db();
		$db = $db->connect();

		$stmt = $db->query($sql);
		$property = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;

		return $this->view->render($response, 'property-details.twig', ['property' => $property]);

	}catch(Exception $e){
		echo '{"error": {"text": ' .$e->getMessage().'}';
	}
})->setName('property-details');


// UPDATE
$app->post('/properties/update', function (Request $request, Response $response) {
		
		//get request parameters into an assoc array
		$parsedBody = $request->getParsedBody();
		//remove the submit from the array
		unset($parsedBody['submit']);

		$property = $parsedBody;

		$this->query->update(
		
		'property', $parsedBody, [ 'id' => $parsedBody['ID'] ]

		);
	
		//redirect to /properties to view all properties again
		return $response->withRedirect('/properties');
	
})->setName('property-edit');


// DELETE
$app->post('/properties/delete/{id}', function(Request $request, Response $response, $args){

	$data = ['notice' => ['text' => '']];
	$result = $this->query->delete('property', $args['id']);

	if ($result === true) {
		$data['notice']['text'] = "Property {$args['id']} deleted";
	} else {
		$data['notice']['text'] = $result;
	}

	return $response->withJson($data);
})->setName('property-delete');
