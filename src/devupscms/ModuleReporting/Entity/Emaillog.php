<?php 
        // user \dclass\devups\model\Model;
    /**
     * @Entity @Table(name="emaillog")
     * */
    class Emaillog extends Model implements JsonSerializable{

        /**
         * @Id @GeneratedValue @Column(type="integer")
         * @var int
         * */
        protected $id;
        /**
         * @Column(name="object", type="string" , length=255 )
         * @var string
         **/
        protected $object;
        /**
         * @Column(name="log", type="text"  , nullable=true)
         * @var text
         **/
        protected $log; 
        

        
        public function __construct($id = null){
            
                if( $id ) { $this->id = $id; }   
                          
}

        public function getId() {
            return $this->id;
        }
        public function getObject() {
            return $this->object;
        }

        public function setObject($object) {
            $this->object = $object;
        }
        
        public function getLog() {
            return $this->log;
        }
        public function getLogmessage() {
            return $this->log;
        }

        public function setLog($log) {
            $this->log = $log;
        }
        
        
        public function jsonSerialize() {
                return [
                    'id' => $this->id,
                    'object' => $this->object,
                    'log' => $this->log,
                ];
        }
        
}
