<?php
/**
 * Created by PhpStorm.
 * User: ATEMKENG AZANKANG
 * Date: 29/07/2019
 * Time: 00:11
 */

interface DatatableOverwrite
{

    public function editAction($btarray);

    public function showAction($btarray);

    public function deleteAction($btarray);

    // todo create DatatableOverwriteFront interface
//    public function editFrontAction($btarray);
//
//    public function showFrontAction($btarray);
//
//    public function deleteFrontAction($btarray);

}
