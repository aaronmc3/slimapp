<?php

namespace Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use App\Property;

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
    public function __construct(\Slim\Container $container)
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


        $properties = App\Property::all();

        foreach ($flights as $flight) {
            echo $flight->name;
        }


        // return $this->container->get('view')->render(
        //     $response, 'test.twig', [
        //     'name' => $args['name']
        //     ]
        // );
    }
}