<?php


use dclass\devups\Datatable\Datatable as Datatable;

class SlideTable extends Datatable
{


    public function __construct($slide = null, $datatablemodel = [])
    {
        parent::__construct($slide, $datatablemodel);
    }

    public static function init(\Slide $slide = null)
    {

        $dt = new SlideTable($slide);
        $dt->entity = $slide;

        return $dt;
    }

    public function buildindextable()
    {

        $this->datatablemodel = [
            ['header' => t('slide.id', '#'), 'value' => 'id'],
            ['header' => t('slide.activated', 'Activated'), 'value' => 'activated'],
            //['header' => t('slide.targeturl', 'Targeturl'), 'value' => 'targeturl'],
            ['header' => t('entity.image', 'image'), 'value' => 'src:image.image']
        ];

        return $this;
    }

    public function builddetailtable()
    {
        $this->datatablemodel = [
            ['label' => t('slide.activated'), 'value' => 'activated'],
            ['label' => t('slide.targeturl'), 'value' => 'targeturl'],
            ['label' => t('entity.dv_image'), 'value' => 'Dv_image.reference']
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
