<?php


namespace dclass\devups\Datatable;

class TableData
{

    public $colspan = "";
    public $rowspan = "";
    public $style = "";
    public $value = "";
    public $id = "";
    public $class = [];
    public $directive = [];

    public function getHtml(){
        $directive = "";
        if($this->colspan)
            $this->directive["colspan"] = $this->colspan;

        if($this->rowspan)
            $this->directive["rowspan"] = $this->rowspan;
        
        if ($this->directive)
            $directive = \Form::serialysedirective($this->directive);

        return "<td $directive >" . $this->value . "</td>";

    }

}