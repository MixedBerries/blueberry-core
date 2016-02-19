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
    $this->post('/auth', 'AuthController');
    $this->any('/users[/{id}]', 'UserController');
    $this->any('/roles[/{id}]', 'RoleController');
    $this->any('/scopes[/{id}]', 'ScopeController');
  });
});
