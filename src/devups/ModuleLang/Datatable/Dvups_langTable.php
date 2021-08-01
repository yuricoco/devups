<?php 


use dclass\devups\Datatable\Datatable as Datatable;

class Dvups_langTable extends Datatable{
    

    public function __construct($dvups_lang = null, $datatablemodel = [])
    {
        parent::__construct($dvups_lang, $datatablemodel);
    }

    public static function init(\Dvups_lang $dvups_lang = null){
    
        $dt = new Dvups_langTable($dvups_lang);
        $dt->entity = $dvups_lang;
        
        return $dt;
    }

    public function buildindextable(){

        $this->datatablemodel = [
['header' => t('dvups_lang.id', '#'), 'value' => 'id'], 
['header' => t('dvups_lang.name', 'Name'), 'value' => 'name'], 
['header' => t('dvups_lang.active', 'Active'), 'value' => 'active'], 
['header' => t('dvups_lang.iso_code', 'Iso_code'), 'value' => 'iso_code'], 
['header' => t('dvups_lang.language_code', 'Language_code'), 'value' => 'language_code'], 
['header' => t('dvups_lang.locale', 'Locale'), 'value' => 'locale'], 
['header' => t('dvups_lang.date_format_lite', 'Date_format_lite'), 'value' => 'date_format_lite'], 
['header' => t('dvups_lang.date_format_full', 'Date_format_full'), 'value' => 'date_format_full']
];

        return $this;
    }
    
    public function builddetailtable()
    {
        $this->datatablemodel = [
['label' => t('dvups_lang.name'), 'value' => 'name'], 
['label' => t('dvups_lang.active'), 'value' => 'active'], 
['label' => t('dvups_lang.iso_code'), 'value' => 'iso_code'], 
['label' => t('dvups_lang.language_code'), 'value' => 'language_code'], 
['label' => t('dvups_lang.locale'), 'value' => 'locale'], 
['label' => t('dvups_lang.date_format_lite'), 'value' => 'date_format_lite'], 
['label' => t('dvups_lang.date_format_full'), 'value' => 'date_format_full']
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
