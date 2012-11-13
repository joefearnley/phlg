<?php

require 'vendor/autoload.php';

$app = new \Slim\Slim(
  array(
    'debug' => false,
    'templates.path' => 'templates'
  )
);

$app->get('/', function() use ($app) {
  $app->render('view_messages.html');
});

/*
 * TODO:
 *  - Config
 *    - app name
 *    - db stuff
 */
$app->post('/logmessage/:type', function($type) use ($app) {

  $response = array(
    'status' => 'ok',
    'message_id' => 0
  );

  $message = $app->request()->post('message');

  $parms = array(
    'app_name' => 'highphasion',
    'message' => $message,
    'message_type' => $type
  );

  $pdo = new PDO('mysql:host=127.0.0.1;dbname=highfashion', 'highfashion', 'password');
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

$app->get('/messages/:type', function($type) use ($app) {
  $response = array(
    'status' => 'ok',
  );

  $parms = array(
    'app_name' => 'highphasion',
    'message_type' => $type
  );

  $pdo = new PDO('mysql:host=127.0.0.1;dbname=highfashion', 'highfashion', 'password');
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
