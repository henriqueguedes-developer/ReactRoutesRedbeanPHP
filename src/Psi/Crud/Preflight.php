<?php
namespace Psi\Crud;
use \CapMousse\ReactRestify\Http\Request;
use \CapMousse\ReactRestify\Http\Response;

class Preflight {
  public function run(Request $request, Response $response) {
    $core = (new \Psi\System\Core)->config($request, $response);
    $response->addHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, PATCH, DELETE');

    $response
      ->writeJson('Preflight in '.SERVERSIGN.' works!')
      ->end();
  }
}
