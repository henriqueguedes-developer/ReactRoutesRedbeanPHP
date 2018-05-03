<?php
namespace Psi\Crud;
use \CapMousse\ReactRestify\Http\Request;
use \CapMousse\ReactRestify\Http\Response;
use \RedBeanPHP\Facade as R;

class Find {
  public function one(Request $request, Response $response, $collection, $id) {
    $core = (new \Psi\System\Core)->config($request, $response);
    $response->addHeader('Access-Control-Allow-Methods', 'GET');

    $response
      ->writeJson(R::load($collection, $id))
      ->end();
  }

  public function many(Request $request, Response $response, $collection) {
    $core = (new \Psi\System\Core)->config($request, $response);
    $response->addHeader('Access-Control-Allow-Methods', 'GET');

    if(!isset($request->httpRequest->getHeaders()['where'])) {
      $response
        ->writeJson(['Não foi encontrado o HEADER "where"'])
        ->end();
    }

    $response
      ->writeJson([
        'data' => R::find($collection, $request->httpRequest->getHeaders()['where'][0]),
        'records' => R::count($collection, $request->httpRequest->getHeaders()['where'][0])
      ])
      ->end();
  }
}
