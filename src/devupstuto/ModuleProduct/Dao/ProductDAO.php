<?php 

    class ProductDAO extends DBAL{

            public function __construct() {
                    parent::__construct(new Product());
            }

    }