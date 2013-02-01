<?php

require '../vendor/autoload.php';
use Guzzle\Http\Client;

class ApiText extends PHPUnit_Framework_TestCase
{
  private $httpClient;

  protected function setUp()
  {
    $this->httpClient = new Client('http://localhost/lowphashion');

    RedBean_Facade::setup(
        'mysql:host=127.0.0.1;dbname=lowphashion',
        'lowphashion',
        'password'
      );

    $messages = RedBean_Facade::dispense('message', 3);
  }

  protected function tearDown()
  {
    RedBean_Facade::nuke();
  }

  private function doGet($path, $data = array())
  {
    $request = $this->httpClient->get($path);
    $response = $request->send();
    return $response;
  }

  private function doPost($path, $data = array())
  {
    $request = $this->httpClient->post($path, $data);
    $response = $request->send();
    return $response;
  }

  public function testIndexGet()
  {
    $response = $this->doGet('/');
    $status = $response->getStatusCode();
    $contentType = $response->getHeader('Content-Type');

    $this->assertEquals(200, $status);
    $this->assertEquals('text/html', $contentType);
  }

  public function testIndexPost()
  {
    $data = array('message' => 'test');
    $response = $this->doPost('/', $data);
    $status = $response->getStatusCode();
    $contentType = $response->getHeader('Content-Type');

    // This is returning a 200 ??? Why??
    $this->assertEquals(404, $status);
    $this->assertEquals('text/html', $contentType);
  }

  public function testPostMessage()
  {
    $this->assertFalse(false);
  }

  public function testPostInfoMessage()
  {
    $this->assertFalse(false);
  }

  public function testPostErrorMessage()
  {
    $this->assertFalse(false);
  }

  public function testGetAllMessages()
  {
    $this->assertFalse(false);
  }

  public function testGetMessage()
  {
    $this->assertFalse(false);
  }

  public function testError()
  {
    $this->assertFalse(false);
  }
}
