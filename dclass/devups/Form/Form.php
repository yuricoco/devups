<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Form
 *
 * @author Aurelien Atemkeng
 */
class Form extends FormFactory{
    public static $name;
    public static $classname;
    public static $fields = [];
    public static $savestate = [];

    public static function open($enitty,  $directives = ["action"=> "#", "method"=> "post"], $overideaction = false) {

        if(!isset($directives['method']))
            $directives['method'] = "post";

        Form::$classname = get_class($enitty);
        Form::$name = strtolower(Form::$classname);
        $action = str_replace("\\", "/", trim($directives["action"]));
        //$directives["action"] = "index.php?path=".Form::$name."/".trim($action);
//        if($overideaction){
//            $directives["action"] = trim($action);
//        }else
//            $action = Form::$name . "/" . $action;
        $formdirective = [];
        foreach ($directives as $key => $value) {
            $formdirective[] = $key ."='" . $value ."'";
        }

        $id = Form::$name.'-form';
        if (isset($directives["id"]))
            $id = $directives["id"];

        return "<form action='" . $action . "' id='$id' ". implode(" ", $formdirective) ." data-id=\"".$enitty->getId()."\"  >";

    }

    public static function init($enitty) {
        Form::$name = strtolower(get_class($enitty));
    }

    public static function close() {

//        $_SESSION[Form::$name ] = Form::$fields;
        //$_SESSION["dvups_form"][Form::$name] = Form::$fields;
//        $dvups_form = "<textarea style='display:none;' name='dvups_form[".Form::$name."]' >".json_encode(Form::$fields)."</textarea>";
//        return $dvups_form."</form>";
        return "<div id='dv-form-".Form::$name."-error}'></div></form>";
    }

    public static function imbricate($enitty) {
        Form::$savestate = [Form::$name, Form::$fields];
        //Form::$fields = [];
        Form::$name = strtolower(get_class($enitty));
        return "";
    }

    public static function closeimbricate() {
        //$_SESSION["dvups_form"][Form::$name] = Form::$fields;
        //$dvups_form = "<textarea style='display: none' name='dvups_form[".Form::$name."]' >".json_encode(Form::$fields)."</textarea>";

        Form::$name = Form::$savestate[0];
        //Form::$fields = Form::$savestate[1];

        return "" ; //$dvups_form;
    }

    public static function addDevupsjs(){
        return "<script src='".CLASSJS."model.js' ></script>
<script src='".CLASSJS."dialogbox.js' ></script>
<script src='".CLASSJS."ddatatable.js' ></script>
<script src='".CLASSJS."dform.js' ></script>";
    }
    public static function addJquery(){
        return "<script src='".__admin."plugins/jquery/jquery.min.js' ></script>";
    }
    public static function addDformjs(){
        return "<script src='".CLASSJS."dform.js' ></script>";
    }

    public static function addjs($js){
        return "<script src='".$js.".js?v=".__jsversion."' ></script>";
    }

    public static function addcss($css){
        return "<link href='$css.css?v=".__cssversion."' rel='stylesheet' />";
    }

    public static function submit($name = "submit", $directive = []) {
        return "<input ".Form::serialysedirective($directive)." type='submit' value='".$name."' />";
    }

    public static function submitbtn($name = "submit", $directive = []) {
        return "<button ".Form::serialysedirective($directive)." type='submit' >".$name."</button>";
    }

    public static function reset($name = "reset", $directive = []) {
        return "<input ".Form::serialysedirective($directive)." type='reset' value='".$name."' >";

    }

    public static function radio($name, $options, $value, $directive = [], $setter = "") {

        FormFactory::$fieldname = Form::$name."_form[".$name.']';
        FormFactory::$fieldid = Form::$name."-".$name.'';
        $field["options"] = $options;
        $field["value"] = $value;

        Form::optionsfield($name, $value, $options, $setter);

        return Form::__radio("", $field, Form::serialysedirective($directive));

    }

    public static function checkbox($name, $options, $values, $directive = [], $setter = [], $callback = null) {

        FormFactory::$fieldname = Form::$name."_form[".$name.']';
        FormFactory::$fieldid = Form::$name."-".$name.'';
        $field["options"] = $options;
        $field["values"] = $values;

        Form::collectionfield($name, $values, $options, $setter);

        if($callback == null){
            return Form::__checkbox("", $field, Form::serialysedirective($directive));
        }
        return Form::__checkboxinput($field, Form::serialysedirective($directive), $callback);

    }

    public static function textarea($name, $value, $directive = [], $setter = []) {

        FormFactory::$fieldname = Form::$name."_form[".$name.']';
        FormFactory::$fieldid = Form::$name."-".$name.'';
        $field["value"] = $value;

        Form::inputfield($name, $value, $setter);

        return Form::__textarea("", $field, Form::serialysedirective($directive));

    }

    /**
     * @param $name
     * @param $options
     * @param $value
     * @param $callback
     * @param array $directive
     * @param array $setter
     * @return string
     */
    public static function selectGroup($name, $options, $value, $callback, $directive = [], $setter = []) {

        FormFactory::$fieldname = Form::$name."_form[".$name.']';
        FormFactory::$fieldid = Form::$name."-".$name.'';
        $field["options"] = $options;
        $field["value"] = $value;

        if(isset($directive['placeholder'])){
            $field["placeholder"] = $directive['placeholder'];
        }

        Form::optionsfield($name, $value, $options, $setter);

        return Form::__selectGroup("", $field, $callback, Form::serialysedirective($directive));

    }

    public static function select($name, $options, $value, $directive = [], $setter = [], $callback = null) {

        FormFactory::$fieldname = Form::$name."_form[".$name.']';
        FormFactory::$fieldid = Form::$name."-".$name.'';
        $field["options"] = $options;
        $field["value"] = $value;

        if(isset($directive['placeholder'])){
            $field["placeholder"] = $directive['placeholder'];
        }

        Form::optionsfield($name, $value, $options, $setter);

        return Form::__select("", $field, Form::serialysedirective($directive), $callback);

    }

    public static function autocomplete($name, $options, $value, $directive = [], $setter = [], $callback = null) {

        FormFactory::$fieldname = Form::$name."_form[".$name.']';
        FormFactory::$fieldid = Form::$name."-".$name.'';
        $field["options"] = $options;
        $field["value"] = $value;
        if(isset($directive['placeholder'])){
            $field["placeholder"] = $directive['placeholder'];
        }

        Form::optionsfield($name, $value, $options, $setter);

        return Form::__autocomplete("", $field, Form::serialysedirective($directive), $callback);

    }

    public static function file($name, $value, $directive = [], $filetype = "image", $setter = []) {

        FormFactory::$fieldname = Form::$name."_form[".$name.']';
        FormFactory::$fieldid = Form::$name."-".$name.'';
        $field["value"] = $value;
        //$field["src"] = $src;
        $field["type"] = FORMTYPE_FILE;
        $field["filetype"] = $filetype;

        Form::inputfield($name, $value, $setter);

        return Form::__file("", $field, Form::serialysedirective($directive));

    }

    public static function filepreview($value, $src, $directive = [], $filetype = "image") {

        $field["value"] = $value;
        $field["src"] = $src;
        $field["filetype"] = $filetype;

        return Form::__filepreview($field, Form::serialysedirective($directive));

    }

    public static function inputarray($name, $key, $value, $directive = [], $setter = "") {

        FormFactory::$fieldname = Form::$name."_form[".$name.']['.$key.']';
        FormFactory::$fieldid = Form::$name."-".$name.'';
        $field["value"] = $value;
        $field["type"] = FORMTYPE_TEXT;

        Form::inputfield($name, $value, $setter);

        return Form::__input("", $field, Form::serialysedirective($directive));

    }

    private static function fieldnamesanitize($name){
        $key = "";
        $namearray = explode("[", $name);
        if(count($namearray) > 1){
            $name = $namearray[0];
            if(strlen($namearray[1]) > 1)
                $key = str_replace("]", "", $namearray[1]);

            return Form::$name."_form[".$name.']['.$key.']';
        }
        return Form::$name."_form[".$name.']';
    }

    public static function input($name, $value, $directive = [], $type = FORMTYPE_TEXT, $setter = []) {

        FormFactory::$fieldname = Form::fieldnamesanitize($name);
        FormFactory::$fieldid = Form::$name."-".$name.'';
        $field["value"] = $value;
        $field["type"] = $type;

        if($type == FORMTYPE_RADIO){
            Form::inputfield($name, $value[0], $setter);

            $field["value"] = $value[0];
            $field["option"] = $value[1];
            return Form::__inputradio("", $field, Form::serialysedirective($directive));
        }
        if($type == FORMTYPE_CHECKBOX){
            Form::inputfield($name, $value[0], $setter);

            if(isset($field["values"]))
                $field["values"] += $value[1];
            else
                $field["values"] = $value[1];

            $field["option"] = $value[0];

            Form::collectionfield($name, $field["values"], [], $setter);

            return Form::__checkboxinput($field, Form::serialysedirective($directive));
        }

        Form::inputfield($name, $value, $setter);

        return Form::__input("", $field, Form::serialysedirective($directive));

    }

    /**
     * @return mixed
     */
    public static function number($name, $value, $directive = [], $setter = [])
    {
        return self::input($name, $value, $directive, FORMTYPE_NUMBER, $setter);
    }

    public static function email($name, $value, $directive = [], $setter = []) {

        FormFactory::$fieldname = Form::$name."_form[".$name.']';
        FormFactory::$fieldid = Form::$name."-".$name.'';
        $field["value"] = $value;
        $field["type"] = FORMTYPE_EMAIL;

        Form::inputfield($name, $value, $setter);

        return Form::__input("", $field, Form::serialysedirective($directive));

    }

    public static function password($name, $value, $directive = [], $setter = []) {

        FormFactory::$fieldname = Form::$name."_form[".$name.']';
        FormFactory::$fieldid = Form::$name."-".$name.'';
        $field["value"] = $value;
        $field["type"] = FORMTYPE_PASSWORD;

        Form::inputfield($name, $value, $setter);

        return Form::__input("", $field, Form::serialysedirective($directive));

    }

    private static function inputfield($name, $value, $setter) {

        if(!isset($setter["setter"]))
            $setter["setter"] = $name;

        Form::$fields[$name] = $setter;

    }

    private static function optionsfield($name, $value, $options, $setter) {

        if(!$setter)
            $setter = $name;

        Form::$fields[$name] = [
            "value" => $value,
            "options" => $options,
            "setter" => $setter
        ];
    }

    private static function collectionfield($name, $values, $options, $setter) {

        if(!$setter)
            $setter = $name;

        Form::$fields[$name] = [
            "values" => $values,
            "options" => $options,
            "setter" => $setter
        ];
    }

}
