<?php
// user \dclass\devups\model\Model;

/**
 * @Entity @Table(name="cmstext_lang")
 * */
class Cmstext_lang extends Dv_langCore
{

    /**
     * @Column(name="title", type="string" , length=255 , nullable=true)
     * @var string
     **/
    protected $title;
    /**
     * @Column(name="content", type="text", nullable=true   )
     * @var text
     **/
    protected $content;
    /**
     * @Column(name="sommary", type="text", nullable=true  )
     * @var text
     * */
    protected $sommary = "";
    /**
     * @Id @ManyToOne(targetEntity="\Cmstext")
     * @JoinColumn(onDelete="cascade")
     * @var \Cmstext
     */
    public $cmstext;

}
