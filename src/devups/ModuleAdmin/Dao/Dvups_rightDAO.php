<?php 

	class Dvups_rightDAO extends DBAL{
			
		public function __construct() {
			parent::__construct(new Dvups_right());
		}			
		
	}