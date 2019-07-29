<?php

use DClass\devups\Datatable;

/**
 * Created by PhpStorm.
 * User: ATEMKENG AZANKANG
 * Date: 26/07/2019
 * Time: 00:31
 */

//namespace cashdesk\ModuleCatalog\datatable;


class ProductTable extends \DClass\devups\Datatable
{

    //protected $dynamicpagination = "select";
    public $entity = "product";
    public $searchaction = true;

    public $datatablemodel = [
        ['header' => '#', 'value' => 'id', "order" => true],
        ['header' => 'Nom du produit', 'value' => 'name', "search" => true, "order" => true],
        ['header' => 'Prix de vente', 'value' => 'price', "order" => true],
    ];

    public function __construct($lazyloading = null, $datatablemodel = [])
    {
        parent::__construct($lazyloading, $datatablemodel);
    }

    public static function init($lazyloading = null){
        $dt = new ProductTable($lazyloading);
        return $dt;
    }

    public function buildindextable(){

        //$this->createaction['content'] = "icil la";
        //$this->dynamicpagination = "select";
        $this->searchaction = true;

        return $this;
    }

    public function buildfronttable(){

        $this->isFrontEnd = true;
        //$this->dynamicpagination = "select";
        $this->searchaction = true;
        $this->actionDropdown = false;
        $this->defaultaction = false;

        return $this;
    }

}
