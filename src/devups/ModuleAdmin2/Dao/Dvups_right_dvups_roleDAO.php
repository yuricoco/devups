<?php 

	class Dvups_right_dvups_roleDAO extends DBAL{
			
		public function __construct() {
			parent::__construct(new Dvups_right_dvups_role());
		}
		
		public function create(Dvups_right_dvups_role $dvups_right_dvups_role) {
			parent::__construct($dvups_right_dvups_role);
			if($id = parent::createDbal()){
				return $id;
			}else {
				return FALSE;
			}
		}
		
		public function update(Dvups_right_dvups_role $dvups_right_dvups_role) {
			parent::__construct($dvups_right_dvups_role);
			if(parent::updateDbal()){
				return TRUE;
			}else {
				return FALSE;
			}
		}
		
		public function findAllBaseEntity() {
			//parent::__construct(new Dvups_right_dvups_role());
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
		 * @var \Dvups_right_dvups_role
		 */
		public function findById($id) {
			$dvups_right_dvups_role = new Dvups_right_dvups_role();
			$dvups_right_dvups_role->setId($id);
			parent::__construct($dvups_right_dvups_role);
			if($instanceDvups_right_dvups_role = parent::findByIdDbal()){
				return $instanceDvups_right_dvups_role;
			}else {
				return null;
			}
		}
		
		public function delete(Dvups_right_dvups_role $dvups_right_dvups_role) {
			parent::__construct($dvups_right_dvups_role);
			if(parent::deleteDbal()){
				return TRUE;
			}else {
				return FALSE;
			}
		}
		
		
	}