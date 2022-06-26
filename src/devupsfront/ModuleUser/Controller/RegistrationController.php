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
            ->count();

        if($nbuser)
            return ["success" => false, "detail" => t("Cette adresse mail existe déjà!")];

        $user = User::find(Request::get("user_id"));
        $activationcode = RegistrationController::generatecode();
        $user->setActivationcode($activationcode);

        $user->__update();

        $_SESSION[USER] = serialize($user);

        // send mail with activation code $codeactivation
        $data = [
            "activation_link" => route('login').'?vld='.$activationcode.'&u_id='.$user->getId(),
            "activation_code" => $activationcode,
            "username" => $user->getFirstname(),
        ];
        Reportingmodel::init("change_email", Dvups_lang::getByIsoCode($user->lang)->id)
            ->addReceiver($email, $user->getUsername())
            ->sendMail($data);

        return ["success" => true, "detail" => t("code d'activation envoyé")];

    }

    public static function changeemailAction(){
        $user = User::find(Request::get("user_id"));
        $code = sha1(Request::post("activationcode"));

        if($user->getActivationcode() !==  $code )
            return ["success" => false, "detail" => t("Activation code incorrect")];

        if($user->getPassword() !== sha1(Request::post("password")))
            return ["success" => false, "detail" => t("Mot de passe incorrect")];

        $user->setEmail(Request::post("email"));

        $user->__update(["email" => Request::post("email")]);

        $_SESSION[USER] = serialize($user);

        return ["success" => true, "detail" => t("adress mail mise a jour")];

    }

    public static function checktelephoneAction()
    {
        if(isset($_POST['phonecode']))
            $country = Country::where("phonecode", Request::post("phonecode"))->firstOrNull();
        else
            $country = Country::where("iso", Request::post("country_iso"))->firstOrNull();

        if (is_null($country)){
            return [
                'success'=> false,
                'detail'=> t('country not found'),
            ];
        }

        $phonenumber = User::sanitizePhonenumber(Request::post("phonenumber"), $country->getPhonecode());

        $nbuser = User::select()
            ->where('user.phonenumber', "=", $phonenumber)
            ->count();

        if($nbuser)
            return ["success" => false, "detail" => t("Ce numéro de téléphone existe déjà")];

        $userhydrate = User::find(Request::get("user_id"));

        $activationcode = RegistrationController::generatecode();
        $userhydrate->setActivationcode($activationcode);
        $userhydrate->__update();

        $userhydrate->phonenumber = $phonenumber;

        Notification::on($userhydrate, "change_telephone", -1)
            ->send($userhydrate, ["username"=>$userhydrate->username, "code"=>$activationcode]);

        return ["success" => true, "detail" => t("code d'activation vous a été envoyé. Utilisez le pour confirmer le changement de votre numéro.")];

    }

    public static function changetelephoneAction()
    {
        $user = User::find(Request::get("user_id"));
        $code = sha1(Request::post("activationcode"));

        if($user->getActivationcode() !==  $code )
            return ["success" => false, "detail" => t("Activation code incorrect")];

        if($user->getPassword() !== sha1(Request::post("password")))
            return ["success" => false, "detail" => t("Mot de passe incorrect")];

        $user->setPhonenumber(Request::post("phonenumber"));

        $user->__update();

        $_SESSION[USER] = serialize($user);

        return ["success" => true, "detail" => t("Numéro de téléphone mise a jour")];

    }

    public static function generatecode() {

        $datetime = new DateTime();

        if (__prod)
            $generate = sha1($datetime->getTimestamp());
        else
            $generate = '12345';

        return substr($generate, 0, 5);
    }

    public static function resendactivationcode() {

        $user = User::find(Request::get("user_id"));
        $activationcode = RegistrationController::generatecode();
        $user->setActivationcode($activationcode);

        $user->__update();
        
        $_SESSION[USER] = serialize($user);

        // send mail with activation code $codeactivation
        if ($user->getEmail()) {
            $data = [
                "activation_link" => route('login') . '?vld=' . $activationcode . '&u_id=' . $user->getId(),
                "activation_code" => $activationcode,
                "username" => $user->getFirstname(),
            ];
            Reportingmodel::init("reset-password", Dvups_lang::getByIsoCode($user->lang)->id)
                ->addReceiver($user->getEmail(), $user->getUsername())
                ->sendMail($data);
        }

        Notification::$send_sms = true;
        Notification::on($user, "reset-password")
            ->send($user, ["username"=>$user->getFirstname(), "code"=>$activationcode]);

        return [
            "success" => true,
            //"activationcode" => $activationcode,
            "detail" => t("un nouveau code d'activation vous a été renvoyé.")
        ];

    }

    public static function activateaccount() {   
//        global $appuser;
        $appuser = User::find(Request::get("user_id"));

        return $appuser->activateaccount($_POST["activationcode"], route("home"));
    }

}
