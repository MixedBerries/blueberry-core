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
    if ($result)
    {
      $token = $this->generateToken($entity);

      return $response->write('jwt' => $token);
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
    $token = [
      'iat' => time();

    ];
    return JWT::encode($token, $this->secret);
  }
}
