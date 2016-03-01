<?php

namespace Blueberry\Core\Service;

use Firebase\JWT\JWT;

/**
 *
 */
class TokenService extends BaseService
{
  public function generateToken($entity)
  {
    $scopes = $entity->scopes();
    $tokenScopes = [];
    foreach ($scopes as $scope) {
      if (!in_array($scope['scopename'], $tokenScopes))
      {
        array_push($tokenScopes, $scope['scopemame']);
      }
    }

    $token = [
      'iat' => time(),
      'iss' => $_SERVER['HTTP_HOST'],
      'exp' => time() + 3600,
      'scopes' => $tokenScopes
    ];

    return json_encode(['jwt' => JWT::encode($token, $this->secret)]);
  }
}
