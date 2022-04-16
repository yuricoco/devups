<?php
// user \dclass\devups\model\Model;

/**
 * @Entity @Table(name="reportingmodel_lang")
 * */
class Reportingmodel_lang extends Dv_langCore
{

    /**
     * @Column(name="title", type="string" , length=255, nullable=true )
     * @var string
     **/
    protected $title;
    /**
     * @Column(name="object", type="string" , length=255, nullable=true )
     * @var string
     **/
    protected $object;
    /**
     * @Column(name="contenttext", type="text"  , nullable=true)
     * @var text
     **/
    protected $contenttext;
    /**
     * @Column(name="content", type="text"  , nullable=true)
     * @var text
     **/
    protected $content;
    /**
     * @Id @ManyToOne(targetEntity="\Reportingmodel")
     * @JoinColumn(onDelete="cascade")
     * @var \Reportingmodel
     */
    public $reportingmodel;

}
