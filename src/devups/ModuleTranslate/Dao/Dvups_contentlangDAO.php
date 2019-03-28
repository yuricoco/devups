<?php 

	class Dvups_contentlangDAO extends DBAL{
			
		public function __construct() {
			parent::__construct(new Dvups_contentlang());
		}			
		
	}