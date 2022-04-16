<?php
// user \dclass\devups\model\Model;

/**
 * @Entity @Table(name="status_lang")
 * */
class Status_lang extends Dv_langCore
{

    /**
     * @Id @ManyToOne(targetEntity="\Status")
     * @JoinColumn(onDelete="cascade")
     * @var \Status
     */
    public $status;
    /**
     * @Column(name="label", type="string" , length=55 )
     * @var integer
     **/
    protected $label;


}
