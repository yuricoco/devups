<?php

/**
 * @Entity @Table(name="product")
 * */
class Product extends \Model implements JsonSerializable
{

    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     * */
    protected $id;
    /**
     * @Column(name="name", type="string" , length=25 )
     * @var string
     **/
    private $name;
    /**
     * @Column(name="description", type="text"  )
     * @var text
     **/
    private $description;

    /**
     * @OneToOne(targetEntity="\Image")
     * , inversedBy="reporter"
     * @var \Image
     */
    public $image;

    /**
     * @ManyToOne(targetEntity="\Category")
     * , inversedBy="reporter"
     * @var \Category
     */
    public $category;

    /**
     * @ManyToOne(targetEntity="\Subcategory")
     * , inversedBy="reporter"
     * @var \Subcategory
     */
    public $subcategory;

    /**
     * manyToMany
     * @var \Storage
     */
    public $storage;


    public function __construct($id = null)
    {

        if ($id) {
            $this->id = $id;
        }

        $this->image = new Image();
        $this->category = new Category();
        $this->subcategory = new Subcategory();
        $this->storage = EntityCollection::entity_collection('storage');
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     *  oneToOne
     * @return \Image
     */
    function getImage()
    {
        //$this->image = $this->__belongto("image");
        return $this->image;
    }

    function setImage(\Image $image = null)
    {
        $this->image = $image;
    }

    /**
     *  manyToOne
     * @return \Category
     */
    function getCategory()
    {
        //$this->category = $this->__belongto("category");
        return $this->category;
    }

    function setCategory(\Category $category)
    {
        $this->category = $category;
    }

    /**
     *  manyToOne
     * @return \Subcategory
     */
    function getSubcategory()
    {
        //$this->subcategory = $this->__belongto("subcategory");
        return $this->subcategory;
    }

    function setSubcategory(\Subcategory $subcategory)
    {
        $this->subcategory = $subcategory;
    }

    /**
     *  manyToMany
     * @return \Storage
     */
    function collectStorage()
    {
        $this->storage = $this->__hasmany("storage");
        return $this->storage;
    }

    function getStorage()
    {
        return $this->storage;
    }

    function addStorage(\Storage $storage)
    {
        $this->storage[] = $storage;
    }

    function dropStorageCollection()
    {
        $this->storage = EntityCollection::entity_collection('storage');
    }


    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'image' => $this->image,
            'category' => $this->category,
            'subcategory' => $this->subcategory,
            'storage' => $this->storage,
        ];
    }

}
