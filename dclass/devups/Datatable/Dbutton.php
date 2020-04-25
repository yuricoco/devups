<?php


namespace dclass\devups\model;


class Dbutton
{
    public $content;
    public $class;
    public $action;
    public $type = "button";
    public $directive = [];

    public function render(){

        if($this->directive){
            $directive = \Form::serialysedirective($this->directive);
            return '<button type="' . $this->type . '" ' . $directive . ' >' . $this->content . '</button>';
        }else{
            return '<button type="button" class="' . $this->class. '" ' . $this->action. ' >' . $this->content . '</button>';
        }

    }
}