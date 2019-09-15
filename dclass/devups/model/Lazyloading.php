<?php
/**
 * Created by PhpStorm.
 * User: ATEMKENG AZANKANG
 * Date: 13/08/2019
 * Time: 14:14
 */
namespace dclass\devups\model;

class Lazyloading implements \JsonSerializable
{
    public $success = true;
    public $classname = "";
    public $listentities = [];
    public $nb_element = 0;
    public $per_page = 30;
    public $pagination = 1;
    public $current_page = 1;
    public $next = 1;
    public $previous = 0;
    public $remain = 0;
    public $detail = 0;

    /**
     * Specify data which should be serialized to JSON
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return array('success' => $this->classname, // pour le restservice
            'classname' => $this->classname,
            'listEntity' => $this->listentities,
            'nb_element' => $this->nb_element,
            'per_page' => $this->per_page,
            'pagination' => $this->pagination,
            'current_page' => $this->current_page,
            'next' => $this->next,
            'previous' => $this->previous,
            'remain' => $this->remain,
            'detail' => $this->detail);
    }
}
