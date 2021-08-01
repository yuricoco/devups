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
            return ["success" => false, "detail" => t("Cette adresse mail existe déjà!")];

        $user = User::find(Request::get("user_id"));
        $activationcode = RegistrationController::generatecode();
        $user->setActivationcode($activationcode);

        $user->__update();

        $_SESSION[USER] = serialize($user);

        // send mail with activation code $codeactivation
        $data = [
            "activationcode" => route('login').'?vld='.$activationcode.'&u_id='.$user->getId(),
            "activation_code" => $activationcode,
            "username" => $user->getFirstname(),
        ];
        Reportingmodel::init("change_email")
            ->addReceiver($email, $user->getUsername())
            ->sendMail($data);

        return ["success" => true, "detail" => t("code d'activation envoyé")];

    }

    public static function changeemailAction(){
        $user = User::find(Request::get("user_id"));
        $code = sha1(Request::post("activationcode"));

        if($user->getActivationcode() !==  $code )
            return ["success" => false, "detail" => t("Activation code incorrect")];

        if($user->getPassword() !== md5(Request::post("password")))
            return ["success" => false, "detail" => t("Mot de passe incorrect")];

        $user->setEmail(Request::post("email"));

        $user->__update(["email" => Request::post("email")]);

        $_SESSION[USER] = serialize($user);

        return ["success" => true, "detail" => t("adress mail mise a jour")];

    }

    public static function checktelephoneAction()
    {
        if(isset($_POST['phonecode']))
            $country = Country::getbyattribut("phonecode", Request::post("phonecode"));
        else
            $country = Country::getbyattribut("iso", Request::post("country_iso"));

        $phonenumber = User::sanitizePhonenumber(Request::post("phonenumber"), $country->getPhonecode());

        $nbuser = User::select()
            ->where('user.phonenumber', "=", $phonenumber)
            ->__countEl();

        if($nbuser)
            return ["success" => false, "detail" => t("Ce numéro de téléphone existe déjà")];

        $userhydrate = User::find(Request::get("user_id"));

        $activationcode = RegistrationController::generatecode();
        $userhydrate->setActivationcode($activationcode);
        $userhydrate->__update();

        Notification::on($userhydrate, "change_telephone", ["username"=>$userhydrate->getFirstname(), "code"=>$activationcode])
            //->send([$userhydrate])
            ->sendSMS([$country->getPhonecode().$phonenumber]);

        return ["success" => true, "detail" => t("code d'activation vous a été envoyé. Utilisez le pour confirmer le changement de votre numéro.")];

    }

    public static function changetelephoneAction()
    {
        $user = User::find(Request::get("user_id"));
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

    protected function updatesetting(\User $userhydrate){

            $nbuser = User::select()
                ->where('user.email', "=", $userhydrate->getEmail())
                ->__countEl();

            if($nbuser)
                return ["success" => false, "detail" => "email address already use"];

            $nbuser = User::select()
                ->where('phonenumber', "=", $userhydrate->getPhonenumber())
                ->andwhere('country.phonecode', "=", $userhydrate->country->__get("phonecode"))
                ->andwhere('user.id', "!=", $userhydrate->getId())
                ->__countEl();

            if($nbuser)
                return ["success" => false, "detail" => "phonenumber already use"];


        $userhydrate->setUsername($_POST['user_form']['username']);
        $userhydrate->setEmail($_POST['user_form']['emailorphonenumber']);

        $userhydrate->__update();

        //updatesession($userhydrate);
        return ["success" => true, "detail" => "success", "user" => $userhydrate];

    }

    public function register($id = null) {
        extract($_POST);

        // check if username is free
        //$userhydrate = Controller::form_generat(new User($id), $user_form, null, true);
        $userhydrate = new User($id);
        if ( ! is_null($id)){
            $userhydrate = $this->form_generat(new User($id), $user_form);

            if($userhydrate->getPassword() != md5($confirm))
                return ["success" => false, "detail" => "le mot de passe est incorrect"];

            $userhydrate->__update();
            return ["success" => true, "detail" => "success", "user" => $userhydrate];

        }

        $userhydrate = $this->form_generat(new User(), $user_form);

        $qb = new QueryBuilder(new User());
        $qb->select();

        $qb->where('this.phonenumber', "=", $userhydrate->getPhonenumber());

            $nbuser = $qb
                //->orwhere('user.username_canonical', "=", $userhydrate->getUsername_canonical())
                ->__countEl();

            if($nbuser) {
                $nbuser = User::select()
                    ->where('this.phonenumber', "=", $userhydrate->getPhonenumber())
                    //->andwhere('country.phonecode', "=", $userhydrate->country->__get("phonecode"))
                    ->__countEl();

                if ($nbuser)
                    return ["success" => false, "detail" => "phonenumber already use"];
            }

        if($userhydrate->getEmail()){

            $qb = User::where('this.email', "=", $userhydrate->getEmail());

            $nbuser = $qb
                //->orwhere('user.username_canonical', "=", $userhydrate->getUsername_canonical())
                ->__countEl();

            if($nbuser) {
                $nbuser = User::select()
                    ->where('user.email', "=", $userhydrate->getEmail())
                    ->__countEl();

                if($nbuser)
                    return ["success" => false, "detail" => "email address already use"];

            }
        }

        $userhydrate->setPassword(md5($user_form['password']));
        //$userhydrate->setUsername($user_form['username']);

        $activationcode = RegistrationController::generatecode();
        $userhydrate->setActivationcode($activationcode);

        // todo: handle it better
        $userhydrate->setIs_activated(1);
        $userhydrate->setApiKey(\DClass\lib\Util::randomcode());

        $userhydrate->__insert();

        $_SESSION[USER] = serialize($userhydrate);
        $_SESSION[USERID] = $userhydrate->getId();

        if($userhydrate->getEmail()) {
            $data = [
                "activationcode" => $activationcode,
                "username" => $userhydrate->getFirstname(),
            ];
            Reportingmodel::init("registered")
                ->addReceiver($userhydrate->getEmail(), $userhydrate->getUsername())
                ->sendMail($data);
        }

        // todo: send notification to seller
        Notification::on($userhydrate, "registered", ["username"=>$userhydrate->getFirstname(), "code"=>$activationcode])
            ->send([$userhydrate])
            ->sendSMS([$userhydrate->getTelephone()]);

        return ["success" => true,
            //"activationcode" => $activationcode,
            "detail" => "success", "user" => $userhydrate];

    }

    public static function resendactivationcode() {

        $user = User::find(Request::get("user_id"));
        $activationcode = RegistrationController::generatecode();
        $user->setActivationcode($activationcode);

        $user->__update();
        
        $_SESSION[USER] = serialize($user);

        // send mail with activation code $codeactivation
        if($user->getEmail()) {
            $data = [
                "activation_link" => route('login') . '?vld=' . $activationcode . '&u_id=' . $user->getId(),
                "username" => $user->getFirstname(),
            ];
            Reportingmodel::init("verify_account")
                ->addReceiver($user->getEmail(), $user->getUsername())
                ->sendMail($data);
        }

        Notification::on($user, "verify_account", ["username"=>$user->getFirstname(), "code"=>$activationcode])
            //->send([$userhydrate])
            ->sendSMS([$user->getTelephone()]);

        // send sms with activation code $codeactivation
        //RegistrationController::sendsms($activationcode, null, $user);

        return [
            "success" => true,
            //"activationcode" => $activationcode,
            "detail" => t("un nouveau code d'activation vous a été renvoyé.")
        ];

    }

    public static function activateaccount() {
//        global $appuser;
        $appuser = User::find(Request::get("user_id"));

        //return $_POST;
        if ($appuser->isActivated())
            return ["success" => true, "url" => route('home')];
        else {
            $code = sha1($_POST['user_form']["activationcode"]);
            if ($code == $appuser->getActivationcode()) {
            //if (substr($code, 0, 5) == $appuser->getActivationcode()) {

                $appuser->setIs_activated(1);
                //$appuser->setLocked(false);
                $appuser->__update();
                //updatesession($appuser);
                $_SESSION[USERAPP] = serialize($appuser);

                return ["success" => true, "url" => route("user-profile")];
            }
        }

        return [
            "success" => false,
            'error' => t("Le code d'activation n'est pas valide. Veuillez entrer de nouveau ou alors renvoyer un autre code")
        ];

    }

    public static function step3Action() {
        extract($_POST);

        $userapp = userapp();

        $userapp->setRegistered(4);
        $userapp->setEnabled(true);
        $userapp->setLocked(false);

        (new DBAL())->executeDbal("update user set registered = 4, enabled = 1 where id = " . $_SESSION[USERID]);

        updatesession($userapp);

        return ['success' => true];
    }

    public static function step1Action() {
        extract($_POST);

        if(isset($_POST['activationcode'])){
            $activated = self::activateaccount();
            if(!$activated["success"])
                return $activated;

        }

        $userapp = userapp();

        $userapp->setRegistered(2);

        (new DBAL())->executeDbal("update user set registered = 2 where id = " . $userapp->getId());
        updatesession($userapp);

        return ['success' => true];

    }

    public static function step2Action($user_form = []) {
        extract($_POST);

        $userhydrate = userapp();

        if(isset($user_form['email'])){

            $user = User::select()->where("user.email", $user_form['email'])->__getOne(false);
            if ($user->getId() && $userhydrate->getId() != $user->getId()) {
                return ['success' => false, "error" => "this email already exist"];
            }

            $userhydrate->setEmail($user_form['email']); // next step
        }elseif(isset($user_form['userphonenumber'])){

            $user = User::select()
                ->where('userphonenumber', "=", $user_form['userphonenumber'])
                ->andwhere('countrylight.phonecode', "=", $userhydrate->countrylight->__get("phonecode"))
                ->__getOne(false);

            if ($user->getId() && $userhydrate->getId() != $user->getId() && $userhydrate->getUserphonenumber())
                return ["success" => false, "error" => "phonenumber already use"];

            $userhydrate->setUserphonenumber($user_form['userphonenumber']); // next step

        }

        //$userhydrate = Controller::form_generat($userapp, $user_form);
        $userhydrate->setUsername($user_form['username']); // next step
        //$userhydrate->setUsername_canonical(clean(remove_accents($user_form['username']))); // next step
        $userhydrate->setRegistered(3); // next step

//        if (!isset($user_form['professionalstatut_id'])) {
//            $userhydrate->setProfessionalstatut(new Professionalstatut());
//        }

        $userhydrate->__update();
        updatesession($userhydrate);
        User::$jsonmodel = 1;
        return [
            'success' => true,
            'user' => $userhydrate
        ];
    }

    public function complation($id)
    {
        extract($_POST);

        $user = $this->form_fillingentity(new User($id), $user_form);

        $user->__update();
        return 	array(	'success' => true,
            'user' => $user,
            'detail' => '');

    }

}
