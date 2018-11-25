<?php 

	class Dvups_right_dvups_entityDAO extends DBAL{
			
		public function __construct() {
			parent::__construct(new Dvups_right_dvups_entity());
		}
		
		public function create(Dvups_right_dvups_entity $dvups_right_dvups_entity) {
			parent::__construct($dvups_right_dvups_entity);
			if($id = parent::createDbal()){
				return $id;
			}else {
				return FALSE;
			}
		}
		
		public function update(Dvups_right_dvups_entity $dvups_right_dvups_entity) {
			parent::__construct($dvups_right_dvups_entity);
			if(parent::updateDbal()){
				return TRUE;
			}else {
				return FALSE;
			}
		}
		
		public function findAllBaseEntity() {
			//parent::__construct(new Dvups_right_dvups_entity());
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
		 * @var \Dvups_right_dvups_entity
		 */
		public function findById($id) {
			$dvups_right_dvups_entity = new Dvups_right_dvups_entity();
			$dvups_right_dvups_entity->setId($id);
			parent::__construct($dvups_right_dvups_entity);
			if($instanceDvups_right_dvups_entity = parent::findByIdDbal()){
				return $instanceDvups_right_dvups_entity;
			}else {
				return null;
			}
		}
		
		public function delete(Dvups_right_dvups_entity $dvups_right_dvups_entity) {
			parent::__construct($dvups_right_dvups_entity);
			if(parent::deleteDbal()){
				return TRUE;
			}else {
				return FALSE;
			}
		}
		
		
	}