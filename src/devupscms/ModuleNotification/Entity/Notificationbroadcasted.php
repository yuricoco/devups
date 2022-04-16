<?php
// user \dclass\devups\model\Model;

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
     * store the date when the notification has been read
     * @Column(name="viewedat", type="datetime"  , nullable=true)
     * @var datetime
     **/
    protected $viewedat;

    /**
     * specify if the notification has been seen in the list of notification (either on top widget or list view)
     * 0 : not yet read
     * 1 : already read
     * @Column(name="read", type="integer" , length=1 )
     * @var string
     **/
    protected $read = 0;
    /**
     * specify if the notification has been seen in the list of notification (either on top widget or list view)
     * 0 : not yet seen
     * 1 : already seen
     * @Column(name="status", type="integer" , length=1 )
     * @var string
     **/
    protected $status = 0;
    /**
     * 0 : has already been taken by the broadcaster system
     * 1 : has not yet been taken by the broadcaster system
     *
     * the initial request will take all the notification least than the date of the device and where ping=1
     * then the timers request will take by the latest notification date and ping = 1
     *
     * @Column(name="ping", type="integer" , length=1 )
     * @var string
     **/
    protected $ping = 1;

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
        $notifs = self::where("admin.id", $user->getId())->orderby("this.id desc")->limit(20)->get();
        $notifcount = self::where("admin.id", $user->getId())->andwhere("this.status", "=", 0)->count();

        // once php load data it sets the ping value to 0 so that timer escape it
        self::where("admin.id", $user->getId())->andwhere("this.ping", "=", 1)->update([
            "this.ping"=>0
        ]);
        return compact("notifcount", "notifs");
    }

    public static function unreadedadmincount($user)
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
        if (Request::get("jsonmodel") == "html") {
            global $viewdir;
            $viewdir[] = ROOT."admin/views";
            return [
                'id' => $this->id,
                'html' => Genesis::getView("default.notification_item", ["notification"=>$this]),
                'status' => $this->status,
                'created_at' => $this->created_at,

            ];
        }

        return [
            'id' => $this->id,
            'viewedat' => $this->viewedat,
            'status' => $this->status,
            'notification' => $this->notification,
            //'user' => $this->user,
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

    public static function send($notification, $receivers)
    {
        $bulk = [];
        foreach ($receivers as $receiver) {

            $nb = new Notificationbroadcasted();
            $nb->notification = $notification;
            $nb->setStatus(0);
            $nb->setUser($receiver);
            $nb->__insert();
            $bulk[$receiver->getTelephone()] = $notification->content;
        }

        if (Notification::$send_sms && __prod) {
            foreach ($bulk as $telephone => $content) {
                $response = Request::initCurl("https://spacekolasms.com/api/sendsms?api_key=" . Configuration::get("sms_api_key"))
//            $response = Request::initCurl("https://spacekolasms.com/api/sendsms_bulk?api_key=" . Configuration::get("sms_api_key"))
                    ->data([
                        "phonenumber" => $telephone,
                        "message" => $content,
                    ])
                    ->send()
                    ->json();

                Emaillog::create([
                    "object" => " - object : " . $notification->notificationtype->_key . ' to ' . $receiver->getTelephone(),
                    "log" => json_encode($response),
                ]);
            }
        }

    }

    public static function sendAdmin($notification, $receivers = null)
    {
        if (!is_array($receivers))
            $receivers = [$receivers];

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
        if ($this->read == 0) {
            if ($this->_notification->_notificationtype->getSession() == "admin") {
                $entity = ucfirst($this->_notification->entity);
                //$entity = Dvups_entity::getbyattribut("name", $this->_notification->entity);
                //return __env.('admin/' .strtolower($entity->dvups_module->project) . '/' . $entity->dvups_module->name . '/' . $entity->url . "/detail?id=".$this->notification->entityid);

                //return $entity->route();
                return $entity::classpath("index.php?path=".$this->_notification->entity."/index&dfilters=on&id:eq={$this->notification->entityid}&notified=" . $this->getId());
            }
            return route('notification?read=' . $this->getId());
        }
        return $this->_notification->getRedirect();
    }

    public static function readed($id)
    {
        (new Notificationbroadcasted($id))->__update([
            "viewedat" => date('Y-m-d'),
            "read" => 1,
        ]);
        return Notificationbroadcasted::find($id);
    }

    public function route()
    {
        $note = "";
        if (!$this->viewedat)
            $note = "&read=" . $this->id;
        switch ($this->notification->entity) {
            case "order":
                return route("order-detail?id=" . $this->notification->entityid) . $note;
            case "sponsoring":
                return route("investor-detail?id=" . $this->notification->entityid) . $note;
            case "cycle":
                return route("cycle?id=" . $this->notification->entityid) . $note;

        }
    }


}
