<?php

namespace Blueberry\Core\Service;

use Blueberry\Core\Model\User;
use Blueberry\Core\Model\Role;
use Firebase\JWT\JWT;

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

  public function getToken($request)
  {
    $header = $request->getHeader('Authorization');
    if (isset($header[0]))
    {
      $header = $header[0];
      preg_match("/Bearer\s+(.*)$/i", $header, $matches);
      return isset($matches[1]) ? $matches[1] : null;
    }
  }

  public function generateToken($entity, $jwt = true)
  {
    $scopes = $this->buildScopes($entity);
    $token = [
      'iat' => time(),
      'iss' => $_SERVER['HTTP_HOST'],
      'exp' => time() + 3600,
      'scopes' => $scopes
    ];
    if ($jwt)
    {
      return json_encode(['jwt' => JWT::encode($token, $this->secret)]);
    } else {
      return $token;
    }
  }

  public function decodeToken($jwt)
  {
    return (array) JWT::decode($jwt, $this->secret, array('HS256'));
  }

  public function getPublicToken()
  {
    $role = Role::where('rolename', 'public')->firstOrFail();
    return $this->generateToken($role,false);
  }

  protected function loginUser($credential, $password)
  {
    $user = User::where($this->credential, $credential)->firstOrFail();
    if (password_verify($password, $user->password))
    {
      return $user;
    }
  }

  protected function buildScopes($entity)
  {
    $scopes = [];
    if ($entity instanceof \Illuminate\Database\Eloquent\Collection)
    {
      $entity = $entity->flatten();
    }
    foreach ($entity->scopes as $scope) {
      if (!in_array($scope['scopename'], $scopes))
      {
        array_push($scopes, $scope['scopename']);
      }
    }
    return $scopes;
  }
}
