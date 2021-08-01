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
class LoginController
{

    static function logout()
    {

        unset($_SESSION[USERID]);
        unset($_SESSION[USERAPP]);
        unset($_SESSION["setting"]);
        session_destroy();

        if (isset($_COOKIE[USERCOOKIE])) {
            setcookie(USERCOOKIE, null, -1, null, null, false, true);
            setcookie(USERMAIL, null, -1, null, null, false, true);
            setcookie(USERPASS, null, -1, null, null, false, true);
        }

        if (isset($_GET['extern']))
            return ["success" => true];

        redirect(route("login"));
    }

    private static function setcookie($email, $pass)
    {
        setcookie(USERCOOKIE, 1, time() + 365 * 24 * 3600, null, null, false, true); // On écrit un cookie
        setcookie(USERMAIL, $email, time() + 365 * 24 * 3600, null, null, false, true); // On écrit un cookie
        setcookie(USERPASS, $pass, time() + 365 * 24 * 3600, null, null, false, true); // On écrit un autre cookie...
    }

    public static function resetactivationcode()
    {
        extract($_POST);

        $user = User::select()
            ->where('user.username', $user_form["login"])
            ->orwhere('user.email', $user_form["login"])
            ->orwhere('user.phonenumber', $user_form["login"])
            ->__getOne();

        if ($user->getId()) {

            if ($user_form["login"] == $user->getPhonenumber()) {
                if (!isset($user_form['country_iso'])) {
                    return array("success" => false,
                        "error" => t('Country has not been specified. important for phonenumber'));
                }
                $country = Country::getbyattribut("iso", $user_form['country_iso']);
            }
            if($country->getId())
                $user->country = $country;

            return LoginController::initialiseUserParam($user) + ["user" => $user];
        } else {
            return array("success" => false,
                "error" => 'No user found');
        }
    }

    private static function initialiseUserParam(\User $user)
    {

        $activationcode = RegistrationController::generatecode();

        $user->setIs_activated(false);
        //$user->setLocked(true);
        $user->setResettingpassword(true);
        $user->setActivationcode($activationcode);
        $user->__update();

        $_SESSION[USERID] = $user->getId();
        $_SESSION[USERAPP] = serialize($user);
        //$_SESSION[LANG] = $user->getLocale();

        //updatesession($user);

        if($user->getEmail()){
            $data = [
                "activation_link" => route('login').'?vld='.$activationcode.'&u_id='.$user->getId(),
                "activation_code" => $activationcode,
                "username" => $user->getFirstname(),
            ];
            Reportingmodel::init("reset-password")
                ->addReceiver($user->getEmail(), $user->getUsername())
                ->sendMail($data);
        }

        Notification::on($user, "reset-password", ["activationcode"=>$activationcode])
            ->sendSMS([$user->getTelephone()]);

        return array('success' => true, 'user' => $user, 'activationcode' => $activationcode, 'url' => "" . d_url("reset-password"));

    }

    public static function resetpassword()
    {
        extract($_POST);
        $userapp = User::find(Request::get("userid"));

        $code = sha1($user_form['activationcode']);
        if ($code == $userapp->getActivationcode()) {
        //if (substr($code, 0, 5) == $userapp->getActivationcode()) {

            //$userapp->setSalt(sha1($_POST['password']));
            $userapp->setPassword(md5(($user_form['password'])));
            $userapp->setIs_activated(1);
            $userapp->setResettingpassword(0);
            $userapp->__update();

            $_SESSION[USERAPP] = serialize($userapp);
            //updatesession($userapp);

            return ["user" => $userapp, "success" => true,
                "url" => route("customer-dashboard") . "", ];
        } else {
            return ["success" => false, "error" => t("Code d'activation incorrect!")];
        }
    }

    public static function changepwAction()
    {

        $user = User::find(Request::get("id"));
        extract($_POST);

        if (!$_POST['currentpassword'] || !$_POST['newpassword'] || !$_POST['confirmpassword'])
            return array('success' => false,
                'detail' => t("Tous les champs sont important"));

        if ($_POST['newpassword'] != $_POST['confirmpassword'])
            return array('success' => false,
                'detail' => t("password.notconfirm"));

        if (md5($_POST['currentpassword']) == $user->getPassword()) {
            $user->__update([
                "password" => md5($_POST['newpassword'])
            ]);
            return array('success' => true,
                'detail' => t('Mot de passe mise à jour avec succès'));
        } else {
            return array('success' => false,
                'detail' => t("Mot de passe incorrect"));
        }
    }

    public static function setLastLoginDateAction()
    {

        $dbal = new DBAL();
        $sql = " update user set last_login = NOW() where id = ? ";
        $dbal->executeDbal($sql, [$_SESSION[USERID]]);
    }

    static function restartsessionAction()
    {

        if (!isset($_COOKIE[USERPASS]) || !isset($_COOKIE[USERPASS]) )
            return 0;

        if(isset($_SESSION[USER]))
            return 0;

        //$dbal = new DBAL(new User());
        //$user = $dbal->findOneElementWhereXisY(['user.email', 'user.devupspwd'], [$_COOKIE[USERMAIL], $_COOKIE[USERPASS]]);
        $user = User::where("this.email", $_COOKIE[USERMAIL])->andwhere('user.password', $_COOKIE[USERPASS])->__getOne();
        if ($user->getId()) {
            self::initSession($user);
            //header("location: " . __env . $url);
        } else {
            redirect(route("login"));
            //header("location: " . route("login") . "");
        }
    }

    public static function initSession(\User $user, $remember_me = null){

        $datetime = date("Y-m-d H:i:s");
        User::where("this.id", $user->getId())->update([
            "last_login" => $datetime,
            "session_token" => sha1($datetime),
        ]);

        $_SESSION[USERAPP] = serialize($user);
        $_SESSION[USERID] = $user->getId();

        // LoginController::setLastLoginDateAction();

        if (isset($remember_me)) {
            //set cookie
            LoginController::setcookie($user->getEmail(), $user->getPassword());
        }

        $url = "user-profile";
//        if (!$user->isActivated())
//            $url = "activate-account";

        return $url;
    }

    static function connexionAction($extern = false)
    {
        extract($_POST);

        //$password = md5($user_form["password"]);
//        $user = User::getbyattribut("phonenumber", 694573490);
//        Notification::on($user, "registered", ["username"=>$user->getFirstname(), "code"=>"test code"])
//            ->send([$user])->sendSMS([$user->getTelephone()]);

        $user = User::select()
            ->where('user.password', "=", md5($password))
            ->andwhere('user.email', "=", $login)
            ->__getOne();

        if (!$user->getId()) {
            $user = User::select()
                ->where('user.password', "=", md5($password))
                ->andwhere('user.phonenumber', "=", $login)
                ->__getOne();

            if (!$user->getId())
                return array("success" => false,
                    "user" => $user,
                    "error" => ["login" => 'erreur de connexion. Login ou mot de passe incorrecte']);

        }
        //if ($user->getId()) {

        // todo: send notification to seller

        $url = self::initSession($user);
        return array(
            'success' => true,
            'detail' => t("Connexion réussi"),
            "user" => User::find($user->getId()),
            "redirect" => route($url),
            //"userserialize" => $_SESSION[USERAPP]
        );

    }

}
