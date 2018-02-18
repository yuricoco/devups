<?php 

	class Dvups_rightDAO extends DBAL{
			
		public function __construct() {
			parent::__construct(new Dvups_right());
		}
		
		public function create(Dvups_right $dvups_right) {
			parent::__construct($dvups_right);
			if($id = parent::createDbal()){
				return $id;
			}else {
				return FALSE;
			}
		}
		
		public function update(Dvups_right $dvups_right) {
			parent::__construct($dvups_right);
			if(parent::updateDbal()){
				return TRUE;
			}else {
				return FALSE;
			}
		}
		
		public function findAllBaseEntity() {
			//parent::__construct(new Dvups_right());
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
		 * @var \Dvups_right
		 */
		public function findById($id) {
			$dvups_right = new Dvups_right();
			$dvups_right->setId($id);
			parent::__construct($dvups_right);
			if($instanceDvups_right = parent::findByIdDbal()){
				return $instanceDvups_right;
			}else {
				return null;
			}
		}
		
		public function delete(Dvups_right $dvups_right) {
			parent::__construct($dvups_right);
			if(parent::deleteDbal()){
				return TRUE;
			}else {
				return FALSE;
			}
		}
		
		
	}