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
class FormFactory
{

    //put your code here
    protected static $fieldname;
    protected static $fieldid;
    protected static $class;

    public static function __inputradio($entitycore, $field, $directive = "")
    {

        $radio = '';
        $key = $field['option'];
        //foreach ($field['options'] as $key => $value) {
        if ('' . $field['value'] == '' . $key)
            $radio .= '<input class="" name="' . FormFactory::$fieldname . '" type="radio" value="' . $key . '" checked />';
        else
            $radio .= '<input class="" name="' . FormFactory::$fieldname . '" type="radio" value="' . $key . '" />';
        //}

        return $radio;
    }

    public static function __radio($entitycore, $field, $directive = "")
    {

        $radio = '';

        foreach ($field['options'] as $key => $value) {
            if ('' . $field['value'] == '' . $key)
                $radio .= '<label  ' . $directive . ' ><input class="" name="' . FormFactory::$fieldname . '" type="radio" value="' . $key . '" checked />' . $value . '</label>';
            else
                $radio .= '<label ' . $directive . ' ><input class="" name="' . FormFactory::$fieldname . '" type="radio" value="' . $key . '" />' . $value . '</label>';
        }

        return $radio;
    }

    public static function __checkboxinput($field, $directive = "", $callback = null)
    {

//        $checkbox['checkecd'] = [];
//        $checkbox['uncheckecd'] = [];

//        if ($field['values']) {
//            foreach ($field['values'] as $key => $value) {
//                $input = '<input class="" name="' . FormFactory::$fieldname . '[]" type="checkbox" value="' . $value->getId() . '" checked />';
//
//                $checkbox['checkecd'][] = ["checkbox" => $input, "entity" => $value];
//            }
//        }

        if ($field['option']) {
            //foreach ($field['options'] as $key => $value) {

            $ckecked = (in_array($field['option'], $field['values'])) ? "checked" : "";
            return '<input class="" name="' . FormFactory::$fieldname . '[]" type="checkbox" value="' . $field['option'] . '"  ' . $ckecked . ' />';

//                $checkbox['uncheckecd'][] = ["checkbox" => $input, "entity" => $value];
            //}
        }

//        call_user_func($callback, $checkbox);
    }

    public static function __checkbox($entitycore, $field, $directive = "")
    {

        $checkbox = '';

        if (isset($field['collectionforminjection'])) {

            $diff = $field['options']['list'];
            $fieldname = FormFactory::$fieldname;
            $fieldid = FormFactory::$fieldid;
            if (isset($field['values']['forcollectionform'])) {
//                die(var_dump($field['options']["forcollectionform"]));
                foreach ($field['values']['forcollectionform'] as $key => $value) {
//                    $collectionform = $field['collectionforminjection']::__renderForm($field['values']['forcollectionform'][$key]);
//                    $bc = new Blockcontentmodel();
//                    $bc->contentmodel = $value;
                    $collectionform = BlockcontentmodelForm::__renderForm($value);
                    $checkbox .= '<div class="checkbox dv-checkbox" >'
                        . '<label><input class="" name="' . $fieldname . '[]" type="checkbox" value="' . $key . '" checked />'
                        . '<span>' . $value->contentmodel->getLabel() . '</span>'
                        . '</label>'
                        . '' . $collectionform
                        . '</div>';
                }
            }
            $checkbox .= '<hr>';
            if ($field['options']['forcollectionform']) {
//                die(var_dump($field['options']["forcollectionform"]));
                foreach ($field['options']['forcollectionform'] as $key => $value) {
//                    $collectionform = $field['collectionforminjection']::__renderForm($field['values']['forcollectionform'][$key]);
                    $bc = new Blockcontentmodel();
                    $bc->contentmodel = $value;
                    $collectionform = BlockcontentmodelForm::__renderForm($bc);
                    $checkbox .= '<div class="checkbox dv-checkbox" >'
                        . '<label><input class="" name="' . $fieldname . '[]" type="checkbox" value="' . $key . '" />'
                        . '<span>' . $value->getLabel() . '</span>'
                        . '</label>'
                        . '' . $collectionform
                        . '</div>';
                }
            }

//            $checkbox .= '<hr>';
//            if ($diff) {
//                foreach ($diff as $key => $value) {
//                    $collectionform = $field['collectionforminjection']::__renderForm($field['options']['forcollectionform'][$key]);
//                    $checkbox .= '<div class="checkbox dv-checkbox" >'
//                            . '<label><input class="" name="' . $fieldname . '[]" type="checkbox" value="' . $key . '" />'
//                            . '<span>' . $value . '</span>'
//                            . '</label>'
//                            . '' . $collectionform
//                            . '</div>';
//                }
//            };
        } elseif (isset($field['checker'])) {
            if (is_callable($field['checker'])) {
                foreach ($field['options'] as $id => $value) {
                    $ckecked = $field['checker']($id) ? "checked" : "";
                    $checkbox .= '<div class="checkbox dv-checkbox" ><label><input class="" name="' . FormFactory::$fieldname . '[]" type="checkbox" value="' . $id . '" ' . $ckecked . ' /><span>' . $value . '</span></label></div>';
                }
            } elseif (is_array($field['checker'])) {
                foreach ($field['options'] as $id => $value) {
                    $ckecked = (in_array($id, $field['checker'])) ? "checked" : "";
                    $checkbox .= '<div class="checkbox dv-checkbox" ><label><input class="" name="' . FormFactory::$fieldname . '[]" type="checkbox" value="' . $id . '" ' . $ckecked . ' /><span>' . $value . '</span></label></div>';
                }
            }
        } else {

//            if ($field['values']) {
//                foreach ($field['values'] as $key => $value) {
//                    $checkbox .= '<div class="checkbox dv-checkbox" ><label><input class="" name="' . FormFactory::$fieldname . '[]" type="checkbox" value="' . $key . '" checked /><span>' . $value . '</span></label></div>';
//                }
//            }
//            $checkbox .= '<hr>';
            if ($field['options']) {
                foreach ($field['options'] as $id => $value) {
                    $ckecked = (in_array($id, $field['values'])) ? "checked" : "";
                    $checkbox .= '<div class="checkbox dv-checkbox" ><label><input class="" name="' . FormFactory::$fieldname . '[]" type="checkbox" value="' . $id . '" ' . $ckecked . ' /><span>' . $value . '</span></label></div>';
                }
            }
        }

        return $checkbox;
    }

    public static function __textarea($entitycore, $field, $directive = "")
    {

        $textarea = "<textarea " . $directive . " name='" . FormFactory::$fieldname . "' ";

        return $textarea . '>' . $field['value'] . '</textarea>';
    }

    public static function __select($entitycore, $field, $directive = "")
    {

        $select = '<select ' . $directive . ' name="' . FormFactory::$fieldname . '" >\n';

        if (isset($field['placeholder'])) {
            $select .= '<option value="" >' . $field['placeholder'] . '</option>\n';
        }

        foreach ($field['options'] as $key => $value) {
            if ('' . $field['value'] == '' . $key)
                $select .= '<option value="' . $key . '" selected >' . $value . '</option>';
            else
                $select .= '<option value="' . $key . '" >' . $value . '</option>';
        }

        return $select . '</select>';
    }

    public static function __file($entitycore, $field, $require)
    {

        $input = FormFactory::__input($entitycore, $field, $require);
        $file = "";

        if (isset($field['src']))
            $file = self::__filepreview($field);

        return $file . $input;
    }

    public static function __filepreview($field)
    {
        $file = "";
        if ($field['value']) {
            $file = $field['src'];
//            switch ($field[FH_FILETYPE]) {
//
//                case FILETYPE_DOCUMENT:
//                    $file = "<a class='dv-doc' href='" . $field['src'] . "' download='" . $field['value'] . "'> download the document</a>";
//                    break;
//                case FILETYPE_VIDEO:
//                    $file = "<video class='dv-video' src='" . $field['src'] . "'> </video>";
//                    break;
//                case FILETYPE_AUDIO:
//                    $file = "<audio class='dv-audio' src='" . $field['src'] . "'> </audio>";
//                    break;
//                case FILETYPE_IMAGE:
//                    $file = $field['src'];
//                    break;
//            }
        }

        return $file;
    }

    public static function __input($entitycore, $field, $directive = null, $lang = null)
    {
        if(!$lang)
            $input = "<input " . $directive . " type='" . $field['type'] . "' name='" . FormFactory::$fieldname . "' value='" . $field['value'] . "'  />";
        else{
            $value = $entitycore->entity->__gettranslate( FormFactory::$entityattrib, $lang, $field['value']);
            $input = "<input " . $directive . " type='" . $field['type'] . "' name='" . FormFactory::$fieldname . "' value='" . $value . "'  />";
        }
        return $input . '';
    }

    public static function serialysedirective($directives)
    {
        $formdirective = [];
        foreach ($directives as $key => $value) {
            $formdirective[] = $key . "='" . $value . "'";
        }
        return implode(" ", $formdirective);
    }

    public static function getLabel($field, $etoil, $lang = ""){

        $label = "";
        if (isset($field['label'])) {
            $label = "<label class='dv_label ' >" . $field['label'] . " $lang " . $etoil . "</label>";
        }
        return $label;
    }

    private static $entityattrib = "";
    public static function __renderForm($entitycore)
    {

        $form = "";
        $formrow = "";
        //$_SESSION["dvups_form"][$entitycore->name] = $entitycore->field;

        foreach ($entitycore->field as $key => $field) {

            $directive = [];
            $require = 'required';
            $etoil = '';
            $class = "";

            if (!isset($field['directive'])) {
                $directive['class'] = "form-control";
            } else {

                $directive = $field['directive'];

                if (isset($directive['require'])) {//&& !$field['require']
                    $require = '';
                    $etoil = '*';
                }

                if (!isset($directive['class'])) {
                    $directive['class'] = "form-control";
                }
            }
            $field['directive'] = FormFactory::serialysedirective($directive);

            if (!isset($field['setter'])) {
                $entitycore->field[$key]["setter"] = $key;
            }

            FormFactory::$fieldname = $entitycore->name . "_form[" . $key . ']';
            FormFactory::$fieldid = $entitycore->name . "-" . $key . '';
            FormFactory::$entityattrib = $key;

            if (in_array($field['type'], [FORMTYPE_TEXT, FORMTYPE_EMAIL, FORMTYPE_NUMBER, FORMTYPE_PASSWORD])) {

                if (isset($field["lang"]) && $field["lang"]) {
                    $formfield = [" "=>FormFactory::__input($entitycore, $field, $field['directive'])];
                    $langs = Dvups_lang::otherLangs();

                    foreach ($langs as $lang) {
                        FormFactory::$fieldname = $entitycore->name . "_form[" . $key . '_'.$lang->getIso_code().']';
                        //FormFactory::$fieldname = $fieldname.'_'.$lang->getIso_code();
                        $formfield[$lang->getIso_code()] = FormFactory::__input($entitycore, $field, $field['directive'], $lang->getIso_code());
                    }
                }else
                    $formfield = FormFactory::__input($entitycore, $field, $field['directive']);

            } elseif ($field['type'] == FORMTYPE_TEXTAREA) {
                $formfield = FormFactory::__textarea($entitycore, $field, $field['directive']);
            } elseif ($field['type'] == FORMTYPE_CHECKBOX) {
                $formfield = FormFactory::__checkbox($entitycore, $field, $field['directive']);
            } elseif ($field['type'] == FORMTYPE_RADIO) {
                $formfield = FormFactory::__radio($entitycore, $field, $field['directive']);
            } elseif ($field['type'] == FORMTYPE_SELECT) {
                $formfield = FormFactory::__select($entitycore, $field, $field['directive']);
            } elseif ($field['type'] == FORMTYPE_INJECTION) {
                $formfield = $field['imbricate'];
                unset($entitycore->field[$key]['imbricate']);
            } elseif ($field['type'] == FORMTYPE_FILE) {
                $formfield = FormFactory::__file($entitycore, $field, $field['directive']);
            } elseif ($field['type'] == FORMTYPE_FILEMULTIPLE) {

//                $input = FormFactory::__input($entitycore, $field, $require);
                $input = "<input " . $field['directive'] . " type='file' name='" . FormFactory::$fieldname . "[]' value='" . $field['value'] . "' ";

                $input . ' multiple />';

                if ($field['value']) {
                    $file = "<img class='dv-img' width='120' src='" . $field['src'] . "' />";
                }

                $formfield = $file . $input;
//                $formfield = FormFactory::__file($entitycore, $field, $field['directive']);
            }

            $hidden = '';
            if(isset($field["hidden"]))
                $hidden = 'hidden';

            if (isset($field["lang"]) && $field["lang"] && is_array($formfield)) {
                foreach ($formfield as $iso_code => $fieldlang) {
                    $label = self::getLabel($field, $etoil, $iso_code);
                    $form .= "<div $hidden id='" . FormFactory::$fieldname . "_$iso_code' class='" . $class . " form-group $hidden' >" . $label . $fieldlang . "</div>";
                }
            } else {

                $label = "";
                if (isset($field['label'])) {
                    $label = "<label class='dv_label ' >" . $field['label'] . " " . $etoil . "</label>";
                }

                $formrow .= "<tr $hidden id='" . FormFactory::$fieldname . "' class='" . $class . " form-group $hidden' ><td>" . $label ."</td><td >". $formfield . "</td></tr>";

            }
        }

        $formaction = "";

        if ($entitycore->formaction) {
            $formaction = "<form id='" . $entitycore->name . "-form' action='" . $entitycore->formaction . "' data-id='" . $entitycore->entity->getId() . "' enctype='multipart/form-data' method='post' >\n";
        }


        $formbutton = "";
        if ($entitycore->formbutton) {
            $formbutton = "<button class='btn btn-success btn-block' type='submit' >Save</button></form>";//<input class='btn btn-light' type='reset' value='reset' >
        }

        $formjs = "";
        if (isset($entitycore->addjs) && $entitycore->addjs) {
            foreach ($entitycore->addjs as $js) {
                $formjs .= "<script src='$js.js' ></script>";
            }
        }

        $formcss = "";
        if (isset($entitycore->addcss) && $entitycore->addcss) {
            foreach ($entitycore->addcss as $css) {
                $formcss .= "<link href='$css.css' rel=\"stylesheet\" />";
            }
        }

        $form = $formcss . $formaction .
            "<table class='table'>".$formrow."</table>"
            //"<table class='table'>".$form."</table>"
            //. $dvups_form
            . $formbutton . $formjs;

        return $form;
    }

}
