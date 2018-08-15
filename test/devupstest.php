<?php
/**
 * Created by PhpStorm.
 * User: Aurelien Atemkeng
 * Date: 6/14/2018
 * Time: 7:39 AM
 */
require '../header.php';

global $em;
$classmetadata = (array) $em->getClassMetadata("\\testentity");

dv_dump(Product::classpath());
$classdevupsmetadata = [];

$classdevupsmetadata["name"] = $classmetadata["name"];
foreach ($classmetadata["fieldMappings"] as $field){
    $dvfield = [
        "name" => $field["fieldName"],
        "visibility" => $field["fieldName"],
        "datatype" => $field["type"],
        "size" => $field["fieldName"],
        "nullable" => $field["fieldName"],
        "formtype" => $field["fieldName"],
    ];
    $classdevupsmetadata["attribut"][] = $dvfield;
}

foreach ($classmetadata["associationMappings"] as $field){
    $dvfield = [
        "entity" => $field["fieldName"],
        "cardinality" => "manyToOne",
        "nullable" => "true",
        "ondelete" => "cascade",
        "onupdate" => "cascade"
    ];
    $classdevupsmetadata["relation"][] = $dvfield;
}

//dd();
dv_dump($classmetadata);