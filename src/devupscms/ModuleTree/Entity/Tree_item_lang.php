<?php
// user \dclass\devups\model\Model;

/**
 * @Entity @Table(name="tree_item_lang")
 * */
class Tree_item_lang extends Dv_langCore
{

    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     * */
    protected $id;
    /**
     * @Column(name="name", type="string" , length=123 )
     * @var string
     **/
    protected $name;

    /**
     * @Column(name="tree_item_id", type="integer" )
     * @var string
     **/
    public $tree_item_id;


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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

}
