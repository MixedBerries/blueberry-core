<?php

namespace Blueberry\Core\Controller;

use Firebase\JWT\JWT;
use Blueberry\Core\Model\User;

/**
 *
 */
class AuthController
{

  public function authenticate($request, $response, $args)
  {
    $entity = false;
    //Determine Auth type and call login method accordingly
    switch ($args['auth']) {
      case 'password':
        $entity = $this->loginUser($args['credential'], $args['password']);
        break;
        //TODO: add other auth methods to class and call conditionally from here
      default:
        $entity = $this->loginUser($args['credential'], $args['password']);
        break;
    }
    if ($entity)
    {
      $token = $this->generateToken($entity);

      return $response->write('{"jwt" => '.$token.'}');
    }
  }
  /**
   * Login with username/email and password
   */
  protected function loginUser($credential, $password)
  {
    return User::login($credential, $password);
  }

  private function generateToken($entity)
  {
    $scopes = $entity->scopes();
    $tokenScopes = [];
    foreach ($scopes() as $scope) {
      if (!in_array($scope['description'], $tokenScopes))
      {
        array_push($tokenScopes, $scope['description']);
      }
    }

    $token = [
      'iat' => time(),
      'iss' => $_SERVER['HTTP_HOST'],
      'exp' => time() + 3600;
      'scopes' => $tokenScopes
    ];
    return JWT::encode($token, $this->secret);
  }
}
