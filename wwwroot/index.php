<?php
include("../vendor/autoload.php");
define('APPROOT', '../App/');

//´íÎóÌáÊ¾
$error_reporting       = E_ALL ^ E_NOTICE;
ini_set('error_reporting', $error_reporting);

//error_reporting(0);
//headers();

$class = App\Model\Form::class;
$res = class_exists($class);
D($res);
//App\Bootstrap::run('../App/');

//server()->Help();

//application('demo')->run('../Document/');

