<?php

namespace Blueberry\Core\Controller;

use Blueberry\Core\Model\User;

/**
 *
 */
class UserController extends BaseController
{

  protected function index($request, $response, $args)
  {
    $users = User::all();

    return $response->write($users->toJson());
  }

  protected function show($request, $response, $args)
  {
    $user = User::findOrFail($args['id']);

    return $response->write($user->toJson());
  }

  protected function create($request, $response, $args)
  {
    $data = $request->getParsedBody();
    if ($data)
    {
      User::unguard();
      $user = User::create($data);
      User::reguard();
      return $response->write($user->toJson());
    }
  }

  protected function update($request, $response, $args)
  {
    $data = $request->getParsedBody();
    $user = User::findOrFail($args['id']);
    $user = $this->object_array_merge($user, $data);
    $user->password = password_hash($data['password'], PASSWORD_BCRYPT);
    $user->save();
    return $response->write($user->toJson());
  }

  protected function destroy($request, $response, $args)
  {
    User::destroy($args['id']);

    return $response;
  }
}
