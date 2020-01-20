<?php

declare(strict_types=1);

namespace Core\Router;


class routeHandlerClass
{
  public $not_found;
  public $method_not_allowed;
  public $found;
  public $routeInfo;
  public $requestInputs;

  function __construct($routeInfo, $not_found = null, $method_not_allowed = null, $found = null, $request_input)
  {
    $this->not_found = $not_found;
    $this->method_not_allowed = $method_not_allowed;
    $this->found = $found;
    $this->routeInfo = $routeInfo;
    $this->requestInputs = $request_input;
  }

  /* public function dispatchRoutes()
  {
    return \FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
      \Core\Router\routeTrait::start($r);
      require_once ROOT_URL . "/routes/route.php";
    });
  }

  public function resolveRoutes($routeInfo, $not_found = null, $method_not_allowed = null, $found = null, $request_input)
  {
    $this->not_found = $not_found;
    $this->method_not_allowed = $method_not_allowed;
    $this->found = $found;
    $this->routeInfo = $routeInfo;
    $this->requestInputs = $request_input;
  } */

  public function run()
  {
    switch ($this->routeInfo[0]) {
      case $this->not_found:
        print " | route not fount";
        // ... 404 Not Found
        break;
      case $this->method_not_allowed:
        $allowedMethods = $this->routeInfo[1];
        // ... 405 Method Not Allowed
        print ' | route method does not exist | ';
        break;
      case $this->found:
        $handlerInfo = $this->routeInfo[1];
        $controllerData = explode('@', $handlerInfo);
        $controller_name = $controllerData[0];
        $controller_action = $controllerData[1];
        //$vars = $this->routeInfo[2];
        $c = "\\App\\Controllers\\" . $controller_name;
        $controller = new $c();
        return $controller->{$controller_action}($this->requestInputs);
        // ... call $handler with $vars
        break;
    }
  }
}
