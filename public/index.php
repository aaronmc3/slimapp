<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
require '../src/config/db.php';

$app = new \Slim\App([
    'settings' => [
    	 // Enable whoops
        'debug' => true,

        // Support click to open editor
        'whoops.editor' => 'sublime',

        // Display call stack in orignal slim error when debug is off
        'displayErrorDetails' => true,
    ]
]);

$app->add(new \Zeuxisoo\Whoops\Provider\Slim\WhoopsMiddleware);

// Get container
$container = $app->getContainer();
// Register component on container
$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig('../templates', [
        'cache' => false
    ]);
    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $container->get('request')->getUri()->getBasePath()), '/');
    // Twig view
    $view->addExtension(new Slim\Views\TwigExtension($container->get('router'), $basePath));
    return $view;
};

$container['db'] = (new db)->connect();

$container['query'] = new Helpers\QueryBuilder($container['db']);


//routes
require '../src/routes/routes.php';

$app->run();