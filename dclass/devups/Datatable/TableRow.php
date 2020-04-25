<?php


namespace dclass\devups\Datatable;


class TableRow
{
    public $style = "";
    public $directive = [];
    public $id = "";
    public $withactioncolumn = true;
    public $class = [];
    public $tabledata;
    public $tds = [];
    public function __construct($actioncolumn = true)
    {
        $this->withactioncolumn = $actioncolumn;
        $this->tabledata = new TableData();
    }

    public function resetTableData(){
        $this->tabledata = new TableData();
    }

    public function getHtml($groupaction = false){
        $directive = "";
        $td = "";

        if ($this->directive)
            $directive = \Form::serialysedirective($this->directive);

        if ($groupaction)
            $td .= "<td ></td>";

        foreach ($this->tds as $tabledata)
            $td .= $tabledata->getHtml();

        if($this->withactioncolumn)
            return "<tr $directive >" . $td . "<td ></td></tr>";

        return "<tr $directive >" . $td . "</tr>";

    }

    /**
     * @return $this
     */
    public function addTabledata()
    {
        $this->tds[] = $this->tabledata;
        $this->tabledata = new TableData();
        return $this;
    }

}