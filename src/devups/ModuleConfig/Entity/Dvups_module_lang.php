<?php
// user \dclass\devups\model\Model;

/**
 * @Entity @Table(name="dvups_module_lang")
 * */
class Dvups_module_lang extends Dv_langCore
{

    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     * */
    protected $id;

    /**
     * @Column(name="label", type="string" , length=25 )
     * @var string
     * */
    protected $label;
    /**
     * @Column(name="dvups_module_id", type="integer" )
     * @var string
     * */
    protected $dvups_module_id;

    public function __construct($id = null)
    {

        if ($id) {
            $this->id = $id;
        }

    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;

    }

}
