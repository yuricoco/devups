<?php 


use dclass\devups\Datatable\Datatable as Datatable;

class NotificationTable extends Datatable{
    
    public $entity = "notification";

    public function __construct($lazyloading = null, $datatablemodel = [])
    {
        parent::__construct($lazyloading, $datatablemodel);
    }

    public static function init($lazyloading = null){
        $dt = new NotificationTable($lazyloading);
        return $dt;
    }

    public function buildindextable(){

        $this->datatablemodel = [
['header' => t('notification.entity', 'Entity'), 'value' => 'entity'], 
['header' => t('notification.entityid', 'Entityid'), 'value' => 'entityid'],
['header' => t('notification.content', 'Content'), 'value' => 'content']
];

        return $this;
    }
    
    public function builddetailtable()
    {
        $this->datatablemodel = [
['label' => 'Entity', 'value' => 'entity'], 
['label' => 'Entityid', 'value' => 'entityid'], 
['label' => 'Creationdate', 'value' => 'creationdate'], 
['label' => 'Content', 'value' => 'content']
];
        // TODO: overwrite datatable attribute for this view
        return $this;
    }

}
