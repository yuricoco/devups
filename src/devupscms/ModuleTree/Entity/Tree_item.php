<?php
// user \dclass\devups\model\Model;

/**
 * @Entity @Table(name="tree_item")
 * */
class Tree_item extends Model implements JsonSerializable
{

    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     * */
    protected $id;
    /**
     * @Column(name="position", type="integer" , nullable=true )
     * @var string
     **/
    protected $position;
    /**
     * @Column(name="name", type="string" , length=123 )
     * @var string
     **/
    protected $name;
    /**
     * @Column(name="description", type="text"  , nullable=true)
     * @var text
     **/
    protected $description;
    /**
     * @Column(name="slug", type="string" , length=55 , nullable=true)
     * @var string
     **/
    protected $slug;
    /**
     * @Column(name="status", type="integer"  , nullable=true)
     * @var integer
     **/
    protected $status;
    /**
     * @Column(name="parent_id", type="integer"  , nullable=true)
     * @var integer
     **/
    protected $parent_id;
    /**
     * @Column(name="main", type="integer"  , nullable=true)
     * @var integer
     **/
    protected $main;
    /**
     * @Column(name="chain", type="text"  , nullable=true)
     * @var text
     **/
    protected $chain;

    /**
     * @ManyToOne(targetEntity="\Tree")
     * @var \Tree
     */
    public $tree;


    public function __construct($id = null)
    {

        if ($id) {
            $this->id = $id;
        }

        $this->tree = new Tree();
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
        if (!$this->slug)
            $this->slug = \DClass\lib\Util::urlsanitize($this->name);
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param string $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getParent_id()
    {
        return $this->parent_id;
    }

    public function setParent_id($parent_id)
    {
        $this->parent_id = $parent_id;
    }

    public function getMain()
    {
        return $this->main;
    }

    public function setMain($main)
    {
        $this->main = $main;
    }

    public function getChain()
    {
        return $this->chain;
    }

    public function setChain($chain)
    {
        $this->chain = $chain;
    }

    /**
     *  manyToOne
     * @return \Tree
     */
    function getTree()
    {
        $this->tree = $this->tree->__show();
        return $this->tree;
    }

    function setTree(\Tree $tree)
    {
        $this->tree = $tree;
    }


    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'position' => (int) $this->position,
            'description' => $this->description,
            'parent_id' => $this->parent_id,
            'main' => $this->main,
            'status' => $this->status,
            'chain' => $this->chain,
            'tree' => $this->tree,
            'children' => (int)self::where("parent_id", $this->id)->__countEl(),
        ];
    }

    public function getChildren($category = null)
    {
        if (!$category)
            $category = new Tree_item();

        return self::select()
            ->where("this.parent_id", $this->id)
            ->andwhere("this.id", "!=", $category->getId())
            ->orderby("this.name")
            ->__getAll();
    }

    /**
     * @param null $idp
     * @return $this
     */
    public function getParent($idp = null)
    {
        if (!$idp)
            $idp = $this->parent_id;

        $categoryparent = self::find($idp);
        if ($idp = $categoryparent->getParent_id())
            $this->getParent($idp);
        else
            return $categoryparent;
    }

    public function collectChildren($limit = 10)
    {
        $count = self::select()->where("parent_id", $this->id)->__countEl();
        if ($count)
            return self::select()->where("parent_id", $this->id)
                ->limit($limit)
                ->__getAll();

        return [];

    }

    public function setParents_id($parent_idsarray)
    {

        if ($parent_idsarray) {
            $this->chain = implode(" ", array_keys($parent_idsarray));
        }
    }

    public function getParents_id()
    {

        if (!$this->chain)
            return false;

        $returns = [];
        $arrays = explode(' ', $this->chain);
        foreach ($arrays as $val) {
            $returns[$val] = $val;
        }

        return $returns;

    }

    public function getParentsCatTree()
    {
        $categorytree = [];
        if ($this->chain)
            $categorytree = self::whereIn("id", explode(",", $this->chain))->get();

        return $categorytree;
    }

//        public function getAttributesCat(){
//            $categoryattribut = Attribute::whereIn("category_id", explode(",", $this->chain))->get();
//
//            return $categoryattribut;
//        }

    public function ofSameTree()
    {
        $categoryparent = self::find($this->parent_id);
        return $categoryparent->collectChildren(25);
    }

    public static function getmainmenu($tree = "menu")
    {
        return self::where("tree.name", $tree)
            ->andwhere("main", 1)
            ->orderby("position")
            //->limit(5)
            ->__getAll();
    }
}
