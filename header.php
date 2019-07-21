<?php

session_start();

define('__cssversion', '1');
define('__jsversion', '1');

require __DIR__ . '/config/dependanceInjection.php';
require __DIR__ . '/lang.php';
require 'src/requires.php';


global $viewdir;
$viewdir = [web_dir . "views"];
