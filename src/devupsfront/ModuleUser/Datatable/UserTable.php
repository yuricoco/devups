<?php


use dclass\devups\Datatable\Datatable as Datatable;

class UserTable extends Datatable
{


    public function __construct($lazyloading = null, $datatablemodel = [])
    {
        parent::__construct($lazyloading, $datatablemodel);
    }

    public static function init(\User $user = null)
    {

        $dt = new UserTable();
        $dt->entity = $user;

        return $dt;
    }

    public function buildindextable()
    {

        $this->datatablemodel = [
            ['header' => t('user.id', '#'), 'value' => 'id'],
            ['header' => t('user.firstname', 'Firstname'), 'value' => 'firstname'],
            ['header' => t('user.lastname', 'Lastname'), 'value' => 'lastname'],
            ['header' => t('user.email', 'Email'), 'value' => 'email'],
        ];

        return $this;
    }

    public function builddetailtable()
    {
        $this->datatablemodel = [
            ['label' => t('user.firstname'), 'value' => 'firstname'],
            ['label' => t('user.lastname'), 'value' => 'lastname'],
            ['label' => t('user.email'), 'value' => 'email'],
            ['label' => t('user.sex'), 'value' => 'sex'],
            ['label' => t('user.phonenumber'), 'value' => 'phonenumber'],
            ['label' => t('user.password'), 'value' => 'password'],
            ['label' => t('user.resettingpassword'), 'value' => 'resettingpassword'],
            ['label' => t('user.is_activated'), 'value' => 'is_activated'],
            ['label' => t('user.activationcode'), 'value' => 'activationcode'],
            ['label' => t('user.birthdate'), 'value' => 'birthdate'],
            ['label' => t('user.lang'), 'value' => 'lang'],
            ['label' => t('user.username'), 'value' => 'username'],
            ['label' => t('entity.country'), 'value' => 'Country.name'],
            ['label' => t('entity.town'), 'value' => 'Town.id']
        ];
        // TODO: overwrite datatable attribute for this view
        return $this;
    }

}
