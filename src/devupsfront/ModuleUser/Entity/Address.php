<?php
// user \dclass\devups\model\Model;

/**
 * @Entity @Table(name="address")
 * */
class Address extends Model implements JsonSerializable
{

    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     * */
    protected $id;
    /**
     * @Column(name="firstname", type="string" , length=255 )
     * @var string
     **/
    protected $firstname;
    /**
     * @Column(name="description", type="string" , length=255 , nullable=true)
     * @var string
     **/
    protected $description;
    /**
     * @Column(name="phonenumber", type="integer"  )
     * @var integer
     **/
    protected $phonenumber;
    /**
     * @Column(name="lastname", type="string" , length=255 )
     * @var string
     **/
    protected $lastname;
    /**
     * @Column(name="address", type="string" , length=255 )
     * @var string
     **/
    protected $address;
    /**
     * @Column(name="postalcode", type="string" , length=255 , nullable=true)
     * @var string
     **/
    protected $postalcode;
    /**
     * @Column(name="_type", type="integer", nullable=true  )
     * @var integer
     **/
    protected $_type;
    /**
     * @Column(name="label", type="string" , length=255 )
     * @var string
     **/
    protected $label;
    /**
     * @Column(name="town", type="string" , length=255 )
     * @var string
     **/
    protected $town;
    /**
     * @Column(name="town_slug", type="string" , length=255 )
     * @var string
     **/
    protected $town_slug;
    /**
     * @Column(name="region", type="string" , length=255, nullable=true )
     * @var string
     **/
    protected $region;

    /**
     * @ManyToOne(targetEntity="\User")
     * , inversedBy="reporter"
     * @var \User
     */
    public $user;


    public function __construct($id = null)
    {

        if ($id) {
            $this->id = $id;
        }

        $this->user = new User();
        // $this->country = new Country();

    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param Country $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @return string
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * @param string $region
     */
    public function setRegion($region)
    {
        $this->region = $region;
    }

    public function getFirstname()
    {
        return $this->firstname;
    }

    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getPhonenumber()
    {
        return $this->phonenumber;
    }

    public function setPhonenumber($phonenumber)
    {
        $this->phonenumber = $phonenumber;
    }

    public function getLastname()
    {
        return $this->lastname;
    }

    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress($address)
    {
        $this->address = $address;
    }

    public function getPostalcode()
    {
        return $this->postalcode;
    }

    public function setPostalcode($postalcode)
    {
        $this->postalcode = $postalcode;
    }

    public function get_type()
    {
        return $this->_type;
    }

    public function set_type($_type)
    {
        $this->_type = $_type;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     *  manyToOne
     * @return \User
     */
    function getUser()
    {
        $this->user = $this->user->__show();
        return $this->user;
    }

    function setUser(\User $user)
    {
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getTown()
    {
        return $this->town;
    }

    public function getTown_slug()
    {
        return $this->town_slug;
    }

    /**
     * @param string $town
     */
    public function setTown($town)
    {
        $this->town = $town;
        $this->town_slug = remove_accents($town);
    }

    public function jsonSerialize($model = null)
    {
        if ($model == 1)
            return [
                'firstname' => $this->firstname,
                'telephone' => $this->phonenumber,
                'lastname' => $this->lastname,
                'address' => $this->address,
                'email' => $this->user->getEmail(),
                'country_iso' => $this->user->country->getPhonecode(),
                'reference' => "bs24_".$this->id,
            ];

        return [
            'id' => $this->id,
            'firstname' => $this->firstname,
            'description' => $this->description,
            'phonenumber' => $this->phonenumber,
            'lastname' => $this->lastname,
            'address' => $this->address,
            'postalcode' => $this->postalcode,
            '_type' => $this->_type,
            'label' => $this->label,
            'user' => $this->user,
            'country' => $this->user->country,
            'town' => $this->town,
            'town_slug' => $this->town_slug,
            'region' => $this->region,
        ];
    }

}
