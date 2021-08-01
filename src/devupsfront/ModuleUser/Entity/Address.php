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
     * @Column(name="phonenumber", type="string", length=150, nullable=true  )
     * @var integer
     **/
    protected $phonenumber;
    /**
     * @Column(name="lastname", type="string" , length=255 , nullable=true )
     * @var string
     **/
    protected $lastname;
    /**
     * @Column(name="address", type="string" , length=255, nullable=true )
     * @var string
     **/
    protected $address;
    /**
     * @Column(name="postalcode", type="string" , length=255 , nullable=true)
     * @var string
     **/
    protected $postalcode;
    /**
     * @Column(name="label", type="string" , length=255, nullable=true )
     * @var string
     **/
    protected $label;
    /**
     * @Column(name="town", type="string" , length=255 , nullable=true )
     * @var string
     **/
    protected $town;
    /**
     * @Column(name="town_slug", type="string" , length=255 , nullable=true )
     * @var string
     **/
    protected $town_slug;
    /**
     * @Column(name="region", type="string" , length=255, nullable=true )
     * @var string
     **/
    protected $region;
    /**
     * @Column(name="email", type="string" , length=255, nullable=true )
     * @var string
     **/
    protected $email;

    /**
     * @ManyToOne(targetEntity="\User")
     * , inversedBy="reporter"
     * @var \User
     */
    public $user;

    /**
     * @ManyToOne(targetEntity="\Country")
     * , inversedBy="reporter"
     * @var \Country
     */
    public $country;

    public function __construct($id = null)
    {

        $this->dvsoftdelete = true;
        if ($id) {
            $this->id = $id;
        }

        $this->user = new User();
        $this->country = new Country();

    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
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
        if(!$firstname)
            return t("Le champ nom est important!");
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

    public function setTown_slug($town)
    {
        $this->town_slug = $town;
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
            'label' => $this->label,
            'user' => $this->user,
            'country' => $this->user->country,
            'town' => $this->town,
            'town_slug' => $this->town_slug,
            'region' => $this->region,
        ];
    }

    function configAddress(){
        if($this->address)
            return $this->address;

        return t("bs24.address","Central Square, 22 Hoi Wing Road, New Delhi, India");

    }
    function configPhonenumber(){
        if($this->phonenumber)
            return $this->phonenumber;

        return t("bs24.telephone","(+237) 233 41 63 48 ");

    }
    function configEmail(){
        if($this->email)
            return $this->email;

        return t("bs24.email","info@buyamsellam24.com");

    }

}
