<?php

require 'vendor/autoload.php';
require 'config/config.php';

use RedBean_Facade as R;

$cfg = $config['prod'];
R::setup($cfg['connection'], $cfg['db_user'], $cfg['db_pass']);

$app = new \Slim\Slim(
  array(
    'debug' => false,
    'templates.path' => 'templates'
  )
);

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

  $message = R::dispense('message');
  $message->app_name = $app_name;
  $message->body = $body;
  $message->type = $type;
  $message->posted = R::$f->now();
  R::store($message);

  writeSuccessfulResposne($app, $message->id);
});

/**
 * Get all messages from the database.
 */
$app->get('/message/all', function() use ($app, $cfg) {

  $messages = array();
  $beans = R::findAll('message');

  foreach($beans as $bean) {
    array_push($messages, $bean->getProperties());
  }
  writeSuccessfulResposne($app, 0, $messages);
});

/**
 * Find a message with the given id.
 */
$app->get('/message/:id', function($id) use ($app, $cfg) {
  $bean = R::load('message', $id);
  $messages = array($bean->getProperties());
  writeSuccessfulResposne($app, 0, $messages);
});

/**
 * Find all of the messages of a certain type.
 */
$app->get('/message/type/:type', function($type) use ($app, $cfg) {

  $messages = array();
  $beans = R::findAll(
      'message', 
      'where type = :type', 
      array( ':type' => $type)
    );

  foreach($beans as $bean) {
    array_push($messages, $bean->getProperties());
  }
  writeSuccessfulResposne($app, 0, $messages);
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

$app->get('/exceptiontest', function() use ($app) {
  throw new Exception('An exception has been thrown.');
});

$app->run();

function writeSuccessfulResposne($app, $messageId = 0, $messages = array()) {
  $response['status'] = 'ok';

  if($messageId > 0) {
    $response['message_id'] = $messageId;
  } else {
    $response['messages'] = $messages;
  }

  $app->response()->header('Content-Type', 'application/json');
  $app->response()->write(json_encode($response));
}
