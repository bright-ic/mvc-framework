<?php

declare(strict_types=1);

namespace Core\Helpers;

use \Core\CoreInterface\ResponseInterface;
use Exception;

class ResponseHelper implements ResponseInterface
{

  public function sendJson(array $data, $code = 200)
  {
    header('Content-Type: application/json');
    $jsonData = json_encode($data);
    /* if ($jsonData === false) {
      // Avoid echo of empty string (which is invalid JSON), and
      // JSONify the error message instead:
      $jsonData = json_encode(array("jsonError", json_last_error_msg()));
      if ($jsonData === false) {
        // This should not happen, but we go all the way now:
        $jsonData = '{"jsonError": "unknown"}';
      }
      // Set HTTP response status code to: 500 - Internal Server Error
      http_response_code(500);
    } */
    http_response_code($code);
    echo $jsonData;
  }

  public function sendArray()
  {
  }

  public function send($data, $code = 200)
  {
    http_response_code($code);
    echo $data;
  }

  public function view($filename, array $data = [])
  {
    /* $closure = function () use ($filename) {
      ob_start();
      include ROOT_URL . "/App/views/$filename.php";
      return
        ob_end_flush();
    }; */
    $data = (object) $data;
    try {
      header('Content-Type: text/html; charset=UTF-8');
      ob_start();
      include ROOT_URL . "/App/views/$filename.php";
      $data = $data;
      $content = ob_get_contents();
      ob_end_clean();
      echo $content;
      //$templates = new \League\Plates\Engine(ROOT_URL . '/App/views');
      /* $dataObj = new Data($data);
      $closure->bindTo($dataObj, $dataObj);
      $closure($filename); */
      //$templates->loadExtension(new \League\Plates\Extension\Asset(ROOT_URL . '/static', true));
      //echo $templates->render($filename, $data);
    } catch (Exception $ex) {
      echo $ex;
      echo "<div>
      404 View Not Found
      </div>";
    }
  }
}

class Data
{
  private $data;
  function __construct($data)
  {
    $this->data = $data;
  }
}
