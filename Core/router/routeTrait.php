<?php

declare(strict_types=1);

namespace Core\Router;

trait routeTrait
{
  static $router;

  public static function start($r)
  {
    self::$router = $r;
  }

  public static function add($method, $path, $handler)
  {
    self::$router->addRoute($method, $path, $handler);
  }

  public static function post($path, $handler)
  {
    self::$router->addRoute("POST", $path, $handler);
  }

  public static function get($path, $handler)
  {
    self::$router->addRoute("GET", $path, $handler);
  }

  public static function put($path, $handler)
  {
    self::$router->addRoute("PUT", $path, $handler);
  }
  public static function patch($path, $handler)
  {
    self::$router->addRoute("PATCH", $path, $handler);
  }
  public static function delete($path, $handler)
  {
    self::$router->addRoute("DELETE", $path, $handler);
  }

  public static function addGroup(string $groupName, array $routes)
  {
    if (is_array($routes)) {
      if (count($routes) > 0) {
        foreach ($routes as $route) {
          self::$router->addRoute($route[0], '/' . $groupName . $route[1], $route[2]);
          if ($route[1] == "/") {
            self::$router->addRoute($route[0], '/' . $groupName, $route[2]);
          }
        }
      }
    }
  }
}
