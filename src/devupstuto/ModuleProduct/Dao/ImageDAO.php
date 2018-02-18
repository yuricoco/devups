<?php 

    class ImageDAO extends DBAL{

            public function __construct() {
                    parent::__construct(new Image());
            }

    }