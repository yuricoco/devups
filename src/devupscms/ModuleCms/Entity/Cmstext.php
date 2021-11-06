<?php
// user \dclass\devups\model\Model;

/**
 * @Entity @Table(name="cmstext")
 * */
class Cmstext extends Model implements JsonSerializable, DatatableOverwrite, DvupsTranslation
{

    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     * */
    protected $id;
    /**
     * @Dvups(multilang=true)
     * @Column(name="title", type="string" , length=255 , nullable=true)
     * @var string
     **/
    protected $title;
    /**
     * @Column(name="reference", type="string" , length=125 , nullable=true)
     * @var string
     **/
    protected $reference;
    /**
     * @Column(name="slug", type="string" , length=255 , nullable=true)
     * @var string
     **/
    protected $slug;
    /**
     * @Column(name="content", type="text"  )
     * @var text
     **/
    protected $content;
    /**
     **/
    public static $LANGS = ['en' => 'En', 'fr' => 'Fr'];
    public static $ACTIVES = ['non', 'yes'];

    /**
     * @Column(name="sommary", type="text", nullable=true  )
     * @var text
     * */
    protected $sommary = "";

    /**
     * @Column(name="active", type="integer" )
     * @var text
     * */
    protected $active = 0;
    /**
     * @Column(name="position", type="integer" )
     * @var text
     * */
    protected $position = 0;

    /**
     * @ManyToOne(targetEntity="\Tree_item")
     * @var \Tree_item
     */
    public $tree_item;


    public function __construct($id = null)
    {

        if ($id) {
            $this->id = $id;
        }

        $this->tree_item = new Tree_item();

    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle($lang = null)
    {
        //return self::__gettranslate( "title", $lang, $this->title);
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
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

    public function getReference()
    {
        return $this->reference;
    }

    public function setReference($reference)
    {
        $this->reference = $reference;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return text
     */
    public function getSommary()
    {
        return $this->sommary;
    }

    /**
     * @param string $sommary
     */
    public function setSommary($sommary)
    {
        $this->sommary = $sommary;
    }

    /**
     * @return text
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param text $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * @return text
     */
    public function getPosition()
    {
        return $this->position;
    }

    public function getLink()
    {
        if($this->reference)
            return $this->reference;
        else
            return route("publications?id=".$this->id);
    }

    /**
     * @param text $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }

    /**
     * @return Tree_item
     */
    public function getTree_item()
    {
        return $this->tree_item;
    }

    /**
     * @param Tree_item $tree_item
     */
    public function setTree_item($tree_item)
    {
        $this->tree_item = $tree_item;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'reference' => $this->reference,
            'content' => $this->content,
        ];
    }

    /**
     * @inheritDoc
     */
    public function editAction($btarray)
    {
        return '<a class="btn btn-warning"  href="'.self::classpath("cmstext/edit?id=").$this->id.'"> edit</a>';
    }

    /**
     * @inheritDoc
     */
    public function showAction($btarray)
    {
        // TODO: Implement showAction() method.
    }

    /**
     * @inheritDoc
     */
    public function deleteAction($btarray)
    {
        // TODO: Implement deleteAction() method.
    }

    public static function getActiveCmstext(){
        return Cmstext::where(Tree_item::getbyattribut("this.name", "news"))
            ->andwhere("active", 1);
    }

    const langs = ["title", "content"];
    public function dvupsTranslate()
    {

        $lang = \Dvups_lang::defaultLang();
        $this->__inittranslate([
            "title" => self::post("title"),
            "content" => self::post("content"),
        ], $lang);

        $langs = \Dvups_lang::otherLangs();
        foreach ($langs as $lang) {
            $this->__inittranslate([
                "title" => self::post("title_".$lang->getIso_code()),
                "content" => self::post("content_".$lang->getIso_code(), $this->content),
            ], $lang);
        }

    }
}
