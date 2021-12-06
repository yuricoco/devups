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

        $this->datatablemodel = [
            ['header' => t('#'), 'value' => 'id'],
            ['header' => t('user.username', 'Username'), 'value' => 'username'],
            //['header' => t('user.lastname', 'Lastname'), 'value' => 'lastname'],
            ['header' => t('Spacekola Ref.'), 'value' => 'spacekolaRef'],
            ['header' => t('user.email', 'Email'), 'value' => 'email'],
            ['header' => t('user.phonenumber', 'Phonenumber'), 'value' => 'phonenumber'],
            //['header' => t('user.resettingpassword', 'Resettingpassword'), 'value' => 'resettingpassword'],
            ['header' => t('user.is_activated', 'Is_activated'), 'value' => 'is_activated'],
            //['header' => t('user.activationcode', 'Activationcode'), 'value' => 'activationcode'],
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
