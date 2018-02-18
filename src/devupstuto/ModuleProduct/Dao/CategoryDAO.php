<?php 

    class CategoryDAO extends DBAL{

            public function __construct() {
                    parent::__construct(new Category());
            }

    }