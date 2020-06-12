<?php 

	class Dvups_role_dvups_moduleDAO extends DBAL{
			
		public function __construct() {
			parent::__construct(new Dvups_role_dvups_module());
		}
		
		public function create(Dvups_role_dvups_module $dvups_role_dvups_module) {
			parent::__construct($dvups_role_dvups_module);
			if($id = parent::createDbal()){
				return $id;
			}else {
				return FALSE;
			}
		}
		
		public function update(Dvups_role_dvups_module $dvups_role_dvups_module) {
			parent::__construct($dvups_role_dvups_module);
			if(parent::updateDbal()){
				return TRUE;
			}else {
				return FALSE;
			}
		}
		
		public function findAllBaseEntity() {
			//parent::__construct(new Dvups_role_dvups_module());
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
		 * @var \Dvups_role_dvups_module
		 */
		public function findById($id) {
			$dvups_role_dvups_module = new Dvups_role_dvups_module();
			$dvups_role_dvups_module->setId($id);
			parent::__construct($dvups_role_dvups_module);
			if($instanceDvups_role_dvups_module = parent::findByIdDbal()){
				return $instanceDvups_role_dvups_module;
			}else {
				return null;
			}
		}
		
		public function delete(Dvups_role_dvups_module $dvups_role_dvups_module) {
			parent::__construct($dvups_role_dvups_module);
			if(parent::deleteDbal()){
				return TRUE;
			}else {
				return FALSE;
			}
		}
		
		
	}