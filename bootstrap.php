<?php



$config = include_once 'config.php';
$container = new \Slim\Container($config['slim']);

$app = new \Slim\App($container);

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

//controller test - passing views
$container['TestController'] = function($container) {
    return new Controllers\TestController;
};
