<?php

/*
 * TODO:
 *  - Config
 *    - app name
 *    - Database credentials
 *  - make db stuff more 'ORMy'
 */

require 'vendor/autoload.php';
require 'config/config.php';

$app = new \Slim\Slim(
  array(
    'debug' => false,
    'templates.path' => 'templates'
  )
);

$cfg = $config['test'];

RedBean_Facade::setup(
    $cfg['connection'],
    $cfg['db_user'],
    $cfg['db_pass']
  );

$app->get('/', function() use ($app) {
  $app->render('view_messages.html');
});

$app->post('/message/:type', function($type) use ($app, $cfg) {

  $response = array(
    'status' => 'ok',
    'message_id' => 0
  );

  $message = $app->request()->post('message');

  $parms = array(
    ':app_name' => $cfg['app_name'],
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


$app->get('/message', function() use ($app, $cfg) {

  $response = array(
    'status' => 'ok',
  );

  $parms = array(
    ':app_name' => $cfg['app_name']
  );

  $response['messages'] = RedBean_Facade::getAll(
      'select * from message where app_name = :app_name', 
      $parms
    );

  $app->response()->header('Content-Type', 'application/json');
  $app->response()->write(json_encode($response));
});

$app->get('/message/:type', function($type) use ($app, $cfg) {

  $response = array(
    'status' => 'ok',
  );

  $parms = array(
    ':app_name' => $cfg['app_name'],
    ':type' => $type
  );

  $response['messages'] = RedBean_Facade::getAll(
      'select * from message
       where app_name = :app_name
       and type = :type',
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
