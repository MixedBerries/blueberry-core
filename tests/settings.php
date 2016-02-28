<?php
return [
  'settings' => [
    'displayErrorDetails' => true,
    // Application Directories
    'appBasedir' => __DIR__,
    'mediaDir' => __DIR__.'/media/',
    // The application secret
    'secret' => 'j3jfw832j9f8wVf7qa',
    // The credential for users to login
    'credential' => 'username',
    // Services
    'services' => [
      'auth' => 'Blueberry\Core\Service\AuthService',
    ],
    // Database configuration
    'database' => [
      'driver' => 'mysql',
      'host' => 'localhost',
      'database' => 'blueberry',
      'username' => 'blueberry',
      'password' => 'mixedberries',
      'charset'   => 'utf8',
      'collation' => 'utf8_unicode_ci',
      'prefix' => ''
    ],
  ]
];
