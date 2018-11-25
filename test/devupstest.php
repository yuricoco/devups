<?php
/**
 * Created by PhpStorm.
 * User: Aurelien Atemkeng
 * Date: 6/14/2018
 * Time: 7:39 AM
 */
//require '../header.php';

$package = "
    require 'Entity/name.php';
    //require 'Dao/nameDAO.php';
    require 'Form/nameForm.php';
    require 'Controller/nameController.php';
    //require 'Genesis/nameGenesis.php';\n";

$filename = __DIR__."/services.php";

$filecontent = "";
$handle = fopen($filename, "r");
if ($handle) {
    while (($line = fgets($handle)) !== false) {
        // process the line read.
        $filecontent .= $line;
    }

    fclose($handle);
} else {
    // error opening the file.
}