<?php
// user \dclass\devups\model\Model;

/**
 * @Entity @Table(name="user")
 * */
class User extends UserCore implements JsonSerializable
{

    public static $currentid;
    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     * */
    protected $id;


    /**
     * @Column(name="spacekola_ref", type="integer" , nullable=true)
     * @var string
     **/
    protected $spacekola_ref;

    /**
     * @Column(name="sexe", type="string" , length=5 , nullable=true)
     * @var string
     **/
    protected $sexe;
    /**
     * @Column(name="phonenumber", type="string" , length=25 , nullable=true)
     * @var string
     **/
    protected $phonenumber;

    /**
     * @Column(name="birthdate", type="date"  , nullable=true)
     * @var date
     **/
    protected $birthdate;


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

    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->api_key;
    }

    /**
     * @param string $api_key
     */
    public function setApiKey($api_key)
    {
        $this->api_key = $api_key;
    }

    public function getLastLogin()
    {
        return $this->last_login;
    }

    /**
     * @param date $last_login
     */
    public function setLastLogin($last_login)
    {
        $this->last_login = $last_login;
    }

    public function setConfirm($confirm){

        if($this->getPassword() != md5($confirm))
            return t("Mot de passe incorrect. veuillez reessayer svp!");

    }

    /**
     * @return string
     */
    public function getSpacekolaRef()
    {
        return $this->spacekola_ref;
    }

    /**
     * @param string $spacekola_ref
     */
    public function setSpacekola_ref($spacekola_ref)
    {
        $this->spacekola_ref = $spacekola_ref;
    }

    /**
     * @return Status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param Status $status
     */
    public function setStatus(Status $status)
    {
        $this->status = $status;
    }


    public function getFirstname()
    {
        return $this->firstname;
    }

    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }
    public function setUpdatePassword($pwd)
    {
        if($pwd)
            $this->password = md5(sha1($pwd));
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
        $this->email = $email;
    }

    public function getSexe()
    {
        return $this->sexe;
    }

    public function setSexe($sexe)
    {
        $this->sexe = $sexe;
    }

    public function getPhonenumber()
    {
        return $this->phonenumber;
    }

    public function setPhonenumber($phonenumber)
    {
        $this->phonenumber = $phonenumber;
    }

    public function getPassword()
    {
        return $this->password;
    }
   /* public function getResettingpassword()
    {
        return $this->resettingpassword;
    }*/

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

    public function setCountry_iso($iso_code)
    {
        $this->country = Country::getbyattribut("iso", $iso_code);
    }

    public function getActivationcode()
    {
        return $this->activationcode;
    }

    public function setActivationcode($activationcode)
    {

        $this->activationcode = sha1($activationcode);
        $this->activationcode_expired_at = date("Y-m-d H:i:s", strtotime("+3 hours", strtotime(date("Y-m-d H:i:s"))));

    }


    public function getBirthdate()
    {
        return $this->birthdate;
    }

    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;
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
     *  manyToOne
     * @return \Town
     */
    function getTown()
    {
        $this->town = $this->town->__show();
        return $this->town;
    }

    function setTown(\Town $town)
    {
        $this->town = $town;
    }

    function userdata()
    {
        return [
            'id' => $this->id,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'username' => $this->username,
            'spacekola_ref' => $this->spacekola_ref,
        ];
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'firstname' => $this->firstname,
            'spacekola_ref' => $this->spacekola_ref,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'sexe' => $this->sexe,
            'phonenumber' => $this->phonenumber,
            'password' => $this->password,
            'resettingpassword' => $this->resettingpassword,
            'is_activated' => $this->is_activated,
            'activationcode' => $this->activationcode,
            'birthdate' => $this->birthdate,
            'lang' => $this->lang,
            'username' => $this->username,
            'api_key' => $this->api_key,
            'session_token' => $this->session_token,
        ];
    }

    public function __insert()
    {
        $this->is_activated = 0;
        return parent::__insert(); // TODO: Change the autogenerated stub
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

    public function updateSession()
    {
        $_SESSION[USER] = serialize(User::find($this->id));
    }

    public function isActivated()
    {
        return boolval((int) $this->is_activated);
    }

    public function addresses()
    {
        return $this->__hasmany(Address::class);
    }

    public static function currentCountry()
    {
        $user = self::userapp();
        if ($user->getId()) {
            return $user->country->getIso();
        }

        return Country::current();

    }

    /**
     * return the phonenumber with the country phone code.
     * @return string
     */
    public function getTelephone(){
        return $this->country->getPhonecode().$this->phonenumber;
    }

    /**
     * return the phonenumber with the country phone code.
     * @return string
     */
    public function getPendingOrder($transporter){
        return Order::where(Status::get("pending"))
            ->andwhere($this)->andwhere($transporter)->__getOne();
    }

}
