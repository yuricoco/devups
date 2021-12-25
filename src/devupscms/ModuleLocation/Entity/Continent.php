<?php 
        // user \dclass\devups\model\Model;
    /**
     * @Entity @Table(name="continent")
     * */
    class Continent extends Model implements JsonSerializable{

        /**
         * @Id @GeneratedValue @Column(type="integer")
         * @var int
         * */
        protected $id;
        /**
         * @Column(name="code", type="string" , length=5 )
         * @var string
         **/
        protected $code;
        /**
         * @Column(name="name", type="string" , length=255 )
         * @var string
         **/
        protected $name;
        /**
         * @Column(name="status", type="integer"  )
         * @var integer
         **/
        protected $status; 
        

        
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

        /**
         * @return string
         */
        public function getCode()
        {
            return $this->code;
        }

        /**
         * @param string $code
         */
        public function setCode(string $code)
        {
            $this->code = $code;
        }
        
        public function getStatus() {
            return $this->status;
        }

        public function setStatus($status) {
            $this->status = $status;
        }
        
        
        public function jsonSerialize() {
                return [
                    'id' => $this->id,
                    'name' => $this->name,
                    'status' => $this->status,
                ];
        }
        
}
