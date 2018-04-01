<?php

session_start();

/**
 * NOTIFIACTION DEFINE
 */
define('LANG', "lang");
define('JSON_ENCODE_DEPTH', 512);

require __DIR__ . '/config/dependanceInjection.php';

require 'src/devupstuto/ModuleStock/devupstuto.modulestock.php';
require 'src/devupstuto/ModuleProduct/devupstuto.moduleproduct.php';
