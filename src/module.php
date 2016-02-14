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

$app->post('/api/core/auth', 'AuthController');
