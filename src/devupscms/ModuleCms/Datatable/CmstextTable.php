<?php


use dclass\devups\Datatable\Datatable as Datatable;

class CmstextTable extends Datatable
{


    public function __construct($cmstext = null, $datatablemodel = [])
    {
        parent::__construct($cmstext, $datatablemodel);
    }

    public static function init(\Cmstext $cmstext = null)
    {

        $dt = new CmstextTable($cmstext);
        $dt->entity = $cmstext;

        return $dt;
    }

    public function buildindextable()
    {

        $this->base_url = __env . "admin/";
        $this->datatablemodel = [
            'id' => ['header' => t('#'),],
            'title' => ['header' => t('Titre'),],
            'reference' => ['header' => t('Reference'),],
            'active' => ['header' => t('Active'),],
        ];

        $this->addcustomaction("editcontent");

        return $this;
    }

    public function builddetailtable()
    {
        $this->datatablemodel = [
            ['label' => t('titre'), 'value' => 'titre'],
            ['label' => t('reference'), 'value' => 'reference'],
            ['label' => t('content'), 'value' => 'content'],
            ['label' => t('lang'), 'value' => 'lang'],
            ['label' => t('creationdate'), 'value' => 'creationdate']
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
