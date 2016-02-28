<?php

// DI Container
$container = $app->getContainer();

$container['appBaseDir'] = function($c) {
  return $c->get('settings')['appBaseDir'];
};

$container['mediaDir'] = function($c) {
  return $c->get('settings')['mediaDir'];
};

$container['secret'] = function($c) {
  return $c->get('settings')['secret'];
};

$container['credential'] = function($c) {
  return $c->get('settings')['credential'];
};

foreach ($container->get('settings')['services'] as $service => $class)
{
  $container[$service] = function($c) use ($class) {
    return new $class($c);
  };
};

// Database setup
$capsule = new Illuminate\Database\Capsule\Manager();
$capsule->addConnection($container->get('settings')['database']);
// Set the event dispatcher used by Eloquent models... (optional)
$capsule->setEventDispatcher(new Illuminate\Events\Dispatcher(new Illuminate\Container\Container));
// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
$capsule->setAsGlobal();
$capsule->bootEloquent();

// Routes
$app->group('/api', function() {
  $this->group('/core', function() {
    $this->post('/auth', 'Blueberry\Core\Controller\AuthController:authenticate')->setName('auth');
    $this->any('/users[/{id}]', 'Blueberry\Core\Controller\UserController')->setName('users');
    $this->any('/roles[/{id}]', 'Blueberry\Core\Controller\RoleController')->setName('roles');
    $this->any('/scopes[/{id}]', 'Blueberry\Core\Controller\ScopeController')->setName('scopes');
    $this->any('/files[/{id}]', 'Blueberry\Core\Controller\FileController')->setName('scopes');
  });
});
