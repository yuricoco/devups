<?php

/**
 * @Entity @Table(name="country")
 * */
class Country extends \Model implements JsonSerializable
{

    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     * */
    protected $id;
    /**
     * @Column(name="name", type="string" , length=255 )
     * @var string
     **/
    protected $name;
    /**
     * @Column(name="iso", type="string" , length=255 )
     * @var string
     **/
    protected $iso;
    /**
     * @Column(name="iso3", type="string" , length=255 )
     * @var string
     **/
    protected $iso3;
    /**
     * @Column(name="nicename", type="string" , length=255 )
     * @var string
     **/
    protected $nicename;
    /**
     * @Column(name="numcode", type="string" , length=255 )
     * @var string
     **/
    protected $numcode;
    /**
     * @Column(name="phonecode", type="integer"  )
     * @var integer
     **/
    protected $phonecode;
    /**
     * @Column(name="status", type="integer"  )
     * @var integer
     **/
    protected $status;


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

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getPhonecode()
    {
        return $this->phonecode;
    }

    public function setPhonecode($phonecode)
    {
        $this->phonecode = $phonecode;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }


    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'phonecode' => $this->phonecode,
            'iso' => $this->iso,
            'status' => $this->status,
        ];
    }

    public function tvas()
    {
        return $this->__hasmany(Tva::class);
    }

    public function showFlag()
    {
        return '<img alt="' . $this->name . '" src="' . assets("image/flags/" . strtolower($this->iso)) . '.png"/>';
    }

    public function availablePaymentMethod()
    {
        $paymentmethods = $this->__hasmany(Payment_method::class, false)
            //->andwhere("this.status", "active")
            ->__getAll();
        return $paymentmethods;
    }

}
