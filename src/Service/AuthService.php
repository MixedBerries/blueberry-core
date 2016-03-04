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
      $header = isset($header[0]);
      preg_match("/Bearer\s+(.*)$/i", $header, $matches);
      return isset($matches[1]) ? $matches[1] : null;
    }
  }

  public function generateToken($entity)
  {
    $scopes = $this->buildScopes($entity);

    $token = [
      'iat' => time(),
      'iss' => $_SERVER['HTTP_HOST'],
      'exp' => time() + 3600,
      'scopes' => $scopes
    ];

    return json_encode(['jwt' => JWT::encode($token, $this->secret)]);
  }

  public function decodeToken($jwt)
  {
    return JWT::decode($jwt, $this->secret);
  }

  public function getPublicToken()
  {
    $role = Role::where('rolename', 'public')->firstOrFail();
    $scopes = $this->buildScopes($role);
    $token = [
      'iat' => time(),
      'iss' => $_SERVER['HTTP_HOST'],
      'exp' => time() + 3600,
      'scopes' => $scopes
    ];
    return $token;
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
    foreach ($entity->scopes as $scope) {
      if (!in_array($scope['scopename'], $scopes))
      {
        array_push($scopes, $scope['scopename']);
      }
    }
    return $scopes;
  }
}
