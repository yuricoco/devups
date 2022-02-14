<?php


class UserCore extends \Model implements JsonSerializable
{

    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     * */
    protected $id;
    /**
     * @Column(name="firstname", type="string" , length=55 , nullable=true )
     * @var string
     **/
    protected $firstname;
    /**
     * @Column(name="lastname", type="string" , length=55 , nullable=true)
     * @var string
     **/
    protected $lastname;
    /**
     * @Column(name="username", type="string" , length=55 , nullable=true)
     * @var string
     **/
    protected $username;

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername( $username)
    {
        $this->username = $username;
    }

    /**
     * @Column(name="email", type="string" , length=55 , nullable=true)
     * @var string
     **/
    protected $email;

    /**
     * @Column(name="phonenumber", type="string" , length=25 , nullable=true)
     * @var string
     **/
    protected $phonenumber;
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
     * @Column(name="activationcode_expired_at", type="date", nullable=true)
     * @var string
     **/
    protected $activationcode_expired_at;

    /**
     * @Column(name="last_login", type="date"  , nullable=true)
     * @var date
     **/
    protected $last_login;
    /**
     * @Column(name="lang", type="string" , length=15 , nullable=true)
     * @var string
     **/
    protected $lang;
    /**
     * @Column(name="api_key", type="string" , length=255 , nullable=true )
     * @var string
     **/
    protected $api_key;
    /**
     * @Column(name="session_token", type="string" , length=255 , nullable=true)
     * @var string
     **/
    protected $session_token;

    public function setTelephoneOrEmail($value)
    {
        //return $this->setEmail($value);
        // code de validation
        if (is_numeric($value)) {
            return $this->setPhonenumber($value);
        }
        return $this->setEmail($value);

    }

    public function setEmail($email)
    {
        if (!$email)
            return null;

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return t("Fomat de l'adresse email invalide");
        }

        $nb = User::where("email", $email);
        if ($nb->count()) {
            if ($nb->first()->getId() != $this->id)
                return t("a user with this :attribute already exist", ["attribute" => "email"]);
        }
        $this->email = $email;
    }

    public function setPhonenumber($phonenumber)
    {
        if (!$phonenumber)
            return null;

        $phonenumber = \DClass\lib\Util::sanitizePhonenumber($phonenumber, $this->country->getPhonecode());

        $nb = User::where("phonenumber", $phonenumber);
        if ($nb->count()) {
            if ($nb->first()->getId() != $this->id)
                return t("a user with this :attribute already exist", ["attribute" => "phonenumber"]);
        }
        $this->phonenumber = $phonenumber;
    }

    public function setPassword($password)
    {
        if(!$password)
            return null;

        $this->password = $password;
    }
    public function setResetpassword ($password)
    {
        if(!$password)
            return null;

        $this->password = sha1($password);
    }

    public function setTelephone($telephone)
    {
        $this->setPhonenumber($telephone);
        /*if (!$telephone)
            return null;

        $telephone = self::sanitizePhonenumber($telephone, $this->country->getPhonecode());

        $nb = User::where("telephone", $telephone);
        if ($nb->count()) {
            if ($nb->first()->getId() != $this->id)
                return t("a user with this :attribute already exist", ["attribute" => "telephone"]);
        }
        $this->telephone = $telephone;*/
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

    public static function generateActivationCode()
    {
        return password_hash(\DClass\lib\Util::randomcode(), PASSWORD_DEFAULT);
    }

    public static function availableToken($token, $route)
    {

        global $user;
        if(__prod)
            $user = User::select("*")->where_str(" '$token' = CONCAT(api_key, '.', session_token) ")
                ->firstOrNull();
        else
            $user = User::find($token);

        if ($user) {
            return $route($user);
        }
        return [
            "success" => false,
            "detail" => t("session token unavailable"),
        ];

    }

    /**
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname( $firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     */
    public function setLastname( $lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }


    /**
     * @return int
     */
    public function getResettingpassword()
    {
        return $this->resettingpassword;
    }

    /**
     * @param int $resettingpassword
     */
    public function setResettingpassword( $resettingpassword)
    {
        $this->resettingpassword = $resettingpassword;
    }

    /**
     * @return int
     */
    public function getIsActivated()
    {
        return $this->is_activated;
    }

    /**
     * @param int $is_activated
     */
    public function setIsActivated( $is_activated)
    {
        $this->is_activated = $is_activated;
    }

    /**
     * @return string
     */
    public function getActivationcode()
    {
        return $this->activationcode;
    }

    /**
     * @param string $activationcode
     */
    public function setActivationcode( $activationcode)
    {
        $this->activationcode = $activationcode;
    }

    /**
     * @return date
     */
    public function getLastLogin()
    {
        return $this->last_login;
    }

    /**
     * @param date $last_login
     */
    public function setLastLogin( $last_login)
    {
        $this->last_login = $last_login;
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
    public function setLang( $lang)
    {
        $this->lang = $lang;
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
    public function setApiKey( $api_key)
    {
        $this->api_key = $api_key;
    }

    /**
     * @return string
     */
    public function getSessionToken()
    {
        return $this->session_token;
    }

    /**
     * @param string $session_token
     */
    public function setSessionToken(  $session_token)
    {
        $this->session_token = $session_token;
    }

    /**
     * @param $token
     * @return User|null
     */
    public static function getUserByToken($token){

        return User::select("*")->where_str(" '$token' = CONCAT(api_key, '.', session_token) ")
            ->firstOrNull();

    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getTelephone(){
        return $this->country->phonecode.$this->phonenumber;
    }

    public function mapAvailableData($userbaseinfo)
    {

        $synchronized = [];
        foreach ($userbaseinfo as $key => $value) {
            if (in_array($key, self::$paramsynch))
                $synchronized[$key] = $value;
        }
        return $synchronized;
    }

    public static $paramsynch;

    public function jsonSerialize()
    {

        if (Request::get("synchro", null)) {
            return $this->mapAvailableData($this);
        }// TODO: Change the autogenerated stub
    }



}