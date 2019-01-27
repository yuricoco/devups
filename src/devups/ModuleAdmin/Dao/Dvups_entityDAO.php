<?php 

	class Dvups_entityDAO extends DBAL{
			
		public function __construct() {
			parent::__construct(new Dvups_entity());
		}			
		
	}