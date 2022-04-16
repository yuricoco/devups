<?php
// user \dclass\devups\model\Model;

/**
 * @Entity @Table(name="notificationtype_lang")
 * */
class Notificationtype_lang extends Dv_langCore
{

    /**
     * @Id @ManyToOne(targetEntity="\Notificationtype")
     * @JoinColumn(onDelete="cascade")
     * @var \Notificationtype
     */
    public $notificationtype;
    /**
     * @Column(name="content", type="string" , length=255 )
     * @var integer
     **/
    protected $content;


}
