<?php
namespace Psi\System;
use \RedBeanPHP\Facade as R;

class Core {
  // from react
  protected $request;
  protected $response;

  public function config($request, $response) {
    $this->request = $request;
    $this->response = $response;
    $this->cors();
  }

  public function __set($key, $value) {
    $this->{$key} = $value;
  }

  public function __get($key) {
    return $this->{$key};
  }

  // debugger
  public function debugger($dump, $die = false) {
    $data = print_r($dump, true);
    $pattern = sprintf('<pre>%s</pre>', $data);

    if($die) die($pattern);
    else echo $pattern;
  }

  private function cors() {
    // cors config default
    $this->response->addHeader('Access-Control-Allow-Origin', CORS);
    $this->response->addHeader('Access-Control-Allow-Credentials', 'true');
    $this->response->addHeader('Access-Control-Max-Age', '300');
    $this->response->addHeader('Access-Control-Allow-Headers', 'Origin, Content-Type');
    $this->response->addHeader('Content-Type', 'application/json; charset=utf-8');
  }

  public function __destruct() {
    if(ENVIRONMENT === 'development') R::fancyDebug(true);
  }
}
