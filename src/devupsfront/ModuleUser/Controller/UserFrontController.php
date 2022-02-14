<?php


class UserFrontController extends UserController
{

    public function registration()
    {

        if (isset($_POST["user_form"]))
            $userhydrate = $this->form_fillingentity(new User(), $_POST["user_form"]);
        else {
            $rawdata = \Request::raw();
            $userhydrate = $this->hydrateWithJson(new User(), $rawdata["user"]);
        }
        if ( $this->error ) {
            return 	array(	'success' => false,
                'user' => $userhydrate,
                'action' => 'create',
                'error' => $this->error);
        }

        $userhydrate->setPassword(md5($userhydrate->getPassword()));

        $activationcode = RegistrationController::generatecode();
        $userhydrate->setActivationcode($activationcode);

        // todo: handle it better
        $userhydrate->setIs_activated(1);
        $userhydrate->setApiKey(\DClass\lib\Util::randomcode());

        $userhydrate->__insert();

        $_SESSION[USER] = serialize($userhydrate);
        $_SESSION[USERID] = $userhydrate->getId();

        // send mail with activation code $codeactivation
        if ($userhydrate->getEmail()) {
            $data = [
                "activationcode" => $activationcode,
                "username" => $userhydrate->getFirstname(),
            ];
            Reportingmodel::init("register")
                ->addReceiver($userhydrate->getEmail(), $userhydrate->getUsername())
                ->sendMail($data);
        }

        // todo: send notification to seller
        Notification::on($userhydrate, "registered",
            ["username" => $userhydrate->getFirstname(),
                "code" => $activationcode])
            ->send([$userhydrate])
            //->sendSMS([$userhydrate->getTelephone()])
        ;

        return array('success' => true,
            'user' => $userhydrate,
            'redirect' => route("activate-account"),
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
