<?php
$result = "";
$string = '12a49803-713c-4204-a8e6-248e554a352d_ Content-Type: text/plain; charset="iso-8859-6" Content-Transfer-Encoding: base64 DQrn0Ocg0dPH5MkgyszR6sjqySDl5iDH5OfoyuXq5A0KDQrH5OTaySDH5NnRyOrJIOXP2ejlySAx MDAlDQogCQkgCSAgIAkJICA= --_12a49803-713c-4204-a8e6-248e554a352d_ Content-Type: text/html; charset="iso-8859-6" Content-Transfer-Encoding: base64 PGh0bWw+DQo8aGVhZD4NCjxzdHlsZT48IS0tDQouaG1tZXNzYWdlIFANCnsNCm1hcmdpbjowcHg7';
if (preg_match_all("/product_/", "Jaime/product_/deaguitare"))
//if (preg_match_all('/charset="([^"]+)"/',$string,$result))
//if (preg_match_all("#/:([^\"]+)#", "Jaime/:jouer/deaguitare/:sdfsdfs", $result))
{
    var_dump('VRAI ', $result);
}else
{
    echo 'FAUX ';
}

//function param (... $param){
//    var_dump($param, $argv);
//}
//
//param("var1", "var2");
//var_dump();