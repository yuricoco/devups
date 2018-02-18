<?php 

	class Dvups_entityDAO extends DBAL{
			
		public function __construct() {
			parent::__construct(new Dvups_entity());
		}
		
		public function create(Dvups_entity $dvups_entity) {
			parent::__construct($dvups_entity);
			if($id = parent::createDbal()){
				return $id;
			}else {
				return FALSE;
			}
		}
		
		public function update(Dvups_entity $dvups_entity) {
			parent::__construct($dvups_entity);
			if(parent::updateDbal()){
				return TRUE;
			}else {
				return FALSE;
			}
		}
		
		public function findAllBaseEntity() {
			//parent::__construct(new Dvups_entity());
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
		 * @var \Dvups_entity
		 */
		public function findById($id) {
			$dvups_entity = new Dvups_entity();
			$dvups_entity->setId($id);
			parent::__construct($dvups_entity);
			if($instanceDvups_entity = parent::findByIdDbal()){
				return $instanceDvups_entity;
			}else {
				return null;
			}
		}
		
		public function delete(Dvups_entity $dvups_entity) {
			parent::__construct($dvups_entity);
			if(parent::deleteDbal()){
				return TRUE;
			}else {
				return FALSE;
			}
		}
		
		
	}