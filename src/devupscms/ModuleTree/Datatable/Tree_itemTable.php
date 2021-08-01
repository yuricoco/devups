<?php


use dclass\devups\Datatable\Datatable as Datatable;

class Tree_itemTable extends Datatable
{


    public function __construct($lazyloading = null, $datatablemodel = [])
    {
        parent::__construct($lazyloading, $datatablemodel);
    }

    public static function init(\Tree_item $tree_item = null)
    {

        $dt = new Tree_itemTable();
        $dt->entity = $tree_item;

        return $dt;
    }

    public function buildindextable()
    {

        $this->datatablemodel = [
            ['header' => t('tree_item.id', '#'), 'value' => 'id'],
            ['header' => t('tree_item.name', 'Name'), 'value' => 'name'],
            ['header' => t('Content'), 'value' => 'content'],
            ['header' => t('tree_item.parent_id', 'Parent_id'), 'value' => 'parent_id'],
            ['header' => t('tree_item.main', 'Main'), 'value' => 'main'],
            ['header' => t('Position'), 'value' => 'position'],
            ['header' => t('tree_item.hierarchy', 'Hierarchy'), 'value' => 'chain']
        ];

        return $this;
    }

    public function builddetailtable()
    {
        $this->datatablemodel = [
            ['label' => t('tree_item.name'), 'value' => 'name'],
            ['label' => t('tree_item.description'), 'value' => 'description'],
            ['label' => t('tree_item.parent_id'), 'value' => 'parent_id'],
            ['label' => t('tree_item.main'), 'value' => 'main'],
            ['label' => t('tree_item.hierarchy'), 'value' => 'hierarchy']
        ];
        // TODO: overwrite datatable attribute for this view
        return $this;
    }

}
