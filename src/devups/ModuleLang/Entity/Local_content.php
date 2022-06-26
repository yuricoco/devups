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
     * @Column(name="reference", type="string" , length=255 )
     * @var string
     **/
    protected $reference;

    /**
     * @ManyToOne(targetEntity="\Local_content_key")
     * @JoinColumn(onDelete="cascade")
     * @var \Local_content_key
     */
    public $local_content_key;


    public function __construct($id = null)
    {

        $this->dvtranslate = true;
        $this->dvtranslated_columns = ["content"];
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

        if($dataset = parent::apimapper())
            return $dataset;

        return [
            'id' => $this->id,
            'reference' => $this->reference,
            'content' => $this->content,
            //'lang' => $this->lang,
            'local_content_key' => $this->local_content_key,
        ];
    }

    public static function generatecacheAction()
    {
        return '<button onclick="model.regeneratecache()" class="btn btn-info">'.t("Regenerate Cache").'</button>';
    }

    public static function getDataLang($id_local_content){

//        $sql = "select lcl.*, l.iso_code from ps_dv_local_content_lang lcl
//                 left join ps_lang l on lcl.id_lang = l.id_lang  where lcl.id_local_content = ".$id_local_content;
        $lcs = self::where("local_content_key_id", $id_local_content)->__getAllRow();

        return ["success"=>true, "data"=>$lcs];
    }

    public static function updateLang()
    {
        $content = Request::post("local_content");
        $idlang = Request::post("idlang");
        $id = Request::get("id");
        // $idlang = Dvups_lang::getByIsoCode(Request::get("iso"))->id;

        return DBAL::_updateDbal("local_content_lang",["content"=>$content], " lang_id = $idlang AND local_content_id = $id ");
        return Local_content::where("this.id", $id)->update(["content"=>$content]);

    }

}
