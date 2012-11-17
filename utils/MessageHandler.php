<?php

class MessageHandler
{
  private $log_type;
  private $app_name;
  private $message_type;
  private $message;
  private $message_id;

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
    $parms = array(
      'app_name' => 'lowphashion',
      'message' => $message,
      'message_type' => $type
    );

    $pdo = new PDO('mysql:host=127.0.0.1;dbname=lowphashion', 'lowphashion', 'password');
    $sql = 'INSERT INTO message
            (app_name, message, message_type)
            VALUES
            (:app_name, :message, :message_type)';

    $stmt = $pdo->prepare($sql);
    $stmt->execute($parms);
    $this->message_id = $pdo->lastInsertId();
    $pdo = null;
  }

  public function logToFilesystem()
  {
  /*
   * get filename from config
   *  use Slim object to log
   *
    filename = app.config['LOG_FILENAME']
        logging.basicConfig(filename=filename, level=logging.INFO)
        logging.info('Message logged from %s: %s', self.app_name, self.message)
   */
  }

  public function getMessageId()
  {
    $this->message_id;
  }
?>
