<?php
/**
 * Created by PhpStorm.
 * User: ATEMKENG AZANKANG
 * Date: 29/07/2019
 * Time: 00:11
 */

interface DatatableOverwrite
{

    /**
     * overwrite the edit button either by changing one of the array parameter of devups default button send in parameter
     * or design an custom html element.
     *
     * @param $btarray the array model of the devupsbutton
     * @return mixed Array | string
     */
    public function editAction($btarray);

    /**
     * overwrite the show button either by changing one of the array parameter of devups default button send in parameter
     * or design an custom html element.
     *
     * @param $btarray the array model of the devupsbutton
     * @return mixed Array | string
     */
    public function showAction($btarray);

    /**
     * overwrite the delete button either by changing one of the array parameter of devups default button send in parameter
     * or design an custom html element.
     *
     * @param $btarray the array model of the devupsbutton
     * @return mixed Array | string
     */
    public function deleteAction($btarray);

    // todo create DatatableOverwriteFront interface
//    public function editFrontAction($btarray);
//
//    public function showFrontAction($btarray);
//
//    public function deleteFrontAction($btarray);

}
