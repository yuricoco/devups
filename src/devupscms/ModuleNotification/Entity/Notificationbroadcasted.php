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
     * @Column(name="status", type="integer" , length=1 )
     * @var string
     **/
    protected $status = 0;

    /**
     * @ManyToOne(targetEntity="\Notification")
     * @JoinColumn(onDelete="cascade")
     * @var \Notification
     */
    public $notification;

    /**
     * @ManyToOne(targetEntity="\User")
     * @JoinColumn(onDelete="cascade")
     * @var \User
     */
    public $user;
    /**
     * @ManyToOne(targetEntity="\Dvups_admin")
     * @JoinColumn(onDelete="cascade")
     * @var \Dvups_admin
     */
    public $admin;


    public function __construct($id = null)
    {

        if ($id) {
            $this->id = $id;
        }

        $this->notification = new Notification();
        $this->user = new User();
        $this->admin = new Dvups_admin();

    }

    /**
     * @return Dvups_admin
     */
    public function getAdmin()
    {
        return $this->admin;
    }

    /**
     * @param Dvups_admin $admin
     */
    public function setAdmin(Dvups_admin $admin)
    {
        $this->admin = $admin;
    }

    public static function unreaded($user)
    {
        return self::where($user)->orderby("this.id desc")->limit(20)->get();
    }

    public static function unreadedcount($user)
    {
        return self::where($user)->andwhere("this.status", "=", 0)->count();
    }

    public static function unreadedadmin($user)
    {
        return self::where("admin.id", $user->getId())->andwhere("this.status", "=", 0)->count();
    }


    public function to()
    {

    }

    public function broadcast()
    {
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
        $this->viewedat = $viewedat;
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
        ];
    }


    public function getWidgetmodel()
    {
        return $this->widgetModel();
    }

    public function widgetModel()
    {
//        if ($this->status == 0) {
//
//            if($redirect = $this->notification->notificationtype->getRedirect())
//                $route = route("notification?read=" . $this->id . "&redirect=" . $redirect . "?id=" . $this->notification->getEntityid());
//            else
//                $route = route("notification?read=" . $this->id . "&redirect=notifications");
//
//        }elseif($redirect = $this->notification->notificationtype->getRedirect())
//            $route = route($redirect . "?id=" . $this->notification->getEntityid());
//        else
//            $route = route("notifications");

        return '<a href="' . $this->getRedirect() . '"><span class="pull-right">'
            . $this->created_at . '</span><br>'
            . $this->notification->getContent() . '</a>';


    }

    public static function send($notification, $receivers = null)
    {
        foreach ($receivers as $receiver) {

            $nb = new Notificationbroadcasted();
            $nb->notification = $notification;
            $nb->setStatus(0);
            $nb->setUser($receiver);
            $nb->__insert();

        }

    }

    public static function sendAdmin($notification, $receivers = null)
    {
        foreach ($receivers as $receiver) {

            $nb = new Notificationbroadcasted();
            $nb->notification = $notification;
            $nb->setStatus(0);
            $nb->setAdmin($receiver);
            $nb->__insert();

        }

    }

    public static function of($entity, $userid = null)
    {
        if ($userid)
            return Notificationbroadcasted::where("notification.entity", $entity)
                ->where("this.user_id", $userid)
                ->whereNull("viewedat")
                ->count();

        return Notificationbroadcasted::where("notification.entity", $entity)
            ->where("viewedat")
            ->whereNull("viewedat")
            ->count();
    }

    public function getRedirect()
    {
        if ($this->status == 0) {
            if ($this->notification->notificationtype->getSession() == "admin")
                return __env . ('admin/index.php?path=notified&read=' . $this->getId());

            return route('notification?read=' . $this->getId());
        }
        return $this->notification->getRedirect();
    }

    public static function readed($id)
    {
        (new Notificationbroadcasted($id))->__update([
            "viewedat" => date('Y-m-d'),
            "status" => 1,
        ]);
        return Notificationbroadcasted::find($id);
    }

    public function route()
    {
        $note = "";
        if (!$this->viewedat)
            $note = "?read=" . $this->id;
        switch ($this->notification->entity) {
            case "schedule":
                return route("rdv") . $note;

        }
    }


}
