<?php 
    /**
     * @Entity @Table(name="region")
     * */
    class Region extends \Model implements JsonSerializable{

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
         * @ManyToOne(targetEntity="\Country")
         * , inversedBy="reporter"
         * @var \Country
         */
        public $country;


        
        public function __construct($id = null){
            
                if( $id ) { $this->id = $id; }   
                          
	$this->country = new Country();
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
         *	@return \Country
         */
        function getCountry() {
            $this->country = $this->country->__show();
            return $this->country;
        }
        function setCountry(\Country $country) {
            $this->country = $country;
        }
                        
        
        public function jsonSerialize() {
                return [
                        'id' => $this->id,
                                'name' => $this->name,
                                'country' => $this->country,
                ];
        }
        
}
