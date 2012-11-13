<?php

class MessageHandler
{
  private $log_type;
  private $app_name;
  private $message_type;
  private $message;

  public function __construct($log_type, $app_name, $message_type, $message)
  {
    $this->log_type = $log_type;
    $this->app_name = $app_name;
    $this->message_type = $message_type;
    $this->message = $message;
  }

  public function logMessage()
  {
    if($this->log_type == 'filesystem') {
      $this->logToDatabase();
    } else if($this->log_type == 'database') {
      $this->logToFilesystem();
    } else {
      echo 'Message logged from ' . $this->app_name . ': ' $this->message;
    }
  }

  private function logToDatabase()
  {
    // log to db
    /*
      log = Message(self.app_name, self.message)
      db.session.add(log)
      db.session.commit()
    */
  }

  public function logToFilesystem()
  {
/*
    filename = app.config['LOG_FILENAME']
        logging.basicConfig(filename=filename, level=logging.INFO)
        logging.info('Message logged from %s: %s', self.app_name, self.message)

 */
  }
?>
