<?php 
    /**
     * @Entity @Table(name="dvups_langavailable")
     * */
    class Dvups_langavailable extends \Model implements JsonSerializable{

        /**
         * @Id @GeneratedValue @Column(type="integer")
         * @var int
         * */
        protected $id;
        /**
         * @Column(name="name", type="string" , length=55 )
         * @var string
         **/
        private $name; 
        

        
        public function __construct($id = null){
            
                if( $id ) { $this->id = $id; }   
                          
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
        
        
        public function jsonSerialize() {
                return [
                        'id' => $this->id,
                                'name' => $this->name,
                ];
        }
        
}
