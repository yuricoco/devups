<?php 

	class StorageDAO extends DBAL{
			
		public function __construct() {
			parent::__construct(new Storage());
		}			
		
	}