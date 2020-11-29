<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LoginController
 *
 * @author azankang
 */

use \Firebase\JWT\JWT;
use PHPMailer\PHPMailer\PHPMailer;

class LoginController
{

    static function logout($rest = false)
    {

        unset($_SESSION[USERID]);
        unset($_SESSION[USER]);
        //session_destroy();

        if (isset($_COOKIE[USERCOOKIE])) {
            setcookie(USERCOOKIE, null, -1, null, null, false, true);
            //setcookie(USERMAIL, null, -1, null, null, false, true);
            //setcookie(API_TOKEN, null, -1, null, null, false, true);
            //setcookie(USERPASS, null, -1, null, null, false, true);
        }

        if ($rest)
            return ["success" => true];

        header("location: " . route("login"));

    }

    public static function startsessionAction(\User $user)
    {

        $_SESSION[USER] = serialize($user);
        $_SESSION[USERID] = $user->getId();

    }

    public static function initResetPassword()
    {
        // todo: send an email with the activation code.
        // todo: init a session resetpassword
    }

    protected static function setcookie($token)
    {
        setcookie(USERCOOKIE, 1, time() + 365 * 24 * 3600, null, null, false, true); // On écrit un cookie
        //setcookie(USERMAIL, $email, time() + 365 * 24 * 3600, null, null, false, true); // On écrit un cookie
        //setcookie(API_TOKEN, $token, time() + 365 * 24 * 3600, null, null, false, true); // On écrit un cookie
        //setcookie(USERPASS, $pass, time() + 365 * 24 * 3600, null, null, false, true); // On écrit un autre cookie...
    }

    public static function resetactivationcode()
    {
        extract($_POST);

        if (isset($_SESSION[USERID])) {
            $user = userapp();
            if (isset($useremail))
                $user->__update("email", $useremail)->exec();
            else
                $user->__update("telephone", $telephone)->exec();

        } else
            $user = User::select()
                ->where('user.email', $login)
                ->orwhere('user.telephone', $login)
                ->__getOne();

        if ($user->getId()) {
            return LoginController::initialiseUserParam($user);
        } else {
            return array("success" => false,
                "error" => 'No user found');
        }
    }

    protected static function initialiseUserParam(\User $user)
    {

        $activationcode = RegistrationController::generatecode();

        $user->setActivated(false);
        $user->setLocked(true);
        $user->setEnabled(false);
        $user->setCredentials_expired(true);
        $user->setActivationcode($activationcode);
        $user->__update();

        $qb = new QueryBuilder(new Phonenumber());
        $phonenumber = $qb->select()->where($user)->__getOne();

        $_SESSION[USERID] = $user->getId();
        $_SESSION[LANG] = $user->getLocale();

        updatesession($user);

        if ($user->getUserphonenumber())
            RegistrationController::sendsms($activationcode, $phonenumber, $user);

        if ($user->getEmail())
            RegistrationController::sendmail($activationcode, $user);

        return array('success' => true, 'url' => "" . __env . "resetpassword");

    }

    public static function resetpassword()
    {

        $user = User::find(Request::get('userid'));
        $token = Request::post('token');

        if (sha1($token) != $user->getToken()) {
            Responsehistory::fail("message", "error token");
            return Responsehistory::$data;
        }

        $user->setToken("");
        $user->setPassword(Request::post('password'));
        $user->__update();

        Responsehistory::set("message", "password changed with success");
        return Responsehistory::$data;

    }

    public static function lostpassword()
    {
        $identify = Request::post('identify', null);
        $result = [];
        $token = (new Dvups_admin())->generatePassword();

        if (!$identify) {
            Responsehistory::set("success", false);
            Responsehistory::set("detail", "identify empty");

            return Responsehistory::$data;

        }

        $user = User::select()
            ->where('phonenumber', "=", $identify)
            ->__getOne();

        if (!$user->getId()) {

            $user = User::select()
                ->where('email', "=", $identify)
                ->__getOne();

            if (!$user->getId())
                return array("success" => false, "user" => $user,
                    "error" => 'erreur aucun utilisateur correspondant à ' . $identify);

            $result = UserFrontController::sendmail($token, $user);

        }
        // else
        //    UserFrontController::sendsms();

        //$pwd = (new Dvups_admin())->generatePassword();
        $user->setToken(sha1($token));
        // send via mail or sms
        $user->__update();

        return ["success" => true, "user" => $user, "token" => $token, "detail" => "Reset password process init"];

    }

    public static function setLastLoginDateAction($id)
    {
        $dbal = new DBAL();
        $sql = " update `user` set last_login = NOW() where id = ? "; // , api_token = '$token'
        $dbal->executeDbal($sql, [$id]);
    }

    static function restartsessionAction()
    {

        $token = $_COOKIE[API_TOKEN];
        try {
            // decode jwt
            $decoded = JWT::decode($token, jwt_key, array('HS256'));

            // set response code
            http_response_code(200);

            $user = User::find($decoded->data->id);
            if ($user->getId()) {
                $jwt = \DClass\devups\Util::generateToken($user);
                $user->setApi_token($jwt);
                $_SESSION[USERAPP] = serialize($user);
                $_SESSION[USERID] = $user->getId();
                $_SESSION[LANG] = $user->getLocale();
                LoginController::setLastLoginDateAction($jwt);

                header("location: " . __env . "");

            } else {

                self::logout();
            }

        } // if decode fails, it means jwt is invalid
        catch (\Exception $e) {
            self::logout();
        }

    }

    public static function connexionAction($extern = false)
    {
        //$login = Request::post('userdate');
        $login = Request::post('login');
        $password = md5(Request::post('password'));

        $user = User::select()
            ->where('user.password', "=", $password)
            ->andwhere('telephone', "=", $login)
            ->__getOne();

        if (!$user->getId()) {

                $user = User::select()
                    ->where('user.password', "=", $password)
                    ->andwhere('email', "=", $login)
                    ->__getOne();

                if (!$user->getId())
                    return array("success" => false,
                        "error" => 'erreur de connexion. Login ou mot de passe incorrecte');

        }

        // we specify which jsonmodel we want
        User::$jsonmodel = 1;

        self::startsessionAction($user);
//        $connexion_history = new Connexion_history(null, $user->getId());
//        $connexion_history->persist(date("Y-m-d"));
        // Generating Token JWT
//        $jwt = \DClass\devups\Util::generateToken($user);
//
//        $user->setApi_token($jwt);

        // LoginController::setLastLoginDateAction($user->getId());// $jwt

        return array(
            'success' => true,
            'redirect' => route("dashboard"),
            "user" => $user,
            "detail" => "Connexion réussite",
            //"jwt" => $jwt,
            //"lang" => $user->getLocale(),
        );

    }

    public static function changePassword()
    {
        extract($_POST);
        $user = User::find(Request::get('id'), false);

        if (sha1($oldpwd) == $user->getPassword()) {

            // $user->setPassword($newpwd);
            $user->__update("password", sha1($newpwd))->exec();

            return array('success' => true, // pour le restservice
                'message' => "Mot de passe modifié avec succes");

        } else {
            return array('success' => false, // pour le restservice
                'message' => 'Ancien Mot de passe non valide');
        }
    }

    public function resetcredential($id)
    {

        $login = Request::post("identifiant");

        $user = \User::select()
            ->where('phonenumber', "=", $login)
            ->__getOne();

        if (!$user->getId()) {

            $user = \User::select()
                ->where('email', "=", $login)
                ->__getOne();

            if (!$user->getId())
                return array("success" => false,
                    "error" => 'erreur de connexion. Login ou mot de passe incorrecte');

        }
        $password = (new User())->generatePassword();
        $user->setPassword(sha1($password));
//        $user->setLogin();
        $user->generateLogin($user->getName());

        $user->__save();

        (new Dvups_adminController())->sendmail($password, $user);

        return array('success' => true, // pour le restservice
            'User' => $user,
            'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
        //
    }

    /**
     * implementation of swiftmailler
     *
     * @param type $activationcode
     * @param \User $userhydrate
     */
    public static function sendmail($message, $activationcode, \User $userhydrate)
    {

        // create curl resource
        if (!__prod)
            return 0;

        //include __DIR__ . '/../Ressource/emailtemplate/mail.php';

//=====Déclaration des messages au format texte et au format HTML.
        $message_html = self::getmailtemplate($message, $activationcode, $userhydrate);

        $mail = new PHPMailer(true);
        $subject = "Bienvenu sur " . PROJECT_NAME . ".";

        try {
            //Server settings
            // $mail->SMTPDebug = 2;                                       // Enable verbose debug output ->SMTPDebug = false;
            $mail->isSMTP();                                            // Set mailer to use SMTP
            $mail->Host = sm_smtp;  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                                   // Enable SMTP authentication
            $mail->Username = sm_username;                     // SMTP username
            $mail->Password = sm_password;                               // SMTP password
            $mail->SMTPSecure = sm_smtpsecurity;                                  // Enable TLS encryption, `ssl` also accepted
            $mail->Port = sm_port;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom(sm_from, PROJECT_NAME);
            $mail->addAddress($userhydrate->getEmail(), $userhydrate->getFirstname());     // Add a recipient
            //$mail->addAddress('ellen@example.com');               // Name is optional
            $mail->addReplyTo(sm_from, PROJECT_NAME);
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
							' . $message . '.
							Lient: [' . $activationcode . ']';

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

    public static function getmailtemplate($message, $activationcode, \User $user)
    {

        $css = file_get_contents(ROOT . "admin/assets/emailtemplate/email.css");
        $username = $user->getFirstname();
        $sitename = PROJECT_NAME;
        $logo = assets . "img/logo-lvdp-min3.jpg";
        return <<<EOF
<!DOCTYPE html>
	<html>
	<head>
	<meta name="viewport" content="width=device-width" />

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Connexion $sitename</title>
	<style> $css </style>

	</head>
	 
	<body bgcolor="#FFFFFF">

	<!-- HEADER -->
	<table class="head-wrap" bgcolor="#ffffff">
		<tr>
			<td></td>
			<td class="header container" >
					
					<div class="content">
					<table bgcolor="#ffffff">
						<tr>
							<td><img src="$logo" /></td>
							<td align="right"><h6 class="collapse">Connexion</h6></td>
						</tr>
					</table>
					</div>
					
			</td>
			<td></td>
		</tr>
	</table><!-- /HEADER -->


	<!-- BODY -->
	<table class="body-wrap">
		<tr>
			<td></td>
			<td class="container" bgcolor="#FFFFFF">

				<div class="content">
				<table>
					<tr>
						<td>
							<h3>Bonjour, $username </h3>
							<p>$message</p>
							<a class="btn">Lien: </a>
							<h2 class="btn"> $activationcode </h2>
											
							<!-- Callout Panel -->
						<!--<p class="callout">
							Toutes l'équipe SPACEKOLA vous souhaite un <b>joyeux noël </b> et une très <b>bonne année 2018 </b>
						</p> /Callout Panel -->
						
						</td>
					</tr>
				</table>
				</div><!-- /content -->
										
			</td>
			<td></td>
		</tr>
	</table><!-- /BODY -->

	<!-- FOOTER -->
	<table class="footer-wrap">
		<tr>
			<td></td>
			<td class="container">
				
					<!-- content -->
					<div class="content">
					<table>
					<tr>
						<td align="center">
							<p>
								<a href="#">$sitename</a> |
								<a href="#">Merci</a> 
								
							</p>
						</td>
					</tr>
				</table>
					</div><!-- /content -->
					
			</td>
			<td></td>
		</tr>
	</table><!-- /FOOTER -->

	</body>
	</html>
EOF;

    }


}
