<?php

namespace Blueberry\Core\Service;

use Blueberry\Core\Model\User;

class AuthService extends BaseService
{
  public function authenticate($data)
  {
    $entity = false;
    //Determine Auth type and call login method accordingly
    switch ($data['auth']) {
      case 'password':
        $entity = $this->loginUser($data['credential'], $data['password']);
        break;
        //TODO: add other auth methods to class and call conditionally from here
      default:
        $entity = $this->loginUser($data['credential'], $data['password']);
        break;
    }
    if ($entity)
    {
      return $entity;
    }
  }

  protected function loginUser($credential, $password)
  {
    $user = User::where($this->credential, $credential)->firstOrFail();
    if (password_verify($password, $user->password))
    {
      return $user;
    }
  }
}
