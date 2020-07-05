<?php
// user \dclass\devups\model\Model;

/**
 * @Entity @Table(name="local_content")
 * */
class Local_content extends Model implements JsonSerializable
{

    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     * */
    protected $id;
    /**
     * @Column(name="lang", type="string" , length=25 )
     * @var string
     **/
    private $lang;
    /**
     * @Column(name="reference", type="string" , length=255 )
     * @var string
     **/
    private $reference;
    /**
     * @Column(name="content", type="text"  )
     * @var text
     **/
    private $content;

    /**
     * @ManyToOne(targetEntity="\Local_content_key")
     * , inversedBy="reporter"
     * @var \Local_content_key
     */
    public $local_content_key;


    public function __construct($id = null)
    {

        if ($id) {
            $this->id = $id;
        }

        $this->local_content_key = new Local_content_key();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getReference()
    {
        return $this->reference;
    }

    public function setReference($reference)
    {
        $this->reference = $reference;
    }

    /**
     * @return string
     */
    public function getLang()
    {
        return $this->lang;
    }

    /**
     * @param string $lang
     */
    public function setLang($lang)
    {
        $this->lang = $lang;
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
     *  manyToOne
     * @return \Local_content_key
     */
    function getLocal_content_key()
    {
        $this->local_content_key = $this->local_content_key->__show();
        return $this->local_content_key;
    }

    function setLocal_content_key(\Local_content_key $local_content_key)
    {
        $this->local_content_key = $local_content_key;
    }


    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'reference' => $this->reference,
            'content' => $this->content,
            'local_content_key' => $this->local_content_key,
        ];
    }

    public static function generatecacheAction()
    {
        return '<button onclick="model.regeneratecache()" class="btn btn-info">'.t("Regenerate Cache").'</button>';
    }

}
