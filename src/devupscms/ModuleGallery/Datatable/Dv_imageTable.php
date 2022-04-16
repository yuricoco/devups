<?php


use dclass\devups\Datatable\Datatable as Datatable;

class Dv_imageTable extends Datatable
{


    public function __construct($dv_image = null, $datatablemodel = [])
    {
        parent::__construct($dv_image, $datatablemodel);
    }

    public static function init(\Dv_image $dv_image = null)
    {

        $dt = new Dv_imageTable($dv_image);
        $dt->entity = $dv_image;

        return $dt;
    }


    public function buildfrontcustom()
    {
        $this->base_url = __env."admin/";
        global $viewdir, $moduledata;
        $viewdir[] = Dv_image::classroot("") . '/Resource/views';

        $this->template = "admin.dv_image.gallery_item";

        //$this->base_url = __env;

        $this->per_page = 30;
        $this->order_by = " this.id desc ";
        return $this;
    }

    public function buildindextable()
    {

        $this->base_url = __env . "admin/";
        $this->datatablemodel = [
            'id' => ['header' => t('#'),],
            'reference' => ['header' => t('Reference'),],
            'name' => ['header' => t('Name'),],
            'description' => ['header' => t('Description'),],
            'image' => ['header' => t('Image'), 'value' => 'src:image'],
            'size' => ['header' => t('Size'),],
            'width' => ['header' => t('Width'),],
            'height' => ['header' => t('Height'),]
        ];

        return $this;
    }

    public function buildcontenttable()
    {

        $this->base_url = __env . "admin/";
        $this->datatablemodel = [
            'image' => ['header' => t('Image'), 'value' => "name", 'get' => function(Dv_image $item){
                return $item->showImage('150_')."({$item->id})<br><button class='btn btn-outline-info btn-block' onclick='cmstext.copyimage(\"{$item->srcImage()}\")' >copy</button>";
            }, "search"=>true],
        ];
        $this->order_by = "this.id desc";
        return $this;
    }

    public function builddetailtable()
    {
        $this->datatablemodel = [
            ['label' => t('reference'), 'value' => 'reference'],
            ['label' => t('name'), 'value' => 'name'],
            ['label' => t('description'), 'value' => 'description'],
            ['label' => t('image'), 'value' => 'src:image'],
            ['label' => t('image'), 'value' => 'src:image'],
            ['label' => t('image'), 'value' => 'image'],
            ['label' => t('size'), 'value' => 'size'],
            ['label' => t('width'), 'value' => 'width'],
            ['label' => t('height'), 'value' => 'height']
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
