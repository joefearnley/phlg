<?php

require '../vendor/autoload.php';

use Guzzle\Http\Client;

class ApiText extends PHPUnit_Framework_TestCase
{
  private $httpClient;
  private $uri;
  private $cfg;

  protected function setUp()
  {
    require '../config/config.php';

    $this->cfg = $config['test'];
    $this->httpClient = new Client($this->cfg['host']);
    $this->uri = $this->cfg['uri'];

    $db_host = $this->cfg['db_host'];
    $db_name = $this->cfg['db_name'];
    $db_user = $this->cfg['db_user'];
    $db_pass = $this->cfg['db_pass'];

     RedBean_Facade::setup(
        'mysql:host='.$db_host.';dbname='.$db_name,
        $db_user,
        $db_pass
      );

    $message = RedBean_Facade::dispense('message');
    RedBean_Facade::store($message);
  }

  protected function tearDown()
  {
    //RedBean_Facade::nuke();
  }

  private function doGet($path, $data = array())
  {
    $path = $this->cfg['uri'] . $path;
    $request = $this->httpClient->get($path);
    $response = $request->send();
    return $response;
  }

  private function doPost($path, $data = array())
  {
    $path = $this->cfg['uri'] . $path;
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
    $response = $this->doPost('/message/info',
      array(
        'message' => 'test',
        'app_name' => 'testapp'
      )
    );

    $status = $response->getStatusCode();
    $contentType = $response->getHeader('Content-Type');
    $this->assertEquals(200, $status);
    $this->assertEquals('application/json', $contentType);

    $response = $this->doPost('/message/info',
      array(
        'message' => 'test2',
        'app_name' => 'testapp'
      )
    );

    $status = $response->getStatusCode();
    $contentType = $response->getHeader('Content-Type');
    $this->assertEquals(200, $status);
    $this->assertEquals('application/json', $contentType);

    //$messages = RedBean_Facade::getAll('select * from message');

    //var_dump($messages);

    $this->assertEquals('test', $messages[0]['message']);
    $this->assertEquals('test2', $messages[1]['message']);
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
