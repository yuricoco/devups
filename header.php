<?php

session_start();

require __DIR__ . '/config/dependanceInjection.php';
require __DIR__ . '/lang.php';
require 'src/requires.php';


global $viewdir;
$viewdir = [web_dir . "views"];
