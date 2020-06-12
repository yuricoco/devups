<?php 

	class Dvups_role_dvups_entityDAO extends DBAL{
			
		public function __construct() {
			parent::__construct(new Dvups_role_dvups_entity());
		}
		
		public function create(Dvups_role_dvups_entity $dvups_role_dvups_entity) {
			parent::__construct($dvups_role_dvups_entity);
			if($id = parent::createDbal()){
				return $id;
			}else {
				return FALSE;
			}
		}
		
		public function update(Dvups_role_dvups_entity $dvups_role_dvups_entity) {
			parent::__construct($dvups_role_dvups_entity);
			if(parent::updateDbal()){
				return TRUE;
			}else {
				return FALSE;
			}
		}
		
		public function findAllBaseEntity() {
			//parent::__construct(new Dvups_role_dvups_entity());
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
		 * @var \Dvups_role_dvups_entity
		 */
		public function findById($id) {
			$dvups_role_dvups_entity = new Dvups_role_dvups_entity();
			$dvups_role_dvups_entity->setId($id);
			parent::__construct($dvups_role_dvups_entity);
			if($instanceDvups_role_dvups_entity = parent::findByIdDbal()){
				return $instanceDvups_role_dvups_entity;
			}else {
				return null;
			}
		}
		
		public function delete(Dvups_role_dvups_entity $dvups_role_dvups_entity) {
			parent::__construct($dvups_role_dvups_entity);
			if(parent::deleteDbal()){
				return TRUE;
			}else {
				return FALSE;
			}
		}
		
		
	}