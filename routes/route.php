<?php

declare(strict_types=1);

namespace Routes;

use Core\Router\routeTrait as Route;

Route::add("GET", "/", "indexController@index");
Route::add("GET", "/user/{name}", "indexController@index");
Route::addGroup(
  'admin',
  [
    ["GET", "/", "adminIndexController@index"],
    ["POST", "/user", "adminIndexController@create"]
  ]
);
