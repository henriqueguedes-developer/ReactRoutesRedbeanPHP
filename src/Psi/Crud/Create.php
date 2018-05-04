<?php
namespace Psi\Crud;
use \CapMousse\ReactRestify\Http\Request;
use \CapMousse\ReactRestify\Http\Response;
use \RedBeanPHP\Facade as R;

class Create {
  public function save(Request $request, Response $response, $collection) {
    $core = (new \Psi\System\Core)->config($request, $response);
    $response->addHeader('Access-Control-Allow-Methods', 'POST');

    if(!isset($request->httpRequest->getHeaders()['data'])) {
      $response
        ->writeJson(['You need pass HEADER named "data" in a JSON format'])
        ->end();
    }

    $data = json_decode($request->httpRequest->getHeaders()['data'][0], true);
    $data['createdAt'] = $data['updatedAt'] = date('Y-m-d H:i:s');

    $dispense = R::dispense($collection);
    $dispense->import($data);

    try {
      $id = R::store($dispense);

      $response
        ->writeJson(R::load($collection, $id))
        ->end();
    }
    catch(Exception $e) {
      $response
        ->writeJson($e->getMessage())
        ->setStatus(502)
        ->end();
    }
  }
}
