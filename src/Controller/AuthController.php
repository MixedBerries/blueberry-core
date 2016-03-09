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
      $token = $this->auth->generateToken($entity);

      return $response->write($token);
    }
  }
}
