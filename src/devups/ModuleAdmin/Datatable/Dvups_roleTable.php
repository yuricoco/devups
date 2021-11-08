<?php


use dclass\devups\Datatable\Datatable;

class Dvups_roleTable extends Datatable
{

    public function __construct($lazyloading = null, $datatablemodel = [])
    {
        parent::__construct(new  Dvups_role(), $datatablemodel);
        $this->entity = new  Dvups_role();
    }

    public static function init(\Dvups_role $entity = null)
    {
        $dt = new Dvups_roleTable();
        // $dt->entity = $entity;

        return $dt;
    }

    public function buildindextable()
    {

        $this->datatablemodel = [
            ['header' => "#", 'value' => 'id', "order"=>true],
            ['header' => t( "dv_name", 'Name'), 'value' => 'name'],
            ['header' => t("dv_alias", 'Alias'), 'value' => 'alias']
        ];
        $this->topactions[] = Dvups_role::updateprivilegeAction();

        return $this;
    }

    public function render()
    {
        $this->lazyloading($this->entity);
        return parent::render();
    }

    public function getTableRest($datatablemodel = [])
    {
        $this->lazyloading($this->entity);
        return parent::getTableRest();
    }

}
