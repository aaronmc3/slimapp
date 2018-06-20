<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

//TEST controller
$app->get('/test', 'TestController:index')->setName('test-controller');

$app->get('/hello/{name}', 'Controllers\\HelloController:index');

// RETRIEVE LIST OF PROPERTIES
// Render Twig template in route
$app->get('/properties', function ($request, $response, $args) {

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










// // //UPDATE
// $app->put('/properties/edit/{id}', function(Request $request, Response $response){

// 	$id = $request->getAttribute('id');

// 	$ZooplaID = $request->getParam('zoopla_id');
// 	$County = $request->getParam('county');
// 	$Country = $request->getParam('country');
// 	$Town = $request->getParam('town');
// 	$Postcode = $request->getParam('postcode');
// 	$Description = $request->getParam('description');
// 	$DisplayableAddress = $request->getParam('displayable_address');
// 	$Image = $request->getParam('image');
// 	$Latitude = $request->getParam('latitude');
// 	$Longitude = $request->getParam('longitude');
// 	$NoOfBathrooms = $request->getParam('num_bathrooms');
// 	$NoOfBedroom = $request->getParam('num_bedrooms');
// 	$PropertyType = $request->getParam('property_type');
// 	$SaleOrRent = $request->getParam('sale_or_rent');

// 	$sql = "UPDATE property SET ZooplaID = :ZooplaID, County :County, Country = :Country, Town = :Town, Postcode = :Postcode, Description = :Description, DisplayableAddress = :DisplayableAddress, Image = :Image, Latitude = :Latitude, Longitude = :Longitude, NoOfBathrooms = :NoOfBathrooms, NoOfBedroom = :NoOfBedroom, PropertyType = :PropertyType, SaleOrRent = :SaleOrRent WHERE ID = :id";


// 	try{
// 		$db = new db();

// 		$db = $db->connect;

// 		$stmt = $db->prepare($sql);

// 		$stmt->bindParam(':ZooplaID', $ZooplaID);
// 		$stmt->bindParam(':County', $County);
// 		$stmt->bindParam(':Country', $Country);
// 		$stmt->bindParam(':Town', $Town);
// 		$stmt->bindParam(':Postcode', $Postcode);
// 		$stmt->bindParam(':Description', $Description);
// 		$stmt->bindParam(':DisplayableAddress', $DisplayableAddress);
// 		$stmt->bindParam(':Image', $Image);
// 		$stmt->bindParam(':Latitude', $Latitude);
// 		$stmt->bindParam(':Longitude', $Longitude);
// 		$stmt->bindParam(':NoOfBathrooms', $NoOfBathrooms);
// 		$stmt->bindParam(':NoOfBedroom', $NoOfBedroom);
// 		$stmt->bindParam(':PropertyType', $PropertyType);
// 		$stmt->bindParam(':SaleOrRent', $SaleOrRent);

// 		$stmt->execute();

// 		echo '{"notice": ("text": "Property updated")} ';
// 	} catch(PDOException $e){
// 		echo '{"error": {"text": ' . $e->getMessage().'}';
// 	}

// })->setName('property-edit');

