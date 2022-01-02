<?php
// user \dclass\devups\model\Model;

/**
 * @Entity @Table(name="dvups_module_lang")
 * */
class Dvups_module_lang extends Dv_langCore
{

    /**
     * @Column(name="label", type="string" , length=25 )
     * @var string
     * */
    protected $label;
    /**
     * @Id @ManyToOne(targetEntity="\Dvups_module")
     * @JoinColumn(onDelete="cascade")
     * @var \Dvups_module
     */
    public $dvups_module;

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
