<?php

namespace Blueberry\Core\Controller;

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
    $this->flash->addMessage('Login', 'Username or password incorrect');
  }
}
