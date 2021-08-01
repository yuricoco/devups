<?php


class Dv_langCore extends \Model implements JsonSerializable
{

    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     * */
    protected $id;

    /**
     * @Column(name="lang_id", type="integer"  )
     * @var integer
     **/
    protected $lang_id;


}