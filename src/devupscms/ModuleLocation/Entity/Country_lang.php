<?php
// user \dclass\devups\model\Model;

/**
 * @Entity @Table(name="country_lang")
 * */
class Country_lang extends Dv_langCore
{

    /**
     * @Column(name="nicename", type="string" , length=100 )
     * @var string
     **/
    protected $nicename;

    /**
     * @Id @ManyToOne(targetEntity="\Country")
     * @JoinColumn(onDelete="cascade")
     * @var \Country
     */
    public $country;



}
