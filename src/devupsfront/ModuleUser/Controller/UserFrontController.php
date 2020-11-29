<?php


class UserFrontController extends UserController
{

    public function ll($next = 1, $per_page = 10)
    {

        $ll = new Lazyloading();
        $ll->lazyloading(new User());
        return $ll;

    }

    public function createFrontAction($user_form = null, $enterprise_form = null)
    {
        extract($_POST);

        $user = $this->form_fillingentity(new User(), $user_form);

        if ($this->error) {

            //var_dump($this->error);die;
            Genesis::render('home', array('success' => false,
                'user' => $user,
                'action' => 'create',
                'error' => $this->error));
        }

        $id = $user->__insert();

        redirect("home");
//        return 	array(	'success' => true,
//            'user' => $user,
//            'tablerow' => UserTable::init()->buildindextable()->getSingleRowRest($user),
//            'detail' => '');

    }

    public function createAction($user_form = null, $enterprise_form = null)
    {
        $rawdata = \Request::raw();

        $user = $this->hydrateWithJson(new User(), $rawdata["user"]);

        if ($this->error) {
            return array('success' => false,
                'user' => $user,
                'action' => 'create',
                'error' => $this->error);
        }

        $id = $user->__insert();
        return array('success' => true,
            'user' => $user,
            'redirect' => route("complete?notif=1"),
            'detail' => '');

    }

    public function updateAction($id, $user_form = null)
    {
        $userhydrate = $this->form_generat(new User($id), $user_form);

        if($userhydrate->getPassword() != md5($confirm))
            return ["success" => false, "detail" => "le mot de passe est incorrect"];

        $userhydrate->__update();
        return ["success" => true, "detail" => "success", "user" => $userhydrate];

        $rawdata = \Request::raw();

        $user = $this->hydrateWithJson(new User($id), $rawdata["user"]);


        $user->uploadProfile();


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

    public function createFrontAjaxAction()
    {

        extract($_POST);

        $user = $this->form_fillingentity(new User(), $user_form);

        if ($this->error) {

            return array('success' => false,
                'user' => $user,
                'error' => $this->error);
        }

        //$user->setProfessional(1);
        $id = $user->__insert();

        (new RegistrationController())->register($user_form, $user);

        Response::set("user", $user);
        Response::set("redirect", route("account"));
        return Response::$data;

    }


}
