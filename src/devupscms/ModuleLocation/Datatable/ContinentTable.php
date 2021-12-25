<?php 


use dclass\devups\Datatable\Datatable as Datatable;

class ContinentTable extends Datatable{
    

    public function __construct($continent = null, $datatablemodel = [])
    {
        parent::__construct($continent, $datatablemodel);
    }

    public static function init(\Continent $continent = null){
    
        $dt = new ContinentTable($continent);
        $dt->entity = $continent;
        
        return $dt;
    }

    public function buildindextable(){

        $this->datatablemodel = [
['header' => t('continent.id', '#'), 'value' => 'id'], 
['header' => t('Code'), 'value' => 'code'],
['header' => t('continent.name', 'Name'), 'value' => 'name'],
['header' => t('continent.status', 'Status'), 'value' => 'status']
];

        return $this;
    }
    
    public function builddetailtable()
    {
        $this->datatablemodel = [
['label' => t('continent.name'), 'value' => 'name'], 
['label' => t('continent.status'), 'value' => 'status']
];
        // TODO: overwrite datatable attribute for this view
        return $this;
    }

    public function router()
    {
        $tablemodel = Request::get("tablemodel", null);
        if ($tablemodel && method_exists($this, "build" . $tablemodel . "table") && $result = call_user_func(array($this, "build" . $tablemodel . "table"))) {
            return $result;
        } else
            switch ($tablemodel) {
                // case "": return this->
                default:
                    return $this->buildindextable();
            }

    }
    
}
