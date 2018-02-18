<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FormFactory
 *
 * @author azankang
 */
class FormFactory {
    //put your code here
    protected static $fieldname;
    protected static $fieldid;
    protected static $class;
    
    public static function __radio($entitycore, $field, $directive = "") {
        
        $radio = '';
        
//        if($require == ''){
//            $radio .= '<div class="dv-radio" ><input name="'.FormFactory::$fieldname.'" type="radio" value="" /><span>-- Default --</span></div>';
//        }else{
//            $radio .= '';
//        }
        
        foreach ($field['options'] as $key => $value) {
            if(''.$field['value'] == ''.$key)
                $radio .= '<label  '.$directive.' ><input class="" name="'.FormFactory::$fieldname.'" type="radio" value="'.$key.'" checked />'.$value.'</label>';
            else
                $radio .= '<label '.$directive.' ><input class="" name="'.FormFactory::$fieldname.'" type="radio" value="'.$key.'" />'.$value.'</label>';
        }
        
        return $radio;
    }
    
    public static function __checkboxinput($field, $directive = "", $callback = null) {
        
            $checkbox['checkecd'] = [];
            $checkbox['uncheckecd'] = [];
            
//        die(var_dump($field['values']));
            if($field['values']){
                foreach ($field['values'] as $key => $value) {
                    $input = '<input class="" name="'.FormFactory::$fieldname.'[]" type="checkbox" value="'.$value->getId().'" checked />';
                    
                    $checkbox['checkecd'][] = ["checkbox"=> $input, "entity" => $value];
                }
            }
            
            if($field['options']){
                foreach ($field['options'] as $key => $value) {
                    $input = '<input class="" name="'.FormFactory::$fieldname.'[]" type="checkbox" value="'.$value->getId().'" />';
                    
                    $checkbox['uncheckecd'][] = ["checkbox"=> $input, "entity" => $value];
                }
            }
            
            $callback($checkbox);
        
    }
    
    public static function __checkbox($entitycore, $field, $directive = "") {
        
        $checkbox = '';
        
        if(isset($field['collectionforminjection'])){
            
            $diff = $field['options']['list'];
            $fieldname = FormFactory::$fieldname;
            $fieldid = FormFactory::$fieldid;
            if($field['values']['list']){
        
                foreach ($field['values']['list'] as $key => $value) {
                    $collectionform = $field['collectionforminjection']::__renderForm($field['values']['forcollectionform'][$key]);
                    
                    $checkbox .= '<div class="checkbox dv-checkbox" >'
                            . '<label><input class="" name="'.$fieldname.'[]" type="checkbox" value="'.$key.'" checked />'
                            . '<span>'.$value.'</span>'
                            . '</label>'
                            . '' . $collectionform
                            . '</div>';
                }
            }
            
            $checkbox .= '<hr>';
            if($diff){
                foreach ($diff as $key => $value) {
                    $collectionform = $field['collectionforminjection']::__renderForm($field['options']['forcollectionform'][$key]);
                    $checkbox .= '<div class="checkbox dv-checkbox" >'
                            . '<label><input class="" name="'.$fieldname.'[]" type="checkbox" value="'.$key.'" />'
                            . '<span>'.$value.'</span>'
                            . '</label>'
                            . '' . $collectionform
                            . '</div>';
                }
            };
            
        }
        
        else{
        
            if($field['values']){
                foreach ($field['values'] as $key => $value) {
                    $checkbox .= '<div class="checkbox dv-checkbox" ><label><input class="" name="'.FormFactory::$fieldname.'[]" type="checkbox" value="'.$key.'" checked /><span>'.$value.'</span></label></div>';
                }
            }
            $checkbox .= '<hr>';
            if($field['options']){
                foreach ($field['options'] as $key => $value) {
                    $checkbox .= '<div class="checkbox dv-checkbox" ><label><input class="" name="'.FormFactory::$fieldname.'[]" type="checkbox" value="'.$key.'" /><span>'.$value.'</span></label></div>';
                }
            }
        }
        
        return $checkbox;
        
    }
    
    public static function __textarea($entitycore, $field, $directive = "") {
        
        $textarea = "<textarea ".$directive." name='".FormFactory::$fieldname."' ";
                
        return $textarea . '>'.$field['value'].'</textarea>';
    }
    
    public static function __select($entitycore, $field, $directive = "") {
        
        $select = '<select '.$directive.' name="'.FormFactory::$fieldname.'" >\n';
        
        if(isset($field['placeholder'])){
            $select .= '<option value="" >'.$field['placeholder'].'</option>\n';
        }
        
        foreach ($field['options'] as $key => $value) {
            if(''.$field['value'] == ''.$key)
                $select .= '<option value="'.$key.'" selected >'.$value.'</option>\n';
            else
                $select .= '<option value="'.$key.'" >'.$value.'</option>\n';
        }
        
        return $select . '</select>';
        
    }
    
    public static function __file($entitycore, $field, $require) {
        
        $input = FormFactory::__input($entitycore, $field, $require);
        $file = "";         
        if($field['value']){
            switch ($field[FH_FILETYPE]) {

                                case FILETYPE_DOCUMENT:
            $file = "<a class='dv-doc' href='".  $field['src'] ."'> download the document</a>";
                                    break; 
                                case FILETYPE_VIDEO:
            $file = "<video class='dv-video' src='".  $field['src'] ."'> </video>";
                                    break; 
                                case FILETYPE_AUDIO:
            $file = "<audio class='dv-audio' src='".  $field['src'] ."'> </audio>";
                                    break; 
                                case FILETYPE_IMAGE:
            $file = "<img class='dv-img' width='120' src='".  $field['src'] ."' />";
                                    break; 
            }
        }
        
        return $file . $input;
        
    }
            
    public static function __input($entitycore, $field, $directive = null) {
        
//        if(isset($field['directive']) && !$directive){
//            $directive = $field['directive'];
//        }
        
        $input = "<input ".$directive." type='".$field['type']."' name='".FormFactory::$fieldname."' value='".$field['value']."' ";
                        
        return $input . ' />';
        
    }
    
    public static function serialysedirective($directives) {
        $formdirective = [];
        foreach ($directives as $key => $value) {
           $formdirective[] = $key ."='" . $value ."'";
        }
        return implode(" ", $formdirective);
    }
    
    public static function __renderForm($entitycore){
        
        $form = "";
        $_SESSION["dvups_form"][$entitycore->name] = $entitycore->field;
                
        foreach ($entitycore->field as $key => $field) {
            
                FormFactory::$fieldname = $entitycore->name."_form[".$key.']';
                FormFactory::$fieldid = $entitycore->name."-".$key.'';

                $require = 'required';
                $etoil = '';
                $class = "";
                    
                if (!isset($field['directive'])){
                    $directive['class'] = "form-control";
                }else{
                    
                    $directive = $field['directive'];
                    
                    if (isset($directive['require'])){//&& !$field['require']
                            $require = '';
                            $etoil = '*';
                    }
                    
                    if(!isset($directive['class'])){
                        $directive['class'] = "form-control";
                    }
                    
                }
                $field['directive'] = FormFactory::serialysedirective($directive);
                
                $label = "";
                if(isset($field['label'])){
                    $label = "<label class='dv_label ' >".$field['label']." ".$etoil."</label>\n";
                }

                if(in_array($field['type'], [FORMTYPE_TEXT, FORMTYPE_EMAIL, FORMTYPE_NUMBER, FORMTYPE_PASSWORD])){
                    $formfield = FormFactory::__input($entitycore, $field, $field['directive']);
                }

                elseif($field['type'] == FORMTYPE_TEXTAREA){
                    $formfield = FormFactory::__textarea($entitycore, $field, $field['directive']);
                }

                elseif($field['type'] == FORMTYPE_CHECKBOX){
                    $formfield = FormFactory::__checkbox($entitycore, $field, $field['directive']);	
                }

                elseif($field['type'] == FORMTYPE_RADIO){
                    $formfield = FormFactory::__radio($entitycore, $field, $field['directive']);	
                }

                elseif($field['type'] == FORMTYPE_SELECT){
                    $formfield = FormFactory::__select($entitycore, $field, $field['directive']);	
                }

                elseif($field['type'] == FORMTYPE_INJECTION){
//                        $form .= $relation->formtype['imbricate'];	
                    $formfield = $field['imbricate'];	
                }

                elseif($field['type'] == FORMTYPE_FILE){
                    $formfield = FormFactory::__file($entitycore, $field, $field['directive']);
                }
                
                $form .= "<div id='".FormFactory::$fieldname."' class='".$class." form-group' >\n" . $label . $formfield . "\n</div>\n";

            }
            
        $formaction = "";
        if($entitycore->formaction){
                $formaction = "<form action='index.php?path=".$entitycore->name."/".$entitycore->formaction."' enctype='multipart/form-data' method='post' >\n";
        }
        
        $formbutton = "";
        if($entitycore->formbutton){
                $formbutton = "<input class='btn btn-default' type='submit' value='save' /><input class='btn btn-default' type='reset' value='reset' >\n</form>";
        }
        
        $form = $formaction . $form . $formbutton;
        
//        $classForm = fopen(__DIR__ . '/../' . $entitycore->name . 'Form.html', 'w');
//
//        fputs($classForm, $form);
//
//        fclose($classForm);
                
        return $form;
    }
        
}
