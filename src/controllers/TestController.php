<?php

namespace Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

//namespace Models
use Models\Property;

//use Slim\Views\Twig as View;
use Slim\Container as Container;

/**
 * Class TestController
 *
 * @package Controllers
 */
class TestController extends Controller
{
   
    public function index(Request $request, Response $response, $args)
    {

        $properties = Property::all();
        //var_dump($property);

        //die();
        return $this->container->view->render(
        	$response, 'test.twig', [
        	'properties' => $properties
    	]);

    }
}