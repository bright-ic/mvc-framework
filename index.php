<?php

declare(strict_types=1);
session_start();


define('ROOT_URL', dirname(__FILE__));

require_once ROOT_URL . "/vendor/autoload.php";


spl_autoload_register(function ($className) {

  $className = str_replace("\\", DIRECTORY_SEPARATOR, $className);
  if (file_exists(ROOT_URL . '/' . $className . '.class.php')) {
    include_once ROOT_URL . '/' . $className . '.class.php';
  } else if (file_exists(ROOT_URL . '/' . $className . '.php')) {
    include_once ROOT_URL . '/' . $className . '.php';
  }
});


$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
  \Core\Router\routeTrait::start($r);
  require_once ROOT_URL . "/routes/route.php";
});



// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];
//print $uri . "=== " . ROOT_URL;

// probably romove this from a non apatche server start
$pageUri = $_SERVER['PHP_SELF'];
$pUri = substr($pageUri, 0, strrpos($pageUri, 'index.php'));

$uri = substr($uri, strlen($pUri) - 1);
// probably remove this from a non apatche server start

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
  $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
$route_params = [];
if (isset($routeInfo[2])) {
  $route_params = $routeInfo[2];
}

/* 
Bootstrap request object
//prepare and return data sent through the request [post, get]
 */
$POST = '';
if ($httpMethod !== 'GET') {
  $reqJsonData = json_decode(file_get_contents('php://input'), true);
  $POST = $reqJsonData !== null ? $reqJsonData : $_POST;
}
// do not change this
$requestHelper = new \Core\Factory\RequestInputFactory($POST, $_GET, $_SERVER, $_COOKIE, $route_params, $_FILES);
$requestInputs = $requestHelper->getRequestInputs();


$routeHandler = new \Core\Router\routeHandlerClass(
  $routeInfo,
  \FastRoute\Dispatcher::NOT_FOUND,
  \FastRoute\Dispatcher::METHOD_NOT_ALLOWED,
  FastRoute\Dispatcher::FOUND,
  $requestInputs
);
$routeHandler->run();
