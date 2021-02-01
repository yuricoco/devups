<?php


use dclass\devups\Datatable\Datatable as Datatable;

class CmstextTable extends Datatable
{


    public function __construct($lazyloading = null, $datatablemodel = [])
    {
        parent::__construct($lazyloading, $datatablemodel);
    }

    public static function init(\Cmstext $cmstext = null)
    {

        $dt = new CmstextTable();
        $dt->entity = $cmstext;

        return $dt;
    }

    public function buildhometable()
    {

//        global $viewdir, $moduledata;
//        $viewdir[] = Cmstext::classroot("") . '/Resource/views';

        $this->template = "_partial.blog_item";

        $this->base_url = __env;

        $this->per_page = 3;
        $this->order_by = " this.id desc ";
        return $this;

    }

    public function buildindextable()
    {

        $this->topactions[] = "<a href='" . Cmstext::classpath("cmstext/new") . "' class='btn btn-primary'>Create new content</a>";

        $this->datatablemodel = [
            ['header' => t('cmstext.titre', 'Titre'), 'value' => 'title'],
            ['header' => t('cmstext.reference', 'Reference'), 'value' => 'slug'],
            ['header' => t('cmstext.lang', 'Lang'), 'value' => 'lang'],
        ];

        return $this;
    }

    public function builddetailtable()
    {
        $this->datatablemodel = [
            ['label' => t('cmstext.titre'), 'value' => 'titre'],
            ['label' => t('cmstext.reference'), 'value' => 'reference'],
            ['label' => t('cmstext.content'), 'value' => 'content'],
            ['label' => t('cmstext.lang'), 'value' => 'lang'],
            ['label' => t('cmstext.creationdate'), 'value' => 'creationdate']
        ];
        // TODO: overwrite datatable attribute for this view
        return $this;
    }

}
