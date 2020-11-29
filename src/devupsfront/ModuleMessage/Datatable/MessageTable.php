<?php 


use dclass\devups\Datatable\Datatable as Datatable;

class MessageTable extends Datatable{
    

    public function __construct($lazyloading = null, $datatablemodel = [])
    {
        parent::__construct($lazyloading, $datatablemodel);
    }

    public static function init(\Message $message = null){
    
        $dt = new MessageTable();
        $dt->entity = $message;
        
        return $dt;
    }

    public function buildindextable(){

        $this->enabletopaction = false;

        $this->datatablemodel = [
['header' => t('message.id', '#'), 'value' => 'id'], 
['header' => t('message.nom', 'Nom'), 'value' => 'nom'], 
['header' => t('message.email', 'Email'), 'value' => 'email'], 
['header' => t('message.telephone', 'Telephone'), 'value' => 'telephone'], 
['header' => t('message.message', 'Message'), 'value' => 'message']
];

        return $this;
    }
    
    public function builddetailtable()
    {
        $this->datatablemodel = [
['label' => t('message.nom'), 'value' => 'nom'], 
['label' => t('message.email'), 'value' => 'email'], 
['label' => t('message.telephone'), 'value' => 'telephone'], 
['label' => t('message.message'), 'value' => 'message']
];
        // TODO: overwrite datatable attribute for this view
        return $this;
    }

}
