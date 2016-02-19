<?php

namespace Blueberry\Core\Controller;

use Blueberry\Core\Model\Scope;

/**
 *
 */
class ScopeController extends BaseController;
{

  protected function index($request, $response, $args)
  {
    $scopes = Scope::all();

    return $response->write($scopes->toJson());
  }

  protected function show($request, $response, $args)
  {
    $scope = Scope::findOrFail($args['id']);

    return $response->write($scope->toJson());
  }

  protected function create($request, $response, $args)
  {
    $data = $request->getParsedBody();
    $scope = Scope::create($data);

    $return $response->write($scope->toJson());
  }

  protected function update($request, $response, $args)
  {
    $data = $request->getParsedBody();
    $scope = Scope::findOrFail($args['id']);
    $scope = $this->object_array_merge($scope, $data);

    return $response->write($scope->toJson());
  }

  protected function destroy($request, $response, $args)
  {
    Scope::destroy($args['id']);

    return $response;
  }
}
