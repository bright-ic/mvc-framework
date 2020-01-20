<?php

declare(strict_types=1);

namespace App\Models;

use Core\Models\BaseModelClass;

class IndexModelClass extends BaseModelClass
{
  protected $fields = ['uid', 'name', 'phone', 'email'];
  protected $tableName = "tbl_users";
  protected $primaryKey = "uid";
}
