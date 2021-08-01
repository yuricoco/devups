<?php


namespace dclass\devups\Controller;


class ControllerCore extends Controller
{
    use CrudTrait;

//    public function __construct()
//    {
//        parent::__construct();
//    }

    public static function init($entityname)
    {

        self::$entityname = $entityname;
        self::$classname = ucfirst(self::$entityname);
        self::$tablename = self::$classname . "Table";
        self::$formname = self::$classname . "Form";
        self::$ctrlname = self::$classname . "Ctrl";

        return new ControllerCore();

    }

}