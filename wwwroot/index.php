<?php
include("../vendor/autoload.php");

define('APPROOT', '../App/');

//错误提示
$error_reporting       = E_ALL ^ E_NOTICE;
ini_set('error_reporting', $error_reporting);
















use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// create a log channel
$log = new Logger('Stand');
$log->pushHandler(new StreamHandler('../Cache/Log/log', Logger::WARNING));

// add records to the log
$log->warning('Foo');
$log->error('Bar');


exit;










App\Bootstrap::run();

