<?php


class UserFrontController extends UserController
{

    public static function renderAccount()
    {
        $user = new User();
        if (isset($_SESSION[USERID]))
            $user = User::find($_SESSION[USERID]);

        Genesis::render('_account', ["user" => $user]);

    }

    public function dashboard()
    {
        //$qb = \Favorite::select()->where('user_id', $_SESSION[USERID]);
        return [
            "user" => \User::userapp(),
            "nborder" => 0,
        ];
    }

    public function account()
    {
        $user = \User::find($_SESSION[USERID]);
        return [
            "user" => $user
        ];
    }


    public function lostpasswordView()
    {
        //self::$jsfiles[]= CLASSJS . "model.js";
        self::$jsfiles[] = CLASSJS . "dform.js";
        self::$jsfiles[] = d_assets("js/userCtrl.js");
        return \Response::$data;
    }

    public function confirmaccountView()
    {
        //self::$jsfiles[]= CLASSJS . "model.js";
        self::$jsfiles[] = CLASSJS . "dform.js";
        self::$jsfiles[] = d_assets("js/userCtrl.js");
        return \Response::$data;
    }

    public function resetpasswordView()
    {
        self::$jsfiles[] = CLASSJS . "dform.js";
        self::$jsfiles[] = d_assets("js/userCtrl.js");
        return \Response::$data;
    }


    public function createAction($user_form = null)
    {

        $response = (new RegistrationController())->register();

        if (!$response["success"]) {
            return $response;
        }
        extract($_POST);

        $user = $response["user"];

        return array('success' => true,
            'user' => $user,
            'redirect' => route("activate-account"),
            'detail' => '');

    }

    public function registration()
    {

        $rawdata = \Request::raw();

        $userhydrate = $this->hydrateWithJson(new User(), $rawdata["user"]);

        if ( $this->error ) {
            return  array(  'success' => false,
                'user' => $userhydrate,
                'action' => 'create',
                'error' => $this->error);
        }

        $activationcode = RegistrationController::generatecode();
        $userhydrate->setActivationcode($activationcode);

        // todo: handle it better
        $userhydrate->setIs_activated(0);
        $userhydrate->setApiKey(\DClass\lib\Util::randomcode());
        $userhydrate->__insert();
/*
        $_SESSION['USER'] = serialize($userhydrate);
        $_SESSION['USERID'] = $userhydrate->getId();*/


        // send mail with activation code $codeactivation
        if ($userhydrate->getEmail()) {
            $data = [
                "activation_code" => $activationcode,
                "username" => $userhydrate->getFirstname(),
            ];
            Reportingmodel::init("register", Dvups_lang::getByIsoCode($userhydrate->lang)->id)
                ->addReceiver($userhydrate->getEmail(), $userhydrate->getUsername())
                ->sendMail($data);
        }

        // todo: send notification to seller
        Notification::$send_sms = true;
        Notification::on($userhydrate, "registered")
            ->send([$userhydrate], ["username" => $userhydrate->getFirstname(), "code" => $activationcode]);

        return array('success' => true,
            'user' => $userhydrate,
            'activation_code' => $activationcode,
            //'redirect' => route("activate-account"),
            'detail' => '');

    }

    public function updateAction($id, $user_form = null)
    {

        $rawdata = \Request::raw();

        $user = $this->hydrateWithJson(new User($id), $rawdata["user"]);

        $user->__update();
        return array('success' => true,
            'user' => $user,
            'detail' => '');

    }

    public function updateApiAction($id, $user_form = null)
    {

        $rawdata = \Request::raw();

        $user = $this->hydrateWithJson(new User($id), $rawdata["user"]);

        if ($this->error) {
            return array('success' => false,
                'user' => $user,
                'error' => $this->error);
        }

        $user->__update();
        return array('success' => true,
            'user' => $user,
            'detail' => '');

    }


    public function detailAction($id)
    {

        $user = User::find($id);

        return array('success' => true,
            'user' => $user,
            'detail' => '');

    }

    public function synchro()
    {
        $rawdata = \Request::raw();

        $userhydrate = $this->hydrateWithJson(new User(), $rawdata["user"]);

        $qb = new QueryBuilder(new User());
        $qb->select();

        $qb->where('phonenumber', "=", $userhydrate->getPhonenumber());

        $nbuser = $qb
            //->orwhere('user.username_canonical', "=", $userhydrate->getUsername_canonical())
            ->__firstOrNull();

        if (!is_null($nbuser)) {
            $userhydrate->setId($nbuser->getId());
        }

        if ($userhydrate->getEmail() && is_null($nbuser)) {

            $qb = User::where('this.email', "=", $userhydrate->getEmail());
            $nbuser = $qb->__firstOrNull();

            if (!is_null($nbuser)) {
                $userhydrate->setId($nbuser->getId());
            }
        }

        if ($userhydrate->getId()) {
            $userhydrate->__update();
            return ["success" => true,
                "user" => $userhydrate,
                "detail" => "your account has been sync with the one of spacekola"];
        }

        $userhydrate->setPassword(md5($userhydrate->getPassword()));

        $activationcode = RegistrationController::generatecode();
        $userhydrate->setActivationcode($activationcode);

        // todo: handle it better
        $userhydrate->setIs_activated(1);
        $userhydrate->setApiKey(\DClass\lib\Util::randomcode());

        $userhydrate->__insert();

        return [
            "success" => true,
            "user" => $userhydrate,
            "detail" => "An account has been created on aggregator system and has been sync with the one of spacekola"];

    }


}
