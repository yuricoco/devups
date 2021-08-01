<?php
// user \dclass\devups\model\Model;

/**
 * @Entity @Table(name="tree_item")
 * */
class Tree_item extends Model implements JsonSerializable, DvupsTranslation
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
     * @Column(name="content", type="text"  , nullable=true)
     * @var text
     **/
    protected $content;
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

    public static function position($ref)
    {
        $ti = self::mainmenu("position")->andwhere("this.name", $ref)->__firstOrNull();
        if (!$ti) {
            return new Tree_item();
            $tree = Tree::where("name", "position")->__getOne();
            if (!Tree::where("name", "position")->count()) {
                $tree = new Tree();
                $tree->setName("position");
                $tree->__insert();
            }
            $ti = new Tree_item();
            $ti->setName($ref);
            $ti->setMain(1);
            $ti->setSlug($ref);
            $ti->tree = $tree;
            $ti->__insert();
        }
        return $ti;
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

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
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
        $namelangs = [];
        foreach (Dvups_lang::otherLangs() as $lang) {
            $namelangs["name_".$lang->getIso_code()] = $this->__gettranslate("name", $lang->getIso_code(), $this->name);
        }
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'position' => (int)$this->position,
            'content' => $this->content,
            'parent_id' => $this->parent_id,
            'main' => $this->main,
            'status' => $this->status,
            'chain' => $this->chain,
            'tree' => $this->tree,
            'content_id' => $this->getCmstext()->getId(),
            'children' => (int)self::where("parent_id", $this->id)->__countEl(),
        ]+$namelangs;
    }

    public function getChildren($category = null)
    {
        if (!$category)
            $category = new Tree_item();

        return self::select()
            ->where("this.parent_id", $this->id)
            //->andwhere("this.id", "!=", $category->getId())
            ->orderby("this.position")
            ->__getAll();
    }

    public static function childrenOf(string $slug)
    {
        return self::select()
            ->where("this.parent_id")
            ->in(" select id from tree_item where slug = '$slug' ")
            ->orderby("this.position")
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

    /**
     * @param string $tree
     * @return QueryBuilder
     */
    public static function mainmenu($tree = "menu")
    {
        return self::where("tree.name", $tree)
            ->andwhere("main", 1);
    }

    /**
     * @param string $tree
     * @return QueryBuilder
     */
    public static function mainmenus($trees = ["menu"])
    {
        return self::where("tree.name")->in($trees)
            ->andwhere("main", 1);
    }

    /**
     * @param string $tree
     * @return array
     */
    public static function getmainmenu($tree = "menu")
    {
        return self::where("tree.name", $tree)
            ->andwhere("main", 1)
            ->orderby("position")
            //->limit(5)
            ->__getAll();
    }

    public function getCmstext()
    {
        return Cmstext::where($this)
            ->__getOne();
    }

    public static function children($id)
    {

        return self::select()
            ->where("this.parent_id", $id)
            ->orderby("this.position")
            ->__getAll();
    }

    public function dvupsTranslate()
    {
        // we can iterate on howmuch lang the system may have to initiate all the lang of the new entry

        $this->__inittranslate([
            "name" => $this->name
        ], Dvups_lang::defaultLang());

        $langs = \Dvups_lang::otherLangs();
        foreach ($langs as $lang) {
            if(!isset(Request::$uri_raw_param["tree_item"]["name_".$lang->getIso_code()]))
                continue;

            $this->__inittranslate([
                "name" => Request::$uri_raw_param["tree_item"]["name_".$lang->getIso_code()]
            ], $lang);

        }
/*
        if (!isset(Request::$uri_raw_param["tree_item"]["namelangs"])) {

            $namelangs[] = $this->__inittranslate("name", $this->name, "fr");
            $namelangs[] = $this->__inittranslate("name", $this->name, "en");

        } else
            foreach (Request::$uri_raw_param["tree_item"]["namelangs"] as $namelang) {
                $this->__inittranslate("name", $namelang["content"], $namelang["lang"]);
            }*/

    }

    public function images()
    {
        $items = $this->__hasmany(Tree_item_image::class, true, null, true);
        $success = true;
        return compact("items", "success");
    }

    /**
     * @return Tree_item_image|null
     */
    public function firstImage()
    {
        return $this->__hasmany(Tree_item_image::class, false)->__getFirst(true);
    }

}
