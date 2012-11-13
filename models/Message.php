<?php

class Message
{
    private $id;
    private $app_name;
    private $message;
    private $message_type;
    private $posted;

    public function __construct($id=0, $app_name='', $message='', $message_type='', $posted)
    {
      $this->id = $id;
      $this->app_name = $app_name;
      $this->message = $message;
      $this->message_type = $message_type;
      $this->posted = $posted;
    }

    public function setId($id=0)
    {
      $this->id = $id;
    }

    public function getId()
    {
      return $this->id;
    }

    public function setAppName($app_name='')
    {
      $this->app_name = $app_name;
    }

    public function getAppName()
    {
      return $this->app_name;
    }

    public function setMessage($message='')
    {
      $this->message = $message;
    }

    public function getMessage()
    {
      return $this->message;
    }

    public function setMessageType($message_type='')
    {
      $this->message_type = $message_type;
    }

    public function getMessageType()
    {
      return $this->message_type;
    }

    public function setPosted($posted)
    {
      $this->posted = $posted;
    }

    public function getPosted()
    {
      return $this-posted;
    }
}

?>
