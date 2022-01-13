<?php

/**
 * @Entity @Table(name="dvups_admin")
 * */
class Dvups_admin extends Model implements JsonSerializable
{
    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     * */
    protected $id;

    /**
     * @Column(name="firstconnexion", type="integer", nullable=true )
     * @var string
     * */
    protected $firstconnexion = 1;
    /**
     * @Column(name="lastlogin_at", type="datetime", nullable=true )
     * @var string
     * */
    protected $lastlogin_at;
    /**
     * @Column(name="name", type="string" , length=255 )
     * @var string
     * */
    protected $name;
    /**
     * @Column(name="email", type="string" , length=255, nullable=true )
     * @var string
     * */
    protected $email;

    /**
     * @Column(name="login", type="string" , length=255 )
     * @var string
     * */
    protected $login;

    /**
     * @Column(name="password", type="string" , length=255 )
     * @var string
     * */
    protected $password;

    /**
     * @ManyToOne(targetEntity="\Dvups_role")
     * @var \Dvups_role
     */
    public $dvups_role;

    public function __construct($id = null)
    {
        $this->dvsoftdelete = true;

        if ($id) {
            $this->id = $id;
        }

        $this->dvups_role = new Dvups_role();

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
     * @return string
     */
    public function getFirstconnexion()
    {
        return $this->firstconnexion;
    }

    /**
     * @param string $firstconnexion
     */
    public function setFirstconnexion($firstconnexion)
    {
        $this->firstconnexion = $firstconnexion;
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

        return parent::__insert();

    }

    protected function wd_remove_accents($str, $charset = 'utf-8')
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
