<?php


class AddressFrontController extends AddressController
{

    public function listView($next = 1, $per_page = 10)
    {

        $lazyloading = $this->lazyloading(new Address(), $next, $per_page);

        self::$jsfiles[] = Address::classpath('Ressource/js/addressCtrl.js');

        $this->entitytarget = 'Address';
        $this->title = "Manage Address";

        return $this->renderListView(AddressTable::init($lazyloading)->router()->render(), true);

    }

    public static function getallAction()
    {
        return [
            "success" => true,
            "addresses" => \User::userapp()->__hasmany(\Address::class)
        ];
    }

    public function ll($next = 1, $per_page = 10)
    {

        return $this->lazyloading(new Address(), $next, $per_page);

    }

    public function createAction($address_form = null)
    {

        extract($_POST);

        $address = $this->form_fillingentity(new \Address(), $address_form);

        if ($this->error) {
            return array('success' => false,
                'error' => $this->error);
        }

        $address->user = \User::userapp();

        $id = $address->__insert();

        $cart = getcart();
        if ($cart->getId()) {
            if (Request::get("option") == "delivery")
                $cart->setDelivery_address_id($id);
            else
                $cart->address = $address;

            $cart->updateSession();

        }
        return array('success' => true,
            'address' => $address,
            'detail' => '');

    }

    public function createApiAction($address_form = null)
    {
        $rawdata = Request::raw();
        $address = $this->hydrateWithJson(new \Address(), $rawdata["address"]);

        if ($this->error) {
            return array('success' => false,
                'error' => $this->error);
        }
        $address->__insert();
        return array('success' => true,
            'address' => $address,
            'detail' => '');

    }

    public function updateAction($id, $address_form = null)
    {

        return parent::updateAction($id);

    }


    public function detailAction($id)
    {

        $address = Address::find($id);

        return array('success' => true,
            'address' => $address,
            'detail' => '');

    }

    public function saveAction($type, $orderid)
    {
        extract($_POST);
        $address = $this->form_fillingentity(new Address(), $address_form);

        $address->__save();
        //if ($type == "sender") {
        Order::where("this.id", $orderid)
            ->update([$type . "_id" => $address->getId()]);
        //}
        return array('success' => true,
            'address' => $address,
            'detail' => '');

    }


}
