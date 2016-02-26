<?php

require(__DIR__.'/../vendor/autoload.php');

class UserTest extends PHPUnit_Framework_TestCase
{
  protected $client;

  protected $body = [
    'username' => 'vrxj81',
    'firstname' => 'Johan',
    'lastname' => 'Vrolix',
    'email' => 'johan@vrolix.eu',
    'password' => 'mixedberries',
  ];

  protected function setUp()
    {
        $this->client = new GuzzleHttp\Client([
            'base_uri' => 'http://localhost:8000/api/core/'
        ]);
    }

    public function testPost_User()
    {
      $response = $this->client->post('users', [
        'json' => $this->body
      ]);

      $this->assertEquals(200, $response->getStatusCode());

      $data = json_decode($response->getBody(), true);

      foreach ($this->body as $key => $value) {
        $this->assertEquals($data[$key], $value);
      }
    }
}
