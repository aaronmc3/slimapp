<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once '../vendor/autoload.php';
require '../src/config/db.php';
require_once '../bootstrap.php';

//routes
require_once '../src/routes/routes.php';

$app->run();