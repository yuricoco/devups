<?php

namespace DClass\devups;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Datatable
 *
 * @author Aurelien Atemkeng
 */
class Datatable {
    private $entity = null;
    
    static function init(\stdClass $entity, $next = 0, $per_page = 10) {
        $dt = new Datatable();
        $dt->entity = $entity;
        return $dt;
    }
    
    /**
     * 
     * @param \stdClass $entity
     * @param type $next
     * @param type $per_page
     * @param \QueryBuilder $qbcustom
     * @return type
     */
    public function lazyloading(\stdClass $entity, $next = 0, $per_page = 10, \QueryBuilder $qbcustom = null) {
        $remain = true;

        if (isset($_GET['next']) && isset($_GET['per_page']))
            extract($_GET);

        $qb = new QueryBuilder($entity);

        if ($qbcustom != null) {

            if (isset($_GET["dfilters"]))
                $qbcustom = $this->filter($entity, $qbcustom);

            $nb_element = $qbcustom->__countEl(false);
        } else {

            if (isset($_GET["dfilters"])) {
                $qbcustom = $this->filter($entity, $qb);
                $nb_element = $qbcustom->__countEl(false);
            } else {
                $nb_element = $qb->selectcount()->__countEl(false);
            }
        }

        if ($per_page != "all") {
            if (!($nb_element % $per_page)) {
                $pagination = $nb_element / $per_page;
            } else {
                $pagination = intval($nb_element / $per_page) + 1;
            }

            if ($next > 0) {
                $page = $next;
                $next = (intval($next) - 1) * $per_page;
            } else {
                $page = 1;
            }

            if ($qbcustom != null) {
                $listEntity = $qbcustom->limit($next, $per_page)->__getAll();
            } else {
                $listEntity = $qb->select()->limit($next, $per_page)->__getAll();
            }

            if ($page == $pagination) {
                $next = $page - 1;
                $remain = false;
            } else {
                $next = $page;
            }
        } else {
            $pagination = 0;
            $page = 1;
            $remain = 0;
            if ($qbcustom != null) {
                $listEntity = $qbcustom->__getAll();
            } else {
                $listEntity = $qb->select()->__getAll();
            }
        }

        return array('success' => true, // pour le restservice
            'listEntity' => $listEntity,
            'nb_element' => $nb_element,
            'per_page' => $per_page,
            'pagination' => $pagination,
            'current_page' => $page,
            'next' => $next + 1,
            'previous' => $page - 1,
            'remain' => $remain,
            'detail' => '');
    }

}
