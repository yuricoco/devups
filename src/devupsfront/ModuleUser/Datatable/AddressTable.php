<?php


use dclass\devups\Datatable\Datatable as Datatable;

class AddressTable extends Datatable
{


    public function __construct($address = null, $datatablemodel = [])
    {
        parent::__construct($address, $datatablemodel);
    }

    public static function init(\Address $address = null)
    {

        $dt = new AddressTable($address);
        $dt->entity = $address;

        return $dt;
    }

    public function buildindextable()
    {

        $this->datatablemodel = [
            ['header' => t('firstname', 'Firstname'), 'value' => 'firstname'],
            ['header' => t('description', 'Description'), 'value' => 'description'],
            ['header' => t('phonenumber', 'Phonenumber'), 'value' => 'phonenumber'],
            ['header' => t('lastname', 'Lastname'), 'value' => 'lastname'],
            ['header' => t('address', 'Address'), 'value' => 'address'],
            ['header' => t('postalcode', 'Postalcode'), 'value' => 'postalcode'],
            ['header' => t('_type', '_type'), 'value' => '_type'],
            ['header' => t('label', 'Label'), 'value' => 'label'],
            ['header' => t('entity.user', 'User'), 'value' => 'User.firstname']
        ];

        return $this;
    }

    public function buildfronttable()
    {

        $this->groupaction = false;
        $this->enabletopaction = false;
        $this->searchaction = false;
        $this->actionDropdown = false;
        $this->isFrontEnd = true;
        //$this->enablecolumnaction = false;
        $this->base_url = __env."/";

        $this->setModel("front");
        $this->datatablemodel = [
            ['header' => "#", 'value' => 'id'],
            ['header' => t('Libelle'), 'value' => 'label'],
            ['header' => t('Nom'), 'value' => 'firstname'],
            ['header' => t('Prénom'), 'value' => 'lastname'],
            ['header' => t('Email'), 'value' => 'email'],
            ['header' => t('Numéro de téléphone'), 'value' => 'phonenumber'],
            ['header' => t('Adresse'), 'value' => 'address'],
            ['header' => t('Code postal'), 'value' => 'postalcode'],
            //['header' => t('_type', '_type'), 'value' => '_type'],
        ];

        $this->addcustomaction(function ($item){
            return '<button type="button" class="mb-2 mr-2 btn btn-warning" onclick="model._edit('.$item->getId().', \'address\')"><i class="fa fa-edit"></i> Edit.</button>'
            .'<button type="button" class="mb-2 mr-2 btn btn-danger" onclick="model._delete(this, '.$item->getId().', \'address\')"><i class="fa fa-edit"></i> Supp.</button>';
        });

        return $this;
    }

    public function builddetailtable()
    {
        $this->datatablemodel = [
            ['label' => t('firstname'), 'value' => 'firstname'],
            ['label' => t('phonenumber'), 'value' => 'phonenumber'],
            ['label' => t('lastname'), 'value' => 'lastname'],
            ['label' => t('address'), 'value' => 'address'],
            ['label' => t('postalcode'), 'value' => 'postalcode'],
            //['label' => t('label'), 'value' => 'label'],
            //['label' => t('entity.user'), 'value' => 'User.firstname'],
        ];
        // TODO: overwrite datatable attribute for this view
        return $this;
    }

    public function router()
    {
        $tablemodel = Request::get("tablemodel", null);
        if ($tablemodel && method_exists($this, "build" . $tablemodel . "table") && $result = call_user_func(array($this, "build" . $tablemodel . "table"))) {
            return $result;
        } else
            switch ($tablemodel) {
                // case "": return this->
                default:
                    return $this->buildindextable();
            }

    }

}
