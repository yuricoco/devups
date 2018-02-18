<?php 

    class SubcategoryDAO extends DBAL{

            public function __construct() {
                    parent::__construct(new Subcategory());
            }

    }