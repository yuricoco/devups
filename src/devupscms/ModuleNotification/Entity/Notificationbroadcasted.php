<?php
// user \dclass\devups\model\Model;
use DClass\lib\SendMail;

/**
 * @Entity @Table(name="notificationbroadcasted")
 * */
class Notificationbroadcasted extends Model implements JsonSerializable
{

    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     * */
    protected $id;
    /**
     * @Column(name="viewedat", type="datetime"  , nullable=true)
     * @var datetime
     **/
    protected $viewedat;
    /**
     **/
    public static $STATUSS = ['un' => 'unviewed', 'vi' => 'viewed'];
    /**
     * @Column(name="status", type="string" , length=2 )
     * @var string
     **/
    protected $status = 'un';

    /**
     * @ManyToOne(targetEntity="\Notification")
     * , inversedBy="reporter"
     * @var \Notification
     */
    public $notification;

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

        $this->notification = new Notification();
        $this->user = new User();
    }

    public static function unreaded($user)
    {
        return self::where($user)->andwhere("this.status", "=", 'un')->__countEl();
    }


    public function to(){

    }

    public function broadcast(){
        // $this->user =

        // todo: send mail and notification for order
//        $user = $this->user;
//        if ($user->getEmail()) {
//            $order = $this->getEntityInstance();
//            $title = t("Commande enregitrée avec succes");
//            $html = SendMail::getmailInvoice($order, $title);
//            SendMail::sendmail($user->getEmail(), $user->getFirstname(), $html,$title , "message alternatif");
//        }

        $this->__insert();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getViewedat()
    {
        if (is_object($this->viewedat))
            return $this->viewedat;
        else
            return new DateTime($this->viewedat);
    }

    public function setViewedat($viewedat)
    {
        if (is_object($viewedat))
            $this->viewedat = $viewedat;
        else
            $this->viewedat = new DateTime($viewedat);
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     *  manyToOne
     * @return \Notification
     */
    function getNotification()
    {
        $this->notification = $this->notification->__show();
        return $this->notification;
    }

    function setNotification(\Notification $notification)
    {
        $this->notification = $notification;
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
     *  manyToOne
     * @return \Dvups_admin
     */
    function getDvups_admin()
    {
        $this->dvups_admin = $this->dvups_admin->__show();
        return $this->dvups_admin;
    }

    function setDvups_admin(\Dvups_admin $dvups_admin)
    {
        $this->dvups_admin = $dvups_admin;
    }


    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'viewedat' => $this->viewedat,
            'status' => $this->status,
            'notification' => $this->notification,
            'user' => $this->user,
            'dvups_admin' => $this->dvups_admin,
        ];
    }


    public function widgetModel(){
        switch ($this->entity){

        }
    }

}
