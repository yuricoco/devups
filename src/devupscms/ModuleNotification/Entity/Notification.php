<?php
// user \dclass\devups\model\Model;

/**
 * @Entity @Table(name="notification")
 * */
class Notification extends Model implements JsonSerializable
{

    public static $send_sms = false;

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
     * @Column(name="entity", type="string" , length=55 )
     * @var string
     **/
    protected $entity;
    /**
     * @Column(name="entityid", type="integer"  )
     * @var integer
     **/
    protected $entityid;

    /**
     * @Column(name="content", type="string" , length=255 , nullable=true)
     * @var string
     **/
    protected $content;
    /**
     * @Column(name="redirect", type="string" , length=255, nullable=true )
     * @var string
     **/
    protected $redirect;

    /**
     * @ManyToOne(targetEntity="\Notificationtype")
     * @JoinColumn(onDelete="set null")
     * @var \Notificationtype
     */
    public $notificationtype;

    /**
     * @Column(name="user_id", type="integer" , nullable=true )
     * @var string
     **/
    public $user_id;
    /**
     * @Column(name="admin_id", type="integer" , nullable=true )
     * @var string
     **/
    public $admin_id;

    public function __construct($id = null)
    {

        if ($id) {
            $this->id = $id;
        }

        $this->notificationtype = new Notificationtype();

    }

    public static function unreaded($user)
    {
        return self::where("user_id", $user->id)->orderby("this.id desc")->limit(20)->get();
    }

    public static function unreadedcount($user)
    {
        return self::where("user_id", $user->id)->andwhere("this.status", "=", 0)->count();
    }

    public static function unreadedadmin($user)
    {
        $notifs = self::where("admin_id", $user->getId())->orderby("this.id desc")->limit(20)->get();
        $notifcount = self::where("admin_id", $user->getId())->andwhere("this.status", "=", 0)->count();

        // once php load data it sets the ping value to 0 so that timer escape it
        self::where("admin_id", $user->getId())->andwhere("this.ping", "=", 1)->update([
            "this.ping"=>0
        ]);
        return compact("notifcount", "notifs");
    }

    public static function unreadedadmincount($user)
    {
        return self::where("admin_id", $user->getId())->andwhere("this.status", "=", 0)->count();
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Notificationtype
     */
    public function getNotificationtype(): Notificationtype
    {
        return $this->notificationtype;
    }

    /**
     * @param string $redirect
     */
    public function setRedirect(  $redirect)
    {
        $this->redirect = $redirect;
        return $this;
    }

    /**
     * @param Notificationtype $notificationtype
     */
    public function setNotificationtype(Notificationtype $notificationtype): void
    {
        $this->notificationtype = $notificationtype;
    }

    public function getEntity()
    {
        return $this->entity;
    }

    public function setEntity($entity)
    {
        $this->entity = $entity;
    }

    public function getEntityid()
    {
        return $this->entityid;
    }

    public function setEntityid($entityid)
    {
        $this->entityid = $entityid;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public static function onadmin($entity, $event, $session = "admin")
    {
        return self::on($entity, $event, $session);
    }

    /**
     * @param $entity
     * @param $event
     * @param array $params
     * @return int|Notification
     */
    public static function on($entity, $event, $session = "user", $sendsms = false)
    {

        $classname = strtolower(get_class($entity));
        $type = Notificationtype::where(["dvups_entity.name" => $classname, "_key" => $event])
            ->where("this.session", $session)
            //->getSqlQuery();
            ->firstOrNull();
        //die(var_dump($type));
        if (is_null($type)) {

            $langs = Dvups_lang::allrows();
            $content = [];
            foreach ($langs as $lang) {
                $content[$lang->iso_code] = "no content";
            }
            $id = Notificationtype::create([
                "dvups_entity_id" => Dvups_entity::getbyattribut("this.name", $classname)->getId(),
                "_key" => $event,
                "session" => $session,
                "content" => $content,
            ]);
            $type = Notificationtype::find($id);
        }

        $notification = new Notification();
        $notification->notificationtype = $type;

        $notification->setEntity($classname);
        $notification->setEntityid($entity->getId());
        return $notification;
    }

    public function send($mb = [], $params = [])
    {
        if (!$this->entityid)
            return $this;

        self::braodcast($this, $mb, $params);

        return $this;

    }

    public static function sendSMS($notification, $receiver)
    {
        if (!__prod)
            return 0;

        $response = Request::initCurl("https://spacekolasms.com/api/sendsms?api_key=" . Configuration::get("sms_api_key"))
            ->data([
                "phonenumber" => $receiver->phonenumber,
                "message" => $notification->content,
                "phone_code" => $receiver->country->phonecode,
            ])
            ->send()
            ->json();

        Emaillog::create([
            "object" => " - object : " . $notification->notificationtype->_key . ' to '.$receiver->country->phonecode . $receiver->phonenumber,
            "log" => json_encode($response),
        ]);

    }

    public static function execSMS($destination, $sms, $event = "")
    {

        if (is_array($destination))
            $destination = implode(",", $destination);

        if (!$destination)
            return [
                'success' => false,
                'detail' => t("you most specify destination (s)"),
            ];

        $from = Configuration::get("sms_sender_id");
        $gateway_url = Configuration::get("sms_api");

        $access = Request::initCurl($gateway_url."auth?type=".Configuration::get("sms_refresh_token"))
            ->raw_data(
                [
                    "type"=> Configuration::get("sms_type"),
                    "username"=> Configuration::get("sms_username"),
                    "password"=> Configuration::get("sms_password"),
                    ]
            )
            ->send()
            ->json();

        if($access->status_code != 200) {
            Emaillog::create([
                "object" => "sms exception"." dest: ".$destination,
                "log" => $access->errors[0]->message,
            ]);
            return [
                "success"=>false,
                "detail" => $access->errors[0]->message,
            ];
        }

// Construire le corps de la requête
        $sms_body = array(
//            'action' => 'send-sms',
//            'api_key' => Configuration::get("sms_api_key"),
            "to" => ["$destination"],
            "from" => $from,
            "message" => $sms
        );

//        $send_data = http_build_query($sms_body);
//        $gateway_url = Configuration::get("sms_api") . "?" . $send_data;

        try {

            $output = Request::initCurl($gateway_url."sms/mt/v2/send")
                ->raw_data([$sms_body])
                ->addHeader('Authorization', "Bearer ".$access->payload->access_token)
                ->send();

            Emaillog::create([
                "object" => "sms sent".$event." dest: ".$destination,
                "log" => $output->_response,
            ]);
            //var_dump($output);

        } catch (Exception $exception) {

            Emaillog::create([
                "object" => "sms exception"." dest: ".$destination,
                "log" => $exception->getMessage(),
            ]);
            //echo $exception->getMessage();
        }
    }

    public function sendMail($mb = ["editorial.3ag@gmail.com" => "3agedition"])
    {
        if ($this->id){
            Reportingmodel::init($this->notificationtype->getEmailmodel())
                ->addReceiver($mb)
                ->sendMail(["notification"=>$this->content]);
        }
        return $this;
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

    public static function of($entity, $userid = null)
    {
        if ($userid)
            return Notification::where("notification.entity", $entity)
                ->where("this.user_id", $userid)
                ->whereNull("viewedat")
                ->count();

        return Notification::where("notification.entity", $entity)
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
        return $this->redirect;
    }

    public static function readed($id)
    {
        (new Notification($id))->__update([
            "viewedat" => date('Y-m-d'),
            "read" => 1,
        ]);
        return Notification::find($id);
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

    public static function braodcast($notification, $receivers, $params)
    {

        if (!is_array($receivers))
            $receivers = [$receivers];

        $type = $notification->notificationtype;
        foreach ($receivers as $receiver) {

            $nb = clone $notification;
            // $nb->notification = $notification;
            $nb->status = 0;
            $nb->ping = 1;
            $nb->read = 0;
            $local = $receiver->lang;
            $msg = $type->content[$local];
            foreach ($params as $search => $value) {
                $msg = str_replace(":". $search ."", $value, $msg);
                //$msg = str_replace("{{". $search ."}}", $value, $msg);
            }
            $nb->setContent($msg);

            if($type->session == "admin")
                $nb->admin_id = $receiver->id;
            else
                $nb->user_id = $receiver->id;

            $nb->__insert();

            if (self::$send_sms)
                self::sendSMS($nb, $receiver);

        }

    }


}
