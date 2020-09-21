<?php 


use dclass\devups\Datatable\Datatable as Datatable;

class TemplateTable extends Datatable{
    

    public function __construct($lazyloading = null, $datatablemodel = [])
    {
        parent::__construct($lazyloading, $datatablemodel);
    }

    public static function init(\Template $template = null){
    
        $dt = new TemplateTable();
        $dt->entity = $template;
        
        return $dt;
    }

    public function buildindextable(){

        $this->datatablemodel = [
['header' => t('template.id', '#'), 'value' => 'id'], 
['header' => t('template.header', 'Header'), 'value' => 'header'], 
['header' => t('template.footer', 'Footer'), 'value' => 'footer'], 
['header' => t('template.logo', 'Logo'), 'value' => 'logo']
];

        return $this;
    }
    
    public function builddetailtable()
    {
        $this->datatablemodel = [
['label' => t('template.header'), 'value' => 'header'], 
['label' => t('template.footer'), 'value' => 'footer'], 
['label' => t('template.logo'), 'value' => 'logo']
];
        // TODO: overwrite datatable attribute for this view
        return $this;
    }

}
