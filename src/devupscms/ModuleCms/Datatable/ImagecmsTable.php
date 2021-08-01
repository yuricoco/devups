<?php


use dclass\devups\Datatable\Datatable as Datatable;

class ImagecmsTable extends Datatable
{

    public $entity = "imagecms";

    public function __construct($lazyloading = null, $datatablemodel = [])
    {
        parent::__construct($lazyloading, $datatablemodel);
    }

    public static function init($lazyloading = null)
    {
        $dt = new ImagecmsTable($lazyloading);
        return $dt;
    }

    public function buildindextable()
    {

        $this->datatablemodel = [
            ['header' => t('Image'), 'value' => 'src:image.image', "param"=>["150_"]]
        ];

        $this->enablepagination = false;
        $this->per_page = "all";
        return $this;
    }

    public function builddetailtable()
    {
        $this->datatablemodel = [
            ['label' => 'Width_size', 'value' => 'width_size']
        ];
        // TODO: overwrite datatable attribute for this view
        return $this;
    }

}
