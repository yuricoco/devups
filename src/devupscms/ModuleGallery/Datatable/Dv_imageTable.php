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

        $this->datatablemodel = [
            ['header' => t('dv_image.id', '#'), 'value' => 'id'],
            ['header' => t('dv_image.reference', 'Reference'), 'value' => 'reference'],
            ['header' => t('dv_image.name', 'Name'), 'value' => 'name'],
            ['header' => t('dv_image.description', 'Description'), 'value' => 'description'],
            ['header' => t('dv_image.image', 'Image'), 'value' => 'src:image'],
            ['header' => t('dv_image.image', 'Image'), 'value' => 'image'],
            ['header' => t('dv_image.size', 'Size'), 'value' => 'size'],
            ['header' => t('dv_image.width', 'Width'), 'value' => 'width'],
            ['header' => t('dv_image.height', 'Height'), 'value' => 'height']
        ];

        return $this;
    }

    public function buildgallerytable($page = "all")
    {

        $this->qbcustom = Dv_image::folderhas("gallery");
        $this->per_page = $page;
        $this->table_class = "";
        $this->order_by = " this.id DESC ";
        $this->template = "_partial._gallery_item";
        return $this;

    }

    public function builddetailtable()
    {
        $this->datatablemodel = [
            ['label' => t('dv_image.reference'), 'value' => 'reference'],
            ['label' => t('dv_image.name'), 'value' => 'name'],
            ['label' => t('dv_image.description'), 'value' => 'description'],
            ['label' => t('dv_image.image'), 'value' => 'src:image'],
            ['label' => t('dv_image.image'), 'value' => 'src:image'],
            ['label' => t('dv_image.image'), 'value' => 'image'],
            ['label' => t('dv_image.size'), 'value' => 'size'],
            ['label' => t('dv_image.width'), 'value' => 'width'],
            ['label' => t('dv_image.height'), 'value' => 'height']
        ];
        // TODO: overwrite datatable attribute for this view
        return $this;
    }

    public function router()
    {
        $tablemodel = Request::get("tablemodel");
        if (method_exists($this, "build" . $tablemodel . "table") && $result = call_user_func(array($this, "build" . $tablemodel . "table"))) {
            return $result;
        } else
            switch ($tablemodel) {
                case "frontcustom":
                    return $this->buildfrontcustom();
                default:
                    return $this->buildindextable();
            }

    }

}
