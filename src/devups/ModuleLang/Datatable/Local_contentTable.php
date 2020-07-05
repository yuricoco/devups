<?php


use dclass\devups\Datatable\Datatable as Datatable;

class Local_contentTable extends Datatable
{

    public $entity = "local_content";

    public function __construct($lazyloading = null, $datatablemodel = [])
    {
        parent::__construct($lazyloading, $datatablemodel);
    }

    public static function init($next = 1, $per_page = 25)
    {

        $dt = new Local_contentTable();
        $dt->next = $next;
        $dt->per_page = $per_page;

        return $dt;
    }

    public function buildindextable()
    {

        $this->datatablemodel = [
            ['header' => t('local_content.reference', 'Reference'), 'value' => 'reference', 'search' => true],
            ['header' => t('local_content.lang', 'Lang'), 'value' => 'lang', 'search' => true],
            ['header' => t('local_content.content', 'Content'), 'value' => 'content', 'search' => true]
        ];
        $this->topactions[] = "generatecache";
        //$this->per_pageEnabled = true;
        $this->enablefilter();

        $this->per_page = 10;
        $this->lazyloading(new Local_content());
        return $this;
    }

    public function builddetailtable()
    {
        $this->datatablemodel = [
            ['label' => 'Reference', 'value' => 'reference'],
            ['label' => 'Content', 'value' => 'content']
        ];
        // TODO: overwrite datatable attribute for this view
        return $this;
    }

}
