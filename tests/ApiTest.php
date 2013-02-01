<?php

require '../vendor/autoload.php';

class ApiText extends PHPUnit_Framework_TestCase
{

  protected function setUp()
  {
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

  public function testIndex()
  {
    $this->assertFalse(false);
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
