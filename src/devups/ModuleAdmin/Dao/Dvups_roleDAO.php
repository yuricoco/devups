<?php 

	class Dvups_roleDAO extends DBAL{
			
		public function __construct() {
			parent::__construct(new Dvups_role());
		}			
		
	}