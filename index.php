<?php

require 'vendor/autoload.php';

$app = new \Slim\Slim(
  array(
    'debug' => false,
    'templates.path' => 'templates'
  )
);

$app->post('/test', function() use ($app) {
  echo 'asdfasdf';
});

$app->get('/', function() use ($app) {
  $app->render('view_messages.html');
});

/*
 * TODO:
 *  - Config
 *    - app name
 *    - db stuff
 */
$app->post('/message/:type', function($type) use ($app) {

  $response = array(
    'status' => 'ok',
    'message_id' => 0
  );

  $message = $app->request()->post('message');

  // TODO: got log type from config here
  // $log_type = 'database';
  // $message_handler = new MessageHandler($log_type, 'lowphasion', $type, $message);
  // $response['message_id'] = $message_handler->getMessageId();

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
  $response['message_id'] = $pdo->lastInsertId();
  $pdo = null;

  $app->response()->header('Content-Type', 'application/json');
  $app->response()->write(json_encode($response));
});


$app->get('/message/', function() use ($app) {

  $response = array(
    'status' => 'ok',
  );

  $parms = array(
    'app_name' => 'lowphashion'
  );

  $pdo = new PDO('mysql:host=127.0.0.1;dbname=lowphashion', 'lowphashion', 'password');
  $sql = 'SELECT app_name, message, posted
          FROM message
          WHERE app_name = :app_name';

  $stmt = $pdo->prepare($sql);
  $pdo = null;
  $stmt->execute($parms);
  $response['messages'] = $stmt->fetchAll(PDO::FETCH_CLASS);

  $app->response()->header('Content-Type', 'application/json');
  $app->response()->write(json_encode($response));
});


$app->get('/message/:type', function($type) use ($app) {

  $response = array(
    'status' => 'ok',
  );

  $parms = array(
    'app_name' => 'lowphashion',
    'message_type' => $type
  );

  $pdo = new PDO('mysql:host=127.0.0.1;dbname=lowphashion', 'lowphashion', 'password');
  $sql = 'SELECT app_name, message, posted
          FROM message
          WHERE app_name = :app_name
          AND message_type = :message_type';

  $stmt = $pdo->prepare($sql);
  $pdo = null;
  $stmt->execute($parms);
  $response['messages'] = $stmt->fetchAll(PDO::FETCH_CLASS);

  $app->response()->header('Content-Type', 'application/json');
  $app->response()->write(json_encode($response));
});

$app->error(function(\Exception $e) use ($app) {
  $response = array(
    'status' => 'fail',
    'error' => $e->getMessage()
  );
  $app->response()->header('Content-Type', 'application/json');
  $app->response()->write(json_encode($response));
});

$app->run();
