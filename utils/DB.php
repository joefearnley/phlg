<?php

class DB
{
  private $user;
  private $password;
  private $host;
  private $name;

  private $pdo;

  public function __construct()
  {
    $this->pdo = new PDO('mysql:host='.$this->host.';dbname='.$this->name, $this->user, $this->pass);
  }

  public static function insertMessage()
  {
    $id = 0;

    try {
      $sql = 'INSERT INTO message
              (app_name, message, message_type)
              VALUES
              (:app_name, :message, :message_type)';

      $stmt = $this->pdo->prepare($sql);
      $stmt->execute($parms);
      $id = $this->pdo->lastInsertId();
    } catch(PDOException $e) {
      $response['status'] = 'fail';
      $response['error'] = $e->getMessage();
      echo json_encode($response);
    }

    return $id;
  }

  public static function getAllMessages()
  {
    try {
      $sql = 'SELECT app_name, message, posted
              FROM message
              WHERE app_name = :app_name
              AND message_type = :message_type';

      $stmt = $this->pdo->prepare($sql);
      $this->pdo = null;
      $stmt->execute($parms);
      $messages = $stmt->fetchAll(PDO::FETCH_CLASS);
    } catch(PDOException $e) {
      $response['status'] = 'fail';
      $response['error'] = $e->getMessage();
      echo json_encode($response);
    }
  }
}
