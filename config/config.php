<?php

$config = array(
  'prod' => array(
    'host' => 'http://localhost',
    'uri' => 'lowphashion',
    'app_name' => 'lowphashion',
    'db_host' => '127.0.0.1',
    'db_name' => 'lowphashion',
    'db_user' => 'lowphashion',
    'db_pass' => 'password',
    'connection' => 'mysql:host=127.0.0.1;dbname=lowphashion'
  ),
  'test' => array(
    'host' => 'http://localhost',
    'uri' => 'lowphashion',
    'app_name' => 'lowphashion_test',
    'db_host' => '127.0.0.1',
    'db_name' => 'lowphashion_test',
    'db_user' => 'lowphashion',
    'db_pass' => 'password',
    'connection' => 'mysql:host=127.0.0.1;dbname=lowphashion_test'
  )
);
