<?php 

	class Dvups_langDAO extends DBAL{
			
		public function __construct() {
			parent::__construct(new Dvups_lang());
		}			
		
	}