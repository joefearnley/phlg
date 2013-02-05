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
    $message->app_name = 'lowphashion_test';
    $message->body = 'setting up database for tests';
    $message->type = 'info';
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

  /**
   * Perform a GET against the API
   *
   * @param string $path - Endpoint to test.
   * @param string $data - Parameters
   * 
   */
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

  /**
   * Test an attempt to post to the /messgae endpoint. This should
   * result in a 404 which throws an exception.
   */
  public function testPostMessage()
  {
    $this->setExpectedException('Guzzle\Http\Exception\ClientErrorResponseException');

    $data = array('message' => 'test');
    $response = $this->doPost('/message', $data);
  }

  /**
   * Test the /message/info endpoint. Two calls are made to the 
   * endpoint, one with an app_name and one without. Check the 
   * http status and content type of the response then the body,
   * app_name and type is stored in the database correctly.
   */
  public function testPostInfoMessage()
  {
    $response = $this->doPost('/message/info', array('body' => 'test'));

    $this->assertEquals(200, $response->getStatusCode());
    $this->assertEquals('application/json', $response->getHeader('Content-Type'));
    $this->assertEquals('OK', $response->getReasonPhrase());

    $response = $this->doPost('/message/info', 
          array(
             'body' => 'test2',
             'app_name' => 'test_app'
           )
         );

    $this->assertEquals(200, $response->getStatusCode());
    $this->assertEquals('application/json', $response->getHeader('Content-Type'));
    $this->assertEquals('OK', $response->getReasonPhrase());

    $messages = RedBean_Facade::find('message', 'app_name is not null');

    $message1 = $messages[2];
    $message2 = $messages[3];

    $this->assertEquals('test', $message1->body);
    $this->assertEquals('lowphashion_test', $message1->app_name);
    $this->assertEquals('info', $message1->type);

    $this->assertEquals('test2', $message2->body);
    $this->assertEquals('test_app', $message2->app_name);
    $this->assertEquals('info', $message2->type);
  }

  /**
   * Same test as testPostInfoMessage() on the endpooint is /message/error.
   */
  public function testPostErrorMessage()
  {
    $response = $this->doPost('/message/error', array('body' => 'test'));

    $this->assertEquals(200, $response->getStatusCode());
    $this->assertEquals('application/json', $response->getHeader('Content-Type'));
    $this->assertEquals('OK', $response->getReasonPhrase());

    $response = $this->doPost('/message/error', 
          array(
             'body' => 'test2',
             'app_name' => 'test_app'
           )
         );

    $this->assertEquals(200, $response->getStatusCode());
    $this->assertEquals('application/json', $response->getHeader('Content-Type'));
    $this->assertEquals('OK', $response->getReasonPhrase());

    $messages = RedBean_Facade::find('message', 'app_name is not null');

    $message1 = $messages[2];
    $message2 = $messages[3];

    $this->assertEquals('error', $message1->type);
    $this->assertEquals('error', $message2->type);
  }

  /**
   * Test for the /message/all endpoint. Create 2 records 
   * and confirm they can be retrieve. The total count is 
   * 3 because of the initial record created in the set up.
   */
  public function testGetAllMessages()
  {
    $message = RedBean_Facade::dispense('message');
    $message->app_name = 'test_app';
    $message->body = 'This is a test message.';
    $message->type = 'info';
    $message->posted = RedBean_Facade::$f->now();
    RedBean_Facade::store($message);

    $message = RedBean_Facade::dispense('message');
    $message->app_name = 'lowphashion';
    $message->body = 'This a second test.';
    $message->type = 'info';
    $message->posted = RedBean_Facade::$f->now();
    RedBean_Facade::store($message);

    $response = $this->doGet('/message/all');

    $body = json_decode($response->getBody());
    $messages = $body->messages;

    $this->assertEquals('ok', $body->status);
    $this->assertEquals(3, count($messages));
    $this->assertEquals(200, $response->getStatusCode());
    $this->assertEquals('application/json', $response->getHeader('Content-Type'));
  }

  /**
   * Test for the /message/:id endpoint. Create a record 
   * and fetch it by its id generated from the ORM. 
   */
  public function testGetMessageById()
  {
    $message = RedBean_Facade::dispense('message');
    $message->app_name = 'test_app';
    $message->body = 'This is a test message.';
    $message->type = 'info';
    $message->posted = RedBean_Facade::$f->now();
    RedBean_Facade::store($message);

    $response = $this->doGet('/message/' . $message->id);

    $body = json_decode($response->getBody());
    $message = $body->message;

    $this->assertEquals('ok', $body->status);
    $this->assertEquals('This is a test message.', $message->body);
    $this->assertEquals(200, $response->getStatusCode());
    $this->assertEquals('application/json', $response->getHeader('Content-Type'));
  }

  /**
   * Test for the /message/type/info endpoint. 
   */
  public function testGetInfoMessage()
  {
    $message = RedBean_Facade::dispense('message');
    $message->app_name = 'test_app';
    $message->body = 'This is an INFO message.';
    $message->type = 'info';
    $message->posted = RedBean_Facade::$f->now();
    RedBean_Facade::store($message);

    $response = $this->doGet('/message/type/info');

    $body = json_decode($response->getBody());
    $message = $body->messages[1];

    $this->assertEquals('ok', $body->status);
    $this->assertEquals('This is an INFO message.', $message->body);
    $this->assertEquals(200, $response->getStatusCode());
    $this->assertEquals('application/json', $response->getHeader('Content-Type'));
  }

  /**
   * Test for the /message/type/error endpoint. 
   */
  public function testGetErrorMessage()
  {
    $message = RedBean_Facade::dispense('message');
    $message->app_name = 'test_app';
    $message->body = 'This is an ERROR message.';
    $message->type = 'error';
    $message->posted = RedBean_Facade::$f->now();
    RedBean_Facade::store($message);

    $response = $this->doGet('/message/type/error');

    $body = json_decode($response->getBody());
    $message = $body->messages[0];

    $this->assertEquals('ok', $body->status);
    $this->assertEquals('This is an ERROR message.', $message->body);
    $this->assertEquals(200, $response->getStatusCode());
    $this->assertEquals('application/json', $response->getHeader('Content-Type'));
  }

  public function testError()
  {
    $this->assertFalse(false);
  }
}
