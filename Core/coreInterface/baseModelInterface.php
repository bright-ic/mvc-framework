<?php

declare(strict_types=1);

namespace Core\CoreInterface;

interface BaseModelInterface
{
  public function getConnection();
  public function initDBConnection();
  public function getDBController();
  public function getChildProperties();
  public function create(array $dbData);
}
