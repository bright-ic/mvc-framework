<?php

declare(strict_types=1);

namespace App\Controllers;

use Core\Helpers\ResponseHelper as response;

/* 
remove this start
*/
use Core\DB\connectionClass;
use Core\DB\DatabaseControllerClass;


use App\Models\IndexModelClass;
use Exception;

/* 
remove this end
*/

class IndexController
{

  public function index($request)
  {
    //$fields = ['name', 'phone', 'email'];
    $data = array('name' => "Henry", 'phone' => "08088877821");
    //$condition = "where name=:name";

    try {
      /*  $User = new IndexModelClass();
      $response = $User->create($data); */
      //var_dump($response);
    } catch (Exception $ex) {
      var_dump($ex->getMessage());
    }
    //var_dump($request);
    return  response::view('home', ['user' => $data]);
  }

  public function create($request)
  {
    return response::view('home');
  }
}
