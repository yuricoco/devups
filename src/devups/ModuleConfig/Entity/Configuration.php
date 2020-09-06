<?php 
        // user \dclass\devups\model\Model;
    /**
     * @Entity @Table(name="configuration")
     * */
    class Configuration extends Model implements JsonSerializable{

        /**
         * @Id @GeneratedValue @Column(type="integer")
         * @var int
         * */
        protected $id;
        /**
         * @Column(name="_key", type="string" , length=150 )
         * @var string
         **/
        private $_key;
        /**
         * @Column(name="_value", type="string" , length=255 )
         * @var string
         **/
        private $_value;
        /**
         * @Column(name="_type", type="string" , length=150 , nullable=true)
         * @var string
         **/
        private $_type; 
        

        
        public function __construct($id = null){
            
                if( $id ) { $this->id = $id; }   
                          
}

        public function getId() {
            return $this->id;
        }
        public function get_key() {
            return $this->_key;
        }

        public function set_key($_key) {
            $this->_key = $_key;
        }
        
        public function get_value() {
            return $this->_value;
        }

        public function set_value($_value) {
            $this->_value = $_value;
        }
        
        public function get_type() {
            return $this->_type;
        }

        public function set_type($_type) {
            $this->_type = $_type;
        }
        
        
        public function jsonSerialize() {
                return [
                        'id' => $this->id,
                                '_key' => $this->_key,
                                '_value' => $this->_value,
                                '_type' => $this->_type,
                ];
        }
        
}
