<?php
namespace Psi\Crud;
use \CapMousse\ReactRestify\Http\Request;
use \CapMousse\ReactRestify\Http\Response;
use \RedBeanPHP\Facade as R;

class Query {
  public function whatever(Request $request, Response $response) {
    $core = (new \Psi\System\Core)->config($request, $response);
    $response->addHeader('Access-Control-Allow-Methods', 'GET');

    if(!isset($request->httpRequest->getHeaders()['query'])) {
      $response
        ->writeJson(['You need pass HEADER named "query" in a STRING format'])
        ->end();
    }

    $registries = R::getAll($request->httpRequest->getHeaders()['query'][0]);

    $response
      ->writeJson(R::convertToBeans('registries', $registries))
      ->end();
  }

  public function execute(Request $request, Response $response) {
    $core = (new \Psi\System\Core)->config($request, $response);
    $response->addHeader('Access-Control-Allow-Methods', 'GET');

    if(!isset($request->httpRequest->getHeaders()['query'])) {
      $response
        ->writeJson(['You need pass HEADER named "query" in a STRING format'])
        ->end();
    }

    $response
      ->writeJson(R::exec($request->httpRequest->getHeaders()['query'][0]))
      ->end();
  }

  public function row(Request $request, Response $response) {
    $core = (new \Psi\System\Core)->config($request, $response);
    $response->addHeader('Access-Control-Allow-Methods', 'GET');

    if(!isset($request->httpRequest->getHeaders()['query'])) {
      $response
        ->writeJson(['You need pass HEADER named "query" in a STRING format'])
        ->end();
    }

    $response
      ->writeJson(R::getRow($request->httpRequest->getHeaders()['query'][0]))
      ->end();
  }

  public function col(Request $request, Response $response) {
    $core = (new \Psi\System\Core)->config($request, $response);
    $response->addHeader('Access-Control-Allow-Methods', 'GET');

    if(!isset($request->httpRequest->getHeaders()['query'])) {
      $response
        ->writeJson(['You need pass HEADER named "query" in a STRING format'])
        ->end();
    }

    $response
      ->writeJson(R::getCol($request->httpRequest->getHeaders()['query'][0]))
      ->end();
  }

  public function cell(Request $request, Response $response) {
    $core = (new \Psi\System\Core)->config($request, $response);
    $response->addHeader('Access-Control-Allow-Methods', 'GET');

    if(!isset($request->httpRequest->getHeaders()['query'])) {
      $response
        ->writeJson(['You need pass HEADER named "query" in a STRING format'])
        ->end();
    }

    $response
      ->writeJson(R::getCell($request->httpRequest->getHeaders()['query'][0]))
      ->end();
  }
}
