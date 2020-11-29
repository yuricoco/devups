<?php


namespace dclass\devups\Controller;


abstract class ModuleController
{
    public $moduledata;

    public abstract function web();
    public abstract function services();
    public abstract function webservices();
}