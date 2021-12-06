<?php
// user \dclass\devups\model\Model;

/**
 * @Entity @Table(name="notification")
 * */
class Notification extends Model implements JsonSerializable
{

    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     * */
    protected $id;
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
     * @ManyToOne(targetEntity="\Notificationtype")
     * @var \Notificationtype
     */
    public $notificationtype;

    public function __construct($id = null)
    {

        if ($id) {
            $this->id = $id;
        }

        $this->notificationtype = new Notificationtype();
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


    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'entity' => $this->entity,
            'entityid' => $this->entityid,
            'content' => $this->content,
        ];
    }

    /**
     * @param $entity
     * @param $event
     * @param array $params
     * @return int|Notification
     */
    public static function on($entity, $event, $params = [])
    {

        $classname = strtolower(get_class($entity));
        $type = Notificationtype::where(["dvups_entity.name" => $classname, "_key" => $event])
            //->getSqlQuery();
            ->firstOrNull();
        //die(var_dump($sql));
        if (is_null($type)) {
            $id = Notificationtype::create([
                "dvups_entity_id" => Dvups_entity::getbyattribut("this.name", $classname)->getId(),
                "_key" => $event,
                "content" => 'no content',
            ]);
            $type = Notification::find($id);
        }
        $msg = $type->getContent();
        foreach ($params as $search => $value) {
            $msg = str_replace(":" . $search, $value, $msg);
        }

        $notification = new Notification();
        $notification->notificationtype = $type;
        $notification->setContent($msg);

        $notification->setEntity($classname);
        $notification->setEntityid($entity->getId());
        return $notification;
    }

    public function send($mb = [])
    {
        if (!$this->entityid)
            return $this;

        $this->__insert();
        Notificationbroadcasted::send($this, $mb);
        return $this;
    }

    public function sendSMS($destination)
    {
        if (!$this->entityid)
            return $this;

        self::execSMS($destination, $this->getContent());
    }

    public static function execSMS($destination, $sms)
    {

        if (!__prod)
            return 0;

        $from = Configuration::get("sms_sender_id");

//Etape 4: precisez le numéro de téléphone (Format international)
        if (is_array($destination))
            $destination = implode(",", $destination);
        /*$destination = implode(",",
            array_map(function ($item) {
                return $item->getId();
            }, $destination));*/

        if (!$destination)
            return [
                'success' => false,
                'detail' => t("you most specify destination (s)"),
            ];

// Construire le corps de la requête
        $sms_body = array(
            'action' => 'send-sms',
            'api_key' => Configuration::get("sms_api_key"),
            'to' => $destination,
            'from' => $from,
            'sms' => $sms
        );

        $send_data = http_build_query($sms_body);
        $gateway_url = Configuration::get("sms_api") . "?" . $send_data;

        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $gateway_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            $output = curl_exec($ch);

            if (curl_errno($ch)) {
                $output = curl_error($ch);
            }
            curl_close($ch);

            Emaillog::create([
                "object" => "sms sent",
                "log" => " tel: ".$destination." detail ".$output,
            ]);
            //var_dump($output);

        } catch (Exception $exception) {

            Emaillog::create([
                "object" => "sms exception",
                "log" => " tel: ".$destination." detail ".$exception->getMessage(),
            ]);
            //echo $exception->getMessage();
        }
    }

}
