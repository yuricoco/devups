<?php

session_start();

define('__debug', false);
define('__cssversion', '1');
define('__jsversion', '1');

require __DIR__ . '/config/dependanceInjection.php';
require __DIR__ . '/lang.php';
require 'src/requires.php';
require 'App.php';
//require 'tests/ProductTest.php';

define('assets', __env. 'web/assets/');
define('webapp', __env. 'web/app/');


global $viewdir;
$viewdir = [web_dir . "views"];
