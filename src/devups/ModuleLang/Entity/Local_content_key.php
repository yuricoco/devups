<?php
// user \dclass\devups\model\Model;

/**
 * @Entity @Table(name="local_content_key")
 * */
class Local_content_key extends Model implements JsonSerializable
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

    public function getReference()
    {
        return $this->reference;
    }

    public function setReference($reference)
    {
        $this->reference = $reference;
    }


    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'reference' => $this->reference,
        ];
    }


    public static function key_sanitise($str, $charset = 'utf-8')
    {
        $str = htmlentities($str, ENT_NOQUOTES, $charset);

        $str = preg_replace('#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str);
        $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str); // pour les ligatures e.g. '&oelig;'
        $str = preg_replace('#&[^;]+;#', '', $str); // supprime les autres caractères
        return strtolower(str_replace("'", '', $str)); // supprime les autres caractères
        ///return str_replace(' ', '_', $str); // supprime les autres caractères
    }

}
