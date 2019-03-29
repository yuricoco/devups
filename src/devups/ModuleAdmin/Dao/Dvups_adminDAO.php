<?php

class Dvups_adminDAO extends DBAL {

    public function findByConnectic($login, $pwd) {
        
        $qb = new QueryBuilder(new Dvups_admin());
        $row = Dvups_admin::select()->where('login', "=", $login)->andwhere('password', "=",  sha1($pwd))->__getOne();

        if (!$row->getId())
            return array('success' => false, "err" => 'Login ou mot de passe incorrect.');
        else {
            return $row;
        }
    }

    public function selectall(DvAdmin $admin) {
        //$query = $this->link->query("select * from Admin WHERE id != ".$admin->getId());
        $array = $query = $this->findAllByCritereDbal("WHERE admin.id != 1 AND admin.id != " . $admin->getId());
        return $array;
    }

    public function selectButAdmin() {
        $query = $this->findAllByCritereDbal(" WHERE admin.id != 1");

        //$array = $this->instance($query->fetchAll(PDO::FETCH_CLASS, 'Admin'));
        return $query;
    }

    public function __construct() {
        parent::__construct(new Dvups_admin());
    }

    public function create(Dvups_admin $dvups_admin) {
        parent::__construct($dvups_admin);
        if ($id = parent::createDbal()) {
            return $id;
        } else {
            return FALSE;
        }
    }

    public function update(Dvups_admin $dvups_admin) {
        parent::__construct($dvups_admin);
        if (parent::updateDbal()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function findAllBaseEntity() {
        //parent::__construct(new Dvups_admin());
        if ($liste = parent::findAllDbal()) {
            return $liste;
        } else {
            return FALSE;
        }
    }

    public function findAll() {
        if ($liste = parent::findAllDbalEntireEntity()) {
            return $liste;
        } else {
            return FALSE;
        }
    }

    /**
     * @var \Dvups_admin
     */
    public function findById($id) {
        $dvups_admin = new Dvups_admin();
        $dvups_admin->setId($id);
        parent::__construct($dvups_admin);
        if ($instanceDvups_admin = parent::findByIdDbal()) {
            return $instanceDvups_admin;
        } else {
            return null;
        }
    }

    public function delete(Dvups_admin $dvups_admin) {
        parent::__construct($dvups_admin);
        if (parent::deleteDbal()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
