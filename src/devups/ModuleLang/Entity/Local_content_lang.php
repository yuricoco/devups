<?php

/**
 * @Entity @Table(name="local_content_lang")
 * */
class Local_content_lang extends \Dv_langCore
{

    /**
     * @Column(name="content", type="text"  )
     * @var text
     **/
    protected $content;

    /**
     * @Id @ManyToOne(targetEntity="\Local_content")
     * @JoinColumn(onDelete="cascade")
     * @var \Local_content
     */
    public $local_content;

}