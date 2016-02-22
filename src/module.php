<?php

// DI Container
$container = $app->getContainer();

$container['secret'] = function($c) {
  return $c->get('settings')['secret'];
};

$container['credential'] = function($c) {
  return $c->get('settings')['credential'];
};

// Routes
$app->group('/api', function() {
  $this->group('/core', function() {
    $this->post('/auth', 'AuthController')->setName('auth');
    $this->any('/users[/{id}]', 'UserController')->setName('users');
    $this->any('/roles[/{id}]', 'RoleController')->setName('roles');
    $this->any('/scopes[/{id}]', 'ScopeController')->setName('scopes');
  });
});
