<?php


/**
 * @Entity @Table(name="product_lang")
 * */
class Product_lang extends Dv_langCore
{

    /**
     * @Id @ManyToOne(targetEntity="\Product")
     * @JoinColumn(onDelete="cascade")
     * @var \Product
     */
    public $product;

    /**
     * @Column(name="name", type="string" , length=55 )
     * @var string
     **/
    protected $name;

}