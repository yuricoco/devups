<?php
// user \dclass\devups\model\Model;

/**
 * @Entity @Table(name="notificationtype")
 * */
class Notificationtype extends Model implements JsonSerializable
{

    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     * */
    protected $id;
    /**
     * @Column(name="_key", type="string" , length=55 )
     * @var string
     **/
    protected $_key;
    /**
     * @Column(name="session", type="string" , length=55 )
     * @var string
     **/
    protected $session = 'user';
    /**
     * @Column(name="content", type="string" , length=255 )
     * @var integer
     **/
    protected $content;
    /**
     * @Column(name="redirect", type="string" , length=255, nullable=true )
     * @var string
     **/
    protected $redirect;
    /**
     * @Column(name="emailmodel", type="string" , length=255, nullable=true )
     * @var integer
     **/
    protected $emailmodel;

    /**
     * @ManyToOne(targetEntity="\Dvups_entity")
     * @var \Dvups_entity
     */
    public $dvups_entity;


    public function __construct($id = null)
    {

        if ($id) {
            $this->id = $id;
        }

        $this->dvups_entity = new Dvups_entity();
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * @param string $session
     */
    public function setSession(  $session)
    {
        $this->session = $session;
    }

    /**
     * @return int
     */
    public function getEmailmodel()
    {
        return $this->emailmodel;
    }

    /**
     * @param int $emailmodel
     */
    public function setEmailmodel($emailmodel)
    {
        $this->emailmodel = $emailmodel;
    }

    /**
     * @return string
     */
    public function getRedirect()
    {
        return $this->redirect;
    }
    /**
     * @return string
     */
    public function getRedirection()
    {
        return $this->redirect;
    }

    /**
     * @param string $redirect
     */
    public function setRedirect($redirect)
    {
        $this->redirect = $redirect;
    }

    public function get_key()
    {
        return $this->_key;
    }

    public function set_key($_key)
    {
        $this->_key = $_key;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     *  manyToOne
     * @return \Dvups_entity
     */
    function getDvups_entity()
    {
        $this->dvups_entity = $this->dvups_entity->__show();
        return $this->dvups_entity;
    }

    function setDvups_entity(\Dvups_entity $dvups_entity)
    {
        $this->dvups_entity = $dvups_entity;
    }


    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            '_key' => $this->_key,
            'content' => $this->content,
            'redirect' => $this->redirect,
            'dvups_entity' => $this->dvups_entity,
        ];
    }

    public function getTest()
    {
        return '
        <input id="notification-' . $this->id . '" class="form-control" name="phonenumber" />
        <button type="button" onclick="model.sendsms(this, ' . $this->id . ')" class="btn btn-info"> Test sms </button>';

    }

}
