<?php

declare(strict_types=1);

namespace App\Controllers;

class RegisterController
{

  public function create()
  {
    return include ROOT_URL . '/App/views/register.php';
  }
}
