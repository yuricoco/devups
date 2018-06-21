<?php
/**
 * Created by PhpStorm.
 * User: Aurelien Atemkeng
 * Date: 6/14/2018
 * Time: 7:39 AM
 */
$reflector = new ReflectionClass("Product");
$fn = $reflector->getFileName();
$path = dirname($fn);

var_dump($path);