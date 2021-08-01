<?php

/**
 * @Entity @Table(name="message")
 * */
class Message extends \Model implements JsonSerializable
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
     * @Column(name="lastname", type="string" , length=255, nullable=true )
     * @var string
     **/
    protected $lastname;
    /**
     * @Column(name="email", type="string" , length=255, nullable=true )
     * @var string
     **/
    protected $email;
    /**
     * @Column(name="subject", type="string" , length=35 , nullable=true)
     * @var string
     **/
    protected $subject;
    /**
     * @Column(name="telephone", type="string" , length=35 , nullable=true)
     * @var string
     **/
    protected $telephone;
    /**
     * @Column(name="message", type="text"  , nullable=true)
     * @var text
     **/
    protected $message;


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
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname($firstname)
    {
        if(!$firstname)
            return t("Vous devez renseigner :attrib", ["attrib"=>"Le nom"]);

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
    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     */
    public function setSubject($subject)
    {
        if(!$subject)
            return t("Vous devez renseigner le :attrib", ["attrib"=>"subject"]);

        $this->subject = $subject;
    }


    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        if(!$email)
            return t("Vous devez renseigner :attrib", ["attrib"=>"l'email"]);

        $this->email = $email;
    }

    public function setTelephoneOrEmail($value)
    {
        // code de validation
        if(is_numeric($value) && $result = !is_null($this->setTelephone($value)))
            return null;

        if($result = !is_null($this->setEmail($value)))
            return null;

        return $result;

    }

    public function getTelephone()
    {
        return $this->telephone;
    }

    public function setTelephone($telephone)
    {
        if(!$telephone)
            return t("Vous devez renseigner :attrib", ["attrib"=>"le Telephone"]);

        $this->telephone = $telephone;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }


    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'firstname' => $this->firstname,
            'email' => $this->email,
            'telephone' => $this->telephone,
            'message' => $this->message,
        ];
    }

    public function actionAfterCreate(){
        $notif = Notification::on($this, "newmessage");

        if($notif)
            $notif->send();
    }

}
