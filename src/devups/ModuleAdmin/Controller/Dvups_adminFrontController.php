<?php


namespace devups\ModuleAdmin\Controller;


use Dvups_admin;
use Request;

class Dvups_adminFrontController extends \Dvups_adminController
{

    public function ll($next = 1, $per_page = 10)
    {

        $qb = Dvups_admin::select()->where("dvups_role_id", "is", null);

        return $this->lazyloading(new \Dvups_admin(), $next, $per_page, $qb);

    }

    public function createAction($user_form = null)
    {
        $rawdata = \Request::raw();
        $dvups_admin = $this->hydrateWithJson(new \Dvups_admin(), $rawdata["admin"]);

        $password = $dvups_admin->generatePassword();
        $dvups_admin->setPassword(sha1($password));
        $dvups_admin->setLogin($dvups_admin->generateLogin());

        $id = $dvups_admin->__insert();

        $this->sendmail($password, $dvups_admin);

        $data = $this->ll();
        $data["admincreated"] = ["admin" => $dvups_admin, "password" => $password,];

        return $data;

    }

    public function updateAction($id, $user_form = null)
    {

        $rawdata = \Request::raw();
        $dvups_admin = $this->hydrateWithJson(new \Dvups_admin($id), $rawdata["admin"]);

        if (isset($rawdata["admin"]["oldpwd"], $rawdata["admin"]["newpwd"])) {
            $result = $dvups_admin->updatePassword($rawdata["admin"]["oldpwd"], $rawdata["admin"]["newpwd"]);

            if (!is_null($result) && $result == false) {
                \Response::fail("error", "Mot de passe incorrecte!");
                return \Response::$data;
            }
        }
        $dvups_admin->__update();

        $data = $this->ll();
        $data["adminupdated"] = ["admin" => $dvups_admin,
            "password" => $rawdata["admin"]["newpwd"],];

        return $data;


    }

    public function changeStatusAction()
    {

        $id = \Request::get("id");

        $rawdata = \Request::raw();
        $admin = $this->hydrateWithJson(new \Dvups_admin($id), $rawdata["admin"]);

        $admin->__update();

        \Response::set("admin", $admin);

        return \Response::$data;

    }

    public function connexionAction($login = false, $password = false)
    {
        $login = Request::post('login');
        $password = sha1(Request::post('password'));

        $user = \Dvups_admin::select()
            ->where('password', "=", $password)
            ->andwhere('login', "=", $login)
            ->__getOne();

        if (!$user->getId()) {

            $user = \Dvups_admin::select()
                ->where('password', "=", $password)
                ->andwhere('email', "=", $login)
                ->__getOne();

            if (!$user->getId())
                return array("success" => false,
                    "error" => 'Login et/ou mot de passe incorrecte');

        }

//        if (!$user->isActivated())
//            return array("success" => false,
//                "error" => 'Votre compte a été désactivé.');

        // we specify which jsonmodel we want
        \Dvups_admin::$jsonmodel = 1;

        // Generating Token JWT
//        $jwt = \DClass\devups\Util::generateToken($user);
//
//        $user->setApi_token($jwt);

        // LoginController::setLastLoginDateAction($user->getId());// $jwt

        return array(
            'success' => true,
            // 'url' => "" . __env . "",
            "admin" => $user,
            //"jwt" => $jwt,
            //"lang" => $user->getLocale(),
        );

    }

    public static function changePassword()
    {
        extract($_POST);
        $user = Dvups_admin::find($id, false);

        if ($oldpwd == $user->getPassword()) {

            $user->setPassword(md5($newpwd));
            $user->__update();

            return array('success' => true, // pour le restservice
                'detail' => $user);

        } else {
            return array('success' => false, // pour le restservice
                'detail' => 'mot de passe incorrect');
        }
    }

    public function resetcredential($id = null)
    {

        $login = Request::post("identifiant");

        $dvups_admin = \Dvups_admin::select()
            ->where('phonenumber', "=", $login)
            ->__getOne();

        if (!$dvups_admin->getId()) {

            $dvups_admin = \Dvups_admin::select()
                ->where('email', "=", $login)
                ->__getOne();

            if (!$dvups_admin->getId())
                return array("success" => false,
                    "error" => 'erreur. aucun administrateur trouvé');

        }
        $password = $dvups_admin->generatePassword();
        $dvups_admin->setPassword(sha1($password));
//        $dvups_admin->setLogin();
        $dvups_admin->generateLogin($dvups_admin->getName());

        $dvups_admin->__save();

        $this->sendmail($password, $dvups_admin);

        return array('success' => true, // pour le restservice
            'dvups_admin' => $dvups_admin,
            'password' => $password,
            'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
        //
    }

    public function changepwAction()
    {
        $id = Request::get("id");
        $oldpwd = Request::post("oldpwd");
        $newpwd = Request::post("newpwd");

        $dvups_admin = Dvups_admin::find($id);

        if (sha1($oldpwd) == $dvups_admin->getPassword()) {
            $dvups_admin->__update("password", sha1($newpwd))->exec();
            return array('success' => true, // pour le restservice
                'detail' => 'Mot de passe mise a jour avec success');
        } else {
            return array('success' => false, // pour le restservice
                'detail' => 'Mot de passe incorrect');
        }
    }

}