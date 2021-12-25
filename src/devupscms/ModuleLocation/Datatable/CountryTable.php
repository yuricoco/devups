<?php 


use dclass\devups\Datatable\Datatable as Datatable;

class CountryTable extends Datatable{
    

    public function __construct($lazyloading = null, $datatablemodel = [])
    {
        parent::__construct($lazyloading, $datatablemodel);
    }

    public static function init(\Country $country = null){
    
        $dt = new CountryTable();
        $dt->entity = $country;
        
        return $dt;
    }

    public function buildindextable(){

        $this->datatablemodel = [
           // ['header' => t('country.id', '#'), 'value' => 'id'], 
            'id' => ['header' => t('country.id', 'Id')],
            ['header' => "Content", 'value' => 'continent.name'],
            'name' => ['header' => t('country.name', 'Name'),],
            'nicename' => ['header' => t('country.name', 'Name')],
            'iso' => ['header' => t('country.iso', 'Iso'), 'value' => 'iso'],
            'phonecode' => ['header' => t('country.phonecode', 'Phonecode'),],
            'status' => ['header' => t('country.status', 'Status'), ],
            /* ['header' => t('country.iso3', 'Iso3'), 'value' => 'iso3'],
             ['header' => t('country.nicename', 'Nicename'), 'value' => 'nicename'],
             ['header' => t('country.numcode', 'Numcode'), 'value' => 'numcode'],
             ['header' => t('country.created_at', 'Created_at'), 'value' => 'created_at'],
             ['header' => t('country.updated_at', 'Updated_at'), 'value' => 'updated_at'],
             ['header' => t('country.deleted_at', 'Deleted_at'), 'value' => 'deleted_at']*/
        ];

        return $this;
    }
    
    public function builddetailtable()
    {
        $this->datatablemodel = [
['label' => t('country.id'), 'value' => 'id'], 
['label' => t('country.name'), 'value' => 'name'], 
['label' => t('country.iso'), 'value' => 'iso'], 
['label' => t('country.iso3'), 'value' => 'iso3'], 
['label' => t('country.nicename'), 'value' => 'nicename'], 
['label' => t('country.numcode'), 'value' => 'numcode'], 
['label' => t('country.phonecode'), 'value' => 'phonecode'], 
['label' => t('country.status'), 'value' => 'status'], 
['label' => t('country.created_at'), 'value' => 'created_at'], 
['label' => t('country.updated_at'), 'value' => 'updated_at'], 
['label' => t('country.deleted_at'), 'value' => 'deleted_at']
];
        // TODO: overwrite datatable attribute for this view
        return $this;
    }

}
