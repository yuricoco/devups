<?php 

	class Dvups_role_dvups_adminDAO extends DBAL{
			
		public function __construct() {
			parent::__construct(new Dvups_role_dvups_admin());
		}
		
		public function create(Dvups_role_dvups_admin $dvups_role_dvups_admin) {
			parent::__construct($dvups_role_dvups_admin);
			if($id = parent::createDbal()){
				return $id;
			}else {
				return FALSE;
			}
		}
		
		public function update(Dvups_role_dvups_admin $dvups_role_dvups_admin) {
			parent::__construct($dvups_role_dvups_admin);
			if(parent::updateDbal()){
				return TRUE;
			}else {
				return FALSE;
			}
		}
		
		public function findAllBaseEntity() {
			//parent::__construct(new Dvups_role_dvups_admin());
			if($liste = parent::findAllDbal()){
				return $liste;
			}else {
				return FALSE;
			}
		}
		
		public function findAll() {
			if($liste = parent::findAllDbalEntireEntity()){
                return $liste;
			}else {
				return FALSE;
			}
		}
		 
		/**
		 * @var \Dvups_role_dvups_admin
		 */
		public function findById($id) {
			$dvups_role_dvups_admin = new Dvups_role_dvups_admin();
			$dvups_role_dvups_admin->setId($id);
			parent::__construct($dvups_role_dvups_admin);
			if($instanceDvups_role_dvups_admin = parent::findByIdDbal()){
				return $instanceDvups_role_dvups_admin;
			}else {
				return null;
			}
		}
		
		public function delete(Dvups_role_dvups_admin $dvups_role_dvups_admin) {
			parent::__construct($dvups_role_dvups_admin);
			if(parent::deleteDbal()){
				return TRUE;
			}else {
				return FALSE;
			}
		}
		
		
	}