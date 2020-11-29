<?php 
    /**
     * @Entity @Table(name="message")
     * */
    class Message extends \Model implements JsonSerializable{

        /**
         * @Id @GeneratedValue @Column(type="integer")
         * @var int
         * */
        protected $id;
        /**
         * @Column(name="nom", type="string" , length=255 )
         * @var string
         **/
        protected $nom;
        /**
         * @Column(name="email", type="string" , length=255 )
         * @var string
         **/
        protected $email;
        /**
         * @Column(name="telephone", type="string" , length=35 , nullable=true)
         * @var string
         **/
        protected $telephone;
        /**
         * @Column(name="message", type="text"  , nullable=true)
         * @var text
         **/
        protected $message;
        

        
        public function __construct($id = null){
            
                if( $id ) { $this->id = $id; }   
                          
}

        public function getId() {
            return $this->id;
        }
        public function getNom() {
            return $this->nom;
        }

        public function setNom($nom) {
            $this->nom = $nom;
        }
        
        public function getEmail() {
            return $this->email;
        }

        public function setEmail($email) {
            $this->email = $email;
        }
        
        public function getTelephone() {
            return $this->telephone;
        }

        public function setTelephone($telephone) {
            $this->telephone = $telephone;
        }
        
        public function getMessage() {
            return $this->message;
        }

        public function setMessage($message) {
            $this->message = $message;
        }
        
        
        public function jsonSerialize() {
                return [
                        'id' => $this->id,
                                'nom' => $this->nom,
                                'email' => $this->email,
                                'telephone' => $this->telephone,
                                'message' => $this->message,
                ];
        }
        
}
