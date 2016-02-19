<?php

namespace Blueberry\Core\Controller;

use Blueberry\Core\Model\Role;

/**
 *
 */
class RoleController extends BaseController;
{

  protected function index($request, $response, $args)
  {
    $roles = Role::all();

    return $response->write($roles->toJson());
  }

  protected function show($request, $response, $args)
  {
    $role = Role::findOrFail($args['id']);

    return $response->write($role->toJson());
  }

  protected function create($request, $response, $args)
  {
    $data = $request->getParsedBody();
    $role = Role::create($data);

    $return $response->write($role->toJson());
  }

  protected function update($request, $response, $args)
  {
    $data = $request->getParsedBody();
    $role = Role::findOrFail($args['id']);
    $role = $this->object_array_merge($role, $data);

    return $response->write($role->toJson());
  }

  protected function destroy($request, $response, $args)
  {
    Role::destroy($args['id']);

    return $response;
  }
}
