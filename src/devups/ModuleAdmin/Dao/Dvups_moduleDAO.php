<?php 

	class Dvups_moduleDAO extends DBAL{
			
		public function __construct() {
			parent::__construct(new Dvups_module());
		}			
		
	}