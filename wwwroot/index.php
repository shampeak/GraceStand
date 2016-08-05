<?php
include("../vendor/autoload.php");
define('APPROOT', '../App/');

//´íÎóÌáÊ¾
$error_reporting       = E_ALL ^ E_NOTICE;
ini_set('error_reporting', $error_reporting);

//error_reporting(0);
//headers();

App\Bootstrap::run('../App/');

//server()->Help();

//application('demo')->run('../Document/');

