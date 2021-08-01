<?php


use dclass\devups\Datatable\Datatable as Datatable;

class ConfigurationTable extends Datatable
{


    public function __construct($lazyloading = null, $datatablemodel = [])
    {
        parent::__construct($lazyloading, $datatablemodel);
    }

    public static function init(\Configuration $configuration = null)
    {

        $dt = new ConfigurationTable(new Configuration());
        $dt->entity = $configuration;

        return $dt;
    }

    public function buildindextable()
    {

        $this->topactions[] = '<button onclick="model.buildConfig()" class="btn btn-primary">Generate constante.php file</button>';
        $this->datatablemodel = [
            ['header' => t('configuration.id', '#'), 'value' => 'id'],
            ['header' => t('configuration._key', '_key'), 'value' => '_key', "search"=>true],
            ['header' => t('configuration._value', '_value'), 'value' => '_value'],
            ['header' => t('configuration._type', '_type'), 'value' => '_type'],
            ['header' => t('configuration.comment', 'Comment'), 'value' => 'comment'],
        ];

        //$this->enablefilter(false);

        $this->per_page = 50;
        return $this;
    }

    public function buildconfigtable()
    {
        $this->searchaction = false;
        $this->groupaction = false;

        $this->datatablemodel = [
            ['header' => t('configuration.id', '#'), 'value' => 'id'],
            ['header' => t('configuration._key', '_key'), 'value' => '_key', "search"=>true],
            ['header' => t('configuration._value', '_value'), 'value' => '_value'],
            ['header' => t('configuration.comment', 'Comment'), 'value' => 'comment'],
        ];
        $this->disablepagination();
        //$this->enablefilter(false);
        $this->per_page = "all";
        return $this;
    }

    public function builddetailtable()
    {
        $this->datatablemodel = [
            ['label' => t('configuration._key'), 'value' => '_key'],
            ['label' => t('configuration._value'), 'value' => '_value'],
            ['label' => t('configuration._type'), 'value' => '_type']
        ];
        // TODO: overwrite datatable attribute for this view
        return $this;
    }

}
