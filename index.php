<?php

/*
 * TODO:
 *  - Config
 *    - app name
 *    - Database credentials
 *  - make db stuff more 'ORMy'
 */

require 'vendor/autoload.php';

RedBean_Facade::setup(
    'mysql:host=127.0.0.1;dbname=lowphashion',
    'lowphashion','password'
  );

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

$app->post('/message/:type', function($type) use ($app) {

  $response = array(
    'status' => 'ok',
    'message_id' => 0
  );

  $message = $app->request()->post('message');

  $parms = array(
    ':app_name' => 'lowphashion',
    ':message' => $message,
    ':type' => $type
  );

  // this doesn't return an id. 
  $response['message_id'] = RedBean_Facade::getAll(
      'insert into message
            (app_name, message, type)
            values
            (:app_name, :message, :type)', 
      $parms
    );

  $app->response()->header('Content-Type', 'application/json');
  $app->response()->write(json_encode($response));
});


$app->get('/message/', function() use ($app) {

  $response = array(
    'status' => 'ok',
  );

  $parms = array(
    ':app_name' => 'lowphashion'
  );

  $response['messages'] = RedBean_Facade::getAll(
      'select * from message where app_name = :app_name', 
      $parms
    );

  $app->response()->header('Content-Type', 'application/json');
  $app->response()->write(json_encode($response));
});


$app->get('/message/:type', function($type) use ($app) {

  $response = array(
    'status' => 'ok',
  );

  $parms = array(
    ':app_name' => 'lowphashion',
    ':type' => $type
  );

  $response['messages'] = RedBean_Facade::getAll(
      'select * from message where app_name = :app_name and type = :type', 
      $parms
    );

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
