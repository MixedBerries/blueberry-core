<?php

namespace Blueberry\Core\Controller;

class BaseController
{
  /**
  * handles HTTP GET
  * returns list
  */
  protected function index($request, $response, $args)
  {
    return $response->withStatus(405)->getBody()->write('Method not allowed');
  }
  /**
  * handles HTTP GET
  * returns entity by id
  */
  protected function show($request, $response, $args)
  {
    return $response->withStatus(405)->getBody()->write('Method not allowed');
  }
  /**
  * handles HTTP POST
  * creates new entity
  */
  protected function create($request, $response, $args)
  {
    return $response->withStatus(405)->getBody()->write('Method not allowed');
  }
  /**
  * handles HTTP PUT
  * updates existing entity
  */
  protected function update($request, $response, $args)
  {
    return $response->withStatus(405)->getBody()->write('Method not allowed');
  }
  /**
  * handles HTTP DELETE
  * deletes existing entity
  */
  protected function destroy($request, $response, $args)
  {
    return $response->withStatus(405)->getBody()->write('Method not allowed');
  }
  /**
   * array_merge, but we merge an object with an array_merge
   *
   */
  protected function object_array_merge($object, $array)
  {
    foreach ($array as $key => $value) {
      $object->$key = $value;
    }

    return $object;
  }
  /**
  * because we use the Controller as a callable in the routes, __invoke is needed to redirect to the correct function
  *
  */
  public function __invoke($request, $response, $args)
  {
    $method = $request->getMethod();
    switch ($method) {
      case 'GET':
        if(isset($args['id']))
        {
          $this->show($request, $response, $args);
        } else {
          $this->index($request, $response, $args);
        }
        break;
      case 'POST':
        $this->create($request, $response, $args);
        break;
      case 'PUT':
        $this->update($request, $response, $args);
        break;
      case 'DELETE':
        $this->destroy($request, $response, $args);
        break;
      default:
        return $response->withStatus(405)->getBody()->write('Method not allowed');
        break;
    }
  }
}
