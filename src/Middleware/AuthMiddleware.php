<?php

namespace Blueberry\Core\Middleware;

/**
 *
 */
class AuthMiddleware
{
  protected $container;
  public function __construct($container)
  {
    $this->container = $container;
  }

  /**
   * Authentication and authorization middleware
   *
   * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
   * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
   * @param  callable                                 $next     Next middleware
   *
   * @return \Psr\Http\Message\ResponseInterface
   */
   public function __invoke($request, $response, $next)
   {
     $scope = $this->getScope($request);
     $jwt = $this->auth->getToken($request);
     if ($jwt)
     {
       $token = $this->auth->decodeToken($jwt);
     } else {
       $token = $this->auth->getPublicToken();
     }
     if (in_array($scope, $token['scopes']) && time() <= $token['exp'])
     {
       return $next($request, $response);
     }
     // Not allowed, but why? Are we logged in?
     if (!$request->hasHeader('Authorization') || time() > $token['exp'])
     {
       // Not logged in or token has expired, give the chance to log in.
       return $response->withStatus(401);
     }
     //Logged in, but not allowed to access route
     return $response->withStatus(403);
  }

   private function getScope($request)
   {
     $resource = $request->getAttribute('route')->getName();
     $method = $request->getMethod();
     switch ($method) {
       case 'GET':
         $scope = $resource.':read';
         break;
       case 'POST':
         $scope = $resource.':create';
         break;
       case 'PUT':
         $scope = $resource.':edit';
         break;
       case 'DELETE':
         $scope = $resource.':delete';
         break;
     }
     return $scope;
   }

   public function __get($name)
   {
     return $this->container->get($name);
   }
}
