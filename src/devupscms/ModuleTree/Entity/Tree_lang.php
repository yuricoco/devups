<?php

/**
 * @Entity @Table(name="tree_lang")
 * */
class Tree_lang extends \Dv_langCore
{

    /**
     * @Column(name="name", type="string" , length=255 )
     * @var string
     **/
    protected $name;

    /**
     * @Id @ManyToOne(targetEntity="\Tree")
     * @JoinColumn(onDelete="cascade")
     * @var \Tree
     */
    public $tree;

}