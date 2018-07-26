<?php 

	class TestentityDAO extends DBAL{
			
		public function __construct() {
			parent::__construct(new Testentity());
		}			
		
	}