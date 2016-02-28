<?php

namespace Blueberry\Core\Controller;

use Firebase\JWT\JWT;
use Blueberry\Core\Model\User;

/**
 *
 */
class AuthController extends BaseController
{

  public function authenticate($request, $response, $args)
  {
    $data = $request->getParsedBody();
    $entity = $this->auth->authenticate($data);
    if ($entity)
    {
      $token = $this->generateToken($entity);

      return $response->write('{"jwt" => '.$token.'}');
    }
  }

  private function generateToken($entity)
  {
    $scopes = $entity->scopes();
    $tokenScopes = [];
    foreach ($scopes as $scope) {
      if (!in_array($scope['description'], $tokenScopes))
      {
        array_push($tokenScopes, $scope['description']);
      }
    }

    $token = [
      'iat' => time(),
      'iss' => $_SERVER['HTTP_HOST'],
      'exp' => time() + 3600,
      'scopes' => $tokenScopes
    ];
    return JWT::encode($token, $this->secret);
  }
}
