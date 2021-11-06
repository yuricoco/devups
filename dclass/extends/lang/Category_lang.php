<?php

/**
 * @Entity @Table(name="category_lang")
 * */
class Category_lang extends \Dv_langCore
{

    /**
     * @Column(name="name", type="string" , length=255 )
     * @var string
     **/
    protected $name;

    /**
     * @Id @ManyToOne(targetEntity="\Category")
     * @JoinColumn(onDelete="cascade")
     * @var \Category
     */
    public $category;

}