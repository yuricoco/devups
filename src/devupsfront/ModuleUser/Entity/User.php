<?php
// user \dclass\devups\model\Model;

/**
 * @Entity @Table(name="user")
 * */
class User extends Model implements JsonSerializable
{

    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     * */
    protected $id;
    /**
     * @Column(name="firstname", type="string" , length=55 )
     * @var string
     **/
    protected $firstname;
    /**
     * @Column(name="lastname", type="string" , length=55)
     * @var string
     **/
    protected $lastname;

    /**
     * @Column(name="email", type="string" , length=55 , nullable=true)
     * @var string
     **/
    protected $email;
    /**
     * @Column(name="sex", type="string" , length=5 , nullable=true)
     * @var string
     **/
    protected $sex;
    /**
     * @Column(name="telephone", type="string" , length=25 , nullable=true)
     * @var string
     **/
    protected $telephone;
    /**
     * @Column(name="password", type="string" , length=255 , nullable=true)
     * @var string
     **/
    protected $password;
    /**
     * @Column(name="resettingpassword", type="integer"  , nullable=true)
     * @var integer
     **/
    protected $resettingpassword;
    /**
     * @Column(name="is_activated", type="integer"  , nullable=true)
     * @var integer
     **/
    protected $is_activated = 1;

    /**
     * @Column(name="activationcode", type="string" , length=255 , nullable=true)
     * @var string
     **/
    protected $activationcode;
    /**
     * @Column(name="birthdate", type="date"  , nullable=true)
     * @var date
     **/
    protected $birthdate;
    /**
     * @Column(name="lang", type="string" , length=15 , nullable=true)
     * @var string
     **/
    protected $lang;
    /**
     * @Column(name="username", type="string" , length=55 , nullable=true )
     * @var string
     **/
    protected $username;


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


    public function getFirstname()
    {
        return $this->firstname;
    }

    public function setFirstname($firstname)
    {
        // code de validation
        if ($firstname == "")
            return "the firstname field is important!";

        $this->firstname = $firstname;
    }

    public function getLastname()
    {
        return $this->lastname;
    }

    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $nb = User::where("email", $email);
        if ($nb->__countEl()) {
            if ($nb->__getOne()->getId() != $this->id)
                return "a user with this email already exist";
        }
        $this->email = $email;
    }


    public function getSex()
    {
        return $this->sex;
    }

    public function setSex($sex)
    {
        $this->sex = $sex;
    }

    public function getTelephone()
    {
        return $this->telephone;
    }

    public function setTelephone($telephone)
    {
        $nb = User::where("telephone", $telephone);
        if ($nb->__countEl()) {
            if ($nb->__getOne()->getId() != $this->id)
                return "a user with this email already exist";
        }
        $this->telephone = $telephone;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function setConfirmpassword($password)
    {

        if ($this->password != $password)
            return "You may enter the same password";

    }

    public function getResettingpassword()
    {
        return $this->resettingpassword;
    }

    public function setResettingpassword($resettingpassword)
    {
        $this->resettingpassword = $resettingpassword;
    }

    public function getIs_activated()
    {
        return $this->is_activated;
    }

    public function setIs_activated($is_activated)
    {
        $this->is_activated = $is_activated;
    }

    public function getActivationcode()
    {
        return $this->activationcode;
    }

    public function setActivationcode($activationcode)
    {
        $this->activationcode = sha1($activationcode);
    }


    public function getBirthdate()
    {
        return $this->birthdate;
    }

    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;
    }

    public function getCreationdate()
    {
        return $this->creationdate;
    }

    public function getLang()
    {
        return $this->lang;
    }

    public function setLang($lang)
    {
        $this->lang = $lang;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     *  manyToOne
     * @return \Country
     */
    function getCountry()
    {
        $this->country = $this->country->__show();
        return $this->country;
    }

    function setCountry(\Country $country)
    {
        $this->country = $country;
    }

    /**
     */
    function getTown()
    {
        return $this->town;
    }

    function setTown($town)
    {
        $this->town = $town;
    }


    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'sex' => $this->sex,
            'telephone' => $this->telephone,
            'password' => $this->password,
            'resettingpassword' => $this->resettingpassword,
            'is_activated' => $this->is_activated,
            'activationcode' => $this->activationcode,
            'birthdate' => $this->birthdate,
            'lang' => $this->lang,
            'username' => $this->username,
        ];
    }

    /**
     * @return \User
     */
    public static function userapp()
    {

        if (isset($_SESSION[USER]))
            return unserialize($_SESSION[USER]);

        return new \User();
    }

    public function isActivated()
    {
        return boolval($this->is_activated);
    }

}
