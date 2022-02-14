<?php
// user \dclass\devups\model\Model;

/**
 * @Entity @Table(name="dvups_entity_lang")
 * */
class Dvups_entity_lang extends Dv_langCore
{

    /**
     * @Column(name="label", type="string" , length=100 )
     * @var string
     **/
    protected $label;

    /**
     * @Id @ManyToOne(targetEntity="\Dvups_entity")
     * @JoinColumn(onDelete="cascade")
     * @var \Dvups_entity
     */
    public $dvups_entity;



}
