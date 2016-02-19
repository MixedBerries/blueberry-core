<?php

namespace Blueberry\Core\Middleware;

use Blueberry\Core\Middleware\AuthMiddleware;

/**
 * This middleware assigns a scope (name) to the route
 */
class RouteScopeMiddleWare
{

  function __invoke($request, $response, $next)
  {
    $scope = "";
    $route = $request->getAttribute('route');
    $resource = explode('/', $route->getPattern())[3];
    $method = $request->getMethod;
    switch ($method) {
      case 'GET':
        $scope = $resource.':read';
        break;
      case 'POST':
        $scope = $resource.':create';
      case 'PUT':
        $scope = $resource.':edit';
      case 'DELETE':
        $scope = $resource.':delete';
    }
    $route->setName($scope);

    return $next($request, $response);
  }
}
