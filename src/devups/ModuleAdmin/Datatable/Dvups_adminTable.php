<?php


use dclass\devups\Datatable\Datatable;

class Dvups_adminTable extends Datatable
{

    public function __construct($lazyloading = null, $datatablemodel = [])
    {
        parent::__construct($lazyloading, $datatablemodel);
    }

    public static function init(\Dvups_admin $admin = null)
    {
        $dt = new Dvups_adminTable($admin);
        $dt->entity = $admin;

        return $dt;
    }

    public function buildindextable()
    {
        $this->datatablemodel = [
            ['header' => 'nom', 'value' => 'name', 'search' => true],
            ['header' => 'Email', 'value' => 'email', 'search' => true],
            ['header' => 'login', 'value' => 'login', 'search' => true],
            ['header' => 'Role', 'value' => 'dvups_role.name'],
        ];

        $this->addcustomaction("callbackbtn");

        $this->qbcustom = Dvups_admin::select()
            ->where("this.login", "!=", "dv_admin");
        //->andwhere("password", "!=", sha1("admin"));
        $this->order_by = "dvups_admin.id desc";
        // $this->lazyloading(new Dvups_admin(), $qb,"dvups_admin.id desc");
        return $this;
    }

}
