<?php 
    /**
     * @Entity @Table(name="department")
     * */
    class Department extends \Model implements JsonSerializable{

        /**
         * @Id @GeneratedValue @Column(type="integer")
         * @var int
         * */
        protected $id;
        /**
         * @Column(name="name", type="string" , length=255 )
         * @var string
         **/
        protected $name;
        
        /**
         * @ManyToOne(targetEntity="\Region")
         * , inversedBy="reporter"
         * @var \Region
         */
        public $region;


        
        public function __construct($id = null){
            
                if( $id ) { $this->id = $id; }   
                          
	$this->region = new Region();
}

        public function getId() {
            return $this->id;
        }
        public function getName() {
            return $this->name;
        }

        public function setName($name) {
            $this->name = $name;
        }
        
        /**
         *  manyToOne
         *	@return \Region
         */
        function getRegion() {
            $this->region = $this->region->__show();
            return $this->region;
        }
        function setRegion(\Region $region) {
            $this->region = $region;
        }
                        
        
        public function jsonSerialize() {
                return [
                        'id' => $this->id,
                                'name' => $this->name,
                                'region' => $this->region,
                ];
        }
        
}
