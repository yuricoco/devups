<?php 
    /**
     * @Entity @Table(name="newsletter")
     * */
    class Newsletter extends \Model implements JsonSerializable{

        /**
         * @Id @GeneratedValue @Column(type="integer")
         * @var int
         * */
        protected $id;
        /**
         * @Column(name="creationdate", type="datetime"  )
         * @var datetime
         **/
        protected $creationdate;
        /**
         * @Column(name="email", type="string" , length=255 )
         * @var string
         **/
        protected $email;
        

        
        public function __construct($id = null){
            
                if( $id ) { $this->id = $id; }   
                          
}

        public function getId() {
            return $this->id;
        }
        public function getCreationdate() {
            return $this->creationdate;
        }

        public function setCreationdate($creationdate) {
            $this->creationdate = $creationdate;
        }
        
        public function getEmail() {
            return $this->email;
        }

        public function setEmail($email) {
            $this->email = $email;
        }
        
        
        public function jsonSerialize() {
                return [
                        'id' => $this->id,
                                'creationdate' => $this->creationdate,
                                'email' => $this->email,
                ];
        }
        
}
