<?php

/**
 * @Entity @Table(name="dvups_admin")
 * */
class Dvups_admin extends Model implements JsonSerializable
{

    const role_admin_approved_center = "admin_approved_center";
    const role_agent_approved_center = "agent_approved_center";
    const role_admin_center = "admin_center";
    const role_agent_center = "agent_center";
    const role_administrator = "administrator";

    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     * */
    private $id;

    /**
     * @Column(name="lastlogin_at", type="datetime", nullable=true )
     * @var string
     * */
    private $lastlogin_at;
    /**
     * @Column(name="name", type="string" , length=255 )
     * @var string
     * */
    private $name;
    /**
     * @Column(name="phonenumber", type="string" , length=55 )
     * @var string
     * */
    private $phonenumber;
    /**
     * @Column(name="email", type="string" , length=55 )
     * @var string
     * */
    private $email;

    /**
     * @Column(name="login", type="string" , length=255 )
     * @var string
     * */
    private $login;

    /**
     * @Column(name="password", type="string" , length=255 )
     * @var string
     * */
    private $password;

    /**
     * @ManyToOne(targetEntity="\Dvups_role")
     * @var \Dvups_role
     */
    public $dvups_role;

    /**
     * @ManyToOne(targetEntity="\Approved_center")
     * @var \Approved_center
     */
    public $approved_center;


    public function __construct($id = null)
    {
        $this->dvsoftdelete = true;

        if ($id) {
            $this->id = $id;
        }

        $this->dvups_role = new Dvups_role();
        $this->approved_center = new Approved_center();

    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getLastloginAt()
    {
        return $this->lastlogin_at;
    }

    /**
     * @param string $lastlogin_at
     */
    public function setLastloginAt($lastlogin_at)
    {
        $this->lastlogin_at = $lastlogin_at;
    }

    function getName()
    {
        return $this->name;
    }

    function setName($name)
    {
        if (!$name)
            return "name empty";

        $this->name = $name;
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function setLogin($login)
    {
        $this->login = $login;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    function setDvups_role($dvups_role)
    {
        $this->dvups_role = $dvups_role;
    }

    /**
     * @return string
     */
    public function getCentername()
    {
        return $this->getApprovedCenter()->getName();
    }

    /**
     * @return Approved_center
     */
    public function getApprovedCenter()
    {
        return $this->approved_center;
    }

    /**
     * @param string $approved_center_id
     */
    public function setApproved_center($approved_center)
    {
        $this->approved_center = $approved_center;
    }

    /**
     *  manyToMany
     * @return \Dvups_role
     */
    function getDvups_role()
    {
        return $this->dvups_role;
    }

    function collectDvups_role()
    {
        $this->dvups_role = $this->__hasmany('dvups_role');
        return $this->dvups_role;
    }

    function addDvups_role(\Dvups_role $dvups_role)
    {
        $this->dvups_role[] = $dvups_role;
    }

    function dropDvups_roleCollection()
    {
        $this->dvups_role = EntityCollection::entity_collection('dvups_role');
    }

    function availableentityright($action)
    {
        if (isset($this->manageentity[$action])) {
            $entity = $this->manageentity[$action];
            return $entity->availableright();
        }
        return [];
    }

    function callbackbtnAction()
    {
        return "<a class='btn btn-default' href='".Dvups_admin::classpath("dvups-admin/resetcredential?id=" . $this->getId() ). "'>".t('reset password')."</a>";
    }

    function resetCredential()
    {
        $password = $this->generatePassword();
        $this->setPassword(sha1($password));
//        $dvups_admin->setLogin();
        $this->generateLogin($this->getName());

        $this->__save();
        return $password;
//        return [
//            "login" => $this->login,
//            "password" => $this->password,
//        ];
    }

    /**
     * @return string
     */
    public function getPhonenumber()
    {
        return $this->phonenumber;
    }

    /**
     * @param string $phonenumber
     */
    public function setPhonenumber($phonenumber)
    {

        if($error = \DClass\lib\Util::validation($phonenumber))
            return $error;

        $entity = self::where("this.phonenumber", $phonenumber)->__getOne();
        if ($entity->getId() && $entity->getId() != $this->id) {
            return t("Un admin avec ce phonenumber existe deja");
        }

        $this->phonenumber = $phonenumber;
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

        $entity = self::where("this.email", $email)->__getOne();
        if ($entity->getId() && $entity->getId() != $this->id) {
            return t("Un admin avec cet email existe deja");
        }

        $this->email = $email;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'login' => $this->login,
            'password' => $this->password,
            //'dvups_role' => $this->dvups_role,
        ];
    }

    public function __insert()
    {
        $admin = getadmin();
        if($admin->getApprovedCenter()->getId())
            $this->approved_center = $admin->getApprovedCenter();

        return parent::__insert();

    }

    private function wd_remove_accents($str, $charset = 'utf-8')
    {
        $str = htmlentities($str, ENT_NOQUOTES, $charset);

        $str = preg_replace('#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str);
        $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str); // pour les ligatures e.g. '&oelig;'
        $str = preg_replace('#&[^;]+;#', '', $str); // supprime les autres caractères
        return str_replace(' ', '_', $str); // supprime les autres caractères
    }

    /**
     * @param mixed $login
     */
    public function generateLogin()
    {//on envoi une liste de login
        $list = "1234567890";
        mt_srand((double)microtime() * 10000);
        $generate = "";
        while (strlen($generate) < 4) {
            $generate .= $list[mt_rand(0, strlen($list) - 1)];
        }

        if (strlen($this->name) > 6)
            $alias = substr($this->name, 0, -(strlen($this->name) - 6));
        else
            $alias = $this->name;

        $this->login = $this->wd_remove_accents($alias) . $generate;
        $login = strtolower($this->login);
        return $login;
    }

    /**
     * @param mixed
     */
    public function generatePassword()
    {
        $list = "0123456789abcdefghijklmnopqrstvwxyz";
        mt_srand((double)microtime() * 1000000);
        $password = "";
        while (strlen($password) < 8) {
            $password .= $list[mt_rand(0, strlen($list) - 1)];
        }
        return $password;
    }

}
