<?php
// user \dclass\devups\model\Model;
use PHPMailer\PHPMailer\PHPMailer;

/**
 * @Entity @Table(name="emailmodel")
 * */
class Emailmodel extends Model implements JsonSerializable, DatatableOverwrite
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
     * @Column(name="title", type="string" , length=255 )
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
     * @return Emailmodel
     */
    public static function model($model){
        return self::getbyattribut("name", $model);
    }

    public function getTest(){
        return '
        <input id="email-'.$this->id.'" class="form-control" name="emailtest" />
        <button type="button" onclick="model.sendmail(this, '.$this->id.')" class="btn btn-info"> Test mail </button>';

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
        return '<a class="btn btn-warning"  href="' . self::classpath("emailmodel/edit?id=") . $this->id . '"> edit</a>';
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
            $content = str_replace("{{" . $key.'}}', $value, $content);
        }

        $content = str_replace("{__env}" , __env, $content);
        //$content = str_replace("__env" , __env, $content);
        return $content;

    }

    public function getPreview()
    {
        $data = [
            "style" => $this->getCss(),
            "activationcode" => "xxxxx",
            "username" => "yyyyy",
        ];
        $message_html = $this->sanitizeContent($this->content, $data);

        ob_start();
        echo $message_html;
        $var = ob_get_contents();
        ob_end_clean();
        return $var;

    }

    public function getCss(){

        $style = "";
        $stylefile = self::classroot("Ressource/css/" . $this->styleressource);
        if (file_exists($stylefile))
            return file_get_contents($stylefile);

        return $this->style;
    }

    static $emailreceiver = [];
    static $namereceiver = [];
    public static function addReceiver($email, $name){
        self::$emailreceiver[] = $email;
        self::$namereceiver[] = $name;
    }

    public function sendMail($datacustom)
    {

        if(!__prod)
            return 0;

        $data = [
            "style" => $this->getCss(),
        ]+$datacustom;
        $message_html = $this->sanitizeContent($this->content, $data);
        $message_text = $this->sanitizeContent($this->contenttext, $data);
// Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            //$mail->SMTPDebug = false;                                       // Enable verbose debug output ->SMTPDebug = false;
            $mail->isSMTP();                                            // Set mailer to use SMTP
            $mail->Host = sm_smtp;  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                                   // Enable SMTP authentication
            $mail->Username = sm_username;                     // SMTP username
            $mail->Password = sm_password;                               // SMTP password
            $mail->SMTPSecure = sm_smtpsecurity;                                  // Enable TLS encryption, `ssl` also accepted
            $mail->Port = sm_port;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom(sm_from, $this->title);
            $mail->addAddress(self::$emailreceiver[0], self::$namereceiver[0]);     // Add a recipient
            //$mail->addAddress('ellen@example.com');               // Name is optional
            $mail->addReplyTo(sm_from, $this->title);
//            $mail->addCC('cc@example.com');
//            $mail->addBCC('bcc@example.com');

            // Attachments
//            $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//            $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $this->object;
            $mail->Body = $message_html;
            $mail->AltBody = $message_text;

            //echo 'Message has been sent';
            return [
                "success" => true,
                "result" => $mail->send(),
                "user" => 'Message has been sent'
            ];
        } catch (Exception $e) {
            //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            return [
                "success" => false,
                "result" => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"
            ];
        }
    }

}
