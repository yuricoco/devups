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
    public static $fields = [];
    public static $savestate = [];

    public static function open($enitty,  $directives = ["action"=> "#", "method"=> "post"], $overideaction = false) {

        if(!isset($directives['method']))
            $directives['method'] = "post";

        Form::$name = strtolower(get_class($enitty));
        $action = $directives["action"];
        $directives["action"] = "index.php?path=".Form::$name."/".trim($action);
        if($overideaction)
            $directives["action"] = trim($action);

        $formdirective = [];
        foreach ($directives as $key => $value) {
            $formdirective[] = $key ."='" . $value ."'";
        }

        return "<form ". implode(" ", $formdirective) ."  >";
    }

    public static function init($enitty) {
        Form::$name = strtolower(get_class($enitty));
    }

    public static function close() {
        
//        $_SESSION[Form::$name ] = Form::$fields;
        //$_SESSION["dvups_form"][Form::$name] = Form::$fields;
        $dvups_form = "<textarea style='display=none;' name='dvups_form[".Form::$name."]' >".serialize(Form::$fields)."</textarea>";
        return $dvups_form."</form>";
    }
    
    public static function imbricate($enitty) {
        Form::$savestate = [Form::$name, Form::$fields];
        //Form::$fields = [];
        Form::$name = strtolower(get_class($enitty));
    }
    
    public static function closeimbricate() {
        //$_SESSION["dvups_form"][Form::$name] = Form::$fields;
        $dvups_form = "<textarea style='display: none' name='dvups_form[".Form::$name."]' >".serialize(Form::$fields)."</textarea>";
        
        Form::$name = Form::$savestate[0];
        //Form::$fields = Form::$savestate[1];

        return $dvups_form;
    }
    
    public static function addjs($js, $path = "Ressource/js"){
        return "<script src='".$path."/".$js.".js' ></script>";
    }

    public static function submit($name = "submit", $directive = []) {
        return "<input ".Form::serialysedirective($directive)." type='submit' value='".$name."' />";
    }
    
    public static function reset($name = "reset", $directive = []) {
        return "<input ".Form::serialysedirective($directive)." type='reset' value='".$name."' >";
       
    }
                
    public static function radio($name, $options, $value, $directive = []) {
        
        FormFactory::$fieldname = Form::$name."_form[".$name.']';
        FormFactory::$fieldid = Form::$name."-".$name.'';
        $field["options"] = $options;
        $field["value"] = $value;
        
        Form::optionsfield($name, $value, $options);
        
        return Form::__radio("", $field, Form::serialysedirective($directive));
        
    }
    
    public static function checkbox($name, $options, $values, $directive = [], $callback = null) {
        
        FormFactory::$fieldname = Form::$name."_form[".$name.']';
        FormFactory::$fieldid = Form::$name."-".$name.'';
        $field["options"] = $options;
        $field["values"] = $values;
        
        Form::collectionfield($name, $values, $options);
        
        if($callback == null){
            return Form::__checkbox("", $field, Form::serialysedirective($directive));            
        }
        return Form::__checkboxinput($field, Form::serialysedirective($directive), $callback);
        
    }
    
    public static function textarea($name, $value, $directive = []) {
        
        FormFactory::$fieldname = Form::$name."_form[".$name.']';
        FormFactory::$fieldid = Form::$name."-".$name.'';
        $field["value"] = $value;
        
        Form::inputfield($name, $value);
        
        return Form::__textarea("", $field, Form::serialysedirective($directive));
        
    }
    
    public static function select($name, $options, $value, $directive = []) {
                
        FormFactory::$fieldname = Form::$name."_form[".$name.']';
        FormFactory::$fieldid = Form::$name."-".$name.'';
        $field["options"] = $options;
        $field["value"] = $value;
        
        if(isset($directive['placeholder'])){
            $field["placeholder"] = $directive['placeholder'];
        }
        
        Form::optionsfield($name, $value, $options);
        
        return Form::__select("", $field, Form::serialysedirective($directive));
        
    }
    
    public static function file($name, $value, $src, $directive = [], $filetype = "image") {
        
        FormFactory::$fieldname = Form::$name."_form[".$name.']';
        FormFactory::$fieldid = Form::$name."-".$name.'';
        $field["value"] = $value;
        $field["src"] = $src;
        $field["type"] = FORMTYPE_FILE;
        $field["filetype"] = $filetype;
        
        Form::inputfield($name, $value);
        
        return Form::__file("", $field, Form::serialysedirective($directive));
        
    }
    
    public static function input($name, $value, $directive = [], $type = FORMTYPE_TEXT) {
                 
        FormFactory::$fieldname = Form::$name."_form[".$name.']';
        FormFactory::$fieldid = Form::$name."-".$name.'';
        $field["value"] = $value;
        $field["type"] = $type;
        
        Form::inputfield($name, $value);
        
        return Form::__input("", $field, Form::serialysedirective($directive));
        
    }
    
    public static function email($name, $value, $directive = []) {
                 
        FormFactory::$fieldname = Form::$name."_form[".$name.']';
        FormFactory::$fieldid = Form::$name."-".$name.'';
        $field["value"] = $value;
        $field["type"] = FORMTYPE_EMAIL;
        
        Form::inputfield($name, $value);
        
        return Form::__input("", $field, Form::serialysedirective($directive));
        
    }
    
    public static function password($name, $value, $directive = []) {
                 
        FormFactory::$fieldname = Form::$name."_form[".$name.']';
        FormFactory::$fieldid = Form::$name."-".$name.'';
        $field["value"] = $value;
        $field["type"] = FORMTYPE_PASSWORD;
        
        Form::inputfield($name, $value);
        
        return Form::__input("", $field, Form::serialysedirective($directive));
        
    }
    
    private static function inputfield($name, $value) {
        
        Form::$fields[$name] = [
            "value" => $value
        ];
        
    }
    
    private static function optionsfield($name, $value, $options) {
        
        Form::$fields[$name] = [
            "value" => $value,
            "options" => $options
        ];
    }
    
    private static function collectionfield($name, $values, $options) {
        
        Form::$fields[$name] = [
            "values" => $values,
            "options" => $options
        ];
    }
    
}
