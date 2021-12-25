<?php 
    /**
     * @Entity @Table(name="district")
     * */
    class District extends \Model implements JsonSerializable{

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
         * @ManyToOne(targetEntity="\Town")
         * , inversedBy="reporter"
         * @var \Town
         */
        public $town;


        
        public function __construct($id = null){
            
                if( $id ) { $this->id = $id; }   
                          
	$this->town = new Town();
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
         *	@return \Town
         */
        function getTown() {
            $this->town = $this->town->__show();
            return $this->town;
        }
        function setTown(\Town $town) {
            $this->town = $town;
        }
                        
        
        public function jsonSerialize() {
                return [
                        'id' => $this->id,
                                'name' => $this->name,
                                'town' => $this->town,
                ];
        }
        
}
