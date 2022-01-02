<?php
// user \dclass\devups\model\Model;

/**
 * @Entity @Table(name="dvups_component_lang")
 * */
class Dvups_component_lang extends Dv_langCore
{

    /**
     * @Column(name="label", type="string" , length=150 )
     * @var string
     **/
    protected $label;

    /**
     * @Id @ManyToOne(targetEntity="\Dvups_component")
     * @JoinColumn(onDelete="cascade")
     * @var \Dvups_component
     */
    public $dvups_component;


}
