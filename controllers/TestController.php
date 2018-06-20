<?php

namespace Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


use models\Property;
use Slim\Views\Twig as View;
use Slim\Container;
/**
 * Class TestController
 *
 * @package Controllers
 */
class TestController
{
    /**
     * @var \Slim\Container Stores the container for dependency purposes.
     */
    protected $container;
    /**
     * Store the container during class construction.
     *
     * @param \Slim\Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }
    /**
     * Output a hello message to a specified name.
     *
     * @param  Request  $request
     * @param  Response $response
     * @param  Array    $args
     * @return mixed
     */
    public function index(Request $request, Response $response, $args)
    {

        return 'Test Controller say: Hellooo there!';

        // $properties = App\Property::all();

        // foreach ($properties as $property) {
        //     echo $property->DisplayableAddress;
        // }


        // return $this->container->get('view')->render(
        //     $response, 'test.twig', [
        //     'name' => $args['name']
        //     ]
        // );
    }
}