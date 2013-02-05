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

  $body = $app->request()->post('body');
  $app_name = $app->request()->post('app_name'); 
  $app_name = (isset($app_name) == true) ? $app_name : $cfg['app_name'];

  $message = RedBean_Facade::dispense('message');
  $message->app_name = $app_name;
  $message->body = $body;
  $message->type = $type;
  $message->posted = RedBean_Facade::$f->now();
  RedBean_Facade::store($message);

  writeOkResponse($app, $message->id);
});

/**
 * Get all messages from the database.
 */
$app->get('/message/all', function() use ($app, $cfg) {

  $messages = array();
  $beans = RedBean_Facade::findAll('message');

  foreach($beans as $bean) {
    array_push($messages, $bean->getProperties());
  }
  writeOkResponse($app, 0, $messages);
});

/**
 * Find a message with the given id.
 */
$app->get('/message/:id', function($id) use ($app, $cfg) {
  $bean = RedBean_Facade::load('message', $id);
  $messages = array($bean->getProperties());
  writeOkResponse($app, 0, $messages);
});

/**
 * Find all of the messages of a certain type.
 */
$app->get('/message/type/:type', function($type) use ($app, $cfg) {

  $messages = array();
  $beans = RedBean_Facade::findAll(
      'message', 
      'where type = :type', 
      array( ':type' => $type)
    );

  foreach($beans as $bean) {
    array_push($messages, $bean->getProperties());
  }
  writeOkResponse($app, 0, $messages);
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

function writeOkResponse($app, $messageId = 0, $messages = array()) {
  $response['status'] = 'ok';

  if($messageId > 0) {
    $response['message_id'] = $messageId;
  }

  if(count($messages) > 0) {
    $response['messages'] = $messages;
  }

  $app->response()->header('Content-Type', 'application/json');
  $app->response()->write(json_encode($response));
}
