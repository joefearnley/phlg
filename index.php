<?php

require 'vendor/autoload.php';
require 'config/config.php';

$app = new \Slim\Slim(
  array(
    'debug' => false,
    'templates.path' => 'templates'
  )
);

$cfg = $config['test'];

RedBean_Facade::setup($cfg['connection'], $cfg['db_user'], $cfg['db_pass']);

/**
 * Return an html view of the messages.
 */
$app->get('/', function() use ($app) {
  $app->render('view_messages.html');
});

/**
 * Create a new message of the given type.
 */
$app->post('/message/:type', function($type) use ($app, $cfg) {

  $response = array(
    'status' => 'ok',
    'message_id' => 0
  );

  $body = $app->request()->post('body');
  $app_name = $app->request()->post('app_name'); 
  $app_name = (isset($app_name) == true) ? $app_name : $cfg['app_name'];

  $message = RedBean_Facade::dispense('message');
  $message->app_name = $app_name;
  $message->body = $body;
  $message->type = $type;
  $message->posted = RedBean_Facade::$f->now();
  RedBean_Facade::store($message);

  $app->response()->header('Content-Type', 'application/json');
  $app->response()->write(json_encode($response));
});

/**
 * Get all messages from the database.
 */
$app->get('/message/all', function() use ($app, $cfg) {
  $response = array(
    'status' => 'ok',
  );

  $beans = RedBean_Facade::findAll('message');
  $messages = array();

  foreach($beans as $bean) {
    array_push($messages, $bean->getProperties());
  }

  $response['messages'] = $messages;

  $app->response()->header('Content-Type', 'application/json');
  $app->response()->write(json_encode($response));
});

/**
 * Find a message with the given id.
 */
$app->get('/message/:id', function($id) use ($app, $cfg) {

  $response = array(
    'status' => 'ok'
  );

  $bean = RedBean_Facade::load('message', $id);
  $response['message'] = $bean->getProperties();

  $app->response()->header('Content-Type', 'application/json');
  $app->response()->write(json_encode($response));
});

/**
 * Find all of the messages of a certain type.
 */
$app->get('/message/type/:type', function($type) use ($app, $cfg) {

  $response = array(
    'status' => 'ok',
  );

  $parms = array(
    ':type' => $type
  );

  $beans = RedBean_Facade::findAll('message', 'where type = :type', $parms);
  $messages = array();

  foreach($beans as $bean) {
    array_push($messages, $bean->getProperties());
  }

  $response['messages'] = $messages;

  $app->response()->header('Content-Type', 'application/json');
  $app->response()->write(json_encode($response));
});

/**
 * Handle if an exception is thrown.
 */
$app->error(function(\Exception $e) use ($app) {

  $response = array(
    'status' => 'fail',
    'error' => $e->getMessage()
  );

  $app->response()->header('Content-Type', 'application/json');
  $app->response()->write(json_encode($response));
});

$app->run();
