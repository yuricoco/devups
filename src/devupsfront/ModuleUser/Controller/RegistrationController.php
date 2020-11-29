<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RegistrationController
 *
 * @author azankang
 */

use dclass\devups\Controller\Controller;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class RegistrationController extends Controller {

    public static function checkmailAction()
    {
        $email = Request::post("email");

        $nbuser = User::select()
            ->where('user.email', "=", $email)
            ->__countEl();

        if($nbuser)
            return ["success" => false, "detail" => t("email address already use")];

        self::resendactivationcode();

        return ["success" => true, "detail" => t("code d'activation envoyé")];

    }

    public static function changeemailAction(){
        global  $user;
        $code = sha1(Request::post("activationcode"));

        if($user->getActivationcode() !==  $code )
            return ["success" => false, "detail" => t("Activation code incorrect")];

        if($user->getPassword() !== md5(Request::post("password")))
            return ["success" => false, "detail" => t("Mot de passe incorrect")];

        $user->setEmail(Request::post("email"));

        $user->__update();

        $_SESSION[USER] = serialize($user);

        return ["success" => true, "detail" => t("adress mail mise a jour")];

    }

    public static function checktelephoneAction()
    {
        $email = Request::post("phonenumber");

        $nbuser = User::select()
            ->where('user.phonenumber', "=", $email)
            ->__countEl();

        if($nbuser)
            return ["success" => false, "detail" => t("Phonenumber address already use")];

        self::resendactivationcode();

        return ["success" => true, "detail" => t("code d'activation envoyé")];

    }

    public static function changetelephoneAction()
    {

        global  $user;
        $code = sha1(Request::post("activationcode"));

        if($user->getActivationcode() !==  $code )
            return ["success" => false, "detail" => t("Activation code incorrect")];

        if($user->getPassword() !== md5(Request::post("password")))
            return ["success" => false, "detail" => t("Mot de passe incorrect")];

        $user->setPhonenumber(Request::post("phonenumber"));

        $user->__update();

        $_SESSION[USER] = serialize($user);

        return ["success" => true, "detail" => t("Numéro de téléphone mise a jour")];

    }

    private static function generateusername($param) {
        $username = remove_accents($param);
        $username = str_replace(" ", ".", $username);

        $user = User::select()->where("user.username", $username)->__getOne();

        if ($user->getId()) {
            $list = "1234567890";
            mt_srand((double) microtime() * 10000);
            $generate = "";
            while (strlen($generate) < 3) {
                $generate .= $list[mt_rand(0, strlen($list) - 1)];
            }

            if (strlen($username) > 6)
                $alias = substr($username, 0, -(strlen($username) - 6));
            else
                $alias = $username;

            return $alias . $generate;
        }


        return $username;
    }

    public static function generatecode() {

        $datetime = new DateTime();

        if (__prod)
            $generate = sha1($datetime->getTimestamp());
        else
            $generate = '12345';

        return substr($generate, 0, 5);
    }


    public function register($user_form, \User $userhydrate) {

        $userhydrate->setPassword(md5($user_form['password']));

        $activationcode = RegistrationController::generatecode();
        $userhydrate->setActivationcode($activationcode);

        // todo: handle it better
        $userhydrate->setIs_activated(1);

        $userhydrate->__update();

        $_SESSION[USER] = serialize($userhydrate);
        $_SESSION[USERID] = $userhydrate->getId();


        if($userhydrate->getEmail())
            // send mail with activation code $codeactivation
            Emailmodel::model( "registration")->sendMail($userhydrate, $activationcode);
//        else
//            // send sms with activation code $codeactivation
//            RegistrationController::sendsms($activationcode, null, $userhydrate);

        return ["success" => true, "activationcode" => $activationcode, "detail" => "success", "user" => $userhydrate];

    }

    public static function resendactivationcode() {
        
        global $user;

        $activationcode = RegistrationController::generatecode();
        $user->setActivationcode($activationcode);

        $user->__update();
        
        $_SESSION[USER] = serialize($user);

        // send mail with activation code $codeactivation
        RegistrationController::sendmail($activationcode, $user);

        // send sms with activation code $codeactivation
        //RegistrationController::sendsms($activationcode, null, $user);

        return ["success" => true, "activationcode" => $activationcode, "detail" => "un nouveau code d'activation vous a ete renvoyé par mal."];
    }

    /**
     * implementation of swiftmailler
     * 
     * @param type $activationcode
     * @param \User $userhydrate
     */
    public static function sendmail($activationcode, $userhydrate)
    {

        // create curl resource
        if (!__prod)
            return 0;

        include __DIR__ . '/../Ressource/emailtemplate/mail.php';

        //$mail = $userhydrate->getEmail(); // Déclaration de l'adresse de destination.
        $message_html = getmailtemplate($activationcode, $userhydrate);
// Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer(true);
        $subject = t("Bienvenu sur Buyamsellam24. Votre code d'activation.");

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
            $mail->setFrom(sm_from, t("email.title", 'Buyamsellam24'));
            $mail->addAddress($userhydrate->getEmail(), $userhydrate->getFirstname());     // Add a recipient
            //$mail->addAddress('ellen@example.com');               // Name is optional
            $mail->addReplyTo(sm_from, t("email.title", 'Buyamsellam24'));
//            $mail->addCC('cc@example.com');
//            $mail->addBCC('bcc@example.com');

            // Attachments
//            $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//            $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body = $message_html;
            $mail->AltBody = 'Bonjour, ' . $userhydrate->getFirstname() . '
							Bien vouloir utiliser le code d\'activation ci-après pour activer votre compte Buyamsellam24.
							Code d\'activation: [' . $activationcode . ']';

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

    public static function activateaccount() {
//        global $appuser;
        $appuser = userapp();

        //return $_POST;
        if ($appuser->isActivated())
            return ["success" => true, "url" => d_url('home')];
        else {
            $code = sha1($_POST['user_form']["activationcode"]);
            if ($code == $appuser->getActivationcode()) {
            //if (substr($code, 0, 5) == $appuser->getActivationcode()) {

                $appuser->setIs_activated(true);
                //$appuser->setLocked(false);
                $appuser->__update();
                //updatesession($appuser);
                $_SESSION[USERAPP] = serialize($appuser);

                return ["success" => true, "url" => d_url("customer-dashboard")];
            }
        }

        return [
            "success" => false,
            'error' => "Activation code not valide. ensure that there is no space"
        ];
    }

    public function listView($next = 1, $per_page = 10)
    {
        // TODO: Implement listView() method.
    }
}
