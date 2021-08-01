<?php 


use dclass\devups\Datatable\Datatable as Datatable;

class Request_historyTable extends Datatable{
    

    public function __construct($request_history = null, $datatablemodel = [])
    {
        parent::__construct($request_history, $datatablemodel);
    }

    public static function init(\Request_history $request_history = null){
    
        $dt = new Request_historyTable($request_history);
        $dt->entity = $request_history;
        
        return $dt;
    }

    public function buildindextable(){

        $this->datatablemodel = [
['header' => t('request_history.id', '#'), 'value' => 'id'], 
['header' => t('request_history.query', 'Query'), 'value' => 'query']
];

        return $this;
    }
    
    public function builddetailtable()
    {
        $this->datatablemodel = [
['label' => t('request_history.query'), 'value' => 'query']
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
