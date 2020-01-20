<?php

declare(strict_types=1);

namespace Core\CoreInterface;

interface JsonResponseInterface
{
  public function sendJson(array $data, $code = 200);
}


interface ArrayResponseInterface
{
  public function sendArray();
}

interface FileResponseInterface
{
  public function send($data, $code = 200);
}

interface ResponseInterface extends JsonResponseInterface, ArrayResponseInterface, FileResponseInterface
{
  public function view($filename);
}
