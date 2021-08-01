<?php


use dclass\devups\Controller\Controller;

class AddressController extends Controller
{

    use \dclass\devups\Controller\CrudTrait;

    public function __construct()
    {
        self::$entityname = 'address';
        parent::__construct();
    }

    public function createAction($address_form = null)
    {
        extract($_POST);

        $address = $this->form_fillingentity(new Address(), $address_form);


        if ($this->error) {
            return array('success' => false,
                'address' => $address,
                'action' => 'create',
                'error' => $this->error);
        }

        $id = $address->__insert();
        return array('success' => true,
            'address' => $address,
            'tablerow' => AddressTable::init()->router()->getSingleRowRest($address),
            'detail' => '');

    }

    public function updateAction($id, $address_form = null)
    {
        extract($_POST);

        $address = $this->form_fillingentity(new Address($id), $address_form);


        if ($this->error) {
            return array('success' => false,
                'address' => $address,
                'action_form' => 'update&id=' . $id,
                'error' => $this->error);
        }

        $address->__update();
        return array('success' => true,
            'address' => $address,
            'tablerow' => AddressTable::init()->router()->getSingleRowRest($address),
            'detail' => '');

    }


    public function detailView($id)
    {

        $this->entitytarget = 'Address';
        $this->title = "Detail Address";

        $address = Address::find($id);

        $this->renderDetailView(
            AddressTable::init()
                ->builddetailtable()
                ->renderentitydata($address)
        );

    }

    public function deleteAction($id)
    {

        Address::delete($id);
        return array('success' => true,
            'detail' => '');
    }


    public function deletegroupAction($ids)
    {

        Address::delete()->where("id")->in($ids);

        return array('success' => true,
            'detail' => '');

    }

}
