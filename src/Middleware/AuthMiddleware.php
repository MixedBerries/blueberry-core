<?php

namespace Blueberry\Core\Middleware;

use Firebase\JWT\JWT;

/**
 *
 */
class AuthMiddleware
{

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
     $scope = $request->getAttribute('route')->getName();
     $jwt = $this->getToken($request);
     $token = $this->decodeToken($jwt);
     if (in_array($scope, $token['scopes']))
     {
       return $next($request, $response);
     }
     // Not allowed, but why? Are we logged in?
     if (!$request->hasHeader('Authorization'))
     {
       // Not logged in, give the chance to log in.
       return $response->withStatus(401);
     }
     //Logged in, but not allowed to access route
     return $response->withStatus(403);
   }

   private function getToken($request)
   {
     $header = $request->getHeader('Authorization');
     $header = isset($header[0]) ? $header[0] : "";
     preg_match("/Bearer\s+(.*)$/i", $header, $matches);
     return $matches[1];
   }

   private function decodeToken($jwt)
   {
     return JWT::decode($jwt, $this->secret);
   }
}