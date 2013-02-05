<?php

require '../vendor/autoload.php';

use Guzzle\Http\Client;

class ApiText extends PHPUnit_Framework_TestCase
{
  private $httpClient;
  private $uri;
  private $cfg;

  /**
   * Set up the database and configuration stuff. This
   * function will get called each time a test is called.
   */
  protected function setUp()
  {
    require '../config/config.php';

    $this->cfg = $config['test'];
    $this->httpClient = new Client($this->cfg['host']);
    $this->uri = $this->cfg['uri'];

    $connection = $this->cfg['connection'];
    $db_user = $this->cfg['db_user'];
    $db_pass = $this->cfg['db_pass'];

    RedBean_Facade::setup($connection, $db_user, $db_pass);

    $message = RedBean_Facade::dispense('message');
    $message->app_name = null;
    $message->body = '';
    $message->type = '';
    $message->posted = RedBean_Facade::$f->now();

    RedBean_Facade::store($message);
  }

  /**
   * Tear down - delete the database tables.
   */
  protected function tearDown()
  {
    RedBean_Facade::nuke();
  }

  private function doGet($path, $data = array())
  {
    $path = $this->uri . $path;
    $request = $this->httpClient->get($path);
    $response = $request->send();
    return $response;
  }

  private function doPost($path, $data = array())
  {
    $path = $this->uri . $path;
    $request = $this->httpClient->post($path)->addPostFields($data);
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
    $this->setExpectedException('Guzzle\Http\Exception\ClientErrorResponseException');

    $data = array('message' => 'test');
    $response = $this->doPost('/', $data);
  }

  public function testPostMessage()
  {
    $this->setExpectedException('Guzzle\Http\Exception\ClientErrorResponseException');

    $data = array('message' => 'test');
    $response = $this->doPost('/message', $data);
  }

  public function testPostInfoMessage()
  {
    $response = $this->doPost('/message/info', array('body' => 'test'));

    $status = $response->getStatusCode();
    $contentType = $response->getHeader('Content-Type');
    $this->assertEquals(200, $status);
    $this->assertEquals('application/json', $contentType);

    $response = $this->doPost('/message/info', array('body' => 'test2'));

    $status = $response->getStatusCode();
    $contentType = $response->getHeader('Content-Type');
    $this->assertEquals(200, $status);
    $this->assertEquals('application/json', $contentType);

    $messages = RedBean_Facade::find('message', 'app_name is not null');

    $message1 = $messages[2];
    $message2 = $messages[3];

    $this->assertEquals('test', $messages[2]->body);
    $this->assertEquals('lowphashion', $me
    $this->assertEquals('test2', $messages[3]->body);
    
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
