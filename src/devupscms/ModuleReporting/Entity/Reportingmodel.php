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
     * @Column(name="description", type="text" , nullable=true )
     * @var string
     **/
    protected $description;

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @Column(name="contenttext", type="text"  , nullable=true)
     * @var text
     **/
    protected $contenttext;
    /**
     * @Column(name="contentheader", type="text"  , nullable=true)
     * @var text
     **/
    protected $contentheader;
    /**
     * @Column(name="contentfooter", type="text"  , nullable=true)
     * @var text
     **/
    protected $contentfooter;
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

    /**
     * @return text
     */
    public function getContentheader()
    {
        return $this->contentheader;
    }

    /**
     * @param text $contentheader
     */
    public function setContentheader( $contentheader)
    {
        $this->contentheader = $contentheader;
    }

    /**
     * @return text
     */
    public function getContentfooter()
    {
        return $this->contentfooter;
    }

    /**
     * @param text $contentfooter
     */
    public function setContentfooter($contentfooter)
    {
        $this->contentfooter = $contentfooter;
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
        global $viewdir;
        $viewdir[] = __DIR__ . '/../Resource/views';
        //Reportingmodel::classroot("Resource/views");

        self::$emailreceiver = [];
        self::$attachments = [];

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

    /**
     * Values:
    \Mpdf\Output\Destination::INLINE, or "I"
    send the file inline to the browser. The plug-in is used if available. The name given by $filename is used when one selects the “Save as” option on the link generating the PDF.
    \Mpdf\Output\Destination::DOWNLOAD, or "D"
    send to the browser and force a file download with the name given by $filename.
    \Mpdf\Output\Destination::FILE, or "F"
    save to a local file with the name given by $filename (may include a path).
    \Mpdf\Output\Destination::STRING_RETURN, or "S"
    return the document as a string. $filename is ignored.
     *
     * https://mpdf.github.io/reference/mpdf-functions/output.html
     *
     * @param string $name
     * @param string $dest
     * @return string
     * @throws \Mpdf\MpdfException
     */
    public function render($name = '', $dest = 'I')
    {

        $mpdf = new \Mpdf\Mpdf([
            "margin_left" => 0,
            "margin_right" => 0,
            "margin_top" => 0,
            "margin_bottom" => 0,
        ]);

// Write some HTML code:
        $mpdf->WriteHTML(self::$view);
        if ($name && $dest != 'S') {
            $name = UPLOAD_DIR . "invoice$name.pdf";
// Output a PDF file directly to the browser
            $mpdf->Output($name, $dest);
        }else
            return $mpdf->Output($name, $dest);

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
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
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
        return '<div class="input-group">
  <input id="email-' . $this->id . '" type="email"  name="emailtest" placeholder="Enter a valide email address" class="form-control" >
  <button type="button" onclick="model.sendmail(this, ' . $this->id . ')" class="input-group-text btn btn-info"> Test mail </button>
  <a target="_blank" href="' . Reportingmodel::classpath("reportingmodel/preview?id=" . $this->id) . '" class="input-group-text"> Preview </a>
       
</div>';

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
    }

    public function showAction($btarray)
    {
        return " ";
    }

    public function deleteAction($btarray)
    {
        // TODO: Implement deleteAction() method.
    }

    public static function extract_content_between_string($begin, $end, $string)
    {
        $matches = array();
        $t = preg_match('/@'.$begin.'(.*?)\@'.$end.'/s', $string, $matches);
        return $matches[1];
    }

    private function sanitizeContent($content, $datareplace)
    {
        foreach ($datareplace as $key => $value) {
            if (is_array($value)) {
                $looptemplate = self::extract_content_between_string($key, $key, $content);
                if (!$looptemplate)
                    continue;

                $iterationtemplate = $looptemplate;
                foreach ($value as $entity) {
                    foreach ($entity as $k => $item) {
                        //die(var_dump($looptemplate, $k, $item));
                        $iterationtemplate = str_replace("{{" . $k . '}}', $item, $iterationtemplate);
                    }
                }

                $content = str_replace("@$key" . $looptemplate . '@' . $key, $iterationtemplate, $content);
                continue;
            }
            $content = str_replace("{{" . $key . '}}', $value, $content);
        }

        $content = str_replace("{__css}", "<style>{$this->getCss()}</style>", $content);
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
    public function addReceiver($email, $name = null)
    {
        if (is_array($email)){
            self::$emailreceiver = $email;
        }else {
            self::$emailreceiver[$email] = $name;
        }
        return $this;
    }
    static $namecc = [];

    /**
     * @param $email
     * @param $name
     * @return $this
     */
    public function addCC($email, $name = null)
    {
        if (is_array($email)){
            self::$namecc = $email;
        }else {
            self::$namecc[$email] = $name;
        }
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

        if(!$this->content){

            Emaillog::create([
                "object" => self::$log_info . " - object : " . $this->object . ' to ' . json_encode(self::$emailreceiver),
                "log" => "Message could not be sent. Error detail: Empty body",
            ]);

            return [
                "success" => false,
                "detail" => "Message could not be sent. Error detail:  Empty body"
            ];

        }

        $data = [
                "style" => $this->getCss(),
            ] + $datacustom;

        $message_html = $this->sanitizeContent($this->content, $data);
        $message_text = $this->sanitizeContent($this->contenttext, $data);

        global $viewdir;
        $viewdir[] = Reportingmodel::classroot("Resource/views");

        $message_html = str_replace("{yield}", $message_html, Genesis::getView("email"));

        //if (!__prod || !$this->id) {
            \DClass\lib\Util::log($message_html, date("Y_m_d-H_i_s")."_".$this->name.".html", ROOT."cache/", "w");
        //    return 0;
        //}

// Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            //$mail->SMTPDebug = false;                                       // Enable verbose debug output ->SMTPDebug = false;
            $mail->isSMTP();
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';                                         // Set mailer to use SMTP
            $mail->Host = Configuration::get("sm_smtp");  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                                   // Enable SMTP authentication
            $mail->Username = Configuration::get("sm_username");                     // SMTP username
            $mail->Password = Configuration::get("sm_password");                               // SMTP password
            $mail->SMTPSecure = Configuration::get("sm_smtpsecurity");                                  // Enable TLS encryption, `ssl` also accepted
            $mail->Port = Configuration::get("sm_port");                                    // TCP port to connect to

            //Recipients
            $mail->setFrom(Configuration::get("sm_from"), $this->title);
            foreach (self::$emailreceiver as $email => $name)
                $mail->addAddress($email, $name);     // Add a recipient
            //$mail->addAddress('ellen@example.com');               // Name is optional
            $mail->addReplyTo(Configuration::get("sm_from"), $this->title);

            foreach (self::$namecc as $email => $name)
                $mail->addCC($email, $name);
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
                "object" => self::$log_info . " - object : " . $this->object . ' to ' . json_encode(self::$emailreceiver),
                "log" => json_encode($result),
            ]);
//            foreach (self::$attachments as $attachment) {
//                unlink($attachment) ;        // Add attachments
//            }
            return [
                "success" => true,
                "result" => $result,
                "detail" => 'Message has been sent'
            ];
        } catch (Exception $e) {
            //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            Emaillog::create([
                "object" => self::$log_info . " - object : " . $this->object . ' to ' . json_encode(self::$emailreceiver),
                "log" => "Message could not be sent. Error detail: {$mail->ErrorInfo}",
            ]);

//            foreach (self::$attachments as $attachment) {
//                unlink($attachment) ;        // Add attachments
//            }
            return [
                "success" => false,
                "detail" => "Message could not be sent. Error detail: {$mail->ErrorInfo}"
            ];
        }
    }

}
