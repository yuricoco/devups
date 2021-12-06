<?php
// user \dclass\devups\model\Model;

/**
 * @Entity @Table(name="configuration")
 * */
class Configuration extends Model implements JsonSerializable
{

    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     * */
    protected $id;
    /**
     * @Column(name="comment", type="text" , nullable=true )
     * @var string
     **/
    protected $comment;
    /**
     * @Column(name="_key", type="string" , length=150 )
     * @var string
     **/
    protected $_key;
    /**
     * @Column(name="_value", type="string" , length=255 )
     * @var string
     **/
    protected $_value;
    /**
     * @Column(name="_type", type="string" , length=150 , nullable=true)
     * @var string
     **/
    protected $_type = "string";


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

    public function get_key()
    {
        return $this->_key;
    }

    public function set_key($_key)
    {

        $this->_key = $_key;

        $entity = self::where("_key", $_key)->first();
        if ($entity && $entity->getId() != $this->id) {
            return t("A constante with same key already exist");
        }

    }

    public function get_value()
    {
        return $this->_value;
    }

    public function set_value($_value)
    {
        $this->_value = $_value;
    }

    public function get_type()
    {
        return $this->_type;
    }

    public function set_type($_type)
    {
        $this->_type = $_type;
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            '_key' => $this->_key,
            '_value' => $this->_value,
            '_type' => $this->_type,
        ];
    }

    public static function get($key)
    {
        return self::getbyattribut("_key", $key)->get_value();
    }

    public static function set($key, $value, $type = "string", $comment = "")
    {

        $cf = self::getbyattribut("_key", $key);
        $cf->set_key($key);
        $cf->set_value($key);
        if (!$cf->getId()) {
            $cf->set_type($key);
            $cf->setComment($key);
        }
        $cf->__save();

    }

    public static function buildConfig()
    {
        $configs = Configuration::allrows();
        $filecontent = "<?php
        
        /**
        
            Configuration of the application
        
        */
        define('ROOT', __DIR__  . '/../');
        ";

        foreach ($configs as $config) {
            $filecontent .= '
            /**
                ' . $config->getComment() . '
            */
            ';
            if ($config->get_type() != "string")
                $filecontent .= "define('" . $config->get_key() . "', " . $config->get_value() . ");\n";
            else {
                preg_match_all("/\{([^\}]*)\}/", $config->get_value(), $matches);

                if ($matches[1]) {
                    $configkey = $matches[1][0];
                    // $configuration = self::getbyattribut("_key", $configkey);
                    $value = str_replace($matches[0][0], "", $config->get_value());

                    $filecontent .= "define('" . $config->get_key() . "', " . $configkey . ".'" . $value . "');\n";
                } else {
                    $filecontent .= "define('" . $config->get_key() . "', '" . $config->get_value() . "');\n";
                }
            }
        }

        $filename = "constante_test.php";
        if (file_exists(ROOT . "config/" . $filename))
            unlink(ROOT . "config/" . $filename);

        \DClass\lib\Util::log(ROOT . "config/", $filename, $filecontent);

    }

}
