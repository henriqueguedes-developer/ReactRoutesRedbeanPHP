<?php
namespace Psi\Crud;
use \CapMousse\ReactRestify\Http\Request;
use \CapMousse\ReactRestify\Http\Response;
use \RedBeanPHP\Facade as R;

class Delete {
  public function remove(Request $request, Response $response, $collection, $id) {
    $core = (new \Psi\System\Core)->config($request, $response);
    $response->addHeader('Access-Control-Allow-Methods', 'DELETE');

    $data = json_decode($request->httpRequest->getHeaders()['data'][0], true);
    $data['createdAt'] = $data['updatedAt'] = date('Y-m-d H:i:s');

    $dispense = R::load($collection, $id);

    try {
      R::trash($dispense);

      $dispense['trash'] = true;
      
      $response
        ->writeJson($dispense)
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
