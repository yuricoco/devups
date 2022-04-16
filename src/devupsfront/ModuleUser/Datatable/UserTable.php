<?php


use dclass\devups\Datatable\Datatable as Datatable;

class UserTable extends Datatable
{

    public $entity = "user";

    public function __construct($user = null, $datatablemodel = [])
    {
        parent::__construct($user, $datatablemodel);
    }

    public static function init(\User $user = null)
    {

        $dt = new UserTable($user);
        $dt->entity = $user;

        return $dt;
    }

    public function buildindextable()
    {

        $this->base_url = __env."admin/";
        $this->datatablemodel = [
            ['header' => t('#'), 'value' => 'id', "search"=>false],
            ['header' => t('Nom'), 'value' => 'username'],
            ['header' => t('Wallet'), 'value' => 'wallet.amount', "search"=>false],
            ['header' => t('Country'), 'value' => 'country.name'],
            ['header' => t('user.phonenumber', 'Phonenumber'), 'value' => 'phonenumber'],
            ['header' => t('email'), 'value' => 'email'],
            ['header' => t('user.is_activated', 'Is_activated'), 'value' => 'is_activated'],
            ['header' => t('Register at'), 'value' => 'createdAt'],
            //['header' => t('user.birthdate', 'Birthdate'), 'value' => 'birthdate'],
        ];

        $this->order_by = " this.id desc ";
        $this->per_page = 30;
        return $this;
    }

    public function builddetailtable()
    {
        $this->datatablemodel = [
            ['label' => 'Firstname', 'value' => 'firstname'],
            ['label' => 'Lastname', 'value' => 'lastname'],
            ['label' => 'Email', 'value' => 'email'],
            ['label' => 'Sexe', 'value' => 'sexe'],
            ['label' => 'Phonenumber', 'value' => 'phonenumber'],
            //['label' => 'Password', 'value' => 'password'],
            ['label' => 'Resettingpassword', 'value' => 'resettingpassword'],
            ['label' => 'Is_activated', 'value' => 'is_activated'],
            ['label' => 'Activationcode', 'value' => 'activationcode'],
            ['label' => 'Birthdate', 'value' => 'birthdate'],
            ['label' => 'Creationdate', 'value' => 'creationdate'],
            ['label' => 'Lang', 'value' => 'lang'],
            ['label' => 'Username', 'value' => 'username'],
            ['label' => 'Has_shop', 'value' => 'has_shop']
        ];
        // TODO: overwrite datatable attribute for this view
        return $this;
    }

}
