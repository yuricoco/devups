<?php


use dclass\devups\Datatable\Datatable;

class Dvups_entityTable extends Datatable
{

    public function __construct($lazyloading = null, $datatablemodel = [])
    {
        parent::__construct(new Dvups_entity(), $datatablemodel);
        $this->entity = new  Dvups_entity();
    }

    public static function init(\Dvups_entity $entity = null)
    {
        $dt = new Dvups_entityTable();
        // $dt->entity = $entity;

        return $dt;
    }

    public function buildindextable()
    {

        // $this->mainrowaction = "show";
        $this->groupaction = true;
        $this->enablegroupaction();
        $this->datatablemodel = [
            ['header' => "#", 'value' => 'id', "order"=>true],
            ['header' => 'Name', 'value' => 'name',  'get' => 'linkname', 'search' => true],
            ['header' => 'Url', 'value' => 'url', 'search' => true],
            ['header' => 'Dvups_module', 'value' => 'Dvups_module.name'],
            ['header' => 'Label', 'value' => 'label', 'get' => 'labelform', 'search' => false,],
            //['header' => 'Rows', 'value' => function(\Dvups_entity $entity){ return ucfirst($entity->getLabel())::count(); },]
        ];
        $this->enablefilter();
        $this->customactions[] = function (\Dvups_entity $entity){
            return "<button class='btn btn-primary btn-block' onclick='model.truncate(".$entity->getId().")' >Truncate</button>";
        };
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
