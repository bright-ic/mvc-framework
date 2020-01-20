<?php

declare(strict_types=1);

namespace Core\Factory;

/* ------------------------------------------------------------------------------------ */

trait PrepareRequestInput
{
  static $reqInput = [];
  public static function prepareInputRequest(array $requestInput)
  {
    self::$reqInput = [];

    if (!is_array($requestInput)) {
      return (object) self::$reqInput;
    }
    if (count($requestInput) === 0) {
      return (object) self::$reqInput;
    }
    foreach ($requestInput as $key => $value) {
      self::$reqInput += [$key => $value];
    }
    return (object) self::$reqInput;
  }
}

/* -------------------------------------------------------------------------------- */

class RequestInputFactory
{
  public $requestHelper;
  public $request = ['post' => [], 'get' => [], 'server' => [], 'cookie' => [], 'param' => [], 'files' => []];
  use PrepareRequestInput;

  function __construct($postInputs = null, $getInputs = null, $server = null, $cookie = null, array $route_params = [], $files)
  {
    if (is_array($postInputs)) {
      $this->request['post'] = PrepareRequestInput::prepareInputRequest($postInputs);
    }
    if (is_array($getInputs)) {
      $this->request['get'] = PrepareRequestInput::prepareInputRequest($getInputs);
    }
    if (is_array($server)) {
      $this->request['session'] = PrepareRequestInput::prepareInputRequest($server);
    }
    if (is_array($cookie)) {
      $this->request['cookie'] = PrepareRequestInput::prepareInputRequest($cookie);
    }
    if (is_array($route_params)) {
      $this->request['param'] = PrepareRequestInput::prepareInputRequest($route_params);
    }
    if (is_array($files)) {
      $this->request['files'] = PrepareRequestInput::prepareInputRequest($files);
    }
  }

  public function getRequestInputs(): object
  {
    return (object) $this->request;
  }
}
