<?php
// user \dclass\devups\model\Model;

/**
 * @Entity @Table(name="cmstext_lang")
 * */
class Cmstext_lang extends Model
{

    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     * */
    protected $id;
    /**
     * @Column(name="title", type="string" , length=255 , nullable=true)
     * @var string
     **/
    protected $title;
    /**
     * @Column(name="content", type="text"  )
     * @var text
     **/
    protected $content;
    /**
     * @Column(name="lang_id", type="integer")
     * @var string
     **/
    protected $lang_id ;
    /**
     * @Column(name="cmstext_id", type="integer")
     * @var string
     **/
    protected $cmstext_id ;

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

    public function getTitle()
    {
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

    public function getLang()
    {
        return $this->lang;
    }

    public function setLang($lang)
    {
        $this->lang = $lang;
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

}
