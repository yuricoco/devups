<?php
// user \dclass\devups\model\Model;
use PHPMailer\PHPMailer\PHPMailer;

/**
 * @Entity @Table(name="reportingmodel")
 * */
class Reportingmodel extends Model implements JsonSerializable, DatatableOverwrite
{

    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     * */
    protected $id;
    /**
     * @Column(name="name", type="string" , length=255 )
     * @var string
     **/
    protected $name;
    /**
     * @Column(name="type", type="string" , length=55 )
     * @var string
     **/
    protected $type;
    /**
     * @Column(name="styleressource", type="string" , length=255, nullable=true )
     * @var string
     **/
    protected $styleressource;
    /**
     * @Column(name="style", type="text" , nullable=true )
     * @var string
     **/
    protected $style;
    /**
     * @Column(name="title", type="string" , length=255, nullable=true )
     * @var string
     **/
    protected $title;
    /**
     * @Column(name="object", type="string" , length=255, nullable=true )
     * @var string
     **/
    protected $object;
    /**
     * @Column(name="subject", type="string" , length=255, nullable=true )
     * @var string
     **/
    protected $subject;
    /**
     * @Column(name="contenttext", type="text"  , nullable=true)
     * @var text
     **/
    protected $contenttext;
    /**
     * @Column(name="content", type="text"  , nullable=true)
     * @var text
     **/
    protected $content;


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
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    public static $log_info = "";

    /**
     * @param $model
     * @return Reportingmodel
     */
    public static function init($model)
    {
        self::$log_info = " mode - " . $model;
        $reportingmodel = Reportingmodel::getbyattribut("name", $model);
        if ($reportingmodel->getId())
            return $reportingmodel;

        $id = Reportingmodel::create([
            "name" => $model,
            "title" => 'email - '.$model,
            "type" => 'email',
        ]);

        return new Reportingmodel($id);
    }

    public static $view;

    /**
     * @param $model
     * @return Reportingmodel
     */
    public static function initPDF($view, $data)
    {

        self::$view = Genesis::getView($view, $data);

        return new Reportingmodel();
    }

    public function render($name = '', $dest = '')
    {

        $mpdf = new \Mpdf\Mpdf([
            "margin_left" => 0,
            "margin_right" => 0,
            "margin_top" => 0,
            "margin_bottom" => 0,
        ]);

// Write some HTML code:
        $mpdf->WriteHTML(self::$view);
        $name = UPLOAD_DIR . "invoice$name.pdf";
// Output a PDF file directly to the browser
        $mpdf->Output($name, "F");
        return $name;

    }

    public function getObject()
    {
        return $this->object;
    }

    public function setObject($object)
    {
        $this->object = $object;
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
        $this->subject = $subject;
    }

    /**
     * @return string
     */
    public function getStyle()
    {
        return $this->style;
    }

    /**
     * @param string $style
     */
    public function setStyle($style)
    {
        $this->style = $style;
    }

    public function getContenttext()
    {
        return $this->contenttext;
    }

    public function setContenttext($contenttext)
    {
        $this->contenttext = $contenttext;
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
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getStyleressource()
    {
        return $this->styleressource;
    }

    /**
     * @param string $styleressource
     */
    public function setStyleressource($styleressource)
    {
        $this->styleressource = $styleressource;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @param $model
     * @return Reportingmodel
     */
    public static function model($model)
    {
        return self::getbyattribut("name", $model);
    }

    public function getTest()
    {
        return '
        <input id="email-' . $this->id . '" class="form-control" name="emailtest" />
        <button type="button" onclick="model.sendmail(this, ' . $this->id . ')" class="btn btn-info"> Test mail </button>
        <a target="_blank" href="' . Reportingmodel::classpath("reportingmodel/preview?id=" . $this->id) . '" class="btn btn-info"> Preview </a>
        <a target="_blank" href="' . Reportingmodel::classpath("reportingmodel/pdf?id=" . $this->id) . '" class="btn btn-info"> PDF </a>';

    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'object' => $this->object,
            'contenttext' => $this->contenttext,
            'content' => $this->content,
        ];
    }

    public function editAction($btarray)
    {
        return '<a class="btn btn-warning"  href="' . self::classpath("reportingmodel/edit?id=") . $this->id . '"> edit</a>';
    }

    public function showAction($btarray)
    {
    }

    public function deleteAction($btarray)
    {
        // TODO: Implement deleteAction() method.
    }

    private function sanitizeContent($content, $datareplace)
    {

        foreach ($datareplace as $key => $value) {
            if (is_array($value)) {
                $looptemplate = \DClass\lib\Util::extract_content_between_string($key, $key, $content);
                if (!$looptemplate)
                    continue;

                $iterationtemplate = '';
                foreach ($value as $entity) {
                    foreach ($entity as $k => $item) {
                        //die(var_dump($looptemplate, $k, $item));
                        $iterationtemplate .= str_replace("{{" . $k . '}}', $item, $looptemplate);
                    }
                }

                $content = str_replace("@$key" . $looptemplate . '@' . $key, $iterationtemplate, $content);
                continue;
            }
            $content = str_replace("{{" . $key . '}}', $value, $content);
        }

        $content = str_replace("{__env}", __env, $content);

        return $content;

    }

    public function getPreview()
    {
        $data = [
            "style" => $this->getCss(),
            "activationcode" => "xxxxx",
            "username" => "yyyyy",
            "loop" => [
                ["name" => "entity 1 name"],
                ["name" => "entity 2 name"],
            ],
        ];
        $message_html = $this->sanitizeContent($this->content, $data);

        ob_start();
        echo $message_html;
        $var = ob_get_contents();
        ob_end_clean();
        return $var;

    }

    public function getCss()
    {

        $style = "";
//        $stylefile = self::classroot("Ressource/css/" . $this->styleressource);
//        if (file_exists($stylefile))
//            return file_get_contents($stylefile);

        return $this->style;
    }

    static $emailreceiver = [];
    static $namereceiver = [];

    /**
     * @param $email
     * @param $name
     * @return $this
     */
    public function addReceiver($email, $name)
    {
        self::$emailreceiver[] = $email;
        self::$namereceiver[] = $name;
        return $this;
    }

    public static $attachments = [];

    /**
     * @param $email
     * @param $name
     * @return $this
     */
    public function addAttachment($attachment)
    {
        self::$attachments[] = $attachment;
        return $this;
    }

    public function sendMail($datacustom)
    {

//        if (!__prod || !$this->id)
//            return 0;

        $data = [
                "style" => $this->getCss(),
            ] + $datacustom;

        $message_html = $this->sanitizeContent($this->content, $data);
        $message_text = $this->sanitizeContent($this->contenttext, $data);
// Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            //$mail->SMTPDebug = false;                                       // Enable verbose debug output ->SMTPDebug = false;
            $mail->isSMTP();                                            // Set mailer to use SMTP
            $mail->Host = Configuration::get("sm_smtp");  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                                   // Enable SMTP authentication
            $mail->Username = Configuration::get("sm_username");                     // SMTP username
            $mail->Password = Configuration::get("sm_password");                               // SMTP password
            $mail->SMTPSecure = Configuration::get("sm_smtpsecurity");                                  // Enable TLS encryption, `ssl` also accepted
            $mail->Port = Configuration::get("sm_port");                                    // TCP port to connect to

            //Recipients
            $mail->setFrom(Configuration::get("sm_from"), $this->title);
            $mail->addAddress(self::$emailreceiver[0], self::$namereceiver[0]);     // Add a recipient
            //$mail->addAddress('ellen@example.com');               // Name is optional
            $mail->addReplyTo(Configuration::get("sm_from"), $this->title);
//            $mail->addCC('cc@example.com');
//            $mail->addBCC('bcc@example.com');

            // Attachments
            foreach (self::$attachments as $attachment) {
                $mail->addAttachment($attachment, 'invoice.pdf');         // Add attachments
            }
//            $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $this->object;
            $mail->Body = $message_html;
            $mail->AltBody = $message_text;

            //echo 'Message has been sent';
            $result = $mail->send();
            Emaillog::create([
                "object" => self::$log_info . " - object : " . $this->object . ' to ' . self::$emailreceiver[0],
                "log" => json_encode($result),
            ]);
            return [
                "success" => true,
                "result" => $mail->send(),
                "user" => 'Message has been sent'
            ];
        } catch (Exception $e) {
            //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            Emaillog::create([
                "object" => self::$log_info . " - object : " . $this->object . ' to ' . self::$emailreceiver[0],
                "log" => "Message could not be sent. Error detail: {$mail->ErrorInfo}",
            ]);

            return [
                "success" => false,
                "result" => "Message could not be sent. Error detail: {$mail->ErrorInfo}"
            ];
        }
    }

}
