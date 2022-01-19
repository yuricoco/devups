<?php
// user \dclass\devups\model\Model;

/**
 * @Entity @Table(name="status")
 * */
class Status extends Model implements JsonSerializable
{

    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     * */
    protected $id;
    /**
     * @Column(name="color", type="string" , length=25 )
     * @var string
     **/
    protected $color;
    /**
     * @Column(name="_key", type="string", length=55, nullable=true  )
     * @var integer
     **/
    protected $_key;
    /**
     * @Column(name="label", type="string" , length=55, nullable=true )
     * @var string
     **/
    protected $label;
    /**
     * @Column(name="position", type="integer", nullable=true )
     * @var string
     **/
    protected $position = 1;
    /**
     * @Column(name="description", type="text" , nullable=true )
     * @var string
     **/
    protected $description;

    /**
     * @ManyToOne(targetEntity="\Dvups_entity")
     * @var \Dvups_entity
     */
    public $entity;

    public function __construct($id = null)
    {

        if ($id) {
            $this->id = $id;
        }

        $this->entity = new Dvups_entity();
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Dvups_entity
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * @param Dvups_entity $entity
     */
    public function setEntity(Dvups_entity $entity)
    {
        $this->entity = $entity;
    }

    /**
     * @param Dvups_entity $entity
     */
    public function setEntityid($entityid)
    {
        $this->entity = Dvups_entity::find($entityid);
    }

    /**
     * @return string
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @return string
     */
    public function getPositionLabel()
    {
        return "<span class='position'>" . $this->position . "</span><i class='fa fa-map'></i>";
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
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getColor()
    {
        return $this->color;
    }

    public function getColortab()
    {
        return "<span class='dv-color' style='background: " . $this->color . "; color: #333333 '>" . $this->label . "</span>";
    }
    public function __toString()
    {
        return "<span class='dv-color' style='background: " . $this->color . "; color: #333333 '>" . $this->label . "</span>";
    }

    public function setColor($color)
    {
        $this->color = $color;
    }

    public function getKey()
    {
        return $this->_key;
    }

    public function get_key()
    {
        return $this->_key;
    }

    public function setKey($_key)
    {
        $this->_key = $_key;
    }

    public function set_key($_key)
    {
        $this->_key = $_key;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function setLabel($label)
    {
        $this->label = $label;
    }

    public function is($key)
    {
        if ($this->_key == $key)
            return true;

        return false;
    }

    public function jsonSerialize()
    {
        $return = [
            'id' => $this->id,
            'color' => $this->color,
            '_key' => $this->_key,
            'label' => $this->label,
            'colortab' => $this->getColortab(),
        ];
        if (Request::get("stat")) {
            $qb = Order::where($this);
            if ($id = Request::get("affiliate_id"))
                $qb->where("affiliate.id", $id);
            if ($id = Request::get("order_id"))
                $qb->where("order.id", $id);
            if ($id = Request::get("user_id"))
                $qb->where("user.id", $id);
            $nb_element = $qb->count();

            $return["stat"] = $nb_element;
        }

        return $return;
    }

    public static function get($key)
    {
        return self::getbyattribut("this._key", $key);
    }

    /**
     * @param $key
     * @param null $entityname
     * @return Status|type|null
     */
    public static function getStatus($key, $entityname = null)
    {
        if ($entityname)
            return self::where("this._key", "=", $key)->where("entity.name", $entityname)->first();

        return self::getbyattribut("this._key", $key);
    }

    public static function getStatusPosition($position, $entity = null)
    {
        if ($entity)
            return self::where("this.position", "=", $position)->where("entity.name", $entity)->__first();
        return self::getbyattribut("this.position", $position);
    }


    public static function getStatusOf($entity)
    {
        return Status::where("entity.name", $entity);
    }

}
