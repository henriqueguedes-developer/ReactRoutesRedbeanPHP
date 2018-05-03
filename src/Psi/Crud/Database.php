<?php
namespace Psi\Crud;
use \CapMousse\ReactRestify\Http\Request;
use \CapMousse\ReactRestify\Http\Response;
use \RedBeanPHP\Facade as R;

class Database {
  public function tables(Request $request, Response $response) {
    $core = (new \Psi\System\Core)->config($request, $response);
    $response->addHeader('Access-Control-Allow-Methods', 'GET');

    $response
      ->writeJson(R::inspect())
      ->end();
  }

  public function table(Request $request, Response $response, $collection) {
    $core = (new \Psi\System\Core)->config($request, $response);
    $response->addHeader('Access-Control-Allow-Methods', 'GET');

    $response
      ->writeJson(R::inspect($collection))
      ->end();
  }
}
