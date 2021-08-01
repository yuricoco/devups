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
        return self::where($user)->andwhere("this.status", "=", 0)->__countEl();
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
        if ($this->status == 0)
            $route = route("notification?read=" . $this->id . "&redirect=" . $this->notification->notificationtype->getRedirect() . "?id=" . $this->notification->getEntityid());
        elseif($redirect = $this->notification->notificationtype->getRedirect())
            $route = route($redirect . "?id=" . $this->notification->getEntityid());
        else
            $route = route("notifications");


        return '<a href="' . $route . '"><span class="pull-right">'
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

    public static function of($entity)
    {
        return Notificationbroadcasted::where("notification.entity", $entity)
            ->andwhere("viewedat")->isNull()
            ->count();
    }

    public static function onPackageDelivered(Package $package)
    {

        $notif = new Notification();
        $notif->setEntity(Package::class);
        $notif->setEntityid($package->getId());
        $notif->setContent(t("event.packagedelivered", "Le paquet n° " . $package->getId() . " a bien été Receptionné. Votre le colis est cloture et les fond sont desormais disponible."));
        $notif->__insert();

        $nb = new Notificationbroadcasted();
        $nb->notification = $notif;
        $nb->shop = $package->shop;
        $nb->user = $package->shop->user->__show();
        return $nb;

    }

}
